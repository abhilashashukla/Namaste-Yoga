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
use App\Models\SocialMedia;


class SocialMediaController extends Controller
{
    public function AddSocialMedia()
    {
        return view('socialmedia/add_socialmedia');
    }
    
    public function SaveSocialMedia(Request $request)
    {
        $user  = Auth::user()->id;
        $rules = [           
                'organization_name'=>'required|max:150|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/',
                'org_facebook'=>'max:150', 
                'org_twitter'=>'max:150',
                'org_instagram'=>'max:150',
                'org_youtube' => 'max:200',
				'org_other'=>'max:150',
             //'category_image' =>'image|mimes:jpeg,png,jpg|dimensions:max_width=1500,max_height=1500',
     ];
     
     $validation = Validator::make($request->all(), $rules);
     if ($validation->fails())
     {
     
             $errors=$validation->errors();
             return back()->withInput()->withErrors($errors);
         
     }
     else
     {
         
        //  $image = $request->file('category_image');
        //  $input['imagename'] = time().'.'.$image->extension();             
        //  $destinationPath = public_path('images\aasana');
        //  $img = Image::make($image->path());
        //  $img->resize(150, 150, function ($constraint) {
        //      $constraint->aspectRatio();
        //  })->save($destinationPath.'/'.$input['imagename']);
    
        //  $destinationPath = public_path('\images');
        //  $image->move($destinationPath, $input['imagename']);

        //  $category_image=$input['imagename'];                
        
         $social_media_data=
         [
          'organization_name' =>trim($request->organization_name),
          'org_facebook' =>trim($request->org_facebook),
          'org_twitter' =>trim($request->org_twitter),
          'org_instagram' =>trim($request->org_instagram),
          'org_other' => trim($request->org_other), 
             
         'org_youtube' => trim($request->org_youtube),
         'status'=>'1',
         'updated_by'=> $user,
         ];
         $result=SocialMedia::create($social_media_data);
		 if($result)
         {
            return redirect()->action('SocialMediaController@ListSocialMedia')->with('success', 'Social Media Added successfully');
         }
		 else
		 {
			  return back()->withErrors(['errors'=>'Failed to update Social Media']);
		 }



     }
    }

    public function ListSocialMedia()
    {
        return view('socialmedia/socialmedia_index');
    }
    
    public function SocialMediaIndexAjax(Request $request)
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
            $socialmedia = SocialMedia::orderBy('id','desc');
            
            if ($request->search['value'] != "") {            
              $socialmedia = $socialmedia->where('organization_name','LIKE',"%".$search."%");
            }             
            $total = $socialmedia->count();
            if($end==-1){
              $socialmedia = $socialmedia->get();
            }else{
              $socialmedia = $socialmedia->skip($start)->take($end)->get();
            }
            
            if($socialmedia->count() > 0)
            {
                $i = 1;
                //$imageUrl=asset('images/aasana/');
                foreach($socialmedia as $k=>$v)
                {
                
                      $socialmedia[$k]->sr_no = $i; 
                      $socialmedia[$k]->id = $socialmedia[$k]->id; 
                      $socialmedia[$k]->organization_name = $socialmedia[$k]->organization_name; 
                      $socialmedia[$k]->org_facebook = $socialmedia[$k]->org_facebook; 
                      $socialmedia[$k]->org_twitter = $socialmedia[$k]->org_twitter; 
                      $socialmedia[$k]->org_instagram = $socialmedia[$k]->org_instagram;
                      $socialmedia[$k]->org_youtube = $socialmedia[$k]->org_youtube;
                      
                      $socialmedia[$k]->org_other = $socialmedia[$k]->org_other;                                     
                      $socialmedia[$k]->status = $socialmedia[$k]->status;                       
					  $i++;
                }     
            }
            $response["recordsFiltered"] = $total;
            $response["recordsTotal"] = $total;
            //response["draw"] = draw;
            $response["success"] = 1;
            $response["data"] = $socialmedia;

