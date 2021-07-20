<?php

    namespace App\Http\Controllers\v6;
   
    use App\Quiz;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Http\Request;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Http\Controllers\Traits\SendMail;
    use Config;
    use App\Common\Utility;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\DB;
    use App\duplicateRequest;
	use  Carbon\Carbon;

    class QuizController extends Controller
    {
         public function getQuiz(Request $request){
			try{
                
                $status = Config::get('app.status_codes');
                $message = "Request processed successfully";      
                $cond[] = ['status',1];   
				
				if(Quiz::where($cond)->count()==0){
					return response()->json(['status'=>$status['NP_NO_RESULT'],'message'=>'No result found','data'=>array()]);
				}
				$quizes = Quiz::where($cond)
								->where([
								['start_date','<=',Carbon::now()],
								['end_date','>=',Carbon::now()]
								])
								->skip(0)->take(4)->get();
				
				//echo Carbon::now();
				//echo $quizes;die;
				$quizesData = [];                    
				foreach($quizes as $k=>$v){
					$questions = DB::table('quiz_questions as q')
						->select('q.id as que_id','q.question')
						->where('q.quiz_id',$v->id)
						->get();
					$questionData = [];
					
					foreach($questions as $qkey=>$question){
						$ansData = [];
						$questionData[$qkey]['que_id'] = $question->que_id;
						$questionData[$qkey]['question'] = $question->question;
						
						$options = DB::table('quiz_question_options as ans')
						->where('ans.quiz_question_id',$question->que_id)
						->get();
						
						foreach($options as $okey=>$option){
							$ansData[$okey]['ans_id'] = $option->id;
							$ansData[$okey]['ans_text'] = $option->options;
						}
						$questionData[$qkey]['ans_data'] = $ansData;
					}
					$quizesData[$k]['quiz_id'] = $v->id;
					$quizesData[$k]['quiz_name'] = $v->quiz_name;
					$quizesData[$k]['quiz_time'] = $v->quiz_time;
					$quizesData[$k]['question_data'] = $questionData;
				}
				//$status = 1;                    
				return response()->json([  
				"status"=>$status['NP_STATUS_SUCCESS'],
				"message"=>$message,				
				'data'=>$quizesData
				]);
               
            }catch(Exception $e){   
                $message = "Data exception";
                return response()->json(['status'=>$status['NP_STATUS_NOT_KNOWN'],'message'=>$message,'data'=>array()]);
            }
		 }
         
		  public function validateQuiz(Request $request){
			 
			 try{
				 $user  = JWTAuth::user();
				 
				 $status=Config::get('app.status_codes');
				 $quiz_valid = false;
				 
				$validator = Validator::make($request->all(), [                 
                        'quiz_id' => 'required'
				]);
				
				if($validator->fails()){
						Log::debug(['Validation failed',$request->all()]);
						
						return response()->json(['status'=>$status['NP_INVALID_REQUEST'],
						'message'=>'invalid Request']);
				}  

				 $user_id = $user->id;
				 $quiz_id = $request->quiz_id;
				 
				 $quiz = Quiz::find($quiz_id);
		
					if(!$quiz){
						return response()->json(['status'=>$status['NP_NO_RESULT'],'message'=>'No result found']);
					}
					if($quiz->status==0){
						return response()->json(['status'=>$status['NP_NO_RESULT'],'message'=>'No result found']);
					}
				 
				 //check if user already given this quiz
				 $count = DB::table('quiz_responses')->where(['user_id'=>$user_id,'quiz_id'=>$quiz_id])->count();
				 
				 $quizesData = [];
				 //echo $count;die;
				 if($count==0){
					 //$quiz_valid = true;
					 $message = "Request processed successfully"; 
					 $s = $status['NP_STATUS_SUCCESS'];
					 
					 return response()->json([
					'status'=>$s,  
					"message"=> $message,				
					//'quiz_valid'=>$quiz_valid
					]); 
				 }else{
					 $attemptedQuizDetails = DB::table('quiz_responses as res')
											->where(['res.user_id'=>$user_id,'res.quiz_id'=>$quiz_id])
											->orderBy('res.id','desc')
											->leftJoin('quiz_question_options as op','op.id','res.quiz_question_option_id')
											->select('res.response_datetime',DB::raw("COUNT(CASE WHEN (op.correct_answer = 1) then (op.correct_answer) END) as correct_answer"))
											->first();
					 
					 //$quiz_valid = false;
					 $attempted_date = date('d M,Y',strtotime($attemptedQuizDetails->response_datetime));
					 $attempted_time = date('H:i A',strtotime($attemptedQuizDetails->response_datetime));
					 
					 $score = DB::table('quiz_questions as ques')
							->where('ques.quiz_id',$quiz_id)
							->count();
					$marks_per_ques = Config::get('app.marks_per_question');
					 $message = 'You have already attempted this quiz on '. $attempted_date.' at '.$attempted_time.' and your total score was '.($attemptedQuizDetails->correct_answer*$marks_per_ques).'/'.($score*$marks_per_ques); 
					 $s = $status['NP_DUPLICATE_REQUEST'];
					 
					 $quizesData['marks_obtained'] =  $attemptedQuizDetails->correct_answer*$marks_per_ques;
					 $quizesData['total_marks'] =  $score*$marks_per_ques;
					 $quizesData['response_date'] =  $attemptedQuizDetails->response_datetime;
					 
					 return response()->json([
					'status'=>$s,  
					"message"=> $message,				
					//'quiz_valid'=>$quiz_valid,
					'data' => $quizesData
					]); 
				 }
				
                   
				
               
            }catch(Exception $e){   
                $message = "Data exception";
                return response()->json(['status'=>$status['NP_STATUS_NOT_KNOWN'],'message'=>$message]);
            }
		 } 
         
		 public function submitQuiz(Request $request){
			try{ 
				$user  = JWTAuth::user();
				//echo $user;die;
				$status = Config::get('app.status_codes');
				//print_r($request->data);
                $validator = Validator::make($request->all(), [                 
                        'data.quiz_id' => 'required'
				]);
				
				if($validator->fails()){
						Log::debug(['Validation failed',$request->all()]);
						return response()->json(['status'=>$status['NP_INVALID_REQUEST'],'message'=>'invalid Request']);
				} 
				
				$user_id = $user->id;
				$quiz_id = $request->data['quiz_id'];
				
				$quiz = Quiz::find($quiz_id);
				//check quiz exist or quiz is activated or not

					if(!$quiz){
						return response()->json(['status'=>$status['NP_NO_RESULT'],'message'=>'No result found']);
					}
					if($quiz->status==0){
						return response()->json(['status'=>$status['NP_NO_RESULT'],'message'=>'No result found']);
					}
				
				//duplicate request
				$checkAlreayAttenedQuiz =  DB::table('quiz_responses')->where(['user_id'=>$user_id,'quiz_id'=>$quiz_id])->count();
				
				 if($checkAlreayAttenedQuiz>0){
					 Log::debug(['Validation failed',$request->all()]);
					return response()->json(['status'=>$status['NP_DUPLICATE_REQUEST'],'message'=>'You have already attended the quiz']);
				 }
				 
				 //Check if the no of questions attended by user is equal to the questions are in the quiz.
				 //get count of questions in quiz
				 $totalQuestionInQuiz = DB::table('quiz_questions')->where('quiz_id',$quiz_id)->count();
				 
				 //count the questions submited by user
				 $questionSubmitedByUser = count($request->data['question_data']);
				 
				 if($totalQuestionInQuiz!=$questionSubmitedByUser){
					 return response()->json(['status'=>$status['NP_INCOMPLETE_DATA'],'message'=>'Please attempt all the questions']);
				 }
				 
				 $data['quiz_id'] = $quiz_id;
				 $data['user_id'] = $user_id;
				 //print_r($request->data['question_data']);die;
				  foreach($request->data['question_data'] as $value){
					  $data['quiz_question_id'] = $value['que_id'];
					  $data['quiz_question_option_id'] = $value['ans_id'];
					  
					   $insert = DB::table('quiz_responses')->insert($data);
				  }

                  
				 if($insert==1){
                     
                    //inser total time
                    $quiz_responses_time_data['quiz_id'] = $quiz_id;
                    $quiz_responses_time_data['user_id'] = $user_id;
                    $quiz_responses_time_data['quiz_responses_time'] = $request->data['quiz_responses_time'];

                    $insertTime = DB::table('quiz_responses_time')->insert($quiz_responses_time_data);
                  
					 $attemptedQuizDetails = DB::table('quiz_responses as res')
											->where(['res.user_id'=>$user_id,'res.quiz_id'=>$quiz_id])
											->orderBy('res.id','desc')
											->leftJoin('quiz_question_options as op','op.id','res.quiz_question_option_id')
											->select(DB::raw("COUNT(CASE WHEN (op.correct_answer = 1) then (op.correct_answer) END) as correct_answer"))
											->first();
                     
					$score = DB::table('quiz_questions as ques')
							->where('ques.quiz_id',$quiz_id)
							->count();
                    
					$marks_per_ques = Config::get('app.marks_per_question');
					$quizesData['marks_obtained'] =  $attemptedQuizDetails->correct_answer*$marks_per_ques;
					$quizesData['total_marks'] =  $score*$marks_per_ques;
                    
					 return response()->json([
						'status'=>$status['NP_STATUS_SUCCESS'],
						'message'=>'Your quiz has been submitted successfully, your score '.($attemptedQuizDetails->correct_answer*$marks_per_ques).'/'.($score*$marks_per_ques),
						'data'=>$quizesData
						]);
				 }else{
					 return response()->json(['status'=>$status['NP_DB_ERROR'],'message'=>'Something went wrong']);
				 }
				
			
			}catch(Exception $e){   
                $message = "Data exception";
                return response()->json(['status'=>$status['NP_STATUS_NOT_KNOWN'],'message'=>$message]);
            }
		 } 
    }