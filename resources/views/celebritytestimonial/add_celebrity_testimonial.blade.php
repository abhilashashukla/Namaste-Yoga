@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/errors')
  
    <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Celebrity Testimonial</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left disableonsubmit" action="{{ url('/celebrity/savecelebrity') }}" method="POST">
                      {{ csrf_field() }}  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Celebrity Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control" type="text" id="celebrity_name" name="name" placeholder="Celebrity Name" value="{{ old('name') }}"/>
                        <span id="organization_name_error" style="color:red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Path </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control" type="text" id="video_id" name="video_id" placeholder="Video Path" value="{{ old('video_id') }}"/>
                        <span id="social_media_facebook" style="color:red"></span>
                        </div>
                      </div>        
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/celebrity/listscelebrity'">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success submitCelebrityTestimonial">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>

<script>
    $(document).ready(function () {
    $('body').on('click','.submitCelebrityTestimonial',function()
    { 

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
    
    $("input[name=name]").focus(function()
    {
      $(this).css('border','#ccc 1px solid');
    });
	$("input[name=video_id]").focus(function()
    {
      $(this).css('border','#ccc 1px solid');
    });
  
     });
</script>
@endsection




