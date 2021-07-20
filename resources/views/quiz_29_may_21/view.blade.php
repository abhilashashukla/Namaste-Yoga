@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/flash')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Quiz</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left"  method="POST">
                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Quiz Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text"  value="{{$quiz->quiz_name}}" readonly>
                        </div>
                      </div>
					  <!--
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Quiz Time (In Seconds)</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text"  value="{{$quiz->quiz_time}}" readonly>
                        </div>
                      </div> -->
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Valid For (In Days)</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text"  value="{{$quiz->valid_for}}" readonly>
                        </div>
                      </div>
					  @if($questionData)
					  @foreach($questionData as $k=>$question)
					  <div class="dynamicFields">
					  <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12 qlabel">Question {{$k+1}}</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" value="{{$question['question']}}" readonly class="form-control">
							</div>
						  </div>
						  @foreach($question['options'] as $okey=>$option)
						  <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="row">
									<div class="col-md-1 col-sm-1 col-xs-12">	
									@if($option->correct_answer==1)
										<input class="form-check-input" type="radio" checked title="Correct Answer">
									@endif									  
									</div>
									<div class="col-md-11 col-sm-11 col-xs-12">
									  <input type="text" class="form-control" value="{{$option->options}}" readonly>
									</div>
								</div>
							</div>
						  </div>
						 @endforeach
					</div>
					@endforeach
					@endif
					
                      <div class="ln_solid"></div>
                      <div class="form-group" style="text-align: center;">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/quiz'">Back</button>
                    
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>


@endsection