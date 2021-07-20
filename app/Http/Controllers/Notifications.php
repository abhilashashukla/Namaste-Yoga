<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
    
	use App\Models\Notification;
    
	use Auth;
    use DB;
	use App\Common\Utility;
    
    //use Curl;
	
    
    class Notifications extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function listGeneralNotifications()
        {
            //Log::info('General notification list:');
            try{
				$notifications = array();// Notification::orderBy('notification_id','DESC')->paginate(config('app.paging'));
				
				//$notifications = Notification::orderBy('notification_id','DESC')->paginate(Config::get('app.record_per_page'));
				
                return view('notifications.notificationlist', ['notifications' => $notifications]);
            }catch(Exception $e){
                abort(500, $e->message());
            }
        }
		
		
        /**
         * Notification list ajax data tables
         */
        public function notificationIndexAjax(Request $request){
			/* echo "<pre>";
			print_r($request->session()->all());
			die; */
			
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
                //$search = ($request->search['value']) ? $request->search['value'] : '';
				
                $notifications = Notification::orderBy('id','DESC');
                
				$total = $notifications->count();
				
                if($end == -1){
                  $notifications = $notifications->get();
                }else{
                  $notifications = $notifications->skip($start)->take($end)->get();
                }
                
                if($notifications->count() > 0){
                    foreach($notifications as $key => $value){
                        
                        $notifications[$key]->id = $value->id;
                        $notifications[$key]->notification_name = $value->notification_name;
                        $notifications[$key]->notification_message = $value->notification_message;
                        //$notifications[$key]->created_at = 1616765811;
                        
                        $created_at = (int)strtotime($value->created_at);
                        $notifications[$key]->created_date = date('d-M-Y h:i A', $created_at);
                        
                        //$notifications[$key]->created_at = \Carbon\Carbon::parse(strtotime($value->created_at))->format('M d, Y');//date('d-M-Y h:i A', strtotime($value->created_at));
                    }
                }
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
				
                $response["success"] = 1;
                $response["data"] = $notifications;
                
              } catch (Exception $e) {    
      
              }
			  
            return response($response);
        }
		
		public function sendGeneralNotification(Request $request) {
            $status = '';
            $message = '';
            try {
								
                if ($request->isMethod('post')) {
					$validator = Validator::make($request->all(),[
					'captcha' => 'required|captcha'
				]);	
				 if ($validator->fails()) {    
								$errors=$validator->messages();
								return back()->withInput()->withErrors($errors);
							} 
				
                    $notification_name = trim($request->input('notification_name'));
                    $notification_message = trim($request->input('notification_message'));
                    
                    if($notification_name !='' || $notification_message !='') {
                        $obj_notif = new Notification;
                        
                        $obj_notif->notification_name = ucfirst($notification_name);
                        $obj_notif->notification_message = ucfirst($notification_message);
                        $obj_notif->created_by = Auth::user()->id;
                        
                        $arr_messageInfo['subject'] = ucfirst($notification_name);
                        $arr_messageInfo['messageBody'] = ucfirst($notification_message);

                        if( $obj_notif->save() ){
                            //$arr_general_device_tokens = DB::table('general_device_tokens')->get();
                            
                            $tokens1 = DB::table('general_device_tokens')->select('device_id')->where('device_id', '!=', "'null'")->where('device_id', '!=', '')->get();
            
                            $tokens2 = DB::table('users')->select('device_id')->where('status', '1')->where('suspended', '0')->where('notificationSetting', '1')->where('device_id', '!=', 'null')->where('device_id', '!=', '')->whereNotNull('device_id')->get();
                            
                            $arr_deviceId = array();
                            foreach($tokens1 as $arrId) {
                                $arr_deviceId[] = $arrId->device_id;
                            }
                            foreach($tokens2 as $arrId2) {
                                $arr_deviceId[] = $arrId2->device_id;
                            }
                            
                            //$arr_deviceId = array_unique($arr_deviceId);
                            //echo'<pre>';
                            //print_r($arr_deviceId);
                            
                            $this->sendPushNotification($arr_deviceId, $arr_messageInfo);

                            //$status = 1;
                            //$message = 'Notification message sent successfully.';
							$message=['message'=>'Notification message sent successfully'];
							return redirect()->action('Notifications@listGeneralNotifications')->with($message);
                        }
                    } else {
                        //$status = 0;						
                        $unsuccess=['unsuccess'=>'Please enter valid informations.'];
						return back()->with($unsuccess);
                    }
                }
                
            } catch (Exception $ex) {
                //$status = 0;
                $unsuccess=['unsuccess'=>'Somthing went wrong. Try again.'];
				return back()->with($unsuccess);
            }
            return view('notifications.create');
            //return view('notifications.create', ['status' => $status, 'message' => $message]);
		}
        
        
        
        /*public function phpinfo() {
            echo phpinfo();
            exit;
        }
		*/
    public function refreshCaptcha()
    {
        return captcha_img('flat');
    }

    }