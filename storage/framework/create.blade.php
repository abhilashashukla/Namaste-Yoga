@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/errors')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Event</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/events/add') }}" method="POST"  enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Event Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Event Name" type="text" name="event_name" value="{{ old('event_name') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Get Location</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" id="address-input" placeholder="Get Location" type="text" name="address" value="{{ old('address') }}"/>						  
							<input type="hidden" name="lat" id="address-latitude" value="0" />
							<input type="hidden" name="lng" id="address-longitude" value="0" />
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
						<!--<div id="address-map-container" style="width:100%;height:400px; ">
							<div style="width: 100%; height: 100%" id="address-map"></div>
						</div>-->
                      </div>					  
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Get Location" type="text" id="cities" name="city_id" value="{{ old('city_id') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Contact Name" type="text" name="contact_person" value="{{ old('contact_person') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Phone Number" type="text" name="contact_no" value="{{ old('contact_no') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Id</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Email Id" type="text" name="email" value="{{ old('email') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Start Date" type="text" name="start_time" value="{{ old('start_time') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="End Date" type="text" name="end_time" value="{{ old('end_time') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                      
                   
                      <!--<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="is_blocked">
                            <option value="0">--Status--</option>
                            <option value="1">Active</option>
                            <option value="0">De-active</option>
                          </select>
                        </div>
                      </div>-->         

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/aasana/listcategory'">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success submitCategory">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>
<script>
$('body').on('click','.submitCategory',function(){

let category_name = $("input[name=category_name]").val();
if(category_name==''){
  $("input[name=category_name]").css('border','red 1px solid').attr('placeholder','Please enter category name');
  return false;
}

let category_description = $("textarea[name=category_description]").val();
  if(category_description==''){      
  $("textarea[name=category_description]").css('border','red 1px solid').attr('placeholder','Please enter category description');
  return false;
}
let category_image = $("input[name=category_image]").val();
  if(category_image==''){      
  $("input[name=category_image]").css('border','red 1px solid').attr('placeholder','Please select category Image');
  return false;
}

});

$("input[name=category_name]").focus(function(){
$(this).css('border','#ccc 1px solid');
});
$("textarea[name=category_description]").focus(function(){
$(this).css('border','#ccc 1px solid');
});
$("input[name=category_image]").focus(function(){
$(this).css('border','#ccc 1px solid');
}); 
</script>


<script>
				$('input[name="category_image"]').change(function(e) {

	
          var fileName = e.target.files[0].name;
					extension = fileName.split('.').pop();
					var validExtensions = ['jpg', 'jpeg', 'png'];
					if (fileName != '') {
						//$('#app_portfolio').hide();
					}

					if ($.inArray(extension, validExtensions) == -1) {

						$("#category_image").html("Please make sure your file is in jpg, jpeg or png format.");
						$('input[name=category_image]').val('');
						$('#category_image').show();
						return false;
					} else {
						$('#category_image').hide();
					}

          var _URL = window.URL || window.webkitURL;
          var file, img;
        if ((file = this.files[0])) {
        img = new Image();
        var objectUrl = _URL.createObjectURL(file);
        img.onload = function () {           
            var fileSize = this.size;
          var filewidth  = this.width;
          var fileheight  = this.height;
		  //alert(filewidth);
		  //alert(filewidth);
		  
          if (filewidth > 1500 && fileheight > 1500) {
             //alert(filewidth);
						$("#category_image").html("File too Large, please select a file less than 1500*1500 px");
						$('#category_image').show();
						$('input[name=category_image]').val('');
						return false;
					} else {
						$('#category_image').hide();
					}


            _URL.revokeObjectURL(objectUrl);
        };
        img.src = objectUrl;
        }
				
				
         
					// extension = fileName.split('.').pop();
					// var validExtensions = ['jpg', 'jpeg', 'png'];
					// if (fileName != '') {
					// 	//$('#app_portfolio').hide();
					// }

					// if ($.inArray(extension, validExtensions) == -1) {

					// 	$("#category_image").html("Please make sure your file is in jpg, jpeg or png format.");
					// 	$('input[name=category_image]').val('');
					// 	$('#category_image').show();
					// 	return false;
					// } else {
					// 	$('#category_image').hide();
					// }

				
				});
			</script>
<script>
/*    function Validate(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorCategoryName = document.getElementById("lblErrorCategoryName");
        lblErrorCategoryName.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorCategoryName.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    }
	    function ValidateDesc(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorDescription = document.getElementById("lblErrorDescription");
        lblErrorDescription.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorDescription.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    } */ 
</script>
<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$( "#cities" ).autocomplete({
    source: "cities",
    minLength: 1,
    select:function(event,ui) { 
        location.href = ui.item.link;
    }
});
</script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
	<script src="{{ url('/') }}/js/mapInput.js"></script>     
	
@endsection
