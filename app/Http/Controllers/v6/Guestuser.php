<?php

namespace App\Http\Controllers\v6;

use App\User;
use App\NotifyMe;
use App\OtpHistory;
use Illuminate\Http\Request;

//use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Traits\SendMail;
use App\Common\Utility;

use Config;
use Mail;

//use Carbon;
//use App\Mail\WelcomeMail;
//use Illuminate\Support\Facades\Mail;

class Guestuser extends Controller
{
	use SendMail;
	
	public function guestUserRegistration(Request $request) {
		
		Utility::stripXSS();
		DB::beginTransaction();
		
		$message = "";
		$status = Config::get('app.status_codes');
		
		try {
			if(!$this->verifyChecksum($request)) {
				return response()->json(["status"=>$status['NP_STATUS_FAIL'], "message"=>'Checksum not verified', "data"=>json_decode('{}')]);
			}

			$request->email = $this->string_replace("__","/",$request->email);
			$request->password = $this->string_replace("__","/",$request->password);
			$request->phone = $this->string_replace("__","/",$request->phone);
			
			//$request->name = $this->string_replace("__","/",$request->name);

			$request->merge([
				'email' => $request->email,
				'password' => $request->password,
				'phone' => $request->phone,
			]);
			
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:155',
                'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6',
                'phone' => 'required|string|min:10|max:10|unique:users',	//integer
            ]);
			

			if($validator->fails()){
				$error = json_decode(json_encode($validator->errors()));
				
				if(isset($error->name[0])){
					$message =	$error->name[0];
				}else if(isset($error->email)){
					$message =	$error->email[0];
				}else if(isset($error->password)){
					$message =	$error->password[0];
				}else if(isset($error->phone)){
					$message =	$error->phone[0];
				}
				
				return response()->json(["status"=>$status['NP_STATUS_FAIL'], "message"=> $message, "data"=> json_decode("{}")]);
				
            } else {
				$otp = rand(111111, 999999);
            }
			
			
			$data = [];
			$data['email'] = $this->encdesc($request->get('email'),'decrypt');
			$data['name'] = $request->get('name');
			$data['supportEmail'] = config('mail.supportEmail');
			$data['website'] = config('app.site_url');
			$data['site_name'] = config('app.site_name');
			
			$data['subject'] = 'Registration OTP from '.config('app.site_name');
			$otp = rand(111111,999999);
			$data['otp'] = $otp;			
			
			$user = User::create([
				'name' => $request->get('name'),
				'email' => $request->email,
				'phone' => $request->phone,
				'password' => Hash::make($request->password),
				
				//'user_type' => 'Guest',//need to define
				
				//'lat' => $request->get('lat'),
				//'lng' => $request->get('lng'),
				
				'device_id' => $request->get('device_id'),
				'otp' => $otp
			]);
			
			$token = JWTAuth::fromUser($user);
			DB::commit();
			
			$data = array(
				'name' => $user->name,
				'email' => $user->email,
				'otp' => $otp
			);
			
			
			/*
			Log::info('Create new user profile for user. Email sent from:'.config('mail.from.address'));
			*/
			
			//need to test mail
			/*if($this->SendMail($data,'registration_otp')){
				$error = 0;
			}
			*/
			//check error then send
			return response()->json(["status"=>$status['NP_STATUS_SUCCESS'], "message"=>"Email sent.", "data"=>compact('user','token')]);
			
			
		} catch(Exception $e){
			return response()->json(['status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'), 'message'=>'Something went wrong. Please try again.','data'=>json_decode("{}")]);
		}
	}
	
	
	public function deviceTokenUpdate(Request $request) {
		
		Utility::stripXSS();
		DB::beginTransaction();
		
		$status = Config::get('app.status_codes');
		
		try {
			if(!$this->verifyChecksum($request)) {
				return response()->json(["status"=>$status['NP_STATUS_FAIL'], "message"=>'Checksum not verified', "data"=>json_decode('{}')]);
			}
			
			if($request->device_token != '') {
				
				//add query for check and insert record in general_device_token table
				//----------------
				//-------------------
				
				return response()->json(["status"=>$status['NP_STATUS_SUCCESS'], "message"=> $message, "data"=> json_decode("{}")]);
			} else {
				return response()->json(["status"=>$status['NP_STATUS_FAIL'], "message"=> "Device token missing.", "data"=> json_decode("{}")]);
			}
			
		} catch(Exception $e){
			return response()->json(['status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'), 'message'=>'Something went wrong. Please try again.','data'=>json_decode("{}")]);
		}
	}
	
	
	public function clearData(){
		DB::table('duplicate_request')->delete();
		DB::table('otp_history')->delete();
	}

}
