@extends('layout.app')

@section('content')
<div class="right_col" role="main">
  @include('layout/errors')
  
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add Moderator</h2>

                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left" id="moderatorForm" action="{{ url('/') }}/users/add" method="POST" autocomplete="off">
              {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Moderator Type</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" name="moderator_id" id="moderator_id">
                    <option value="">--Select--</option>
                     @foreach($moderators as $moderator)
                    <option value="{{ $moderator->id}}" {{old ('moderator_id') == $moderator->id ? 'selected' : ''}}>{{ $moderator->moderator}}</option>
                    @endforeach
				   </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input class="form-control" placeholder="Name" type="text" name="name" id="name" maxlength="150" value="{{ old('name') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <input class="form-control" placeholder="Phone" type="text" name="phone" id="phone" maxlength="10" value="{{ old('phone') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input class="form-control" placeholder="Email" type="text" name="email" id="email" maxlength="150" value="{{ old('email') }}">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                   <input class="form-control" placeholder="Password" type="password" name="password" id="password" maxlength="75" value="{{ old('password') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Organization Name</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input class="form-control" placeholder="Organization Name" type="text" name="organization_name" id="organization_name" maxlength="250" value="{{ old('organization_name') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Designation </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <input class="form-control" placeholder="Designation" type="text" name="designation" id="designation" maxlength="100" value="{{ old('designation') }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <select class="form-control" name="is_blocked" id="is_blocked">
                    <option value="">--Status--</option>
                    <option value="1" {{(old('is_blocked') == '1') ? 'selected' : ''}}>Active</option>
                    <option value="0" {{(old('is_blocked') == '0') ? 'selected' : ''}}>De-active</option>
                  </select>
                </div>
              </div>



              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                  <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/users'">Cancel</button>
                  <button type="reset" class="btn btn-primary">Reset</button>
                  <button type="submit" class="btn btn-success validateModerator">Submit</button>
                </div>
              </div>

            </form>
            </div>
        </div>
    </div>
  
</div>
<script>
    $(document).ready(function(){
	/* 	$('#password').on('click', function () {
	   $(this).attr('type', 'password'); 
	}); */
	setTimeout(
			function() { $('#password').val('');
			$('#email').val('');			},
			1000  //1,000 milliseconds = 1 second
		);
         setTimeout(function(){
            $('.alert-error').remove();
            $('.alert-success').remove();
        }, 5000); 
    });
</script>

@endsection
