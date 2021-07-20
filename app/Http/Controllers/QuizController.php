<?php

    namespace App\Http\Controllers;
    use App\Http\Controllers\Traits\NotifyMail;
    use App\Quiz;
	use App\User;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Traits\SendMail;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use Illuminate\Support\Facades\Log;
    use Config;
    use DateTime;
    use Mail;
	use Auth;
	use DB;
	use  Carbon\Carbon;
    

    class QuizController extends Controller
    {
        
    
        /**
         * Get formated time (hours minus and second)
         * @param type $seconds
         * @return type
         */
        public function convert_seconds($seconds) {
            $dt1 = new DateTime("@0");
            $dt2 = new DateTime("@$seconds");

            //return $dt1->diff($dt2)->format('%a days, %h hours, %i minutes and %s seconds');

            return $dt1->diff($dt2)->format('%i Minutes %s Seconds');
        }
    
		/**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            try{                           
                return view('quiz.index');
            }catch(Exception $e){
                abort(500, $e->message());
            }
        }
		/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
		public function create(Request $request){
		  $quizes = '';
		   return view('quiz.create',compact(['quizes']));
		}
		
		/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
		public function store(Request $request){
		
            $validator = Validator::make($request->all(),[
                    'quiz_name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/',
                   // 'quiz_time' => 'required|numeric',
                    'valid_for' => 'required|numeric'
                ],
                [
                  'quiz_name.required'=>'Please enter Quiz name',
                 // 'quiz_time.required'=>'Please enter quiz time',
                //  'quiz_time.numeric'=>'Please enter valid quiz time',
                  'valid_for.required'=>'Please enter quiz valid for',
                  'valid_for.numeric'=>'Please enter valid quiz valid for'
                ]
            );
			if ($validator->fails()) {   
				return back()->withInput()->withErrors($validator);	
				//return response()->json(['failed'=>1,'messages'=>$validator->messages()]);
			}
			
			$quiz = new Quiz;
			$quiz->quiz_name = $request->quiz_name;
			$quiz->valid_for = $request->valid_for;
			//$quiz->quiz_time = $request->quiz_time;
			$quiz->created_by = Auth::user()->id;
			if($quiz->save()){				
				$quiz_id = $quiz->id;
				 return redirect('/quiz/add/'.$quiz_id)
				 ->with('flash_message', 'Quiz added successfully, add questions here')
				->with('flash_type', 'alert-success');
				
			}else{				
				return back()->withErrors(['errors'=>'Failed to add Quiz']);				
			}
		}
		
		/**
     * Display the specified resource.
     *
     * @param  \Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
	public function view(Request $request){
		$id = $request->id;
		$current_user = Auth::user()->id;
		$quiz = Quiz::find($id);
		
		if(!$quiz){
			return redirect()->action('QuizController@index')->with('flash_message', 'Quiz not available')->with('flash_type', 'alert-danger');
		}
		
		$questions = DB::table('quiz_questions')->where('quiz_id',$id)->get();
		$questionData = [];
		foreach($questions as $key=>$question){
			$questionData[$key]['id'] = $question->id;
			$questionData[$key]['question'] = $question->question;
						
			$options = DB::table('quiz_question_options')->where('quiz_question_id',$question->id)->get();
			
			$questionData[$key]['options'] = $options;
		}
        return view('quiz.view', compact('quiz','questionData'));
	}
	/**
     * Display the specified resource.
     *
     * @param  \App\quiz  $quiz
     * @return \Illuminate\Http\Response
     */
	public function show(Request $request){
		$id = $request->id;
		$current_user = Auth::user()->id;
		$quiz = Quiz::find($id);
		
		if(!$quiz){
			return redirect()->action('QuizController@index')->with('flash_message', 'Invalid Quiz')
				->with('flash_type', 'alert-danger');
		}
		if($quiz->is_editable==0)
			return redirect()->action('QuizController@index')->with('flash_message', 'Quiz is not editable')
				->with('flash_type', 'alert-danger');
			
		$questions = DB::table('quiz_questions')->where('quiz_id',$id)->get();
		$questionData = [];
		foreach($questions as $key=>$question){
			$questionData[$key]['id'] = $question->id;
			$questionData[$key]['question'] = $question->question;
						
			$options = DB::table('quiz_question_options')->where('quiz_question_id',$question->id)->get();
			
			$questionData[$key]['options'] = $options;
		}
        return view('quiz.edit', compact('quiz','questionData'));
	}
	
		/**
		 * Add questions of a quiz.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		*/
		public function AddQuestions(Request $request){
			$id = $request->quiz_id;
			$quiz = Quiz::find($id);
			if(!$quiz){
				return redirect('/quiz')
				 ->with('flash_message', 'Invalid quiz')
				->with('flash_type', 'alert-danger');
			}
			if($quiz->is_editable==0){
				return redirect('/quiz')
				 ->with('flash_message', 'Quiz not editable')
				->with('flash_type', 'alert-danger');
			}
			$checkQuiz = DB::table('quiz_questions')->where('quiz_id',$id)->count();
				if($checkQuiz>0){
					return redirect('/quiz')
					->with('flash_message', 'Quiz already submitted')
					->with('flash_type', 'alert-danger');
				}
		   return view('quiz.add',compact(['quiz']));
		}
		
		/**
		 * Store questions of a quiz.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @return \Illuminate\Http\Response
		*/
		public function storeQuestions(Request $request){
			$validator = Validator::make($request->all(),[
                'questions*'=>'required|max:255',
                'answer[0].*' => 'required',
                'options[0].*' => 'required|max:255'
            ],
            [
              'questions.required'=>'Please enter questions',
              'questions.max'=>'Questions length should not be greater than 255 characters',
              'answer.required'=>'Please choose correct answer',
              'options.required'=>'Please enter options',
              'options.max'=>'Options length should not be greater than 255 characters.'
            ]
		);
			if ($validator->fails()) {   
				return back()->withErrors($validator);	
				//return response()->json(['failed'=>1,'messages'=>$validator->messages()]);
			}
			

			$id = $request->quiz_id;
			$quiz = Quiz::find($id);
			if(!$quiz){
				return redirect('/quiz')
				 ->with('flash_message', 'Invalid quiz')
				->with('flash_type', 'alert-danger');
			}
			if($quiz->is_editable==0){
				return redirect('/quiz')
				 ->with('flash_message', 'Quiz not editable')
				->with('flash_type', 'alert-danger');
			}
			
			if($id){
				
				//dd($request->all());
				foreach($request->questions as $qid=>$question){
					if($question!=''){
						if(DB::table('quiz_questions')->insert(
						  ['quiz_id' => $id, 'question'=>trim($question)]
						)){
							$quiz_question_id = DB::getPdo()->lastInsertId();
							foreach($request->options[$qid] as $okey=>$option){
								if($option!=''){
									$correct_ans = 0;
									if($request->answer[$qid]==$okey)
										$correct_ans = 1;
										
										
									DB::table('quiz_question_options')->insert(
									  ['quiz_question_id' => $quiz_question_id, 'options'=>trim($option),'correct_answer'=>$correct_ans]
									);
								}
							}
						}
					}
				}
				return redirect('/quiz')
				 ->with('flash_message', 'Quiz added successfully')
				->with('flash_type', 'alert-success');
			}
			else{
				return redirect('/quiz')
				 ->with('flash_message', 'Invalid data set')
				->with('flash_type', 'alert-danger');
			}
		}
		
		/**
     * Update the specified resource.
     *
     * @param  \Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request){
		
		$validator = Validator::make($request->all(),[
                'quiz_name'=>'required|max:255|regex:/^[a-zA-Z]+[a-zA-Z0-9-_ ]*[a-zA-Z0-9]$/',
               // 'quiz_time'=>'required|numeric',
                'valid_for'=>'required|numeric',
                'questions.*'=>'required|max:255',
                'options[0].*' => 'required|max:255'
            ],
            [
              'quiz_name.required'=>'Please enter quiz name',
              'quiz_name.max'=>'quiz name limit exceed',
			  //'quiz_time.required'=>'Please enter quiz time',
              //'quiz_time.numeric'=>'Please enter valid quiz time',
              'valid_for.required'=>'Please enter quiz valid for',
              'valid_for.numeric'=>'Please enter valid quiz valid for',
              'questions.required'=>'Please enter questions',
              'options.required'=>'Please enter option'
            ]
       );
        if ($validator->fails()) {  
			return back()->withErrors($validator);			
            //return response()->json(['failed'=>1,'messages'=>$validator->messages()]);
        }
		
		$id = $request->id;
		$current_user = Auth::user()->id;
		$quizArr['quiz_name'] = trim($request->quiz_name);
		//$quizArr['quiz_time'] = trim($request->quiz_time);
		$quizArr['valid_for'] = trim($request->valid_for);
		$quizArr['updated_by'] = $current_user;
		
		 if(Quiz::where('id',$id)->update($quizArr)){
			 
			 $questions = DB::table('quiz_questions')->where('quiz_id',$id)->get();
			 foreach($questions as $question){
				  DB::table('quiz_question_options')->where('quiz_question_id',$question->id)->delete();
			 }
			 DB::table('quiz_questions')->where('quiz_id',$id)->delete();
			 if($request->questions)
			 {
				foreach($request->questions as $qid=>$postQuestion){
				 if($postQuestion!=''){
					if(DB::table('quiz_questions')->insert(
						  ['quiz_id' => $id, 'question'=>trim($postQuestion)]
						)){
							$quiz_question_id = DB::getPdo()->lastInsertId();
							foreach($request->options[$qid] as $okey=>$option){
								if($option!=''){
									$correct_ans = 0;
									if($request->answer[$qid]==$okey)
										$correct_ans = 1;
									DB::table('quiz_question_options')->insert(
									  ['quiz_question_id' => $quiz_question_id, 'options'=>trim($option),'correct_answer'=>$correct_ans]
									);
								}
							}
						}
				 }
				}
			 }
		 return redirect()->action('QuizController@index')->with('flash_message', 'Quiz updated successfully')->with('flash_type', 'alert-success');
			
        }else{
			return back()->withErrors(['errors'=>'Could not update Quiz']);
            //return back()->with('flash_message', 'Could not update Quiz')->with('flash_type', 'alert-danger');;
        }
	}
		
		/*get Data by ajax to show quizes*/
		public function quizIndexAjax(Request $request){
			$draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
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
               
                //$cond[] = ['status','<>',''];
                $quizes = Quiz::orderBy('id','desc');
                
                
                if ($request->search['value'] != "") {            
                  $quizes = $quizes->where('quiz_name','LIKE',"%".$search."%");
                } 
     // echo $quizes->toSql();die;
                $total = $quizes->count();
                if($end==-1){
                  $quizes = $quizes->get();
                }else{
                  $quizes = $quizes->skip($start)->take($end)->get();
                }
                
                if($quizes->count() > 0){
					$i = 1;

                    foreach($quizes as $k=>$v){
					 $total_no_of_submission = DB::table('quiz_responses')->where([
					['quiz_id',$quizes[$k]->id]
					])->count(DB::raw('DISTINCT user_id')); 
					
					$is_publishable = 1;
					if($quizes[$k]->end_date< Carbon::now() && $quizes[$k]->end_date!=''){
						$is_publishable = 0;
					}
					
                      $quizes[$k]->sr_no = $i; 
                      $quizes[$k]->id = $quizes[$k]->id; 
                      $quizes[$k]->quiz_name = ucwords($quizes[$k]->quiz_name);  
                      $quizes[$k]->quiz_time = bcadd(0,$quizes[$k]->quiz_time/60,2);  
                      $quizes[$k]->total_no_of_submission = $total_no_of_submission;
                      $quizes[$k]->start_date = ($quizes[$k]->start_date) ?date('d-M-Y h:i A',strtotime($quizes[$k]->start_date)) : 'Not descied yet'; 
                      $quizes[$k]->end_date = ($quizes[$k]->end_date) ? date('d-M-Y h:i A',strtotime($quizes[$k]->end_date)) : 'Not descied yet'; 
                      $quizes[$k]->status = $quizes[$k]->status; 
                      $quizes[$k]->is_editable = $quizes[$k]->is_editable; 
                      $quizes[$k]->is_publishable = $is_publishable; 
					  $i++;
                    }
                  }     
                
                $response["recordsFiltered"] = $total;
                $response["recordsTotal"] = $total;
                //response["draw"] = draw;
                $response["success"] = 1;
                $response["data"] = $quizes;
                
              } catch (Exception $e) {    
      
              }
            
      
            return response($response);
		}
		/* change status of quiz
		*/
		public function changestatus(Request $request){
          try{
			ini_set('memory_limit', '256M');
            if(!$this->checkAuth(4)){
               return abort(404);; 
            }
			$date = date('Y-m-d H:i:s');
            $quiz = new Quiz();
			
            $id = $request->quiz_id;
            $quizData = $quiz->findOrFail($id);
			
			
			if(!$quizData){
				return redirect()->action('QuizController@index')->with('flash_message', 'Quiz not available')->with('flash_type', 'alert-danger');
			}
			
			if($request->status==1){
				//only 4 Quiz should be activated.
				$quizCount = $quiz::where('status',1)->count();
				//echo $quizCount;die;
				if($quizCount==4){
					$msg = "Four quizes are currently active. If you want to activate this quiz then please deaactive any of the active quizes.";
					
					return response()->json(["status"=>1,"message"=>$msg,'flash_type'=>'alert-danger']);  				
				}
				
				//check if atleast 1 question is there in current quiz or not,if not then can not activate the quiz
				
				$noOfQuestions = DB::table('quiz_questions as ques')
							->where('ques.quiz_id',$id)
							->count();
				if($noOfQuestions==0){
					$msg = "This quiz can not be activated as there are no questions in this quiz.";
					
					return response()->json(["status"=>1,"message"=>$msg,'flash_type'=>'alert-danger']); 
				}

			}
             if($quizData->count()>0){
              $quizData->status = $request->status;
              
			  if($quizData->is_editable==1){
				  $quizData->start_date =  $date;
				  $date = strtotime($date);
				  $quizData->end_date = date('Y-m-d H:i:s',strtotime("+ ".$quizData->valid_for." day", $date));
			 }
			  $quizData->is_editable = 0;
              if($quizData->save()){
                if($request->status==1){
                  $msg = "Quiz Activated Successfully";
				  
				  $userData = User::where([['device_id','!=',null],['device_id','!=',''],['device_id','!=','null']])->whereIn('role_id',[2,3,5])->select('device_id')->get();
            
				//dd($userData);

                  $data[] = [];
				  $msgBody = 'Congratulations, We have added a new quiz, Please be the first to submit it.';
				 /*  $msgBody .= 'Quiz Start Date: '.date('d-M-Y h:i A',strtotime($quizData->start_date));
				   $msgBody .=', Quiz End Date: '.date('d-M-Y h:i A',strtotime($quizData->end_date)); */
				   
				   $data['subject'] = $quizData->quiz_name.' is ready';
				   $data['messageBody'] = $msgBody;
				   
				$arr_deviceId = array();
				foreach($userData as $ukey=>$user){  
					if($user['device_id']!=null && $user['device_id']!='null')			
						$arr_deviceId[] = $user['device_id'];			  
				}
				//dd($arr_deviceId);
				$this->sendPushNotification($arr_deviceId,$data);
				$flash_type = 'alert-success';
                }else{
                  $msg = "Quiz De-activated Successfully";
				  $flash_type = 'alert-danger';
                }            
                return response()->json(["status"=>1,"message"=>$msg,'flash_type'=>$flash_type]);            
              }else{
                return response()->json(["status"=>0,"message"=>"Technical ERROR",'flash_type'=>'alert-danger']);            
              }
            }else{
              return response()->json(["status"=>0,"message"=>"Technical error",'flash_type'=>'alert-danger']);          
            }
            
          }catch(Exception $e){
            abort(500, $e->message());
          }
        }
		/*
			Delete quiz
		*/		
		public function destroy(Request $request){
			
		  $msg = '';
		  $id = $request->id;
		  $checkQuiz = Quiz::find($id);
		  if($checkQuiz->is_editable==1){			 
			  $deleted = Quiz::find($id)->delete();
			  
			  if($deleted)
				 $msg = 'Quiz deleted successfully';
			  else
			   $msg = 'Failed to delete Quiz';
		  }else{
			  $msg = "Can not delete this Quiz";
		  }
		  echo $msg;
		}
		
		/* Get all Quizes which are about to expire
			Send notification to user 
		*/
		public function QuizesAboutToExpire(Request $request){
			
			try{
				 $quizCount = Quiz::where('status',1)->whereRaw('DATEDIFF(end_date,CURRENT_DATE())=1')->count();
				 if($quizCount>0){
					 
					 $userData = User::where([['device_id','!=',null],['device_id','!=',''],['device_id','!=','null']])->whereIn('role_id',[2,3,5])->select('device_id')->get();
					 
					 $quizes = Quiz::where('status',1)->whereRaw('DATEDIFF(end_date,CURRENT_DATE())=0')->get();
					 foreach($quizes as $quiz){
						 
						 
						 
						  $data[] = [];
						   $msgBody = 'Hurry, Today is the last chance to submit the '. $quiz->quiz_name. '. Please submit the quiz before it being expired.';
						   
						   $data['subject'] = $quiz->quiz_name.' will be expired today.';
						   $data['messageBody'] = $msgBody;
						   
						$arr_deviceId = array();
						foreach($userData as $ukey=>$user){  
							if($user['device_id']!=null && $user['device_id']!='null')			
								$arr_deviceId[] = $user['device_id'];			  
						}
						//dd($arr_deviceId);
						$this->sendPushNotification($arr_deviceId,$data); 
					 }
				 }
				
			}catch(Exception $e){
				abort(500, $e->message());
			  } 
		}
		/**
     * Display indivisual Quiz result.
     *
     * @param  App\quiz  $quiz
     * @return \Illuminate\Http\Response
     */
	public function viewResult(Request $request){
		$id = $request->id;
		
		$quiz = Quiz::find($id);
		
		if(!$quiz){
			return redirect()->action('QuizController@index')->with('flash_message', 'Invalid quiz')
				->with('flash_type', 'alert-danger');
		}
        
		if($quiz->is_editable==1)
			return redirect()->action('QuizController@index')->with('flash_message', 'Quiz not pulbish yet')->with('flash_type', 'alert-danger');
		

            
			return view('quiz.result', compact('quiz'));
		}
		
	public function getResultbyQuiz(Request $request){
		//$draw = ($request->data["draw"]) ? ($request->data["draw"]) : "1";
		$response = [
		  "recordsTotal" => "",
		  "recordsFiltered" => "",
		  "data" => "",
		  "success" => 0,
		  "msg" => ""
		];
		try {
			 $id = $request->quiz_id;
	
			$questin_count_arr = DB::table('quiz_questions')->select( DB::raw('COUNT(id) as total_question') )->where('quiz_id', $id)->first();
		
		
				$userDetails = DB::table('quiz_responses as res')
						->leftJoin('users as u','u.id','res.user_id')
						->leftJoin('quiz_question_options as op','op.id','res.quiz_question_option_id')
						->select('res.user_id','res.quiz_id','u.name','u.email',DB::raw("COUNT(CASE WHEN (op.correct_answer = 1) then (op.correct_answer) END) as correct_answer"))
						->where([
								['res.quiz_id',$id]
							]);
							
						if ($request->search['value'] != "") {            
						  $userDetails = $userDetails->where('u.name','LIKE',"%".$request->search['value']."%");
						} 
							
						$userDetails = $userDetails->groupBy('res.user_id')
						->get();
	//echo $userDetails;exit;
		 $userArr = array();
		$marks_per_ques =  Config::get('app.marks_per_question');
		$i =1;
		foreach($userDetails as $users){
			
			$response_time_arr = DB::table('quiz_responses_time')->select('quiz_responses_time')->where('quiz_id', $id)->where('user_id', $users->user_id)->first();
			$time = (isset($response_time_arr->quiz_responses_time) ? $response_time_arr->quiz_responses_time : 0);
			
			if($time > 60) {
				$time = $this->convert_seconds($time);
			} else {
				$time = $time . ' Seconds';
			}
			
			$userArr[] = array(
				'name'              => $users->name,
				'email'             => $this->encdesc($users->email,'decrypt'),
				'marks_obtained'    => $users->correct_answer*$marks_per_ques,
				'correct_answer'    => $users->correct_answer*$marks_per_ques . '/' . $questin_count_arr->total_question*$marks_per_ques,
				'user_id'           => $users->user_id,
				'quiz_id'           => $users->quiz_id,
				'quiz_responses_time' => $time
			);
			
		}
		
		$marks_obtained = array_column($userArr, 'marks_obtained');
		array_multisort($marks_obtained, SORT_DESC, $userArr);
			
			$responseArr = [];
			$i=1;
			foreach($userArr as $users){
				$responseArr[] = array(
					'sr_no'      => $i,
					'name'              => $users['name'],
					'email'             => $users['email'],
					'marks_obtained'    => $users['marks_obtained'],
					'correct_answer'    => $users['correct_answer'],
					'user_id'           => $users['user_id'],
					'quiz_id'           => $users['quiz_id'],
					'quiz_responses_time' => $users['quiz_responses_time']
				);
				$i++;
			}
			
			$response["recordsFiltered"] = count($responseArr);
			$response["recordsTotal"] =  count($responseArr);
			//response["draw"] = draw;
			$response["success"] = 1;
			$response["data"] = $responseArr;
			
		  } catch (Exception $e) {    
  
		  }
		
  
		return response($response);
	}
        
        
		public function viewQuizDetailsByUser(Request $request){
			$quiz_id = $request->quiz_id;
			$user_id = $request->user_id;
			
			$quiz = Quiz::find($quiz_id);
			$userResponse = DB::table('quiz_responses as r')
								->where([
											['r.quiz_id',$quiz_id],
											['r.user_id',$user_id]
										])
								->leftJoin('quiz_questions as q','q.id','r.quiz_question_id')
								->leftJoin('quiz_question_options as o','o.id','r.quiz_question_option_id')
								->select('q.question','o.options','o.correct_answer')
								->get();
			
			$html = '<p><b>Quiz</b>: '.$quiz->quiz_name.'</p>';
			$html .='<table class="table-responsive table table-striped table-bordered">';
			$html .='<thead><th>Q.No.</th><th>Questions</th><th>Options Attained</th><th>Marks Obtained</th></thead>';
			$html .='<tbody>';
			$i=1;
			$marks_per_ques = Config::get('app.marks_per_question');
			foreach($userResponse as $response){
				$html .='<tr>';
				$html .='<td>'.$i.'</td>';
				$html .='<td>'.$response->question.'</td>';
				$html .='<td>'.$response->options.'</td>';
				$html .='<td>'.($response->correct_answer*$marks_per_ques).'</td>';
				$html .='</tr>';
				$i++;
			}
			$html .='</tbody></table>';
			echo $html;
		}
	}
?>