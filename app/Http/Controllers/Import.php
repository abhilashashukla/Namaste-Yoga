<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Aasanas;
use App\Models\AayushProducts;
use App\Models\AayushImages;
use App\Models\AayushCategory;
use Illuminate\Support\Facades\Validator;
use Image;


use Illuminate\Support\Facades\DB;
use Excel;

class Import extends Controller
{

public function importAsanaView(){

  return view('aasanas/import');
}
public function importAsanaImages(){

  return view('aasanas/image');
}
public function importAsanaImage(Request $request){
  if ($request->selectOption == 1)
  {
  $validation = Validator::make($request->all(), [
    'selectOption' => 'required',
    'file_image'=>'required',
    'file_image.*' => 'image|mimes:jpeg,png,jpg',
    ],
    [
      'selectOption.required'=>'Please select one option.',
      'file_image.required'=>'Image field is required',
    ]
  );
     if($validation->passes())
     {

      $image = $request->file('file_image');
      foreach($image as  $key =>$image)
   {

     $new_name =   $_FILES['file_image']['name'][$key];
     $destinationPath = public_path('images/aasana');
     $img = Image::make($image->path());
     $img->fit(438,234, function ($constraint) {
         $constraint->aspectRatio();
     })->save($destinationPath . '/' . $new_name);;
       }


      //$image->move(public_path('images/aayush_products'), $new_name);
      return response()->json(['success'=>true,'message'=>' Category image uploded sucessfully','type'=>'1']);
      die;
     }
     else
     {
      return response()->json([
        'success'=>false,
        'message'   => $validation->errors()->all(),
      ]);
     }
   }else if ($request->selectOption == 2){
     $validation = Validator::make($request->all(),[
       'selectOption' => 'required',
       'file_image'=>'required',
       'file_image.*' => 'image|mimes:jpeg,png,jpg',
       ],
       [
         'selectOption.required'=>'Please select one option.',
         'file_image.required'=>'Image field is required',
       ]

     );
        if($validation->passes())
        {
          $image = $request->file('file_image');
          foreach($image as  $key =>$image)
         {
         $new_name =   $_FILES['file_image']['name'][$key];
         $destinationPath = public_path('images/aasana');
         $img = Image::make($image->path());
         $img->fit(438,234, function ($constraint) {
             $constraint->aspectRatio();
         })->save($destinationPath . '/' . $new_name);;
           }
         //$image->move(public_path('images/aayush_products'), $new_name);
         return response()->json(['success'=>true,'message'=>'Sub Category image uploded sucessfully','type'=>'2']);
         die;
        }
        else
        {
         return response()->json([
           'success'=>false,
           'message'   => $validation->errors()->all(),
         ]);
        }


  }else{
    return response()->json(['success'=>false,'message'=>'All field are required']);
    die;
  }


}

public function importAsana(Request $request){
  // print_r($_FILES['doc']);die;

  if($_FILES['doc']['error'] == 4 ){
   return response()->json(['success'=>false,'message'=>'Please select  xls or xlsx file']);
   die;

  }else {
    $ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
    if($ext == 'xls' || $ext == 'xlsx'  ){
      $path = $request->file('doc')->getRealPath();
      $data = Excel::load($path)->get();
      $saved_1 = false;
      $saved_2 = false;
      $saved_3 = false;
      $num = 0;
      $flg= 0;


        if ($data->count() > 0){
        $header = $data->first()->keys()->toArray();
        // echo '<pre>';
        // print_r($header);die;





      if($header[0] == 'category_name' && $header[1] == 'category_image' && $header[2] == 'sub_category_name' && $header[3] == 'sub_category_description' && $header[4] == 'sub_category_images' && $header[5] == 'aasana_name' && $header[6] == 'aasana_description' && $header[7] == 'tags' && $header[8] == 'video_path' && $header[9] == 'video_duration' && $header[10] == 'benefits'  && $header[11] == 'instructions')
       {

          foreach ($data->toArray() as $key => $value) {

          if(isset($value['category_name']) && isset($value['category_image'])  && isset($value['sub_category_name']) && isset($value['sub_category_description']) && isset($value['sub_category_images']) && isset($value['aasana_name']) && isset($value['aasana_description']) && isset($value['tags']) && isset($value['video_path']) && isset($value['video_duration']) && isset($value['instructions']))
          {
           $categories = Category::select('category_name','id')->where('category_name',$value['category_name'])->get();

           if(count($categories) > 0)
           {

              $subcat = SubCategory::select('id')->where('subcategory_name',$value['sub_category_name'])->get();
               $subcategory_id = 0;
              if(count($subcat) > 0){
                $subcategory_id = $subcat[0]['id'];
              //  print_r('2');
              }else{
                //print_r('1');

                $subcategory_data  = array(
                 'aasana_categories_id'=> $categories[0]['id'] ,
                 'subcategory_name'=> ucwords($value['sub_category_name'])  ,
                 'subcategory_description'=>  ucfirst($value['sub_category_description']),
                 'status'=> '1',
                 'subcategory_image'=>  $value['sub_category_images'],

                  );

                   $subcategory_id =  DB::table('aasana_sub_categories')->insertGetId($subcategory_data);
                   $saved_2 =  true;
                 }
                     // DB::enableQueryLog();
                  $asan = Aasanas::select('aasana_sub_categories_id')->where(array('aasana_sub_categories_id'=> $subcategory_id,'aasana_name'=> $value['aasana_name']))->get();
                  // $asan = Aasanas::select('id','aasana_sub_categories_id')->where(array('aasana_categories_id'=> $categories[0]['id'] ,'aasana_name'=>$value['aasana_name']))->get();

                 if(count($asan) > 0){
                 }else{

                     //$subcat_new = SubCategory::select('id')->where('aasana_categories_id',$categories[0]['id'])->get();

                   $asans_data = array(
                     'aasana_categories_id'=>  $categories[0]['id'],
                     'aasana_sub_categories_id'=> $subcategory_id,
                     //'aasana_sub_categories_id'=> ( $flg === 1 ? $asan[0]['aasana_sub_categories_id'] :    isset($subcategory_id) ? $subcategory_id : $asan[0]['aasana_sub_categories_id'] ) ,
                     'aasana_name'=>  ucwords($value['aasana_name']),
                     'aasana_description'=>  ucfirst($value['aasana_description']),
                     'assana_tag'=>  ucwords($value['tags']),
                     'assana_video_id'=>  $value['video_path'],
                     'assana_video_duration'=> date("H:i",strtotime($value['video_duration'])),
                     'assana_benifits'=>  ucfirst($value['benefits']),
                     'assana_instruction'=> ucfirst($value['instructions']),
                     'status'=> '1',

                   );

                     $asans =  DB::table('aasanas')->insertGetId($asans_data);
                     $saved_3 =  true;
                 }



 /// main else


           }else{


             $category_data = array(
              'category_name'=> ucwords($value['category_name']) ,
              'category_image'=>  $value['category_image'],
              'status'=> '1'

            );

              $category_id =  DB::table('aasana_categories')->insertGetId($category_data);
              $saved_1 = true;


                $subcategory_data  = array(
                 'aasana_categories_id'=> $category_id,
                 'subcategory_name'=> ucwords($value['sub_category_name'])  ,
                 'subcategory_description'=>  ucfirst($value['sub_category_description']),
                 'status'=> '1',
                 'subcategory_image'=>  $value['sub_category_images'],

                  );

                   $subcategory_id =  DB::table('aasana_sub_categories')->insertGetId($subcategory_data);
                   $saved_2 =  true;

                   $asans_data = array(
                     'aasana_categories_id'=>   $category_id ,
                     'aasana_sub_categories_id'=> $subcategory_id ,
                     'aasana_name'=>  ucwords($value['aasana_name']),
                     'aasana_description'=>  ucfirst($value['aasana_description']),
                     'assana_tag'=>  ucwords($value['tags']),
                     'assana_video_id'=>  $value['video_path'],
                     'assana_video_duration'=>  date("H:i:s",strtotime($value['video_duration'])),
                     'assana_benifits'=>  ucfirst($value['benefits']),
                     'assana_instruction'=> ucfirst($value['instructions']),
                     'status'=> '1',

                   );

                     $asans =  DB::table('aasanas')->insertGetId($asans_data);
                     $saved_3 =  true;

              }
            $num = $num + 1;



                 }

             }
          if($saved_1 =  true && $saved_2 =  true && $saved_3 =  true ){

            if($num > 0){
              return response()->json(['success'=>true,'message'=>'Total '.$num.' imported successfully']);
              die;
            }else{
              return response()->json(['success'=>false,'message'=>'Something went wrong']);
              die;
            }


          }else{
            return response()->json(['success'=>false,'message'=>'Technical error']);
            die;
          }
        }else{
         return response()->json(['success'=>false,'message'=>'invalid file,file did not match from sample file']);
         die;

        }


        }else{
          return response()->json(['success'=>false,'message'=>'file can not be empty']);
          die;
        }

      }else{
      return response()->json(['success'=>false,'message'=>'invalid  file format,file should be xlsx or xls']);
      die;
    }
  }

}

public function importpollView(){

  return view('polls/poll');
}


public function importPoll(Request $request){
  if($_FILES['doc']['error'] == 4 ){
   return response()->json(['success'=>false,'message'=>'Please select  xls or xlsx file']);
   die;

  }else {
    $ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
    if($ext == 'xls' || $ext == 'xlsx'  ){
      $path = $request->file('doc')->getRealPath();
      $data = Excel::load($path)->get();
      $saved_1 = false;
      $saved_2 = false;
      $saved_3 = false;


        if ($data->count() > 0){
        $header = $data->first()->keys()->toArray();
        // echo '<pre>';
        // print_r($header);die;

      if($header[0] == 'poll_identification'  && $header[1] == 'pollname'  && $header[2] == 'question' && $header[3] == 'options1' && $header[4] == 'options2' && $header[5] == 'options3' && $header[6] == 'options4')
       {

          $num1 = 0;
          $num2 = 0;
         $questions_value = [];
         $poll_identification = [];
         $araay_identity = array();

          foreach ($data->toArray() as $key => $value) {


           if( isset($value['poll_identification'])  && isset($value['pollname']) && isset($value['question']) && isset($value['options1']) && isset($value['options2']) && isset($value['options3']) && isset($value['options4']))
           {


               array_push($questions_value,$value['options1']);
               array_push($questions_value,$value['options2']);
               array_push($questions_value,$value['options3']);
               array_push($questions_value,$value['options4']);

               $Key = (int)$value['poll_identification'];



               if (array_key_exists($Key,$araay_identity))
                {
                   //$num = $num +1;


                  $question_counter = $araay_identity[$Key]['question_counter'];

                   if ($question_counter < 5){



                     $db_poll_id = $araay_identity[$Key]['db_poll_id'];


                     $question = array(
                      'audience_poll_id'=>  $db_poll_id,
                      'question'=> ucwords($value['question']),
                     );


                     $question_id =  DB::table('audience_poll_questions')->insertGetId($question);
                     $araay_identity[$Key]['question_counter'] = $araay_identity[$Key]['question_counter'] + 1;
                     $saved_2 = true;

                  for ($i=0;$i<count($questions_value);$i++){
                    $option = array(
                     'audience_poll_question_id'=> $question_id,
                     'options'=>  ucwords($questions_value[$i])
                       );
                       $option =  DB::table('audience_poll_question_options')->insertGetId($option);
                       $saved_3 = true;
                     }


                      $num1 = $num1 + 1;


                   }



                }
                else
                {

                      $polls = array(
                       'poll_name'=> ucwords($value['pollname']),
                       'status'=> 0,
                       'is_editable'=> 1
                         );
                       $poll_id =   DB::table('audience_polls')->insertGetId($polls);

                        $araay_identity[$Key]['db_poll_id'] =   $poll_id;

                          $question = array(
                           'audience_poll_id'=> $poll_id,
                           'question'=> ucwords($value['question']),
                          );


                          $question_id =  DB::table('audience_poll_questions')->insertGetId($question);
                          $araay_identity[$Key]['question_counter'] = 1;
                          $saved_2 = true;

                       for ($i=0;$i<count($questions_value);$i++){
                         $option = array(
                          'audience_poll_question_id'=> $question_id,
                          'options'=>  ucwords($questions_value[$i])
                            );
                            $option =  DB::table('audience_poll_question_options')->insertGetId($option);
                            $saved_3 = true;

                          }
                          $num2 = $num2 + 1;
                       }

                        unset($questions_value);
                        $questions_value = [];

                     }

                     }


            //  print_r($num);die('mok');
          if($saved_1 =  true && $saved_2 =  true && $saved_3 =  true ){

            $final_count = (int)$num1 + (int)$num2 * 1;
            if($final_count > 0){
              return response()->json(['success'=>true,'message'=>'Total '.$final_count .' Rows Imported Successfully']);
              die;

            }else{
              return response()->json(['success'=>false,'message'=>'Something went wrong']);
              die;
            }

          }else{
            return response()->json(['success'=>false,'message'=>'Technical error']);
            die;
          }
        }else{

         return response()->json(['success'=>false,'message'=>'invalid file,file did not match from sample file']);
         die;

        }


        }else{
        return response()->json(['success'=>false,'message'=>'file can not be blank']);
        die;
      }

      }else{
      return response()->json(['success'=>false,'message'=>'invalid  file format,file should be xlsx or xls']);
      die;
    }
  }



}



public function importQuizView(){

  return view('quiz/import');
}


public function importQuiz(Request $request){
  if($_FILES['doc']['error'] == 4 ){
   return response()->json(['success'=>false,'message'=>'Please select  xls or xlsx file']);
   die;

  }else {
    $ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
    if($ext == 'xls' || $ext == 'xlsx'  ){
      $path = $request->file('doc')->getRealPath();
      $data = Excel::load($path)->get();
      $saved_1 = false;
      $saved_2 = false;
      $saved_3 = false;


        if ($data->count() > 0){
        $header = $data->first()->keys()->toArray();
        // echo '<pre>';
        //  print_r($header);die;


      if($header[0] == 'quiz_identification'  && $header[1] == 'quizname'  && $header[2] == 'durationin_days' && $header[3] == 'questions' && $header[4] == 'options1' && $header[5] == 'options2' && $header[6] == 'options3' && $header[7] == 'options4' && $header[8] == 'correctanswer')
       {


          $num1 = 0;
          $num2 = 0;
         $questions_value = [];
         $poll_identification = [];
         $araay_identity = array();



          foreach ($data->toArray() as $key => $value) {



           if(isset($value['quiz_identification'])  && isset($value['quizname']) && isset($value['durationin_days']) && isset($value['questions']) && isset($value['options1']) && isset($value['options2']) && isset($value['options3']) && isset($value['options4']) && isset($value['correctanswer']))
           {
             if ($value['correctanswer'] > 0 && $value['correctanswer'] <= 4)
             {
               $questions_value[0] = array($value['options1'], ($value['correctanswer'] == 1 ? 1 : 0));
               $questions_value[1] = array($value['options2'], ($value['correctanswer'] == 2 ? 1 : 0));
               $questions_value[2] = array($value['options3'], ($value['correctanswer'] == 3 ? 1 : 0));
               $questions_value[3] = array($value['options4'], ($value['correctanswer'] == 4 ? 1 : 0));



               $Key = (int)$value['quiz_identification'];



               if (array_key_exists($Key,$araay_identity))
                {



                  $question_counter = $araay_identity[$Key]['quiz_counter'];

                   if ($question_counter < 5){



                     $db_quiz_id = $araay_identity[$Key]['db_quiz_id'];


                     $question = array(
                      'quiz_id'=>  $db_quiz_id,
                      'question'=> ucwords($value['questions']),
                     );


                     $question_id =  DB::table('quiz_questions')->insertGetId($question);
                     $araay_identity[$Key]['quiz_counter'] = $araay_identity[$Key]['quiz_counter'] + 1;
                     $saved_2 = true;

                  for ($i=0; $i<count($questions_value); $i++){
                    $option = array(
                     'quiz_question_id'=> $question_id,
                     'options'=>  ucwords($questions_value[$i][0]),
                     'correct_answer'=> $questions_value[$i][1],
                       );
                       $option =  DB::table('quiz_question_options')->insertGetId($option);
                       $saved_3 = true;
                     }



                      $num1 = $num1 + 1;


                   }



                }
                else
                   {

                      $quiz = array(
                       'quiz_name'=> ucwords($value['quizname']),
                       'status'=> 0,
                       'valid_for'=> $value['durationin_days'],
                       'is_editable'=> 1
                         );
                       $quiz_id =   DB::table('quizzes')->insertGetId($quiz);

                        $araay_identity[$Key]['db_quiz_id'] =   $quiz_id;

                          $question = array(
                            'quiz_id'=>  $quiz_id,
                            'question'=> ucwords($value['questions']),
                          );


                          $question_id =  DB::table('quiz_questions')->insertGetId($question);
                          $araay_identity[$Key]['quiz_counter'] = 1;
                          $saved_2 = true;

                       for ($i=0;$i<count($questions_value);$i++){
                         $option = array(
                           'quiz_question_id'=> $question_id,
                           'options'=>  ucwords($questions_value[$i][0]),
                           'correct_answer'=>  $questions_value[$i][1],
                            );
                            $option =  DB::table('quiz_question_options')->insertGetId($option);
                            $saved_3 = true;

                          }
                          $num2 = $num2 + 1;
                       }

                        unset($questions_value);
                        $questions_value = [];

                     }
                   }

                     }



          if($saved_1 =  true && $saved_2 =  true && $saved_3 =  true ){
            $final_count = (int)$num1 + (int)$num2 * 1;
            if($final_count > 0){
              return response()->json(['success'=>true,'message'=>'Total '.$final_count .' Rows Imported Successfully']);
              die;

            }else{
              return response()->json(['success'=>false,'message'=>'Something went wrong']);
              die;
            }

          }else{
            return response()->json(['success'=>false,'message'=>'Technical error']);
            die;
          }
        }else{

         return response()->json(['success'=>false,'message'=>'invalid file,file did not match from sample file']);
         die;

        }


      }else{
        return response()->json(['success'=>false,'message'=>'file can not be empty']);
        die;
      }

      }else{
      return response()->json(['success'=>false,'message'=>'invalid  file format,file should be xlsx or xls']);
      die;
    }
  }

}


public function AyushMerchandisUploadView(){

  return view('aayushmerchandise/import');
}

public function ImagesCategoryProduct(){

  return view('aayushmerchandise/images');
}



public function ImagesCategoryProductUplod(Request $request){

  if ($request->selectOption == 1)
  {
  $validation = Validator::make($request->all(), [
    'selectOption' => 'required',
    'file_image'=>'required',
    'file_image.*' => 'image|mimes:jpeg,png,jpg',
  ],  [
    'selectOption.required'=>'Please select one option.',
    'file_image.required'=>'Image field is required',
    ]

  );
     if($validation->passes())
     {

      $images = $request->file('file_image');
      // echo '<pre>';
      // print_r($images);die;
      foreach($images as  $key =>$image)
      {

       $new_name = $_FILES['file_image']['name'][$key];
       $destinationPath = public_path('images/aayush_products');
       $img = Image::make($image->path());
       $img->fit(320, 320, function ($constraint) {
           $constraint->aspectRatio();
       })->save($destinationPath . '/' . $new_name);
          $image->move(public_path('images/aayush_products'), $new_name);
          }
      return response()->json(['success'=>true,'message'=>' Category image uploded sucessfully','type'=>'1']);
      die;
     }
     else
     {
      return response()->json([
        'success'=>false,
        'message'   => $validation->errors()->all(),
      ]);
     }
   }else if ($request->selectOption == 2){
     $validation = Validator::make($request->all(), [
         'selectOption' => 'required',
         'file_image'=>'required',
         'file_image.*' => 'image|mimes:jpeg,png,jpg',
       ],  [
         'selectOption.required'=>'Please select one option.',
         'file_image.required'=>'Image field is required',
         ]


     );
        if($validation->passes())
        {

          $images = $request->file('file_image');

        

     foreach($images as  $key =>$image)
     {

      $new_name = $_FILES['file_image']['name'][$key];
      $destinationPath = public_path('images/aayush_products');
      $img = Image::make($image->path());
      $img->fit(320, 320, function ($constraint) {
          $constraint->aspectRatio();
      })->save($destinationPath . '/' . $new_name);
      // $image->move(public_path('images/aayush_products'), $new_name);
         }
         return response()->json(['success'=>true,'message'=>'Products images uploded sucessfully' ,'type'=>'2']);
         die;


        }
        else
        {
         return response()->json([
           'success'=>false,
           'message'   => $validation->errors()->all(),
         ]);
        }

  }else{
    return response()->json(['success'=>false,'message'=>'All field are required']);
    die;
  }



}

















public function AyushMerchandisUpload(Request $request){


  if($_FILES['doc']['error'] == 4 ){
   return response()->json(['success'=>false,'message'=>'Please select  xls or xlsx file']);
   die;

  }else {
    $ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
    if($ext == 'xls' || $ext == 'xlsx'  ){
      $path = $request->file('doc')->getRealPath();
      $data = Excel::load($path)->get();
      $saved_1 = false;
      $saved_2 = false;
      $saved_3 = false;

      // echo '<pre>';
      // print_r($data->count());die;
        if ($data->count() > 0){
        $header = $data->first()->keys()->toArray();



      if($header[0] == 'category_name'  && $header[1] == 'category_description'  && $header[2] == 'category_image' && $header[3] == 'product_name' && $header[4] == 'product_description' && $header[5] == 'key_ingredients' && $header[6] == 'benefits_of_product' && $header[7] == 'product_images')
       {


          $num1 = 0;
          $num2 = 0;

          foreach ($data->toArray() as $key => $value) {

           if(isset($value['category_name'])  && isset($value['category_image']) && isset($value['product_name']) && isset($value['product_description']) && isset($value['key_ingredients']) && isset($value['benefits_of_product']) && isset($value['product_images']))
           {

          $images = explode(',',$value['product_images']);
          if (count($images) > 0 && count($images)<=4)
          {

            $categories = AayushCategory::select('category_name','id')->where('category_name',$value['category_name'])->get();

            if (count($categories) > 0){

              $productArray = AayushProducts::select('id')->where('product_name',$value['product_name'])->get();
              if(count($productArray) > 0){
              }else{
              $product = array(
                'ayush_categories_id'=>  $categories[0]['id'],
                'product_name'=>  ucwords($value['product_name']),
                'product_description'=>  ucfirst($value['product_description']),
                'key_ingredients'=> ucwords($value['key_ingredients']),
                'direction'=>  ucfirst($value['benefits_of_product']),
                'status'=> '1',
              );
              $product_id =  DB::table('ayush_products')->insertGetId($product);
              $saved_2 = true;
              $productImage = array(
                'ayush_products_id'=> $product_id,
                'image_one'=> $images[0],
                'image_two'=>  isset($images[1]) ? $images[1] : '',
                'image_three'=> isset($images[2]) ? $images[2] : '',
                'image_four'=>  isset($images[3]) ? $images[3] : '' ,
              );

                DB::table('ayush_product_images')->insertGetId($productImage);
            }





                $saved_1 = true;
                $saved_3 = true;
                $saved_3 = true;
                $num1 = $num1 + 1;

            }else{


              $categoryArray = array(
                'category_name'=>  ucwords($value['category_name']),
                'category_description'=> ucfirst($value['category_description']),
                'image'=>  $value['category_image'],
                'status'=> '1',
              );
              $cat_id =  DB::table('ayush_categories')->insertGetId($categoryArray);
              $saved_1 = true;

              $product = array(
                'ayush_categories_id'=> $cat_id,
                'product_name'=> ucwords($value['product_name']),
                'product_description'=>  ucfirst($value['product_description']),
                'key_ingredients'=> ucwords($value['key_ingredients']),
                'direction'=>  ucfirst($value['benefits_of_product']) ,
                'status'=> '1',
              );
              $product_id =  DB::table('ayush_products')->insertGetId($product);
              $saved_2 = true;


              $productImage = array(
                'ayush_products_id'=> $product_id,
                'image_one'=> $images[0],
                'image_two'=>  isset($images[1]) ? $images[1] : '',
                'image_three'=> isset($images[2]) ? $images[2] : '',
                'image_four'=>  isset($images[3]) ? $images[3] : '' ,
              );

                DB::table('ayush_product_images')->insertGetId($productImage);
                $saved_3 = true;
                $num2 = $num2 + 1;


              }

               }


                   }

                     }



          if($saved_1 =  true && $saved_2 =  true && $saved_3 =  true ){
            $final_count = (int)$num1 + (int)$num2 * 1;
            if($final_count > 0){
              return response()->json(['success'=>true,'message'=>'Total '.$final_count .' Rows Imported Successfully']);
              die;
            }else{
              return response()->json(['success'=>false,'message'=>'Something went wrong']);
              die;
            }

          }else{
            return response()->json(['success'=>false,'message'=>'Technical error']);
            die;
          }
        }else{

         return response()->json(['success'=>false,'message'=>'invalid file,file did not match from sample file']);
         die;

        }


      }else{
        return response()->json(['success'=>false,'message'=>'file can not be empty']);
        die;
      }

      }else{
      return response()->json(['success'=>false,'message'=>'invalid  file format,file should be xlsx or xls']);
      die;
    }
  }



}



}
