@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
    @include('layout/flash')
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
		 @if ($errors->has('captcha'))
         <div class="alert alert-danger" style="margin-top:15px;">
          <strong>{{ $errors->first('captcha') }}</strong>
           </div>
            @endif
            <div class="x_title">
                <h2>Send General Notification</h2>
              <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div id="message"><?php //echo $message;?></div>

                <form action="" method="POST" class="form-horizontal form-label-left">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Notification Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="notification_name" id="notification_name" class="form-control" placeholder="Notification Name" maxlength="100" value="{{ old('notification_name') }}">
                        </div>
                    </div>

                    <div class="dynamicFields">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Notification Message</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <textarea name="notification_message" id="notification_message" class="form-control" rows="3" cols="250" placeholder="Notification Message..." >{{ old('notification_message') }}</textarea>
                            </div>
                        </div>
                    </div>
					  <div class="form-group">
                            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Captcha</label>

                            <div class="col-md-9 col-sm-9 col-xs-12 captcha">
                                <span>{!! captcha_img('flat') !!}</span>
                                <button type="button" class="btn btn-success btn-refresh">Refresh</button>
                            </div>
							<label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Enter Captcha</label>
							 <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="captcha" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}" placeholder="Enter Captcha" name ="captcha">
							</div>                  
                        </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ url('generalnotifications') }}'">Cancel</button>
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <button type="submit" class="btn btn-success sendNotification">Send Notification</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    <?php
/*         if($status == 1) {
            $class = 'alert alert-success';
        } else if($status === 0) {
            $class = 'alert alert-error';
        } else {
            $class = '';
        } */
    ?>
    
    

		

   

	$(".btn-refresh").click(function() {
    $.ajax({
        type: 'GET',
        url: '/refresh_captcha',
		headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
        success: function(data) {
            $(".captcha span").html(data);
        }
    })
})
 });
</script>

@endsection