@extends('layout.app')

@section('content')

<style>
.button-center-align
{	
	display: table;
    margin: auto;
}
</style>

<div class="right_col clearfix" role="main">
  @include('layout/flash')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Feedback</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left"  method="POST">
                     @if($feeback_view)
					  @foreach($feeback_view as $k=>$question)						
					  <div class="dynamicFields">
						  <div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Question {{$k+1}}</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" name="questions" class="form-control" value="{{$question->question}}" readonly>
							</div>
						  </div>
						   <div class="form-group">
						 
						 
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Answer</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="row">
								
									<div class="col-md-6 col-sm-6 col-xs-12">
									  <input type="text" name="options" class="form-control margin-bottom" value="{{$question->options}}" readonly>
									</div>
								
								</div>
							</div>
						
						  </div>
	                  
						  
					</div>
					@endforeach
					@endif
					
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <button type="button" class="btn btn-primary button-center-align" onclick="location.href='{{ url('/') }}/feedback/listsfeedback'">Back</button>
                    
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>


@endsection