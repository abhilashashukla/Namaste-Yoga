@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
@include('layout/errors')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Celebrity Testimonial</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/celebrity/updatecelebrity/{{$editcelebritytestimonial->id}}" method="POST">
                      {{ csrf_field() }}

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celebrity Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" id="celebrity_name" name="name" value="{{$editcelebritytestimonial->name}}" placeholder="Celebrity Name">                        
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Path</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" type="text" placeholder="Video Path" id="video_id" name="video_id" value="{{$editcelebritytestimonial->video_id}}">                          
                        </div>
                         </div>                                                    
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/celebrity/listscelebrity'">Cancel</button>                    
                          <button type="submit" class="btn btn-success submitCelebrityTestimonial">Update</button>
                        </div>
                      </div>				
                    </form>
                  </div>
                </div>
              </div>
</div>

<script>
$('body').on('click','.submitCelebrityTestimonial',function(){

		let name = $("input[name=name]").val();
		if(name==''){
			$("input[name=name]").css('border','red 1px solid').attr('placeholder','Please enter celebrity name');
			return false;
		}
		let video_id = $("input[name=video_id]").val();
		if(video_id==''){
			$("input[name=video_id]").css('border','red 1px solid').attr('placeholder','Please enter video path');
			return false;
		}
  });
	
  
	$("input[name=name]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
	 $("input[name=video_id]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
</script>
@endsection

