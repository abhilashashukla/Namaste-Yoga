<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\City;
use App\State;
use App\Country;
use App\SaveRegistration;
use App\Visitor;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Event;
use Illuminate\Support\Facades\Hash;
use App\OtpHistory;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\SendMail;

use App\Http\Controllers\Controller;

use Config;
use Mail;


class Registration extends Controller
{
    use SendMail;
  public function city(Request $request){
      $search = $request->search;
     // $employees = RegistrationCity::orderby('name','asc')->select('id','name','lat','lng','state_id')->where('name', 'like', '%' .$search . '%')->get();
      // echo '<pre>';
      // print_r($employees);die();
	  $employees=City::with('State.Country')->where('name', 'LIKE', $search . '%')->take(10)->get();
      $response = array();
      foreach($employees as $employee){
		  $state=$employee->state;
         $response[] = array("value"=>$employee->id,"label"=>$employee->name .' , '.$state->name,"latitude"=>$employee->lat,"longitude"=>$employee->lng,"state_id"=>$state->id);
      }
      return response()->json($response);
   }


public function registerForm(){
  try{

    //select role_id, count(role_id) AS count FROM users GROUP BY role_id HAVING role_id > 1


    $ip = \Request::ip();
    $visit_date = date('Y-m-d');

    $visitor = Visitor::firstOrCreate(['ip'=>$ip,'visit_date'=>$visit_date]);

    if($visitor->visit_date != date('Y-m-d')){
      $visitor->hits = $visitor->hits+1;
      $visitor->visit_date = $visit_date;
      $visitor->save();
    }


    $visitorObj = new Visitor();
    $visitorCount = $visitorObj->getVisitorCount();
    $data = User::select('role_id',DB::raw('count(role_id) as role_count'))
    ->groupBy('role_id')
    ->havingRaw('role_id > 1')->get();

    $event = Event::select(DB::raw('count(*) as event_count'))
    ->where('status','1')
    ->get();
    $trainer = isset($data[1]->role_count) ? $data[1]->role_count : 0;
    $center = isset($data[0]->role_count) ? $data[0]->role_count : 0;
    $event = isset($event[0]->event_count) ? $event[0]->event_count : 0;
    //echo '<pre>';print_r($data[1]->role_count); die;
    return view('pages/register',["center"=>$center,
    "trainer"=>$trainer,
    "events"=>$event,
    'visitor_count'=>$visitorCount
    ]);
  }catch(Exception $e){
    abort(500, $e->message());
  }
//  return view('pages/register');

}

   public function RegisterOtp(Request $request){

     $employees = SaveRegistration::select('email')->where('email',$request->encyrpted_email)->get();

     if(count($employees) > 0)
     {
         return response()->json(['success'=>false,'message'=>'Email id already registered']);

     }else{
     try{
         $status = 0;
         $message = "";

         $request->merge([
           'email'=>$request->email
         ]);

         $validator = Validator::make($request->all(), [
           'email' => 'required|string|max:255'
         ]);

         if($validator->fails()){
           return response()->json(["status"=> Config::get('app.status_codes.NP_STATUS_FAIL'), "message"=>"Please send email","data"=>json_decode("{}")]);
         }
          $email = $this->encdesc($request->email, 'encrypt');

         $employees = SaveRegistration::select('email')->where('email',$email)->get();

         if(count($employees) > 0)
         {
         return response()->json(['success'=>false,'message'=>'Email id already registered']);
         die;
         }



         $otpHistory = new OtpHistory();
         $otpHistory->type = 'RG';
         $otpHistory->save();

         // if(!$this->checkOtpHistory('RG',$user->id)){
         //     return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_FAIL'),'message'=>'Your OTP limit over now. Please try after 24 hour','data'=>json_decode("{}")]);
         // }

         $otp = rand(111111,999999);
         $data['name'] = ucwords($request->name);
         $data['otp'] = $otp;
         $data['email'] = $request->email;
         $data['supportEmail'] = config('mail.supportEmail');
         $data['website'] = config('app.site_url');
         $data['site_name'] = config('app.site_name');
         $data['subject'] = 'New OTP on Registration';

         if($this->SendMail($data,'registration_otp')){
           $request->session()->put('otp',$otp);
           
           return response()->json(["status"=> Config::get('app.status_codes.NP_STATUS_SUCCESS'), "message"=>"Otp sent successfully to your email id."]);
         }
         //$validator->errors()
     }catch(Exception $e){
       return response()->json(['status'=> Config::get('app.status_codes.NP_INVALID_REQUEST'), 'message'=>'Exception error']);
     }
   }
 }


   public function saveRegister(Request $request){

            $request->trainer_email = $this->encdesc($request->trainer_email, 'encrypt');
          //  print_r($request->trainer_email);die;
            $request->trainer_mobile = $this->encdesc($request->trainer_mobile, 'encrypt');

            $save =  new SaveRegistration();

            $employees = SaveRegistration::select('email')->where('email',$request->trainer_email)->get();



            if(count($employees) > 0)
            {
            return response()->json(['success'=>false,'message'=>'Email id already registered']);
            die;
            }else{
           if($request->session()->get('otp')!=$request->otp){
             return response()->json(['success'=>false,'message'=>'Please enter the correct Otp.']);
             die;
           }else{
           $lat_lon  = explode(',',$request->trainer_location);



        $save->name = $request->trainer_name;

        $save->email = $request->trainer_email;
        $save->phone = $request->trainer_mobile;

        $save->city_id = $request->city_id;

        $save->state_id =  $request->state_id;
        $save->role_id = $request->form_type === '1' ? '3': '2' ;

        $save->password = Hash::make($request->trainer_password);//$request->trainer_password;
        $save->type = $request->form_type === '1' ? 'C': 'P';
        $save->user_type = $request->form_type === '1' ? $request->trainer : 'Public';



        $save->address = $request->trainer_address;
        $save->lat = $lat_lon[0];
        $save->lng =  $lat_lon[1];
        $save->nearest = $request->city_input === 'nearby_city' ? 1 : 0;
        $save->nearest_distance = $request->city_input === 'curent_city' ? NULL : $request->distance;
        $save->token = $request->_token;
        $save->otp = $request->otp;
        $save->device_id = Auth::id();
        $save->deviceType = 'web';
        $save->sitting_capacity = $request->sitting_capacity;
        $save->ycb_number = $request->trainer_certificate_no;
        $save->ycb_approved = $request->form_type === '1' ? '0': '1';
        $save->status =  '0';

        $validator = Validator::make($request->all(), [
            'trainer_name' => 'required',
            'trainer_password' => 'required',
            'trainer_mobile' => 'required',
            'trainer_email' => 'required',
            'trainer_address' => 'required',
            'city_latitude' => 'required',
            'city_logitude' => 'required',
        ]);
// print_r($request->all());

        if($validator->fails()){
          return response()->json(['sucess'=>false,'message'=>'This filed is required']);
        }else{
          $resutl =  $save->save();
        if(  $resutl > 0){
			$message1 = 'Your registration details have been sent to the administrator for approval. Once approved,your listing will be visible on the Namaste Yoga app.';
			return response()->json(['success'=>true,'message'=> $message1]);

            // return response()->json(['success'=>true,'message'=>$request->form_type === '1' ? $message1 : $message2]);
        }else{
          return response()->json(['success'=>false,'message'=>'Error in registration.']);

        }
        }




       }



       }




     //return $request->all();




    }








}
