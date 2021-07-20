<?php

namespace App\Http\Controllers\v6;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\AayushCategory;
use App\Models\AayushProducts;

use App\Common\Utility;

use Config;

//use App\User;
//use Carbon;
//use App\Mail\WelcomeMail;
//use Illuminate\Support\Facades\Mail;

class Aayushmerchandise extends Controller
{
	
	public function getAllCategories(Request $request) {
		
		Utility::stripXSS();
		DB::beginTransaction();
		
		try {
			if(!$this->verifyChecksum($request)) {
				return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'), "message"=>'Checksum not verified']);
			}
            
            $where[] = ['status', '1'];            
            $categories_arr = AayushCategory::where($where)->paginate(Config::get('app.record_per_page'));
            
            $cat_arr = $categories_arr->items();
            
            $image_path = asset('public/images/aayush_products');
            foreach ($cat_arr as $key => $val) {
                if($val['image'] == '') {
                    $cat_arr[$key]['image'] = '';
                } else {
                    $cat_arr[$key]['image'] = $image_path .'/'. $val['image'];
                }
            }
            
            return response()->json([
                        "status"=> Config::get('app.status_codes.NP_STATUS_SUCCESS'), 
                        "message"=> "Request processed successfully.",
                        
                        'total_record'=> $categories_arr->total(),
                        'last_page'=> $categories_arr->lastPage(),
                        'current_page'=> $categories_arr->currentPage(),
                        "data"=> $cat_arr
                    ]);
            
		} catch(Exception $e){
			return response()->json(['status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'), 'message'=>'Something went wrong. Please try again.']);
		}
	}
	
	
	public function getProductByCategory(Request $request) {
		
		Utility::stripXSS();
		DB::beginTransaction();
        
        $image_path = asset('public/images/aayush_products');
		
		try {
			if(!$this->verifyChecksum($request)) {
				return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'), "message"=>'Checksum not verified' ]);
			}
            
            $category_id = $request->category_id;
            
            if($category_id) {
                $where = array('ayush_categories_id' => $category_id, 'status' => '1');
                $product_arr = AayushProducts::where($where)
                                                    ->select('id', 'product_name', 'product_description')
                                                    ->orderBy('product_name','asc')
                                                    ->paginate(Config::get('app.record_per_page'));
                
                $data_arr = array();
                $prod_arr = $product_arr->items();
                
                foreach ($prod_arr as $value) {
                    
                    $images_arr = DB::table('ayush_product_images')->where(array('ayush_products_id' => $value['id']))->first();
                    
                    $img_arr = array();
                    if(count((array)$images_arr)) {//object array count
                        if($images_arr->image_one != '') {
                            $img_arr[0]['image_counter'] = 1;
                            $img_arr[0]['product_image'] = $image_path . '/' . $images_arr->image_one;
                        }
                        if($images_arr->image_two != '') {
                            $img_arr[1]['image_counter'] = 2;
                            $img_arr[1]['product_image'] = $image_path . '/' . $images_arr->image_two;
                        }
                        if($images_arr->image_three != '') {
                            $img_arr[2]['image_counter'] = 3;
                            $img_arr[2]['product_image'] = $image_path . '/' . $images_arr->image_three;
                        }
                        if($images_arr->image_four != '') {
                            $img_arr[3]['image_counter'] = 4;
                            $img_arr[3]['product_image'] = $image_path . '/' . $images_arr->image_four;
                        }
                    }
                    $value['product_image'] = $img_arr;
                    $data_arr[] = $value;
                }
                
                
                return response()->json([
                        "status"=> Config::get('app.status_codes.NP_STATUS_SUCCESS'), 
                        "message"=> "Request processed successfully.",
                        
                        'total_record'=> $product_arr->total(),
                        'last_page'=> $product_arr->lastPage(),
                        'current_page'=> $product_arr->currentPage(),
                        
                        "data"=> $data_arr//$categories_arr->items()
                    ]);
            } else {
                return response()->json(["status"=> Config::get('app.status_codes.NP_STATUS_FAIL'), "message"=> "Category id missing in request." ]);
            }
			
		} catch(Exception $e){
			return response()->json(['status'=>Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'), 'message'=> 'Something went wrong. Please try again.' ]);
		}
	}
	
	
	public function getProductDetails(Request $request) {
		
		Utility::stripXSS();
		DB::beginTransaction();
        
        $image_path = asset('public/images/aayush_products');
		
		try {
			if(!$this->verifyChecksum($request)) {
				return response()->json(["status"=> Config::get('app.status_codes.NP_INVALID_REQUEST'), "message"=>'Checksum not verified' ]);
			}
            
            $product_id = $request->product_id;
            
            if($product_id) {
                $where = array('id' => $product_id, 'status' => '1');
                $product_arr = AayushProducts::where($where)->select('id', 'product_name', 'product_description', 'key_ingredients', 'direction')->first();
                
                if($product_arr) {
                    $images_arr = DB::table('ayush_product_images')->where(array('ayush_products_id' => $product_id))->first();
                    
                    $img_arr = array();
                    if(count((array)$images_arr)) {//object array count
                        if($images_arr->image_one != '') {
                            $img_arr[0]['image_counter'] = 1;
                            $img_arr[0]['product_image'] = $image_path . '/' . $images_arr->image_one;
                        }
                        if($images_arr->image_two != '') {
                            $img_arr[1]['image_counter'] = 2;
                            $img_arr[1]['product_image'] = $image_path . '/' . $images_arr->image_two;
                        }
                        if($images_arr->image_three != '') {
                            $img_arr[2]['image_counter'] = 3;
                            $img_arr[2]['product_image'] = $image_path . '/' . $images_arr->image_three;
                        }
                        if($images_arr->image_four != '') {
                            $img_arr[3]['image_counter'] = 4;
                            $img_arr[3]['product_image'] = $image_path . '/' . $images_arr->image_four;
                        }
                    }
                    $product_arr['images'] = $img_arr;
                    
                    return response()->json([ "status"=> Config::get('app.status_codes.NP_STATUS_SUCCESS'), "message"=> "Request processed successfully.", "data"=> $product_arr ]);
                } else {
                    return response()->json([ "status"=> Config::get('app.status_codes.NP_NO_RESULT'), "message"=> "No record found." ]);
                }
                
                
            } else {
                return response()->json(["status"=> Config::get('app.status_codes.NP_STATUS_FAIL'), "message"=> "Product id missing in request." ]);
            }
			
		} catch(Exception $e){
			return response()->json(['status'=> Config::get('app.status_codes.NP_STATUS_NOT_KNOWN'), 'message'=> 'Something went wrong. Please try again.',  ]);
		}
	}
    
    
    
	
	
	public function clearData(){
		DB::table('duplicate_request')->delete();
		DB::table('otp_history')->delete();
	}

}