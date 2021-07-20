<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;
use Auth;
use App\Http\Requests;
use Image;
use App\Models\CelebrityTestimonial;


class CelebrityTestimonialController extends Controller
{
    public function AddCelebrityTestimonial()
    {
        return view('celebritytestimonial/add_celebrity_testimonial');
    }
    
    public function SaveCelebrityTestimonial(Request $request)
    {
			$user  = Auth::user()->id;
			$rules = [           
					'name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/',
					'video_id'=>'max:255', 
		 ];
		 
		 $validation = Validator::make($request->all(), $rules);
		 if ($validation->fails())
		 {
		 
				 $errors=$validation->errors();
				 return back()->withInput()->withErrors($errors);
			 
		 }
		 else
		 {        
			 $celebrity_testimonial_data=
			 [
			  'name' =>trim(ucwords($request->name)),
			  'video_id' =>trim($request->video_id),
			  'status'=>'1',
			  'updated_by'=> $user,
			 ];
			 $result=CelebrityTestimonial::create($celebrity_testimonial_data);
			 if($result)
			 {
				 return redirect()->action('CelebrityTestimonialController@ListCelebrityTestimonial')->with('success', 'Celebrity Testimonial added successfully');
			 }
			 else
			 {
				 return back()->withErrors('errors', 'Failed to add celebrity testimonial');
			 }


		 }
    }

    public function ListCelebrityTestimonial()
    {
        return view('celebritytestimonial/celebrity_testimonial_index');
    }
    
    public function CelebrityTestimonialIndexAjax(Request $request)
    {
        //$draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
        
        $response = [
          "recordsTotal" => "",
          "recordsFiltered" => "",
          "data" => "",
          "success" => 0,
          "msg" => ""
        ];
        try
         {
                      
            $start = ($request->start) ? $request->start : 0;
            $end = ($request->length) ? $request->length : 10;
            $search = ($request->search['value']) ? $request->search['value'] : '';
           
            //$cond[] = ['status','<>',''];
            $celebritytestimonial = CelebrityTestimonial::orderBy('id','desc');
            if ($request->search['value'] != "") {            
              $celebritytestimonial = $celebritytestimonial->where('name','LIKE',"%".$search."%");
            }             
            $total = $celebritytestimonial->count();
            if($end==-1){
              $celebritytestimonial = $celebritytestimonial->get();
            }else{
              $celebritytestimonial = $celebritytestimonial->skip($start)->take($end)->get();
            }
            
            if($celebritytestimonial->count() > 0)
            {
                $i = 1;
                $linkUrl='https://www.youtube.com/watch?v=';
                foreach($celebritytestimonial as $k=>$v)
                {
                
                      $celebritytestimonial[$k]->sr_no = $i; 
                      $celebritytestimonial[$k]->id = $celebritytestimonial[$k]->id; 
                      $celebritytestimonial[$k]->name = $celebritytestimonial[$k]->name; 
                      $celebritytestimonial[$k]->video_id = $linkUrl .''. $celebritytestimonial[$k]->video_id;                                            
					  $i++;
                }     
            }
            $response["recordsFiltered"] = $total;
            $response["recordsTotal"] = $total;
            //response["draw"] = draw;
            $response["success"] = 1;
            $response["data"] = $celebritytestimonial;

           // $response["imageUrl"] = $imageUrl;
            
            
        }
        catch (Exception $e)
        {    
  
        }
        
  
        return response($response);
    }
    
