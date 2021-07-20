<?php

    namespace App\Http\Controllers\v4;
    
    use App\Event;
    use App\State;
    use App\City;
    use App\Country;
	use App\EventImage;
    use App\User;
    use App\NotifyMe;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Http\Request;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Controllers\Traits\SendMail;
    use App\Common\Utility;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\DB;
    use App\duplicateRequest;
    use Config;
    use JWTAuth;
    
    class EventController extends Controller
    {
        use SendMail;
        public function addEvent(Request $request){ 

            try{ 
		
                    if(!$this->verifyChecksum($request)){
                        return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'),
                        "message"=>'checksum not verified',
                        "data"=>json_decode('{}')]);
                    }
                    Utility::stripXSS();
                    
                    Log::info('entered in add event API');
                   
                    $status = 0;
                    $message = "";
                    
                    $validator = Validator::make($request->all(), [
                        'event_name' => 'required|string|max:255',
                        'email' => 'required|string|max:255',
                        'contact_person' => 'required|string|max:255',
                        'contact_no' => 'required|string',
						'joining_instruction'=>'required',
						'isHighlight'=>'required|integer',
						'short_description'=>'required',
                        'start_time'  => 'required|date_format:Y-m-d H:i:s|after:yesterday',
                        'end_time'  => 'required|date_format:Y-m-d H:i:s|after:yesterday',
						'lat'=>'required',
						'lng'=>'required',
                    ]);
					if($validator->fails()){
                            Log::debug(['add event validation failed',$request->all()]);
                            return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>'Invalid data set','data'=>json_decode("{}")]);
                            //return response()->json($validator->errors()->toJson(), 400);
                    } 

                    if($this->checkDuplicateRequest($request)){
                        return response()->json(['status'=> Config::get('app.status_codes.NP_DUPLICATE_REQUEST'),'message'=>'Duplicate request','data'=>[]]);
                    }


                    $user  = JWTAuth::user();
                    if($user->count()==0){
                        return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>'User not found','data'=>[]]);
                    }
                    //if($user)
                             

                    
                    $request->email = $this->string_replace("__","/",$request->email);
                    $request->contact_person = $this->string_replace("__","/",$request->contact_person);
                    $request->contact_no = $this->string_replace("__","/",$request->contact_no);
                    $request->address = $this->string_replace("__","/",$request->address);  
					

                    $request->merge([
                        'email' => $request->email,
                        'contact_person' => $request->contact_person,
                        'contact_no' => $request->contact_no,
                        'address' => $request->address,
                    ]);

                    $cityObj = new City();
                    $returnData  = $cityObj->getCountryStateCityByName($request);
					if($returnData['error']==0 && $returnData['success']==1){
                        $country_id = $returnData['data']['country_id'];
                        $state_id = $returnData['data']['state_id'];
                        $city_id = $returnData['data']['city_id'];
						$city_lat=$returnData['data']['city_lat'];
						$city_lng=$returnData['data']['city_lng'];
						
						
                    }else{
                        Log::debug(['add event country state not found',$returnData]);
                        return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>$returnData['message'],'data'=>[]]);
                    }                       
                    
                    //$start_time = date('Y-m-d H:i:s', $request->get('start_time')); 
                    //$end_time = date('Y-m-d H:i:s', $request->get('end_time')); 

                    $event = Event::create([
                    'event_name' => ucwords(trim($request->get('event_name'))),
                    'user_id' => $user->id,
                    'contact_person' => trim($request->get('contact_person')),            
                    'contact_no' => trim($request->get('contact_no')),
                    'address' => ucfirst(trim($request->get('address'))),
                    'email' => trim($request->get('email')),
                    'state_id' => trim($state_id), 
                    'city_id' => trim($city_id), 
                    'country_id' => trim($country_id),
                    'sitting_capacity' => trim($request->get('sitting_capacity')),
                    'zip' => trim($request->get('zip')),
                    'lat' => trim($request->get('lat')),
                    'lng' => trim($request->get('lng')),
                    'nearest' => trim($request->get('nearest')),
                    'nearest_distance' => trim(round($request->get('nearest_distance'),2)),
                    'mode' => trim($request->get('mode')),
					'joining_instruction'=> ucwords(trim($request->get('joining_instruction'))),
					'isHighlight'=> trim($request->get('isHighlight')),
					'short_description'=> ucfirst(trim($request->get('short_description'))),
                    'start_time' => trim($request->get('start_time')),            
                    'end_time' => trim($request->get('end_time')),
					'city_lat'=>trim($city_lat),
					'city_lng'=>trim($city_lng),
					'meeting_link'=>trim($request->get('meeting_link')),
					'status'=>'0',
                ]);
				
				$data['state'] = $request->state;
                $data['name'] = ucwords($user->name);
                $data['event_name'] = $request->event_name;    
                $data['address'] = $request->get('address');
                $data['city'] = $request->city;
                $data['country'] = $request->country;
                $data['start_date'] = $request->get('start_time');
                $data['end_date'] = $request->get('end_time');                    
                $data['type'] = 'Event';                                
                $data['supportEmail'] = config('mail.supportEmail');
                $data['website'] = config('app.site_url');  
                $data['site_name'] = config('app.site_name');
                $data['email'] = $this->encdesc($user->email,'decrypt');
                $data['subject'] = 'Event Add Success Mail From '.config('app.site_name');
                
                if($this->SendMail($data,'add_event')){                                        
                    $dupObj = new duplicateRequest();
                    $dupObj->md5val = $request->header("checksum");
                    
                    $dupObj->save();
                    Log::info(['add event mail sent']);
                    $user->type = 'event';
                    
                    $this->sendNotificationMail($user);
                    $status = 1;
                    
                    Log::info('response add event',['status'=>$status,'message'=>"",'data'=>$event]); 
                    return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),'message'=>"",'data'=>$event]);
                } 
                                
            }catch(Exception $e){
                return response()->json(['status'=> Config::get('app.status_codes.NP_INVALID_REQUEST'),'message'=>'data exception','data'=>json_decode("{}")]);
            }
            
        }

        
        /**
         * Show the form for get user lsit.
         *
         * @return \Illuminate\Http\Response
         */
        public function getEventList(Request $request){
            try{
                $status = 0;
                $message = "";      
                $cond[] = ['status','1'];  
                
                if(!$this->verifyChecksum($request)){
                    return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'), 
                    "message"=>'checksum not verified',
                    "data"=>json_decode('{}')]);
                }
				if($request->country != "")
				{
					
					$cityObj = new City();
					$returnData  = $cityObj->getCountryStateCityByName($request);
					if($returnData['error']==0 && $returnData['success']==1){
						$country_id = $returnData['data']['country_id'];
						$state_id = $returnData['data']['state_id'];
						$city_id = $returnData['data']['city_id'];
					}else{
						return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'), 'message'=>$returnData['message'],'data'=>[]]);
					} 
                }
				else
				{
					
					$country_id ='';
					$state_id ='';
					$city_id ='';
				}
				
				
                if($request->city != ""){
                    $cond[] = ['city_id',$city_id];
                }
				
                if($request->state !=""){            
                $cond[] = ['state_id',$state_id];
                }
                if($request->country !=""){
                  $cond[] = ['country_id',$country_id];

                }
                //$cond[] = ['mode',"FREE"];
                
                //$events = Event::with(['country','state','city'])->where($cond)->orderBy('start_time','asc')->paginate(Config::get('app.record_per_page'));                                       
                
                $eventsCount = Event::with(['country','state','city'])->where($cond)->count();
                if(isset($request->event_type) && $request->event_type !=""){
                    if($request->event_type=="past"){
                        $cond[] = ['end_time','<',date('Y-m-d H:i:s')];        
                    }else if($request->event_type=="upcoming"){
                        $cond[] = ['start_time','>',date('Y-m-d H:i:s')];        
                    }else if($request->event_type=="current"){
                        $cond[] = ['start_time','<=',date('Y-m-d H:i:s')];
                        $cond[] = ['end_time','>=',date('Y-m-d H:i:s')];
                                               
                    }
                }
              /*   $post = Event::whereYear('start_time', '=', $request->year)
              ->whereMonth('start_time', '=', $request->month)
              ->get()->toArray(); 
				echo "<pre>";
				print_r($post);
				die; */

                if($eventsCount==0){   
                    $eventCount = Event::where('status','1')->count();                                    
                    return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),
                    'message'=>$message,                    
                    'data'=>[],
                    'count'=>$eventCount
                    ]);
                }else
				{
					if($request->year !=''  && $request->month !='')
					{
					$events1 = Event::with(['country','state','city','EventRating'])                    
                    ->where($cond)
					->whereYear('start_time', '=', $request->year)
					->whereMonth('start_time', '=', $request->month)
					->orderBy('id','desc')
                    /* ->orderBy('start_time','asc') */
                    ->paginate(Config::get('app.record_per_page'));
						
					}
					else
					{
						if($request->year !=''  && $request->month =='')
						{
						return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'), 
                    "message"=>'Invalid request',
                    "data"=>json_decode('{}')]);
							
							
						}
						if($request->year ==''  && $request->month !='')
						{
							  return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'), 
                    "message"=>'Invalid request',
                    "data"=>json_decode('{}')]);
						}
						
					$events1 = Event::with(['country','state','city','EventRating'])                    
                    ->where($cond)					
					->orderBy('id','desc')
                    /* ->orderBy('start_time','asc') */
                    ->paginate(Config::get('app.record_per_page'));
						
					}
					
                    
				
                    
                    $eventData = [];   
                    $avgRating = 0; 
					
					
					
                    foreach($events1 as $k=>$v){
						$event_images=[];
						$storage_path=asset('/public/images/event');
                        if(isset($v->EventRating)){
                            $ratingData = $this->getRating('event',$v->id);
                            if(count($ratingData)>0){
                                $v->rating = $ratingData['rating'];
                                $v->out_of = $ratingData['out_of'];
                            }
                        }
						$EventImageData =EventImage::getImages($v->id);			
						
						if($EventImageData['image_one'])
						{	
							$event_images_count=count($event_images);
						
							$event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_one'];
						}
						if($EventImageData['image_two'])
						{
							$event_images_count=count($event_images);
							 $event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_two'];
						}
						if($EventImageData['image_three'])
						{
							$event_images_count=count($event_images);
							 $event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_three'];
						}
						if($EventImageData['image_four'])
						{
							 $event_images_count=count($event_images);
							 $event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_four'];
						}
						
						if(count($event_images))
						{
							$v->event_images = $event_images;							
							
						}
						else 
						{
							$v->event_images=array();
							
						} 
                       
						
                       							
                         $v->country_name = $v->country->name;
                        $v->state_name = $v->state->name;
                        $v->city_name = $v->city->name; 
						
                        //$v->rating = $avgRating;
                        
                       unset($v->country);
                        unset($v->state);
                        unset($v->city);
                        unset($v->EventRating);
						
                        
                        $eventData[$k] = $v;   
                    }
					//die;
                    $status = 1;                    
                    // return response()->json(['status'=>1,
                    // 'message'=>$message,                    
                    // 'data'=>$eventData
                    // ]);
                    if($events1->total() == 0){
                        $currentPage = 0;
                    }else{
                        $currentPage = $events1->currentPage();
                    }

                    return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),
                        'message'=>$message,
                        'total_record'=>$events1->total(),
                        'last_page'=>$events1->lastPage(),
                        'current_page'=>$currentPage,
                        'data'=>$eventData
                    ]);
                }

                
                
            }catch(Exception $e){   
                $message = "Data exception";
                return response()->json(['status'=> Config::get('app.status_codes.NP_INVALID_REQUEST'),'message'=>$message]);
            }            
            //$users[0]->role            
        }
		
		


        /**
         * Show the form for get user lsit.
         *
         * @return \Illuminate\Http\Response
         */
        public function getMyEventList(Request $request){
            try{
                $status = 0;
                $message = "";      
                if(!$this->verifyChecksum($request)){
                    return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'),
                    "message"=>'checksum not verified',
                    "data"=>json_decode('{}')]);
                }
                $user  = JWTAuth::user();
                if($user->count()==0){
                    return response()->json(['status'=> Config::get('app.status_codes.NP_NO_RESULT'), 'message'=>'User not found','data'=>[]]);
                }
                //$cond = [['status','1'],['user_id',$user->id],['mode','FREE']];
				$cond = [['status','1'],['user_id',$user->id]];
                if(isset($request->event_type) && $request->event_type !=""){
                    if($request->event_type=="past"){
                        $cond[] = ['end_time','<',date('Y-m-d H:i:s')];  						
						
                    }else if($request->event_type=="upcoming"){
                        $cond[] = ['start_time','>',date('Y-m-d H:i:s')]; 														
                    }else if($request->event_type=="current"){
						
                        $cond[] = ['start_time','<=',date('Y-m-d H:i:s')];
                        $cond[] = ['end_time','>=',date('Y-m-d H:i:s')];
						
                                               
                    }
                }				
                $events = Event::with(['country','state','city'])->where($cond)->orderBy('id')->paginate(Config::get('app.record_per_page'));
				    
                if($events->count() > 0){
                    $eventData = [];
					
										
                    foreach($events as $k=>$v){
						$storage_path=asset('/public/images/event');
						$event_images=[];
                        $v->country_name = $v->country->name;
                        $v->state_name = $v->state->name;
                        $v->city_name = $v->city->name;
                        $ratingData = $this->getRating('event',$v->id);
                        if(count($ratingData)>0){
                            $v->rating = $ratingData['rating'];
                            $v->out_of = $ratingData['out_of'];
                        }
						$EventImageData =EventImage::getImages($v->id);
						if($EventImageData['image_one'])
						{
							$event_images_count=count($event_images);
							$event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_one'];
						}
						if($EventImageData['image_two'])
						{
							 $event_images_count=count($event_images);
							 $event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_two'];
						}
						if($EventImageData['image_three'])
						{
							 $event_images_count=count($event_images);  
							 $event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_three'];
						}
						if($EventImageData['image_four'])
						{
							$event_images_count=count($event_images);
							 $event_images[$event_images_count] = $storage_path.'/'.$EventImageData['image_four'];
						}
						
						if(count($event_images))
						{
							$v->event_images = $event_images;							
							
						}
						else 
						{
							$v->event_images=array();
							
						} 
						
                       
							 
						
                        unset($v->country);
                        unset($v->state);
                        unset($v->city);						
                        $eventData[$k] = $v;
                    }
                    $status = 1;
                    return response()->json([
                                'status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),
                                'message'=>'Request processed successfully',
                                'total_record'=>$events->total(),
                                'last_page'=>$events->lastPage(),
                                'current_page'=>$events->currentPage(),
                                'data'=>$eventData]
                            );        
                }else{
                    $status = 1;
                    $message = "no data found";
                    return response()->json([
                                'status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),
                                'total_record'=>0,
                                'last_page'=>0,
                                'current_page'=>0,
                                'message'=>$message,
								//'data'=>[]
								]
                            );        
                }
            }catch(Exception $e){   
                $message = "Data exception";
                return response()->json(['status'=> Config::get('app.status_codes.NP_INVALID_REQUEST'),'message'=>$message
				]);
            }            
            //$users[0]->role            
        }


        /**
         * Edit event method
         * @return success or error
         * 
         * */
        public function editMyEvent(Request $request){
			
			//echo'<pre>';print_r($request);
            //return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),'message'=>'Please provide event ID'.$request ]);
            
            $status = 0;
            $message = "";
            
            if(!$this->verifyChecksum($request)){
                return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'),
                "message"=>'checksum not verified',
                "data"=>json_decode('{}')]);
            }
			

            if($this->checkDuplicateRequest($request)){
                return response()->json(['status'=> Config::get('app.status_codes.NP_DUPLICATE_REQUEST'), 'message'=>'Duplicate request','data'=>[]]);
            }
            
            Utility::stripXSS();
            $event_id = ($request->event_id) ? $request->event_id : 0;
			
			
            if(!$event_id){
                return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>'Please provide event ID','data'=>json_decode("{}")]);
            }
			  $validator = Validator::make($request->all(), [
                        'event_name' => 'required|string|max:255',
                        'email' => 'required|string|max:255',
                        'contact_person' => 'required|string|max:255',
                        'contact_no' => 'required|string',
						'joining_instruction'=>'required',
						'isHighlight'=>'required|integer',
						'short_description'=>'required',
                        'start_time'  => 'required|date_format:Y-m-d H:i:s|after:yesterday',
                        'end_time'  => 'required|date_format:Y-m-d H:i:s|after:yesterday',
						'lat'=>'required',
						'lng'=>'required',
                    ]);
			if($validator->fails())
			{
                            Log::debug(['add event validation failed',$request->all()]);
                            return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>'invalid data set','data'=>json_decode("{}")]);
                            //return response()->json($validator->errors()->toJson(), 400);
            } 
					

            $user  = JWTAuth::user();
            if($user->count()==0){
                return response()->json(['status'=> Config::get('app.status_codes.NP_NO_RESULT'), 'message'=>'User not found','data'=>json_decode("{}")]);
            }

            $eventObj = Event::where('id',$event_id)->where('user_id',$user->id)->first();			
            if ($eventObj == null) {
                return response()->json(['status'=> Config::get('app.status_codes.NP_NO_RESULT'), 'message'=>'no event data for this ID','data'=>json_decode("{}")]);
            } else {
                if(isset($request->country) && isset($request->state) && isset($request->city)){
                    $cityObj = new City();
                    $returnData  = $cityObj->getCountryStateCityByName($request);
                    if($returnData['error']==0 && $returnData['success']==1){
                        $country_id = $returnData['data']['country_id'];
                        $state_id = $returnData['data']['state_id'];
                        $city_id = $returnData['data']['city_id'];

                        $eventObj->country_id = $country_id;
                        $eventObj->state_id = $state_id;
                        $eventObj->city_id = $city_id;

                    }else{
                        return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>$returnData['message'],'data'=>[]]);
                    }
                }         
                
                if(isset($request->address)){
                    $request->address = $this->string_replace("__","/",$request->address);
                    $request->merge([
                      'address'=>$request->address
                    ]);
                }            

                if((isset($request->start_time) && $request->start_time < date('Y-m-d')) && (isset($request->end_time) && $request->end_time < date('Y-m-d'))){
                    return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>"Invalid Date",'data'=>[]]);

                }  

                //print_r($eventObj); die;
                $eventObj->event_name = ($request->event_name) ? ucwords(trim($request->event_name)) : ucwords(trim($eventObj->event_name));
                $eventObj->contact_person = ($request->contact_person) ? trim($this->string_replace("__","/",$request->contact_person)) : trim($eventObj->contact_person);
                $eventObj->contact_no = ($request->contact_no) ? trim($this->string_replace("__","/",$request->contact_no)): trim($eventObj->contact_no);
                $eventObj->address = ($request->address) ? ucfirst(trim($request->address)): ucfirst(trim($eventObj->address));
                $eventObj->email = ($request->email) ? trim($this->string_replace("__","/",$request->email)): trim($eventObj->email);
                $eventObj->sitting_capacity = ($request->sitting_capacity) ? trim($request->sitting_capacity): trim($eventObj->sitting_capacity);
                $eventObj->zip = ($request->zip) ? trim($request->zip) : trim($eventObj->zip);
                $eventObj->lat = ($request->lat) ? trim($request->lat): trim($eventObj->lat);
                $eventObj->lng = ($request->lng) ?  trim($request->lng) : trim($eventObj->lng);
                $eventObj->nearest = trim($request->nearest);
                $eventObj->nearest_distance = trim($request->nearest_distance);                
                $eventObj->mode = ($request->mode) ?  trim($request->mode) : trim($eventObj->mode);
				$eventObj->joining_instruction = ($request->joining_instruction) ?  ucwords(trim($request->joining_instruction)) : ucwords(trim($eventObj->joining_instruction));
				$eventObj->isHighlight = ($request->isHighlight) ?  trim($request->isHighlight) : trim($eventObj->isHighlight);
				$eventObj->short_description = ($request->short_description) ?  ucfirst(trim($request->short_description)) : ucfirst(trim($eventObj->short_description));
				//$eventObj->videoId = ($request->videoId) ?  $request->videoId : $eventObj->videoId;
                $eventObj->start_time = ($request->start_time) ?  $request->start_time : $eventObj->start_time;
                $eventObj->end_time = ($request->end_time) ? $request->end_time : $eventObj->end_time;
				$eventObj->meeting_link = ($request->meeting_link) ? $request->meeting_link : $eventObj->meeting_link;
				
                //$eventObj->status = '0';				
				if($eventObj)
				{
					$event_subscriber= DB::table('users')->select('users.*', 'event_subscriber.events_id as events_id', 'event_subscriber.users_id as users_id')->Join('event_subscriber', 'event_subscriber.users_id', '=', 'users.id')->where('users.notificationSetting', '1')->where('users.status', '1')->where('suspended', '0')->where('device_id', '!=', 'null')->where('device_id', '!=', '')->whereNotNull('device_id')->groupBy('users.id')->get();
					
                            $arr_deviceId = array();
                            foreach($event_subscriber as $arrId) {
                                $arr_deviceId[] = $arrId->device_id;
							
                            }
					
						   $arr_messageInfo['subject'] = $request->event_name .' '. 'updated';
                           $arr_messageInfo['messageBody'] = $request->event_name .' '. 'which you are intrested in is updated. Please check the latest updated in event list';
                          
                            $this->sendPushNotification($arr_deviceId, $arr_messageInfo);
				}
                
                if(!$eventObj->save()){
                    return response()->json(['status'=> Config::get('app.status_codes.NP_DB_ERROR'),'message'=>'Unable to save','data'=>json_decode("{}")]);                    
                }else{
                    return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_SUCCESS'),'message'=>'Event updated successfully','data'=>json_decode("{}")]);                    
                }                
            }
         }   
    }