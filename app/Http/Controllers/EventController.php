<?php

    namespace App\Http\Controllers;
    use App\Http\Controllers\Traits\NotifyMail;
	//use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Support\Facades\Crypt;
    use App\Event;
	use App\EventImage;
    use App\State;
    use App\City;
    use App\Country;
    use App\NotifyMe;
    use App\EventRating;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Traits\SendMail;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use Illuminate\Support\Facades\Log;
    use Config;
    use DateTime;
	
    
    use App\Http\Controllers\Controller; //---------encrypt
    
    use Mail;
	use DB;
	use App\User;
	

    class EventController extends Controller
    {
        use SendMail;

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
       
            try{            
                               
                return view('events.index');
            }catch(Exception $e){
                abort(500, $e->message());
            }
        }
		/**
         * Display a listing of the pending events.
         *
         * @return \Illuminate\Http\Response
         */
        public function pendingEvents()
        {
            try{            
                               
                return view('events.pendingEvents');
            }catch(Exception $e){
                abort(500, $e->message());
            }
        }

        /**
         * Approved event list ajax data tables
         */

        public function eventIndexAjax(Request $request){
     
            $draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
            $response = [
              "recordsTotal" => "",
              "recordsFiltered" => "",
              "data" => "",
              "success" => 0,
              "msg" => ""
            ];
            try {
                
                $start = ($request->start) ? $request->start : 0;
                $end = ($request->length) ? $request->length : 10;
                $search = ($request->search['value']) ? $request->search['value'] : '';
                //echo 'ddd';die;
                //$cond[] = ['status','1'];
				
				//where in condition for toggle button to change status if status 1 then it will 3 and if status 3 then it will be 1,for unwanted record not display in api list.//
				
                $events = Event::with(['Country','State','City'])->whereIn('status',['1', '3'])->orderBy('id', 'desc');
                //echo '<pre>'; print_r($users); die;
                
                if ($request->search['value'] != "") {            
                   $events->where(function($result) use($search){
                    $result->where('email','LIKE',"%".$search."%")
                        ->orWhere('event_name','LIKE',"%".$search."%")
					  ->orWhere('contact_no','LIKE',"%".$search."%")
					  ->orWhere('contact_person','LIKE',"%".$search."%")
					  ->orWhere('address','LIKE',"%".$search."%");
                   });
                } 
      
                $total = $events->count();
                if($end==-1){
                  $events = $events->get();
                }else{
                  $events = $events->skip($start)->take($end)->get();
                }
                
                if($events->count() > 0){
                    foreach($events as $k=>$v){

                      $events[$k]->email = $this->encdesc($events[$k]->email,'decrypt'); 
                      $events[$k]->contact_person = ucwords($this->encdesc($events[$k]->contact_person,'decrypt')); 
                      $events[$k]->contact_no = $this->encdesc($events[$k]->contact_no,'decrypt'); 
					  //$events[$k]->start_time =$events[$k]->start_time;
					 
					 
						/* if($events[$k]->start_time > date('Y-m-d H:i:s'))
						{						
						  $events[$k]->isedit=true;
						} 
						else 
						{
							$events[$k]->isedit= false;
						}  */
						
                    }
                  }   
			  
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
                //response["draw"] = draw;
                $response["success"] = 1;
                $response["data"] = $events;
                
              } catch (Exception $e) {    
      
              }
            
      
            return response($response);
        }   
			/**
         * Pending event list ajax data tables
         */

        public function pendingEventIndexAjax(Request $request){
     
            $draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
            $response = [
              "recordsTotal" => "",
              "recordsFiltered" => "",
              "data" => "",
              "success" => 0,
              "msg" => ""
            ];
            try {
                
                $start = ($request->start) ? $request->start : 0;
                $end = ($request->length) ? $request->length : 10;
                $search = ($request->search['value']) ? $request->search['value'] : '';
                //echo 'ddd';die;
                $cond[] = ['status','0'];
                $events = Event::with(['Country','State','City'])->where($cond)->orderBy('id', 'desc');
                //echo '<pre>'; print_r($users); die;
                
                if ($request->search['value'] != "") {            
                  /*  $events->where('email','LIKE',"%".$search."%")
                  ->orWhere('event_name','LIKE',"%".$search."%")
                  ->orWhere('contact_no','LIKE',"%".$search."%")
                  ->orWhere('contact_person','LIKE',"%".$search."%")
                  ->orWhere('address','LIKE',"%".$search."%");
				   */
				  $events->where(function($result) use($search){
                    $result->where('email','LIKE',"%".$search."%")
                        ->orWhere('event_name','LIKE',"%".$search."%")
					  ->orWhere('contact_no','LIKE',"%".$search."%")
					  ->orWhere('contact_person','LIKE',"%".$search."%")
					  ->orWhere('address','LIKE',"%".$search."%");
                   });
                } 
      
                $total = $events->count();
                if($end==-1){
                  $events = $events->get();
                }else{
                  $events = $events->skip($start)->take($end)->get();
                }
                
                if($events->count() > 0){
                    foreach($events as $k=>$v){
                      $events[$k]->email = $this->encdesc($events[$k]->email,'decrypt'); 
                      $events[$k]->contact_person = ucwords($this->encdesc($events[$k]->contact_person,'decrypt')); 
                      $events[$k]->contact_no = $this->encdesc($events[$k]->contact_no,'decrypt'); 
                    }
                  }     
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
                //response["draw"] = draw;
                $response["success"] = 1;
                $response["data"] = $events;
                
              } catch (Exception $e) {    
      
              }
            
      
            return response($response);
        }   		
        //use NotifyMail;
       
        function validateDateTime($dateStr, $format)
        {
            date_default_timezone_set('UTC');
            $date = DateTime::createFromFormat($format, $dateStr);
            return $date && ($date->format($format) === $dateStr);
        }
		
        public function changestatusEvents(Request $request)
		{		
			try
			{
					if(!$this->checkAuth(4))
					{
					   return abort(404);; 
					}				
					$events = new Event();
					$status = $request->status;
					$id = $request->eventid;
					$eventData = $events->findOrFail($id);
			
				if($eventData->count()>0)
				{			
					$eventData->status = $status;
					if($eventData->save())
					{
						
						$users = new User();
						$userDatas = $users->findOrFail($eventData->user_id);
						if($status==1)
						{
							
						  
							$userData = User::where([['device_id','!=',null],['device_id','!=',''],['device_id','!=','null']])->select('device_id')->get()->toArray();
							
						  $datas[] = [];
						  $msgBody =$eventData->event_name.' is published successfully for'.' '.$eventData->start_time;
						  /* $msgBody .= 'Poll Start Date: '.date('d-M-Y h:i A',strtotime($pollData->start_date));
						   $msgBody .=', Poll End Date: '.date('d-M-Y h:i A',strtotime($pollData->end_date)); */
						   
						   $datas['subject'] = ucfirst($eventData->event_name.' is published');
						   $datas['messageBody'] = ucfirst($msgBody);
						   
							$arr_deviceId = array();
							foreach($userData as $ukey=>$user){  
								if($user['device_id']!=null && $user['device_id']!='null')			
									$arr_deviceId[] = $user['device_id'];			  
							}
							$this->sendPushNotification($arr_deviceId,$datas);
							
							if(!empty($this->encdesc($userDatas->email,'decrypt')))
							{
								
								$data = [];
								$data['email'] = $this->encdesc($userDatas->email,'decrypt');
								$data['name'] = ucwords($userDatas->name);
								
								$data['event_name'] = ucwords($eventData->event_name);
								$data['supportEmail'] = config('mail.supportEmail');
								$data['website'] = config('app.site_url');  
								$data['site_name'] = config('app.site_name');                                           
								$data['subject'] = 'Event Approval Mail '.config('app.site_name'); 			
								
								$this->SendMail($data,'admin_event_approve');
							}
							
							return response()->json(["status"=>1,"message"=> "Record Activated Successfully", "data"=>json_decode("{}")]);            
						} 
						else if($status == 2)
						{
							
							if(!empty($this->encdesc($userDatas->email,'decrypt')))
							{
								$data = [];
								$data['email'] = $this->encdesc($userDatas->email,'decrypt');
								$data['name'] = ucwords($userDatas->name);
								
								$data['event_name'] = ucwords($eventData->event_name);
								$data['supportEmail'] = config('mail.supportEmail');
								$data['website'] = config('app.site_url');  
								$data['site_name'] = config('app.site_name');                                           
								$data['subject'] = 'Event Rejected Mail '.config('app.site_name'); 								
								$this->SendMail($data,'admin_event_reject');
							}
							
							
							return response()->json(["status"=>1, "message"=> "Record Rejected Successfully", "data"=>json_decode("{}")]);
						}
							
							/*else
							{
								$msg = "Record De-activated Successfully";
							}* 
						
						
					  else
					  {
						return response()->json(["status"=>0,"message"=>"Technical ERROR","data"=>json_decode("{}")]);            
					  }*/
					}					
					else
					{
					  return response()->json(["status"=>0,"message"=>"Technical error","data"=>json_decode("{}")]);          
					}
				}
				
			}
				  catch(Exception $e)
				  {
					abort(500, $e->message());
				  }
			
		}
		public function create()
		{
			return view('events.create');
		}
	Public function GetCities(Request $request)
	{
		if($request->get('search'))
		{
		  $query = $request->get('search');
		  $data = City::with('State.Country')->where('name', 'LIKE', $query . '%')->take(10)->get();
		
     	  //$data =City::where('name', 'LIKE', "%{$query}%")->take(10)->get();
		  $response = array();
		  foreach($data as $autocomplate){			 
			$state=$autocomplate->state;
			$country=$state->country;
			$response[] = array("value"=>$autocomplate->id,"label"=>$autocomplate->name .' , '.$state->name . ' , '.$country->name ,"lat"=>$autocomplate->lat,"lng"=>$autocomplate->lng,);
		  }
		  return json_encode($response);
		  /* 
		  if(count($response)>0)
		  {
			  echo json_encode($response);
		  }
		  else
		  {
			 
			  echo json_encode(array('value'=>'','label'=>''));
		  } */
		 /*  echo "<pre>";
		  print_r($response);
		  die; */
		  
        
     
		}
                     
    }
 	public function add(Request $request)
    {
		$validator = Validator::make($request->all(),[
		'event_name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/', 
		'lat_lng' =>'required', 
		'address' =>'required|max:255',                
		'nearest' => 'required',               
		'cities_id_hide'=>'required', 
		'contact_person' =>'required|max:255',
		'contact_no'=>'required',
		'email' => 'required|max:255',
		'joining_instruction'=>'required|max:255',
		'isHighlight'=>'required|max:1',
		'short_description'=>'required|max:255',
		'mode'=>'required',
		'sitting_capacity'=>'required',
		'start_time' => 'required', 
		'end_time' => 'required',  				
		],
		[
		'contact_no.integer'=>'Please enter valid phone number.',
		'contact_no.required'=>'phone number field is required.',		
		'lat_lng.required'=>'get location is field is required.',
		'cities_id_hide.required'=>'Please select city name.'
		]
		);
		if ($validator->fails())
		{    
                $errors=$validator->messages();
                return back()->withInput()->withErrors($errors);
        }
		else
		{
            $email =strtolower($request->email); //---------encrypt
            
			
			$state_data=City::where('id',$request->cities_id_hide)->select('state_id')->first();
		    $country_data=State::where('id',$state_data->state_id)->select('country_id')->first();
			$user  = JWTAuth::user();
			$id=$user->id;
			$lat_lng=explode(',',$request->lat_lng);
			$address_lat=$lat_lng[0];
			$address_lng=$lat_lng[1];
			
							
			
			$city_lat=$request->city_lat;
			$city_lng=$request->city_lng;
			if($request->nearest==1)
			{
				$kilometers=$this->distance($address_lat,$address_lng,$city_lat,$city_lng,$unit="K");
				$kilometer=round($kilometers,2);
				
			}
			else
			{
				$kilometer='0';
			}
			$event_data=[
			'user_id'=>$id,
			'event_name'=>ucwords(trim($request->event_name)),
			'address'=>ucfirst(trim($request->address)),
			'lat'=>trim($address_lat),
			'lng'=>trim($address_lng),
			'nearest'=>trim($request->nearest),
			'nearest_distance'=>trim($kilometer),
			'city_id'=>trim($request->cities_id_hide),
			'state_id'=>trim($state_data->state_id),
			'country_id'=>trim($country_data->country_id),
			'contact_person'=>trim($this->encdesc($request->contact_person,'encrypt')),
			'contact_no'=>trim($this->encdesc($request->contact_no,'encrypt')),
			'email'=>trim($this->encdesc($email,'encrypt')),
			'joining_instruction'=>ucwords(trim($request->joining_instruction)),
			'isHighlight'=>trim($request->isHighlight),
			'short_description'=>ucfirst(trim($request->short_description)),
			'mode'=>trim($request->mode),
			'sitting_capacity'=>trim($request->sitting_capacity),
			'start_time'=>trim($request->start_time),
			'end_time'=>trim($request->end_time),
			'city_lat'=>trim($city_lat),
			'city_lng'=>trim($city_lng),
			'meeting_link'=>trim($request->meeting_link),
			
			];
 			/*  echo "<pre>";
			print_r($event_data);
			die;  */
			$result=Event::create($event_data);
			if($result)
			{
                $userData = User::where([['device_id','!=',null],['device_id','!=',''],['device_id','!=','null']])->select('device_id')->get()->toArray();				
                $data[] = [];
                $msgBody =$request->event_name.' is created successfully for'.' '.$request->start_time;
                $data['subject'] = ucfirst($request->event_name.' is created');
                $data['messageBody'] = ucfirst($msgBody);
				   
				$arr_deviceId = array();
				foreach($userData as $ukey=>$user){  
					if($user['device_id']!=null && $user['device_id']!='null')			
						$arr_deviceId[] = $user['device_id'];			  
				} 
				 $this->sendPushNotification($arr_deviceId,$data);
				
			   return redirect()->action('EventController@index')->with('success', 'Event added successfully!');
			   //return response()->json([ 'success'=> 'Event added successfully!']);
			}
			else
			{
				return back()->with('errors', 'Failed to add event');				
				//return response()->json([ 'success'=> 'Something went wrong!']);
			}
		  
		}

    } 
	function distance($lat1, $lon1, $lat2, $lon2, $unit)
	{

		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);

		  if ($unit == "K") {
			  return ($miles * 1.609344);
		  } else if ($unit == "N") {
			  return ($miles * 0.8684);
		  } else {
			  return $miles;
		  }
	}
    
      public function Edit(Request $request)
      {
        $id = $request->id; 
		/* $editevent=DB::table('events')
					->join('event_image', 'event_image.events_id', '=', 'events.id')
					->join('event_subscriber', 'event_subscriber.events_id', '=', 'event_image.events_id')
					->select('events.*','event_image.image','event_subscriber.users_id')
					->where('events.id', '=', $id)
					->get()->toArray();
 */
		

		
		
        $editevent = Event::select('events.*', 'event_image.id as img_id', 'event_image.events_id', 'event_image.image_one', 'event_image.image_two', 'event_image.image_three', 'event_image.image_four')->where('events.id',$id)->leftJoin('event_image', 'event_image.events_id', '=', 'events.id')->first();
		/* echo "<pre>";
		print_r($editevent->start_time);
		die; */
		if($editevent){
		$contact_person=$this->encdesc($editevent->contact_person,'decrypt');		
		$contact_no=$this->encdesc($editevent->contact_no,'decrypt');
		$email=$this->encdesc($editevent->email,'decrypt');
		//$data = City::with('State.Country')->where('name', 'LIKE', $query . '%')->take(10)->get();
		$city =City::with('State.Country')->where('id',$editevent->city_id)->first();
		
		$state=$city->state;
		$country=$state->country;
		//$editimage = EventImage::where('events_id',$id)->first();	
		//$editeventimage=explode(',',$editimage->image);
        
        return view('events.edit_event')->with(['editevent'=>$editevent,'contact_person'=>$contact_person,'contact_no'=>$contact_no,'email'=>$email,'city'=>$city,'state'=>$state,'country'=>$country]);
		}
		else 
		{
			return redirect()->action('EventController@index')->with('flash_message_for_event_edit', 'Event not available')->with('flash_type', 'alert-danger'); 
		}
     }
     
    public function Update(Request $request)
    {
		/*  echo "<pre>";
		print_r($request->all()); */
		//die;   
		
		
        $user  = JWTAuth::user();
        $user_id=$user->id;	
		
		if(isset($request->iseditable) && $request->iseditable == true){
            $validator = Validator::make($request->all(),[
                    'event_name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/', 
                    'lat_lng' =>'required', 
                    'address' =>'required|max:255',                
                    'nearest' => 'required',               
                    'cities_id_hide'=>'required', 
                    'contact_person' =>'required|max:255',
                    'contact_no'=>'required',
                    'email' => 'required|email|max:255',
                    'joining_instruction'=>'required|max:255',
                    'isHighlight'=>'required|max:1',
                    'mode'=>'required',
                    'sitting_capacity'=>'required',			
                    'videoId'=>'required',
                    'start_time' => 'required', 
                    'end_time' => 'required', 			
                    'image_one' => 'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
                    'image_two' => 'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
                    'image_three' =>'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
                    'image_four' =>'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
                ],
                [
                    'contact_no.required'=>'phone number field is required',
                    'lat_lng.required'=>'get location is field is required.',
                    'cities_id_hide.required'=>'Please select city name.'
                ]
            );
            
		} else {
            
            $validator = Validator::make($request->all(),[
                    'event_name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/', 
                    'lat_lng' =>'required', 
                    'address' =>'required|max:255',                
                    'nearest' => 'required',               
                    'cities_id_hide'=>'required', 
                    'contact_person' =>'required|max:255',
                    'contact_no'=>'required',
                    'email' => 'required|email|max:255',
                    'joining_instruction'=>'required|max:255',
                    'isHighlight'=>'required|max:1',
                    'mode'=>'required',
                    'sitting_capacity'=>'required',	           
                    'start_time' => 'required',            
                ],
                [
                    'contact_no.required'=>'phone number field is required',
                    'lat_lng.required'=>'get location is field is required.',
                    'cities_id_hide.required'=>'Please select city name.'
                ]
            );
		}
        
        if ($validator->fails())
        {    
            $errors=$validator->messages();
            return back()->withErrors($errors);
        }
        else
        {
			
            $pushnotification = false;
            if(!isset($request->iseditable)) {
				
				
                
                $email=strtolower($request->email);
                
                $lat_lng=explode(',',$request->lat_lng);
                $address_lat=$lat_lng[0];
                $address_lng=$lat_lng[1];


                $city_lat=$request->city_lat;
                $city_lng=$request->city_lng;
                
                if($request->nearest==1)
                {
                    $kilometers=$this->distance($address_lat,$address_lng,$city_lat,$city_lng,$unit="K");
                    $kilometer=round($kilometers,2);
                }
                else
                {
                    $kilometer='0';
                }
				if($request->start_time <= date('Y-m-d H:i:s'))
				{
					
					$start_date=['start_date'=>'Event start date should be greater than current date and time'];
					return back()->withErrors($start_date);
				}
				if($request->end_time <= $request->start_time)
				{
					$end_date=['end_date'=>'Event end date should be greater than start date and time'];
					return back()->withErrors($end_date);
				}

                $state_data=City::where('id',$request->cities_id_hide)->select('state_id')->first();
                $state_id=$state_data->state_id;

                $country_data=State::where('id',$state_data->state_id)->select('country_id')->first();
                $country_id=$country_data->country_id;

                $event_data=[
                    'user_id'=>$user_id,
                    'event_name'=>ucwords(trim($request->event_name)),
                    'contact_person'=>trim($this->encdesc($request->contact_person,'encrypt')),
                    'contact_no'=>trim($this->encdesc($request->contact_no,'encrypt')),
                    'address'=>ucfirst(trim($request->address)),
                    'email'=>trim($this->encdesc($email,'encrypt')),
                    'joining_instruction'=>ucwords(trim($request->joining_instruction)),
                    'isHighlight'=>trim($request->isHighlight),
                    'short_description'=>ucfirst(trim($request->short_description)),
                    'city_id'=>trim($request->cities_id_hide),
                    'state_id'=>trim($state_id),
                    'country_id'=>trim($country_id),
                    'lat'=>trim($address_lat),
                    'lng'=>trim($address_lng),
                    'nearest'=>trim($request->nearest),
                    'nearest_distance'=>trim($kilometer),
                    'start_time'=>trim($request->start_time),
                    'end_time'=>trim($request->end_time),
                    //'videoId'=>trim($request->videoId),
                    'mode'=>trim($request->mode),
                    'sitting_capacity'=>trim($request->sitting_capacity),
					'city_lat'=>trim($city_lat),
					'city_lng'=>trim($city_lng),
					'meeting_link'=>trim($request->meeting_link),
                ];
				/*  echo "<pre>";
				print_r($event_data);
				die;  */ 
                $result = Event::where('id',$request->id)->update($event_data);
				
				if($result==1)
				{
					$pushnotification = true;
				}
				
				
				
            }
			
            
            if(isset($request->iseditable) && $request->iseditable == true) {
				$pushnotification=true;
				$data_video_id=['videoId'=>trim($request->videoId)];
				Event::where('id',$request->id)->update($data_video_id);
                $event_image = EventImage::where('events_id', $request->id)->first();
                
                if($request->file('image_one') || $request->file('image_two') || $request->file('image_three') || $request->file('image_four')) {
                    $data = array();
					
                    if($request->file('image_one')) {
						$pushnotification=true;
                        $data['image_one'] = $filename_one = $request->id .'_1_'.time().'.'.$request->image_one->getClientOriginalExtension();
                        $request->image_one->move(public_path('images/event'), $filename_one);
                    }

                    if($request->file('image_two')) {
						$pushnotification=true;
                        $data['image_two'] = $filename_two = $request->id .'_2_'.time().'.'.$request->image_two->getClientOriginalExtension();
                        $request->image_two->move(public_path('images/event'), $filename_two);
                    }

                    if($request->file('image_three')) {
						$pushnotification=true;
                        $data['image_three'] = $filename_three = $request->id .'_3_'.time().'.'.$request->image_three->getClientOriginalExtension();
                        $request->image_three->move(public_path('images/event'), $filename_three);
                    }

                    if($request->file('image_four')) {
						$pushnotification=true;
                        $data['image_four'] = $filename_four = $request->id .'_4_'.time().'.'.$request->image_four->getClientOriginalExtension();
                        $request->image_four->move(public_path('images/event'), $filename_four);
                    }
                    
                    if(isset($event_image->id))
					{
                        //update image
                        EventImage::where('id', $event_image->id)->update( $data );
                        
                        //delete old image
                        $path = public_path('images/event');
                        
                        if(isset($data['image_one'])) {
                            if (file_exists($path . '/' . $event_image->image_one)) @unlink($path . '/' . $event_image->image_one);
                        }
                        if(isset($data['image_two'])) {
                            if (file_exists($path . '/' . $event_image->image_two)) @unlink($path . '/' . $event_image->image_two);
                        }
                        if(isset($data['image_three'])) {
                            if (file_exists($path . '/' . $event_image->image_three)) @unlink($path . '/' . $event_image->image_three);
                        }
                        if(isset($data['image_four'])) {
                            if (file_exists($path . '/' . $event_image->image_four)) @unlink($path . '/' . $event_image->image_four);
                        }
                        
                    } 
					else 
					{
                        $data['events_id'] = $request->id;
                        EventImage::insert( $data );
                    }

                }
                $result = 1;
			}
			
            		if($pushnotification==true)
					{
						/* echo "<pre>";
						print_r("hii");
						die; */ 
						
						$event_subscriber= DB::table('users')->select('users.*', 'event_subscriber.events_id as events_id', 'event_subscriber.users_id as users_id')->Join('event_subscriber', 'event_subscriber.users_id', '=', 'users.id')->where('users.notificationSetting', '1')->where('users.status', '1')->where('suspended', '0')->where('device_id', '!=', 'null')->where('device_id', '!=', '')->whereNotNull('device_id')->groupBy('users.id')->get()->toArray();
						/*  echo "<pre>";
						print_r($event_subscriber);
						die;  */
                            $arr_deviceId = array();
                            foreach($event_subscriber as $arrId) {
                                $arr_deviceId[] = $arrId->device_id;
							
                            }
						
						   $arr_messageInfo['subject'] = ucfirst($request->event_name .' '. 'updated');
                           $arr_messageInfo['messageBody'] = ucfirst($request->event_name .' '. 'which you are intrested in is updated. Please check the latest updated in event list');
                          
                            $this->sendPushNotification($arr_deviceId, $arr_messageInfo);

					}
            if($result == 1) 				
                return redirect()->action('EventController@index')->with('success', 'Event updated successfully');
            else 
                return back()->with('errors', 'Failed to upadte event');
        }
    }
	public function DeleteImages(Request $request)
	{
		$image_data=explode(',',$request->images_data_id_name);
		$img_id=$image_data[0];
		$events_id=$image_data[1];
		$image_name=$image_data[2];
		$names=explode('_',$image_name);
		$name=$names[1];
		if($name=='1')
		{
			
			$data=[
			'image_one'=>NULL,	
			];
		}
		if($name=='2')
		{
			$data=[
			'image_two'=>NULL,	
			];
			
		}
		if($name=='3')
		{
			$data=[
			'image_three'=>NULL,	
			];
		}
	    if($name=='4')
		{
			$data=[
			'image_four'=>NULL,	
			];
		}
		$deleteimage = EventImage::where('id', $img_id)->where('events_id',$events_id)->update($data);
		if($deleteimage==1){
  
		return response()->json([
			'image_success' => 'Image deleted successfully!'
		]);
		} 
		else
		{
			return response()->json([
			'image_unsucees' => 'Something went wrong!'
		]);
		}
			
		
	}
	public function EventAboutToStart(Request $request)
	{
			
			try
			{
				
				$current_date_time = date('Y-m-d H:i:s');				
				$date_time = date('Y-m-d H:i:s',strtotime('+2 hours'));	
				/* echo $current_date_time ;
				echo "<br>";
				echo $date_time ; */
				$status = '1';
				$events = Event::orderBy('id','DESC')
								->where('status',$status)
								->whereBetween('start_time',[$current_date_time,$date_time])
								->select('id','user_id','event_name','start_time','end_time')->get();
				/* echo "<pre>";
				print_r($events);
				die; */
				if($events)
				{
					foreach($events as $event_data)
					{				
						$event_subscriber= DB::table('users')->select('users.device_id', 'event_subscriber.events_id as events_id', 'event_subscriber.users_id as users_id')->Join('event_subscriber', 'event_subscriber.users_id', '=', 'users.id')->where('users.notificationSetting', '1')->where('users.status', '1')->where('suspended', '0')->where('device_id', '!=', 'null')->where('device_id', '!=', '')->whereNotNull('device_id')->where('event_subscriber.events_id',$event_data->id)->get();
					
							$arr_deviceId = array();
							foreach($event_subscriber as $arrId) {
								$arr_deviceId[] = $arrId->device_id;
							
							}
							/* echo "<pre>";
							print_r($arr_deviceId);
							die; */
						   $arr_messageInfo['subject'] ='Reminder';
						   $arr_messageInfo['messageBody'] = $event_data->event_name .' '. 'will be held today at'.' '.$event_data->start_time;
							
							$this->sendPushNotification($arr_deviceId, $arr_messageInfo); 
					}
				}
				
			}
			catch(Exception $e)
			{
				abort(500, $e->message());
			} 
	}
	public function rejectedEvents(Request $request) 
	{
        try {
            return view('events.rejected_events');
        } catch(Exception $e) {
            abort(500, $e->message());
        }
    }
	public function rejectedEventsAjax(Request $request)
	{
		

			$draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
            $response = [
              "recordsTotal" => "",
              "recordsFiltered" => "",
              "data" => "",
              "success" => 0,
              "msg" => ""
            ];
            try {
                
                $start = ($request->start) ? $request->start : 0;
                $end = ($request->length) ? $request->length : 10;
                $search = ($request->search['value']) ? $request->search['value'] : '';
                //echo 'ddd';die;
                $cond[] = ['status','2'];
                $events = Event::with(['Country','State','City'])->where($cond)->orderBy('id', 'desc');
               
                
                if ($request->search['value'] != "") {            
                  /*  $events->where('email','LIKE',"%".$search."%")
                  ->orWhere('event_name','LIKE',"%".$search."%")
                  ->orWhere('contact_no','LIKE',"%".$search."%")
                  ->orWhere('contact_person','LIKE',"%".$search."%")
                  ->orWhere('address','LIKE',"%".$search."%");
				   */
				  $events->where(function($result) use($search){
                    $result->where('email','LIKE',"%".$search."%")
                        ->orWhere('event_name','LIKE',"%".$search."%")
					  ->orWhere('contact_no','LIKE',"%".$search."%")
					  ->orWhere('contact_person','LIKE',"%".$search."%")
					  ->orWhere('address','LIKE',"%".$search."%");
                   });
                } 
      
                $total = $events->count();
                if($end==-1){
                  $events = $events->get();
                }else{
                  $events = $events->skip($start)->take($end)->get();
                }
                
                if($events->count() > 0){
                    foreach($events as $k=>$v){
						 
                      $events[$k]->email = $this->encdesc($events[$k]->email,'decrypt'); 
                      $events[$k]->contact_person = ucwords($this->encdesc($events[$k]->contact_person,'decrypt')); 
                      $events[$k]->contact_no = $this->encdesc($events[$k]->contact_no,'decrypt'); 
                    }
                  }     
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
                //response["draw"] = draw;
                $response["success"] = 1;
                $response["data"] = $events;
                
              } catch (Exception $e) {    
      
              }
            
      
            return response($response);
    }
	
	public function changestatusEventsToggle(Request $request)
	{
			try
			{
					if(!$this->checkAuth(4))
					{
					   return abort(404);; 
					}				
					$events = new Event();
					$status = $request->status;
					$id = $request->eventid;
					$eventData = $events->findOrFail($id);
			
					if($eventData->count()>0)
					{			
						if($status=='1')
						{
							$status='3';
							$event_status_change=['status'=>$status,							
							];
							$result=Event::where('id',$id)->update($event_status_change);
							if($result==1)
							{
								$msg = "Record De-activated Successfully";  
								
							}
							return response()->json(["status"=>3,"message"=>$msg,"data"=>json_decode("{}")]);
						}
						else if($status=='3')
						{
							$status='1';
							$event_status_change=['status'=>$status,							
							];
							$result=Event::where('id',$id)->update($event_status_change);
							if($result==1)
							{
								$msg = "Record Activated Successfully";  
								
							}
						return response()->json(["status"=>1,"message"=>$msg,"data"=>json_decode("{}")]);
						}
						
					}      
					else
					{
						return response()->json(["status"=>0,"message"=>"Technical ERROR","data"=>json_decode("{}")]);            
					}
          }
        catch(Exception $e){
          abort(500, $e->message());
        }

	}
	

    
    
}