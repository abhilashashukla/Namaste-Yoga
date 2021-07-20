<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    
    use App\Models\AayushCategory;
    use App\Models\AayushProducts;
    
    use Image;
	use Auth;
    use DB;
    
    class Aayushmerchandise extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function listCategories()
        {
            try {
                return view('aayushmerchandise.listCategories');
            }catch(Exception $e){
                abort(500, $e->message());
            }
        }
		
		
        /**
         * Categories list ajax data tables
         */
        public function categoriesIndexAjax(Request $request){
			
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
				
                $categories = AayushCategory::orderBy('id', 'DESC');
                
				$total = $categories->count();
				
                if($end == -1){
                    $categories = $categories->get();
                }else{
                    $categories = $categories->skip($start)->take($end)->get();
                }
                
                if($categories->count() > 0){
                    $i = 1;
                    foreach($categories as $key => $value){
                        
                        $categories[$key]->sr_no = $i++;
                        $categories[$key]->category_name = $value->category_name;
                        
                        if($categories[$key]->image != null) {
                            $categories[$key]->image = asset('images/aayush_products/'.$value->image);
                        }
                        
                        $created_at = (int)strtotime($value->created_at);
                        $categories[$key]->created_date = date('d-M-Y h:i A', $created_at);
                    }
                }
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
				
                $response["success"] = 1;
                $response["data"] = $categories;
                
            } catch (Exception $e) {
                
            }
            
            return response($response);
        }
        
        
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function listProducts()
        {
            try {
                return view('aayushmerchandise.listProducts');
            } catch(Exception $e) {
                abort(500, $e->message());
            }
        }
		
		
        /**
         * Product list ajax data tables
         */
        public function productsIndexAjax(Request $request){
			
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
				
                $products = AayushProducts::select('ayush_products.*', 'ayush_categories.category_name', 'ayush_product_images.image_one', 'ayush_product_images.image_two', 'ayush_product_images.image_three', 'ayush_product_images.image_four')
                                            ->join('ayush_categories', 'ayush_categories.id', '=', 'ayush_products.ayush_categories_id')
                                            ->leftJoin('ayush_product_images', 'ayush_product_images.ayush_products_id', '=', 'ayush_products.id')
                                            //->where('ayush_categories.status', '1')
                                            ->orderBy('ayush_products.id', 'DESC');
                
				$total = $products->count();
				
                if($end == -1){
                  $products = $products->get();
                } else {
                  $products = $products->skip($start)->take($end)->get();
                }
                
                if($products->count() > 0){
                    $sr = 1;
                    foreach($products as $key => $value){
                        
                        $products[$key]->sr_no = $sr++;
                        $products[$key]->category_name = $value->category_name;
                        
                        if($value->product_description) {
                            //$wCount = str_word_count($value->product_description);
                            
                            $product_description_arr  = explode(' ', $value->product_description);
                            
                            $pd_text = '';
                            if(count($product_description_arr) > 20) {
                                $i = 0;
                                for($i=0; $i < 20; $i++) {
                                    $pd_text.= $product_description_arr[$i] . ' ';
                                }
                                $pd_text.= '...';
                                
                            } else {
                                $pd_text.= $value->product_description;
                            }
                            $products[$key]->product_description = $pd_text;
                        }
                        
                        if($products[$key]->image_one != null) {
                            $products[$key]->product_image = asset('images/aayush_products/'.$value->image_one);
                        } else if($products[$key]->image_two != null) {
                            $products[$key]->product_image = asset('images/aayush_products/'.$value->image_two);
                        } else if($products[$key]->image_three != null) {
                            $products[$key]->product_image = asset('images/aayush_products/'.$value->image_three);
                        } else if($products[$key]->image_four != null) {
                            $products[$key]->product_image = asset('images/aayush_products/'.$value->image_four);
                        } else {
                            $products[$key]->product_image = null;
                        }
                        
                        $created_at = (int)strtotime($value->created_at);
                        $products[$key]->created_date = date('d-M-Y h:i A', $created_at);
                    }
                }
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
				
                $response["success"] = 1;
                $response["data"] = $products;
                
            } catch (Exception $e) {    
                
            }
            
            return response($response);
        }
        
        
        /**
         * View aayush product by product id.
         *
         * @return \Illuminate\Http\Response
         */
        public function aayushProduct(Request $request) {
			try {
                $pid = $request->pid;
                
                $arrProduct = DB::table('ayush_products')
                        ->select('ayush_products.*', 'ayush_categories.category_name', 'ayush_product_images.image_one', 'ayush_product_images.image_two', 'ayush_product_images.image_three', 'ayush_product_images.image_four' )
                        ->join('ayush_categories', 'ayush_categories.id', '=', 'ayush_products.ayush_categories_id')
                        ->leftjoin('ayush_product_images', 'ayush_product_images.ayush_products_id', '=', 'ayush_products.id')
                        ->where('ayush_products.id', $pid)
                        //->where('ayush_products.status', '1')
                        //->where('ayush_categories.status', '1')
                        ->first();
                        
                if($arrProduct) {
                    $image_one = $arrProduct->image_one;
                    if($image_one != null) {
                        $arrProduct->image_one = asset( 'images/aayush_products/' . $image_one );
                    }
                    
                    $image_two = $arrProduct->image_two;
                    if($image_two != null) {
                        $arrProduct->image_two = asset( 'images/aayush_products/' . $image_two );
                    }
                    
                    $image_three = $arrProduct->image_three;
                    if($image_three != null) {
                        $arrProduct->image_three = asset( 'images/aayush_products/' . $image_three );
                    }
                    
                    $image_four = $arrProduct->image_four;
                    if($image_four != null) {
                        $arrProduct->image_four = asset( 'images/aayush_products/' . $image_four );
                    }
                }
                if($arrProduct){
                return view('aayushmerchandise.viewAayushProduct', compact('arrProduct', 'arrProduct'));
				}
				else
				{
					$flash_message_for_ayush_product_view=['flash_message_for_ayush_product_view'=>'Product not available'];				
					return redirect()->action('Aayushmerchandise@listProducts')->with($flash_message_for_ayush_product_view); 
				}
            }catch(Exception $e){
                abort(500, $e->message());
            }
        }
        
        /**
         * Add aayush category.
         * @param Request $request
         * @return type
         */
        public function addAayushCategory(Request $request){
            /* $status = '';
            $message = ''; */
            try {
                if ($request->isMethod('post')) {
                    
                    $validator = Validator::make($request->all(), [
                                    'category_name'         => 'required|max:150',
                                    'category_description'  => 'max:250',
                                    'image'                 => 'image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048'
                                ],
                                [
                                    'category_name.required'=>'The category name field is required',
                                    //'image.max'=>'Image size should be 2MB.',
                                ]
                            );
                    
                    if ($validator->fails()) {
                        //$status = 0;
                        //$message = 'Error: Please enter valid informations.';
						$errors=$validator->messages();
						return back()->withInput()->withErrors($errors);
						//return view('aayushmerchandise.addAayushCategory', ['status' => $status, 'message' => $message]);
                        
                    } else {
                        
                        $category_name = ucfirst( trim($request->input('category_name')) );
                        
                        if($request->input('category_description') != '') {
                            $category_description = ucfirst( trim($request->input('category_description')) );
                        } else {
                            $category_description = '';
                        }
                        
                        $arrCat = DB::table('ayush_categories')->whereRaw('LOWER(category_name) = ?', strtolower($category_name))->first();
                        
                        if($arrCat) {
                            //$status = 0;
							//$message = 'Error: Duplicate category name, try with other.';
							$dublicate_category=['dublicate_category'=>'Duplicate category name, try with other'];
							return back()->withInput()->withErrors($dublicate_category);
                            
							
                        } else {
                            
                            /*$image = $request->file('image');
                            $cat_image_name = 'cat_'.time() . '.' . strtolower($image->extension());

                            $destinationPath = public_path('images/aayush_products');

                            $img = Image::make($image->path());
                            $img->fit(320, 320, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save($destinationPath . '/' . $cat_image_name);

                            $destinationPath2 = public_path('images');
                            $image->move($destinationPath2, $cat_image_name);
                            */
                            
                            if($image = $request->file('image')) {
                                $cat_image_name = 'cat_'.time() . '.' . strtolower($image->extension());
                                
                                $destinationPath = public_path('images/aayush_products');
                                
                                $request->image->move($destinationPath, $cat_image_name);
                            }


                            $obj_aayush = new AayushCategory;

                            $obj_aayush->category_name = ucwords($category_name);
                            $obj_aayush->category_description = $category_description;
                            $obj_aayush->image = $cat_image_name;                        
                            $obj_aayush->created_by = Auth::user()->id;
							$result=$obj_aayush->save();
							//$result=0;
                            if($result ==1){
                                //$status = 1;
                                //$message = 'Category added successfully.';
								$message=['message'=>'Category added successfully'];
								return redirect()->action('Aayushmerchandise@listCategories')->with($message);
                            }
							else
							{	
								$unsuccess=['unsuccess'=>'Failed to add Category'];						
								return back()->with($unsuccess);
							}
                        }
                    }
                }
                
            } catch (Exception $ex) {
               /*  $status = 0;
                $message = 'Error: Somthing went wrong. Try again.'; */
            }
			return view('aayushmerchandise.addAayushCategory');
            //return view('aayushmerchandise.addAayushCategory', ['status' => $status, 'message' => $message]);
		}
        
        
        public function editAayushCategory(Request $request){
            $status = '';
            $message = '';
            $arrCat = array();
            
            try {
                $cid = $request->cid;
                
                if($cid > 0) {
                    
                    if ($request->isMethod('post')) {
                        
                        $validator = Validator::make($request->all(), [
                                        'category_name'         => 'required|max:150',
                                        'product_description'   => 'max:250',
                                        'image1'                => 'image|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2048'
                                    ],
                                    [
                                        'category_name.required'=>'The aayush category name field is required',
                                    ]
                                );
                        
                        if ($validator->fails()) {
                            
                            /* $status = 0;
                            $message = 'Error: Please enter valid informations.'; */
								$errors=$validator->messages();
								return back()->withErrors($errors);
                            
                        } else {
                            
                            $category_name = strtolower(trim($request->input('category_name')));
                            $category_name_old = strtolower(trim($request->input('category_name_old')));
                            
                            $arrCat1 = array();
                            if($category_name != $category_name_old) {
                                
                                $arrCat1 = DB::table('ayush_categories')->whereRaw('LOWER(category_name) = ?', strtolower($category_name))->first();
                            }
                            
                            if($arrCat1) {
                                //send error
                                /* $status = 0;
                                $message = 'Error: Duplicate category name, try with other.'; */
								$dublicate_category=['dublicate_category'=>'Duplicate category name, try with other'];
							    return back()->withErrors($dublicate_category);
								
                                
                            } else {
                                $image = $request->file('image1');
                                
                                if($image) {
                                    /*$cat_image_name = 'cat_'.time() . '.' . strtolower($image->extension());

                                    $destinationPath = public_path('images/aayush_products');

                                    $img = Image::make($image->path());
                                    $img->fit(320, 320, function ($constraint) {
                                        $constraint->aspectRatio();
                                    })->save($destinationPath . '/' . $cat_image_name);

                                    $destinationPath2 = public_path('images');
                                    $image->move($destinationPath2, $cat_image_name);
                                    */
                                    
                                    $cat_image_name = 'cat_'.time() . '.' . strtolower($image->extension());
                                    
                                    $destinationPath = public_path('images/aayush_products');
                                    
                                    $request->image1->move($destinationPath, $cat_image_name);
                                    
                                    //delete old file
                                    $old_cat_image = trim($request->image);
                                    if($old_cat_image != '') {
                                        if (file_exists($destinationPath . '/' . $old_cat_image)) {

                                            @unlink($destinationPath . '/' . $old_cat_image);
                                        }
                                    }
                                    
                                    $data['image'] = $cat_image_name;
                                }
                                
                                $data['category_name']          = ucwords(trim($request->category_name));
                                
                                if($request->category_description != '') {
                                    $data['category_description']   = ucfirst( trim($request->category_description) );
                                } else {
                                    $data['category_description']   = '';
                                }    

                                $result=AayushCategory::where('id', $cid)->update($data);
								if($result ==1)
								{
									//$status = 1;
									//$message = 'Category added successfully.';
									$message=['message'=>'Category updated successfully'];
									return redirect()->action('Aayushmerchandise@listCategories')->with($message);
								}

                               /*  $status = 1;
                                $message = 'Category updated successfully.'; */
                            }
                        }
                    }
                    
                    $arrCat = AayushCategory::where('id', $cid)->first();
                    
                } else {
                    /* $status = 0;
                    $message = 'Error: Category id not found.'; */
					$unsuccess=['unsuccess'=>'Failed to add Category'];						
				    return back()->with($unsuccess);
                }
            } catch (Exception $ex) {
                /* $status = 0;
                $message = 'Error: Somthing went wrong. Try again.'; */
            }
            if($arrCat){
            return view('aayushmerchandise.editAayushCategory', ['arrCat' => $arrCat ]);
			}
			else
			{
				$flash_message_for_ayush_edit=['flash_message_for_ayush_edit'=>'Category not available'];				
				return redirect()->action('Aayushmerchandise@listCategories')->with($flash_message_for_ayush_edit); 
			}
        }
        
        
        public function updateAayushCategoryStatus(Request $request) {
            try {
                $id = trim($request->id);
                $status = trim($request->status);
                
                if($id > 0) {
                    if ($request->isMethod('post')) {
                        if($status) {
                            $data['status'] = '1';
                        } else {
                            $data['status'] = '0';
                        }
                        
                        if(AayushCategory::where('id', $id)->update($data)) {
                            
                            return response()->json(["status" => 1, "message" => "Category Status updated successfully."]);
                        } else {
                            return response()->json(["status" => 0, "message" => "Error: Something went wrong."]);
                        }
                    }
                } else {
                    return response()->json(["status" => 0, "message" => "Category id not found."]);
                }
                
            } catch(Exception $e) {
                abort(500, $e->message());
            }
        }
        
        
        public function updateAayushProductStatus(Request $request) {
            try {
                $id = trim($request->id);
                $status = trim($request->status);
                
                if($id > 0) {
                    if ($request->isMethod('post')) {
                        if($status) {
                            $data['status'] = '1';
                        } else {
                            $data['status'] = '0';
                        }
                        
                        if(AayushProducts::where('id', $id)->update($data)) {
                            
                            return response()->json(["status" => 1, "message" => "Product Status updated successfully."]);
                        } else {
                            return response()->json(["status" => 0, "message" => "Error: Something went wrong."]);
                        }
                    }
                } else {
                    return response()->json(["status" => 0, "message" => "Product id not found."]);
                }
                
            } catch(Exception $e) {
                abort(500, $e->message());
            }
        }
        
        
        /**
         * Add aayush product.
         * @param Request $request
         * @return type
         */
        public function addAayushProduct(Request $request){
            $status = '';
            $message = '';
            $categorylist = array();
            
            try {
                if ($request->isMethod('post')) {
                    
                    $validator = Validator::make($request->all(), [
                                    'ayush_categories_id'   => 'required',
                                    'product_name'          => 'required|max:150',
                                    'product_description'   => 'required',
                                    'key_ingredients'       => 'required',
                                    'direction'             => 'required',
                                    'image_one'             => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                    'image_two'             => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                    'image_three'           => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                    'image_four'            => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                ],
                                [
                                    'ayush_categories_id.required'=>'The aayush category name field is required',
                                    //'product_image.max'=>'Image size should be 2MB.',
                                ]
                            );
                    
                    if ($validator->fails()) {
                        
                        /* $status = 0;
                        $message = 'Error: Please enter valid informations.'; */
						$errors=$validator->messages();
					    return back()->withInput()->withErrors($errors);
                        
                    } else {
                        
                        $destinationPath = public_path('images/aayush_products');
                        
                        /*$image = $request->file('product_image');
                        $product_image_name = time() . '.' . strtolower($image->extension());
                        
                        $img = Image::make($image->path());
                        $img->fit(320, 320, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . $product_image_name);
                        
                        //Image::make($img)->fit(220, 220 )->save( 'images/aayush_products/220x220_' . $product_image_name );
                        
                        $destinationPath2 = public_path('images');
                        $image->move($destinationPath2, $product_image_name);
                        */
                        $obj_ayshPro = new AayushProducts;
                        
                        //$post = Input::All();
                        
                        $obj_ayshPro->ayush_categories_id   = trim($request->ayush_categories_id);
                        $obj_ayshPro->product_name          = ucwords(trim($request->product_name));
                        $obj_ayshPro->product_description   = ucfirst(trim($request->product_description));
                        $obj_ayshPro->key_ingredients       = ucfirst(trim($request->key_ingredients));
                        $obj_ayshPro->direction             = ucfirst(trim($request->direction));
                        $obj_ayshPro->created_by            = Auth::user()->id;
                        
                        if( $obj_ayshPro->save() ){
                            
                            $lastId = $obj_ayshPro->id;
                            
                            if($request->file('image_one') || $request->file('image_two') || $request->file('image_three') || $request->file('image_four')) {
                                $data['ayush_products_id'] = $lastId;

                                if($request->file('image_one')) {
                                    $data['image_one'] = $filename_one = strtolower($lastId .'_1_'.time().'.'.$request->image_one->getClientOriginalExtension() );
                                    $request->image_one->move($destinationPath, $filename_one);
                                }

                                if($request->file('image_two')) {
                                    $data['image_two'] = $filename_two = strtolower($lastId .'_2_'.time().'.'.$request->image_two->getClientOriginalExtension() );
                                    $request->image_two->move($destinationPath, $filename_two);
                                }

                                if($request->file('image_three')) {
                                    $data['image_three'] = $filename_three = strtolower($lastId .'_3_'.time().'.'.$request->image_three->getClientOriginalExtension() );
                                    $request->image_three->move($destinationPath, $filename_three);
                                }

                                if($request->file('image_four')) {
                                    $data['image_four'] = $filename_four = strtolower($lastId .'_4_'.time().'.'.$request->image_four->getClientOriginalExtension() );
                                    $request->image_four->move($destinationPath, $filename_four);
                                }
                                
                                DB::table('ayush_product_images')->insert( $data );
                            }
							 
								$message=['message'=>'Product added successfully'];
								return redirect()->action('Aayushmerchandise@listProducts')->with($message);
                            
							
                            
                            /* $status = 1;
                            $message = 'Product added successfully.'; */
							
                        }
						else
						{	
								$unsuccess=['unsuccess'=>'Failed to add Product'];						
								return back()->with($unsuccess);
						}
                    }
                    //ayush_categories_id product_name product_description key_ingredients direction product_image
                }
                
                $categorylist = AayushCategory::where('status','1')->orderBy('category_name', 'ASC')->get();
                
            } catch (Exception $ex) {
               /*  $status = 0;
                $message = 'Error: Somthing went wrong. Try again.'; */
            }
            
            return view('aayushmerchandise.addAayushProduct', ['categorylist' => $categorylist ]);
		}
        
        
        /**
         * Edit product by product id.
         * @param Request $request
         * @return type
         */
        public function editAayushProduct(Request $request) {
            $status = '';
            $message = '';
            $categorylist = array();
            $arrProduct = array();
            
            try {
                $pid = $request->pid;
                
                if($pid > 0) {
                    if ($request->isMethod('post')) {
                        
                        $validator = Validator::make($request->all(), [
                                        'ayush_categories_id'   => 'required',
                                        'product_name'          => 'required|max:150',
                                        'product_description'   => 'required',
                                        'key_ingredients'       => 'required',
                                        'direction'             => 'required',
                                        'image_one'             => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                        'image_two'             => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                        'image_three'           => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                        'image_four'            => 'max:2048|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG',
                                    ],
                                    [
                                        'ayush_categories_id.required'=>'The aayush category name field is required',
                                    ]
                                );

                        if ($validator->fails()) {
                            
                            /* $status = 0;
                            $message = 'Error: Please enter valid informations.'; */
								$errors=$validator->messages();
								return back()->withErrors($errors);
							
                            
                        } else {
                            
                            $ayush_categories_id   = trim($request->ayush_categories_id);
                            $product_name          = ucwords(trim($request->product_name));
                            $product_description   = ucfirst(trim($request->product_description));
                            $key_ingredients       = ucfirst(trim($request->key_ingredients));
                            $direction             = ucfirst(trim($request->direction));
                            $updated_by            = Auth::user()->id;
                            
                            AayushProducts::where('id', $pid)
                                            ->update([
                                                    'ayush_categories_id'   => $ayush_categories_id,
                                                    'product_name'          => $product_name,
                                                    'product_description'   => $product_description,
                                                    'key_ingredients'       => $key_ingredients,
                                                    'direction'             => $direction,
                                                    'updated_by'            => $updated_by
                                                ]);
                            
                            $lastId = $pid;
                            $destinationPath = public_path('images/aayush_products');
                            
                            if($request->file('image_one') || $request->file('image_two') || $request->file('image_three') || $request->file('image_four')) {

                                if($request->file('image_one')) {
                                    $data['image_one'] = $filename_one = strtolower($lastId .'_1_'.time().'.'.$request->image_one->getClientOriginalExtension() );
                                    $request->image_one->move($destinationPath, $filename_one);
                                    
                                    //delete old image file
                                    $old_image_one = trim($request->old_image_one);
                                    if($old_image_one != '') {
                                        if (file_exists($destinationPath . '/' . $old_image_one)) {

                                            @unlink($destinationPath . '/' . $old_image_one);
                                        }
                                    }
                                }

                                if($request->file('image_two')) {
                                    $data['image_two'] = $filename_two = strtolower($lastId .'_2_'.time().'.'.$request->image_two->getClientOriginalExtension() );
                                    $request->image_two->move($destinationPath, $filename_two);
                                    
                                    //delete old image file
                                    $old_image_two = trim($request->old_image_two);
                                    if($old_image_two != '') {
                                        if (file_exists($destinationPath . '/' . $old_image_two)) {

                                            @unlink($destinationPath . '/' . $old_image_two);
                                        }
                                    }
                                }

                                if($request->file('image_three')) {
                                    $data['image_three'] = $filename_three = strtolower($lastId .'_3_'.time().'.'.$request->image_three->getClientOriginalExtension() );
                                    $request->image_three->move($destinationPath, $filename_three);
                                    
                                    //delete old image file
                                    $old_image_three = trim($request->old_image_three);
                                    if($old_image_three != '') {
                                        if (file_exists($destinationPath . '/' . $old_image_three)) {
                                            
                                            @unlink($destinationPath . '/' . $old_image_three);
                                        }
                                    }
                                }

                                if($request->file('image_four')) {
                                    $data['image_four'] = $filename_four = strtolower($lastId .'_4_'.time().'.'.$request->image_four->getClientOriginalExtension() );
                                    $request->image_four->move($destinationPath, $filename_four);
                                    
                                    //delete old image file
                                    $old_image_four = trim($request->old_image_four);
                                    if($old_image_four != '') {
                                        if (file_exists($destinationPath . '/' . $old_image_four)) {
                                            
                                            @unlink($destinationPath . '/' . $old_image_four);
                                        }
                                    }
                                }
                                if( $request->input('ayush_product_images_id') ) {
                                    DB::table('ayush_product_images')->where('ayush_products_id', $pid)->update( $data );
                                } else {
                                    $data['ayush_products_id'] = $pid;
                                    DB::table('ayush_product_images')->insert( $data );
                                }
                            }
                            
                            /* $status = 1;
                            $message = 'Product updated successfully.'; */
							$message=['message'=>'Product updated successfully'];
							return redirect()->action('Aayushmerchandise@listProducts')->with($message);
                        }
                        //ayush_categories_id product_name product_description key_ingredients direction product_image
                    }
                    
                    
                    $categorylist = AayushCategory::where('status','1')->orderBy('category_name', 'ASC')->get();
                    $arrProduct = AayushProducts::where('ayush_products.id', $pid)
                                                ->select('ayush_products.*', 'ayush_product_images.id as ayush_product_images_id', 'ayush_product_images.image_one', 'ayush_product_images.image_two', 'ayush_product_images.image_three', 'ayush_product_images.image_four' )
                                                ->leftJoin('ayush_product_images', 'ayush_product_images.ayush_products_id', '=', 'ayush_products.id')
                                                ->first();
                } else {
                    /* $status = 0;
                    $message = 'Error: Product id not found.'; */
						
					$unsuccess=['unsuccess'=>'Failed to update Product'];						
					return back()->with($unsuccess);
					
                }
            } catch (Exception $ex) {
             /*    $status = 0;
                $message = 'Error: Somthing went wrong. Try again.'; */
            }
			if($arrProduct)
			{            
				return view('aayushmerchandise.editAayushProduct', ['categorylist' => $categorylist, 'arrProduct' => $arrProduct ]);
			}
			else
			{
				$flash_message_for_ayush_product_edit=['flash_message_for_ayush_product_edit'=>'Product not available'];				
				return redirect()->action('Aayushmerchandise@listProducts')->with($flash_message_for_ayush_product_edit); 
			}
		}
        
        
        
        
        
        
        /*public function phpinfo() {
            echo phpinfo();
            exit;
        }
		*/

    }