    public function ChangeCelebrityTestimonialStatus(Request $request){
	
        try{
					  
			           
/*            ini_set('memory_limit', '256M');
          if(!$this->checkAuth(1)){
             return abort(404);; 
          }  */
          $celebritytestimonial = new CelebrityTestimonial();
          $status = $request->status;
          $id = $request->celebrity_id;
          $celebritytestimonialData = $celebritytestimonial->findOrFail($id);
           if($celebritytestimonialData->count()>0){
            $celebritytestimonialData->status = $status;
            if($celebritytestimonialData->save()){
              if($status==1){
                $msg = "Record Activated Successfully";

                $data[] = [];
                 $data['name'] =$celebritytestimonialData->name;
                 $data['supportEmail'] = config('mail.supportEmail');
                 $data['website'] = config('app.site_url');  
                 $data['site_name'] = config('app.site_name');
                 $data['subject'] = 'New Social Media created '.config('app.site_name');
                 $userData = array(array('name'=>'Devendra Singh','email'=>'devendra.singh@netprophetsglobal.com'),array('name'=>'Tapeshwar Das','email'=>'tapeshwar.das@netprophetsglobal.com '),array('name'=>'Abhilasha Shukla','email'=>'abhilasha.shukla@netprophetsglobal.com '));
              foreach($userData as $ukey=>$user){
                $data['email'] = $user['email'];//$this->encdesc($user->email,'decrypt');
                $data['name'] = $user['name'];//$user->name;            
                //$this->SendMail($data,'admin_event_approve');
              }
              // dd($data);
              }else{
                $msg = "Record De-activated Successfully";
              }            
              return response()->json(["status"=>1,"message"=>$msg,"data"=>json_decode("{}")]);            
            }else{
              return response()->json(["status"=>0,"message"=>"Technical ERROR","data"=>json_decode("{}")]);            
            }
          }else{
            return response()->json(["status"=>0,"message"=>"Technical error","data"=>json_decode("{}")]);          
          }
          
        }catch(Exception $e){
          abort(500, $e->message());
        }

      } 

    public function ViewCelebrityTestimonial(Request $request)
    {

            $id = $request->id;
            $current_user = Auth::user()->id;
            $viewcelebritytestimonial = CelebrityTestimonial::where('id',$id)->first();
			if( $viewcelebritytestimonial){
            return view('celebritytestimonial.view_celebrity_testimonial', compact('viewcelebritytestimonial','viewcelebritytestimonial'));
			}
			else
			{
				return redirect()->action('CelebrityTestimonialController@ListCelebrityTestimonial')->with('flash_message_for_celebrity_view', 'Celebrity not available')->with('flash_type', 'alert-danger'); 
			}

    }
      
      public function EditCelebrityTestimonial(Request $request)
      {
        $id = $request->id;
        $current_user = Auth::user()->id;
        //$poll = Poll::find($id);
        $editcelebritytestimonial = CelebrityTestimonial::where('id',$id)->first();
		if($editcelebritytestimonial)
		{
         return view('celebritytestimonial.edit_celebrity_testimonial', compact('editcelebritytestimonial','editcelebritytestimonial'));
		}
		else
		{
			return redirect()->action('CelebrityTestimonialController@ListCelebrityTestimonial')->with('flash_message_for_celebrity_edit', 'Celebrity not available')->with('flash_type', 'alert-danger');			
		}
     }
     
     public function UpdateCelebrityTestimonial(Request $request)
     {
			$rules = [           
					'name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/',
					'video_id'=>'max:255', 
					];
		 
		 $validation = Validator::make($request->all(), $rules);
		 if ($validation->fails())
		 {
		 
				 $errors=$validation->errors();
				 return back()->withErrors($errors);
			 
		 }
		 else
		 {
                $id = $request->id;
                $current_user = Auth::user()->id;                    

                    $CelebrityTestimonialArr=[
                        'name' =>trim(ucwords($request->name)),
                        'video_id' =>trim($request->video_id),
                        'updated_by' => $current_user,
                         
                    ];
                   
                    if(CelebrityTestimonial::where('id',$id)->update($CelebrityTestimonialArr))
                    {  
                                           
                        return redirect()->action('CelebrityTestimonialController@ListCelebrityTestimonial')->with('success', 'Celebrity Testimonial Updated successfully');                
                    }
                    else{
                        return back()->withErrors(['errors'=>'Failed to update Celebrity Testimonial']);
                        
                    }
		}
                                   
                     
    }

    public function DeleteSocialMedia(Request $request, $id)
    {
          try{
          $socialmedia = new SocialMedia();
          $socialmediaData = $socialmedia->findOrFail($id);
          //print_r($userData); die;
          if($socialmediaData->count()>0){
            $socialmediaData->delete();
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Social media deleted successfully');
            return redirect()->action('SocialMediaController@ListSocialMedia');
          }else{
            $request->session()->flash('message.level', 'error');
            $request->session()->flash('message.content', 'Social media not found');
          }
  
        }catch(Exception $e){
          abort(500, $e->message());
        }
  
        //return view('users.index', ['users' => $users->getAllUser()]);
      
        
    }

      
}
