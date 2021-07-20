

     @if(session('success'))
        <div class="alert alert-success" style="margin-top:15px;">
          {{ session('success') }}
        </div> 
        @endif
       @if(session()->has('message.level'))
      <div class="alert alert-{{ session('message.level') }}" style="margin-top:15px;">
      {!! session('message.content') !!}
      </div>
      @endif
        @if($errors->any())
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ implode(' ', $errors->all(':message')) }}
       </div>
      @endif
	  
	   @if(session('errors_images'))
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ session('errors_images') }}
       </div>
      @endif
	 @if(session('start_date'))
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ session('start_date') }}
       </div>
      @endif
	   @if(session('end_date'))
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ session('end_date') }}
       </div>
      @endif
	  






