<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedbackQuestions;
use App\Models\FeedbackQuestionsOptions;
use App\Models\FeedbackResponses;
use App\Models\FeedbackResponsesRatings;
use Exception;
use Illuminate\Support\Facades\Validator;
use Config;
use ValidationException;
use DB;
use Auth;





class Feedback extends Controller
{
	public function __construct()
    {
         //$this->middleware('App\Http\Middleware\ModeratorType');
    }

    public function ListsFeedback()
	{
		try{
			return view('feedback.feedback_index');
		  }catch(Exception $e){
			abort(500, $e->message());
		  }
	}
	public function FeedbackIndexAjax(Request $request)
	{
      //$draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
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
          $search = ($request->search['value']) ? $request->search['value'] : ''; 
		 // DB::enableQueryLog();
		  /* $users=DB::table('feedback_responses_ratings')
		  ->join('feedbacks', 'feedbacks.id', '=', 'feedback_responses_ratings.feedback_id')
		  ->join('users','users.id', '=', 'feedbacks.users_id')
		  ->select('feedbacks.id','users.name','users.email','users.phone','feedbacks.created_at','feedback_responses_ratings.rating','feedback_responses_ratings.rating_description')
		  ->where('users.status','1')
		  ->groupBy('feedbacks.created_at')
		  ->orderBy('feedbacks.id','desc')
		  ->get(); */
		   $users=DB::table('feedbacks')
		   ->join('users','users.id', '=', 'feedbacks.users_id')
		  ->leftjoin('feedback_responses_ratings', 'feedback_responses_ratings.feedback_id', '=', 'feedbacks.id')		 
		  ->select('feedbacks.id','users.name','users.email','users.phone','feedbacks.created_at','feedback_responses_ratings.rating','feedback_responses_ratings.rating_description')
		  ->where('users.status','1')
		  //->groupBy('feedbacks.created_at')
		  ->orderBy('feedbacks.id','desc');
		  //->get();
		 /*  echo "<pre>";
		  print_r($users);
		  die; */
		$start = ($request->start) ? $request->start : 0;
        $end = ($request->length) ? $request->length : 10; 
	    $search = ($request->search['value']) ? $request->search['value'] : '';
		 if ($request->search['value'] != "") {
            $users = $users->where('name','LIKE',"%".$search."%");
          } 

		

		
		//echo $end;
           $total = $users->count();
          if($end==-1){
            $users = $users->get();
          }else{
            $users = $users->skip($start)->take($end)->get();
          }  

          if($users->count() > 0){		   
			 $i = 1;
            foreach($users as $k=>$v){
				$star = '';
				for($j=0;$j<$users[$k]->rating;$j++){
					$star .= '&#9733;';
				}
			  $users[$k]->sr_no = $i; 
              $users[$k]->id = $users[$k]->id;			  
			  $users[$k]->name = ucfirst($users[$k]->name);
              $users[$k]->email = $this->encdesc($users[$k]->email,'decrypt');
              $users[$k]->phone = $this->encdesc($users[$k]->phone,'decrypt');
			  $users[$k]->created_at =($users[$k]->created_at) ? date('d-M-Y h:i A',strtotime($users[$k]->created_at)) : '';
			  $users[$k]->rating = $star;//$users[$k]->rating; 
			  $users[$k]->rating_description = ucfirst($users[$k]->rating_description);  
			  $i++;  
			  
			  						  			
		
		 
            }

          }
		  $response['recordsFiltered'] = $total;
		  $response['recordsTotal'] = $total;
		  $response['success'] = 1; 
		  $response['data'] = $users;
		   

//echo "<pre>";
		 // print_r($response);
		 
         /* $response["recordsFiltered"] = $total;
          $response["recordsTotal"] = $total;
          //response["draw"] = draw;
          $response["success"] = 1;
          $response["data"] = $users; */ 
		  
		 // die;
		
		
        } catch (Exception $e) {

        }
			return response($response);

      
	}

	public function ViewFeedback(Request $request)
	{
			$feeback_view = DB::select("select
				`feedback_questions`.*, `feedback_questions_options`.`id` as `feedback_questions_options_id`, `feedback_questions_options`.`feedback_questions_id` as `feedback_questions_id`, `feedback_questions_options`.`options` as `options`
			from
				`feedback_responses`
			 inner join
				`feedback_questions` on `feedback_questions`.`id` = `feedback_responses`.`feedback_questions_id`
			left join
				`feedback_questions_options` on `feedback_questions_options`.`id` = `feedback_responses`.`feedback_questions_options_id` and  feedback_questions_options.feedback_questions_id = feedback_responses.feedback_questions_id 
			where
				`feedback_responses`.`feedback_id` = $request->id");
			/* echo "<pre>";
			print_r($feeback_view);
			die;  */
			if($feeback_view)
			{
				return view('feedback.feedback_view',compact('feeback_view',$feeback_view));
			}
			else
			{
				return redirect()->action('Feedback@ListsFeedback')->with('flash_message_feedback', 'Feedback not available')->with('flash_type', 'alert-danger');
			}
	}
}
