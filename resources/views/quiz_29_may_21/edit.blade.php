@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/flash')
  <div class="col-md-12 col-xs-12">
   @if($errors->any())
    <span class="alert alert-danger">{{ implode('', $errors->all(' :message')) }}</span>
@endif
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Quiz</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/quiz/update/{{$quiz->id}}" method="POST">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Quiz Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" value="{{$quiz->quiz_name}}" name="quiz_name">
                        </div>
                      </div>
					  <!--
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Quiz Time (In Seconds) <span class="red">*</span></label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <input class="form-control" type="text" name="quiz_time" value="{{$quiz->quiz_time}}">
                        </div>
                      </div> -->
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Valid For (In Days) <span class="red">*</span></label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <input class="form-control" type="text" name="valid_for" value="{{$quiz->valid_for}}">
                        </div>
                      </div>
					  @if($questionData)
					  @foreach($questionData as $k=>$question)
					  <div class="dynamicFields">
					   <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12 qlabel">Question {{$k+1}}</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							  <input type="text" name="questions[{{$k}}]" id="question_{{$k}}" class="form-control questions" value="{{$question['question']}}">
							</div>
							<label class="col-md-1 col-sm-1 col-xs-12"><button type="button" id="" class="btn btn-danger deleteQuizRow"><i class="fa fa-trash" aria-hidden="true"></i></button></label>
						  </div>
					@foreach($question['options'] as $okey=>$option)
					  <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-12">							
									  <input class="form-check-input answer_{{$k}}" type="radio" name="answer[{{$k}}]" value="{{$okey}}" title="Choose Correct Answer" @if($option->correct_answer==1) checked="1" @endif>								
									</div>
									<div class="col-md-11 col-sm-11 col-xs-12">
									  <input type="text" name="options[{{$k}}][]" class="form-control options_{{$k}}" value="{{$option->options}}">
									</div>
								</div>
							</div>
						  </div>
					  @endforeach
					</div>
					@endforeach
					@else
					 <div class="dynamicFields"></div>
					@endif
					
					@if(count($questionData)<5)
					<div class="form-group">
						<a href="javascript:void(0)" id="addMoreRows" class="btn btn-primary pull-right">Add More</a>
                      </div>
					  @endif
					 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/quiz'">Cancel</button>
                    
                          <button type="submit" class="btn btn-success submitQuestions" disabled>Update</button>
                        </div>
                      </div>
					<input type="hidden" id="lastKey" value="{{count($questionData)}}">
					<input type="hidden" id="qCount" value="{{count($questionData)}}">
                    </form>
                  </div>
                </div>
              </div>
</div>

@endsection