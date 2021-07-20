<?php

    namespace App\Http\Controllers\v5;
    
    use App\Event;
    use App\State;
    use App\City;
    use App\Country;
	use App\EventImage;
    use App\User;
    use App\NotifyMe;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Http\Request;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Controllers\Traits\SendMail;
    use Config;
    use App\Common\Utility;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\DB;
    use App\duplicateRequest;
	use App\Models\EventSubscriber;
	use App\Http\Controllers\Controller; //---------encrypt

    class EventController extends Controller
    {
		public function addEventSubscribers(Request $request)
		{
			$status=Config::get('app.status_codes');
			$user  = JWTAuth::user();
				$user_id = $user->id;				
				$users_id=$user_id;
			try{				
					$rules = [           
						 'events_id' => 'required|numeric',
						 //'users_id'=>'required|numeric'
					];
				   $validation = Validator::make($request->all(), $rules);
				   if ($validation->fails())
				   {
						 $data=[
							'status'=>$status['NP_INVALID_REQUEST'], 
							'error'=>'Something went wrong', 
						 ];
						 return response()->json($data,403);
				   }
				   else
					{
						$vaildate_user_id=EventSubscriber::where('users_id', $users_id)->where('events_id',$request->events_id)->count()>0;
						/* echo "<pre>";
						print_r($vaildate_user_id);
						die; */
						//$users_id=$vaildate_user_id->users_id;
						
						if($vaildate_user_id)
						{
							$alldata=[
								'status'=>$status['NP_DUPLICATE_REQUEST'],
								'message'=>'User Id already exists',						        
								];
								return response()->json($alldata); 
						}
						else
						{
							   $event_subscribers=
							   [
							   'events_id'=>trim($request->events_id),
							   'users_id'=>trim($users_id)
							   ];
							   $event_subscribers_data=EventSubscriber::create($event_subscribers);	
							   if($event_subscribers_data)
								{
									$alldata=[
									'status'=>$status['NP_STATUS_SUCCESS'],
									'message'=>'Request processed successfully',						        
									];
									return response()->json($alldata); 
								}
								else
								{
									$alldata=[
									'status'=>$status['NP_DB_ERROR'],
									'message'=>'Something went wrong',						        
									];
									return response()->json($alldata); 
							   }
						}
					}
			}
			catch(Exception $e)
			{
				//echo "catech";
					return response()->json([
					  'status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'),
					  ],403);
					
			}
	}
	public function uploadEventImages(Request $request)
	{
		$status=Config::get('app.status_codes');
		$user  = JWTAuth::user();
		$user_id = $user->id;				
		$users_id=$user_id;
		
		try
		{				
			$rules = [           
						  'events_id' => 'required|numeric',
						  //'videoId'=>'required',
						  'image_one' => 'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
						  'image_two' => 'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
                          'image_three' =>'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048',
                          'image_four' =>'image|mimes:jpeg,jpg,png,JPEG,JPG,PNG|max:2048'
					];
			$validation = Validator::make($request->all(), $rules);
			if ($validation->fails())
			{
				$data=[
					'status'=>$status['NP_INVALID_REQUEST'], 
					'error'=>'Something went wrong', 
				];
				return response()->json($data,403);
			}
			else
			{
				$event_list=Event::where('id',$request->events_id)->where('user_id',$users_id)->first();
				if(!$event_list)
				{
					$alldata=[
									'status'=>$status['NP_DB_ERROR'],
									'message'=>'You are not authorised user to edit this event ',						        
							];
							return response()->json($alldata);
				}
				$pushnotification = false;
				if($request->videoId)
				{
						
						$pushnotification=true;
                        $data_video_id =['videoId'=>trim($request->videoId)];
						$resultVideoId=Event::where('id',$request->events_id)->where('user_id',$users_id)->update($data_video_id);
						
						if($resultVideoId == 0)
						{
								$alldata=[
									'status'=>$status['NP_DB_ERROR'],
									'message'=>'event or user id does not matched',						        
									];
									//return response()->json($alldata); 
						}
						else
						{
							$alldata=[
									'status'=>$status['NP_STATUS_SUCCESS'],
									'message'=>'Request processed successfully',						        
									];
									//return response()->json($alldata); 
						}
						
                }
				else
				{
					$pushnotification=true;
                    $data_video_id =['videoId'=>null];
				    $resultVideoId=Event::where('id',$request->events_id)->where('user_id',$users_id)->update($data_video_id);
						if($resultVideoId == 0)
						{
								$alldata=[
									'status'=>$status['NP_DB_ERROR'],
									'message'=>'event or user id does not matched',						        
									];
									//return response()->json($alldata); 
						}
						else
						{
							$alldata=[
									'status'=>$status['NP_STATUS_SUCCESS'],
									'message'=>'Request processed successfully',						        
									];
									//return response()->json($alldata); 
						}
					
				}
					
				$event_image = EventImage::where('events_id', $request->events_id)->first();
				
				$imageOne   = $request->file('image_one')??NULL;
				$imageTwo   = $request->file('image_two')??NULL;
				$imageThree = $request->file('image_three')??NULL;
				$imageFour  = $request->file('image_four')??NULL;
				
				/* if($request->file('image_one') || $request->file('image_two') || $request->file('image_three') || $request->file('image_four'))
				{ */
					
                    $data = array();					
                    if($imageOne)
					{
						$pushnotification=true;
                        $data['image_one'] = $filename_one = $request->events_id .'_1_'.time().'.'.$imageOne->getClientOriginalExtension();
                        $imageOne->move(public_path('images/event'), $filename_one);
                    }
					else
					$data['image_one']= NULL;

                    if($imageTwo)
					{
						$pushnotification=true;
                        $data['image_two'] = $filename_two = $request->events_id .'_2_'.time().'.'.$imageTwo->getClientOriginalExtension();
                        $imageTwo->move(public_path('images/event'), $filename_two);
                    }
					else
					$data['image_two']= NULL;

                    if($imageThree)
					{
						$pushnotification=true;
                        $data['image_three'] = $filename_three = $request->events_id .'_3_'.time().'.'.$imageThree->getClientOriginalExtension();
                        $imageThree->move(public_path('images/event'), $filename_three);
                    }
					else
					$data['image_three']= NULL;

                    if($imageFour)
					{
						$pushnotification=true;
                        $data['image_four'] = $filename_four = $request->events_id .'_4_'.time().'.'.$imageFour->getClientOriginalExtension();
                        $imageFour->move(public_path('images/event'), $filename_four);
                    }
					else
					$data['image_four']= NULL;
                    
                    if(isset($event_image->id))
					{	
						
					    /* EventImage::where('id', $event_image->id)->update(['image_one'=>null,'image_two'=>null,'image_three'=>null,'image_four'=>null]); */
                        $updateEvent=EventImage::where('id', $event_image->id)->update( $data );
                        
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
						if($updateEvent)
						{
									$alldata=[
									'status'=>$status['NP_STATUS_SUCCESS'],
									'message'=>'Request processed successfully',						        
									];
									//return response()->json($alldata); 
						}
						else
						{
							//echo "hi";die;
									$alldata=[
									'status'=>$status['NP_DB_ERROR'],
									'message'=>'Something went wrong',						        
									];
									//return response()->json($alldata); 
						}
                        
                    } 
					else 
					{
                        $data['events_id'] = $request->events_id;
                        $EventImageSave=EventImage::insert( $data );

								if($EventImageSave)
								{
									$alldata=[
									'status'=>$status['NP_STATUS_SUCCESS'],
									'message'=>'Request processed successfully',						        
									];
									//return response()->json($alldata); 
								}
								else
								{
									$alldata=[
									'status'=>$status['NP_DB_ERROR'],
									'message'=>'Something went wrong',						        
									];
									//return response()->json($alldata); 
							   }
                    }
				/* }
				else
				{
					EventImage::where('id', $event_image->id)->update(['image_one'=>null,'image_two'=>null,'image_three'=>null,'image_four'=>null]);
					
				} */ 
				
				if($pushnotification==true)
				{
					
					$event_subscriber= DB::table('users')->select('users.*', 'event_subscriber.events_id as events_id', 'event_subscriber.users_id as users_id')->Join('event_subscriber', 'event_subscriber.users_id', '=', 'users.id')->where('users.notificationSetting', '1')->where('users.status', '1')->where('suspended', '0')->where('device_id', '!=', 'null')->where('device_id', '!=', '')->whereNotNull('device_id')->get();

						$arr_deviceId = array();
						foreach($event_subscriber as $arrId) {
							$arr_deviceId[] = $arrId->device_id;
						
						}
  
					   $arr_messageInfo['subject'] =$event_list->event_name .' '. 'updated';
					   $arr_messageInfo['messageBody'] = $event_list->event_name .' '. 'which you are intrested in is updated. Please check the latest updated in event list';
						
						$this->sendPushNotification($arr_deviceId, $arr_messageInfo);
						

				}
				
						
				
				return response()->json($alldata); 

		    }
		}
		catch(Exception $e)
		{				
			return response()->json([
			'status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'),
			],403);
					
		}
		
	}
}