<?php

namespace App\Http\Controllers\v6;
use App\Http\Controllers\Controller;
use App\Models\CelebrityTestimonial as Testimonials ;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Config;
use DB;


class CelebrityTestimonial extends Controller
{   
   public function getTestimonials(Request $request)
   {
	   
		$status=Config::get('app.status_codes');
    try
    {     
             $rules = [           
                   'page' => 'numeric',
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
                $testimonial_list=DB::table('celebrity_testimonial')->orderBy('id','desc')->paginate(Config::get('app.celebrity_testimonial_record_per_page'));
               // $storage_path=asset('/public/images/social_media');
                
                $testimonial_data=[];       
                foreach($testimonial_list as $testimonials)
                {
                              
                   $testimonial_data[]=
                   [
                         "id"=>$testimonials->id,
                         "name"=>$testimonials->name,
						 'vedio_id'=>$testimonials->video_id
                                                        
                        
                   ];
                  
                }            
                if($testimonial_data)
                {       
                   $alldata=[
                      'status'=>$status['NP_STATUS_SUCCESS'],
                      'message'=>'Request processed successfully',
                      'data'=>$testimonial_data       
       
                   ];
                   return response()->json($alldata); 
                }
                else
                {
                   $data=[];
                   $alldata=[
                      'status'=>$status['NP_NO_RESULT'],
                      'message'=>'Social media links not found',
                      //'data'=>$data      
       
                   ];
                   return response()->json($alldata); 

                } 
                
                
             }
                
    }     
    catch (Exception $e) {
             return response()->json([
                'status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'),
                ],403);
                }
    }
}