           // $response["imageUrl"] = $imageUrl;
            
            
        }
        catch (Exception $e)
        {    
  
        }
        
  
        return response($response);
    }
    
    public function ChangeSocialMediaStatus(Request $request){
      
        try{
           
          ini_set('memory_limit', '256M');
          if(!$this->checkAuth(1)){
             return abort(404);; 
          }
          $socialmedia = new SocialMedia();
          $status = $request->status;
          $id = $request->social_media_id;
        //   print_r($id);
        //  print_r($status);
          $socialmediaData = $socialmedia->findOrFail($id);
        //   print_r($socialmediaData);
        //   die;
          //$userData = User::whereIn('role_id',[2,3,5])->select('email','name')->get();
          
          //dd($userData);
           if($socialmediaData->count()>0){
            $socialmediaData->status = $status;
            if($socialmediaData->save()){
              if($status==1){
                $msg = "Record Activated Successfully";

                $data[] = [];
                 $data['organization_name'] = $socialmediaData->organization_name;
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

    public function ViewSocialMedia(Request $request)
    {

            $id = $request->id;
            $current_user = Auth::user()->id;
            //$poll = Poll::find($id);
            $viewsocialmedia = SocialMedia::where('id',$id)->first();
			if($viewsocialmedia){
            return view('socialmedia.view_socialmedia', compact('viewsocialmedia','viewsocialmedia')); 
			}
			else 
			{
				return redirect()->action('SocialMediaController@ListSocialMedia')->with('flash_message_for_media_view', 'Social media not available')->with('flash_type', 'alert-danger');			 
				
			} 

    }
      
      public function EditSocialMedia(Request $request)
      {
        $id = $request->id;
        $current_user = Auth::user()->id;
        //$poll = Poll::find($id);
        $editsocialmedia = SocialMedia::where('id',$id)->first();
		if($editsocialmedia)
		{
        return view('socialmedia.edit_socialmedia', compact('editsocialmedia','editsocialmedia'));
		}
		else 
		{
				 return redirect()->action('SocialMediaController@ListSocialMedia')->with('flash_message_for_media_edit', 'Social media not available')->with('flash_type', 'alert-danger'); 
				
	    } 
     }
     
     public function UpdateSocialMedia(Request $request)
     {
        //  echo "<pre>";
        //  print_r($request->category_image);
        //  die;
         
            $validator = Validator::make($request->all(),[
                   $rules = [           
                'organization_name'=>'required|max:150|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/',
                'org_facebook'=>'max:150', 
                'org_twitter'=>'max:150',
                'org_instagram'=>'max:150',
                'org_youtube' => 'max:200',
				'org_other'=>'max:150'
             //'category_image' =>'image|mimes:jpeg,png,jpg|dimensions:max_width=1500,max_height=1500',
				],
                // [
                //   'category_name.required'=>'Please enter category name',
                //   'category_description.required'=>'Please enter category description',
                //   'category_image.required'=>'Please jpeg,png,jpg|max:1500 category Image',
                  
                // ]
				]
           );
            if ($validator->fails()) {    
                $errors=$validator->messages();
                return back()->withErrors($errors);
            }
            
                $id = $request->id;
                $current_user = Auth::user()->id;                    
               // $socialmedia = SocialMedia::find($id);     
                // if($request->category_image != '')
                // { 
                    
                                    
                //     $path = public_path('images\aasana');
                //     $mainpath=public_path('images');
                //    // print_r($path);
                //     if($category->category_image != ''  && $category->category_image != null)
                //     {  
                //      // print_r($path);                          
                //         $file_old = $path."/".$category->category_image; 
                //         $file_old_main = $mainpath."/".$category->category_image;     
                //        // echo "<pre>"; 
                //        // print_r($file_old);     
                //         //die;               
                //         unlink($file_old);
                //         unlink($file_old_main);
                //     }
                //     $image = $request->file('category_image');

                //     $input['imagename'] = time().'.'.$image->extension();             
                //     $destinationPath = public_path('images\aasana');
                //     $img = Image::make($image->path());
                //     $img->resize(150, 150, function ($constraint) {
                //         $constraint->aspectRatio();
                //     })->save($destinationPath.'/'.$input['imagename']);                
                //     $destinationPath = public_path('\images');
                //     $image->move($destinationPath, $input['imagename']);
                //     $category_image=$input['imagename'];
               // }
                // else
                // {
                   
                                    
                //             $image =$category->category_image;
                            
                //             $category_image=$image;
                // }
                    $SocialMediaArr=[
                        'organization_name' =>trim($request->organization_name),
                        'org_facebook' =>trim($request->org_facebook),
                        'org_twitter' =>trim($request->org_twitter),
                        'org_instagram' =>trim($request->org_instagram),
                        'org_youtube' => trim($request->org_youtube),
                        'org_other' =>trim($request->org_other),                       
                         'updated_by' => $current_user,
                         //'category_image'=>$category_image ? $category_image : ''
                    ];
                   
                    if(SocialMedia::where('id',$id)->update($SocialMediaArr))
                    {  
                                           
                        return redirect()->action('SocialMediaController@ListSocialMedia')->with('success', 'Social Media Updated successfully');                
                    }
                    else{
                        return back()->withErrors(['errors'=>'Failed to update Social Media']);
                        
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
