@extends('layout.app')
<style>
.column{
	margin-top:10px;
	padding:0 10px;
	float:left;
}
.success-event{
	color:#28a745;
    display: block;
    text-align: center;
    font-size: 1.3em;
	
}
.errors-event{
	color:#dc3545;    
    font-size: 1.3em;
	
}
.bootstrap-datetimepicker-widget{
	width:320px!important;

}
.bootstrap-datetimepicker-widget table th,
.bootstrap-datetimepicker-widget table td{
font-size:12px}
.right_col{
min-height:auto!important;
}
</style>
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
                    <form class="form-horizontal form-label-left disableonsubmit"  action="{{ url('/events/add') }}" onload="initialize();"  id="add_event" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Event Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Event Name" type="text" name="event_name" value="{{ old('event_name') }}" autocomplete="off"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Address" type="text" name="address" value="{{ old('address') }}" autocomplete="off"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Get Location</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control map-input" readonly id="address_input" placeholder="Get Location" type="text" name="lat_lng" value="{{ old('lat_lng') }}"/>							 
                        </div>						
                      </div>
						<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Nearest City</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<div class="clearfix">
						  <div class="column">
							<input type="radio" name="nearest" value="0" {{(old('nearest') == '0') ? 'checked' : ''}}>
							<label for="currentrow-in">Current City</label>
						  </div>
						  <div class="column">
							<input type="radio" name="nearest" value="1" {{(old('nearest') == '1') ? 'checked' : ''}}>						  
							<label for="nearby">Nearby City</label>	 
						  </div>
						</div>
						 								  
						  <span id="nearest_error" style="color:#dc3545"></span>					  
						</div>
											
                      </div>					  
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control cities_id" placeholder="Get City" type="text" id="cities" name="city_id"/>
						   <input type="hidden" id="cities_id_hide" name="cities_id_hide"/>
						    <input type="hidden" id="city_lat" name="city_lat"/>
							 <input type="hidden" id="city_lng" name="city_lng"/>
						</div>					
                      </div>
					 
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Contact Name" value="{{ old('contact_person') }}" type="text" id="contact_person" name="contact_person"  autocomplete="off"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Phone Number" maxlength="10" type="text" id="contact_no" name="contact_no" value="{{ old('contact_no') }}" autocomplete="off"/>
						  <span id="contact" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Id</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Email Id" type="text" id="email" name="email" value="{{ old('email') }}" autocomplete="off" />
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Joining Instruction</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Joining Instruction" type="text" name="joining_instruction" value="{{ old('joining_instruction') }}" autocomplete="off"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
    				  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Highlight</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<div class="clearfix">
						  <div class="column">
							<input type="radio" name="isHighlight" value="1" {{(old('isHighlight') == '1') ? 'checked' : ''}}>
							<label for="yes">Yes</label>
						  </div>
						  <div class="column">
							<input type="radio" name="isHighlight" value="0" {{(old('isHighlight') == '0') ? 'checked' : ''}}>						  
							<label for="no">No</label>	 
						  </div>
						</div>						 								  
						  <span id="isHighlight_error_check" style="color:#dc3545"></span>
						</div>									
                      </div>	
					  
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Short Description" type="text" name="short_description" value="{{ old('short_description') }}" autocomplete="off"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mode</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<div class="clearfix">
						  <div class="column">
							<input type="radio" name="mode" value="FREE" @if(old('mode') == 'FREE') checked @endif>
							<label for="Free">FREE</label>
						  </div>
						  <div class="column">
							<input type="radio" name="mode" value="PAID" @if(old('mode') == 'PAID') checked @endif>						  
							<label for="Paid">PAID</label>	 
						  </div>
						</div>						 								  
						  <span id="mode_error_check" style="color:#dc3545"></span>
						</div>
						</div>
						 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Seating Capacity</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Seating Capacity" id="sitting_capacity" type="number" name="sitting_capacity" value="{{ old('sitting_capacity') }}" min="10" max="99999" autocomplete="off"/>
						  <span id="sitting" style="color: red"></span>
						   <span id="sitting_for_range" style="color: red"></span>
						  
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meeting link</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Meeting link" id="meeting_link" type="text" onchange="return validUrl();" name="meeting_link" value="{{ old('meeting_link') }}" autocomplete="off"/>	
							<span id="meeting_link_error" style="color:red"></span>						  
                        </div>
						
                      </div>                     
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Start Date" id="start_time" value="{{ old('start_time') }}" type="text" name="start_time" autocomplete="off"/>						   
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="End Date" type="text" id="end_time" name="end_time" value="{{ old('end_time') }}"autocomplete="off"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>       

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/events'">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" id="submit_event" class="btn btn-success submitEvents">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
             
			</div>
		</div>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
 <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }
  </style>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">    

   	<script src="{{ url('/') }}/js/mapInput.js"></script>  
	    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer>
	</script>
	<script src="{{ url('/') }}/js/eventjs/jquery-ui.js"></script> 
	<script src="{{ url('/') }}/js/eventjs/moment.min.js"></script> 
	<script src="{{ url('/') }}/js/eventjs/bootstrap-datetimepicker.min.js"></script> 	
	<!--<script src="{{ url('/') }}/js/eventjs/bootstrap.min.js"></script>-->
	<script src="{{ url('/') }}/js/sha256.js"></script>
	<script src="{{ url('/') }}/js/crypto-js.js"></script>
    <script type="text/javascript">
	
/* 		$("#start_time").datetimepicker({
        //numberOfMonths: 2,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#end_time").datetimepicker("option", "minDate", dt);
        }
    });
    $("#end_time").datetimepicker({
        //numberOfMonths: 2,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#start_time").datetimepicker("option", "maxDate", dt);
        }
    }); */
	
	$(document).ready(function(){
		
		//$($("input[name=lat_lng]")).val('');
        $(function() {
			
			
            $('#start_time').datetimepicker({
				//defaultDate: null,				
				 format: 'YYYY-MM-DD HH:mm:ss',				  
				  //minDate:new Date(),
				 widgetPositioning: {
					horizontal: "auto",
					vertical: "top"
				  },
				  //debug:true,

				  
			});
			//$('#start_time').val('');
			$('#end_time').datetimepicker({	
				 //defaultDate: null,			
				 format: 'YYYY-MM-DD HH:mm:ss',				  
				  //minDate:new Date(), 
				   widgetPositioning: {
					horizontal: "auto",
					vertical: "top"
				  },
				  //debug:true,
				  
				  
			});
			//$('#end_time').val('');
			 
        }); 
    
      $( "#cities" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({           
			url: '/events/cities',
            type: "POST",
		    dataType:'json',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
         data: {
                search: request.term
              },          
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#cities').val(ui.item.label);
		   $('#cities_id_hide').val(ui.item.value); 
		   $('#city_lat').val(ui.item.lat); 
		   $('#city_lng').val(ui.item.lng); 
           return false;
        }
      });

	


$(".submitEvents").click(function () {
    let event_name = $("input[name=event_name]").val();
	let address = $("input[name=address]").val();
	let lat_lng = $("input[name=lat_lng]").val();
	let city_id = $("input[name=city_id]").val();
	let contact_persons = $("input[name=contact_person]").val();
	let contact_nos = $("input[name=contact_no]").val();
	let emails = $("input[name=email]").val();
	let joining_instruction = $("input[name=joining_instruction]").val();
	let short_description = $("input[name=short_description]").val();
	let mode = $("input[name=mode]").val();
	let sitting_capacity = $("input[name=sitting_capacity]").val();
	let start_time = $("input[name=start_time]").val();
	let end_time = $("input[name=end_time]").val();
	let regex = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	let nearest=$('input[name="nearest"]:checked').length;
	let isHighlight=$('input[name="isHighlight"]:checked').length;
	let modes=$('input[name="mode"]:checked').length;
	let meeting_links = $("input[name=meeting_link]").val();
	
	
	
	if (event_name==null || event_name=="")
    {
		$("input[name=event_name]").css('border','red 1px solid').attr('placeholder','Please enter Event name').focus();
		return false;  
	}
	else
	{
		$("input[name=event_name]").css('border','#ccc 1px solid');
	}
	if (address==null || address=="")
    {
		$("input[name=address]").css('border','red 1px solid').attr('placeholder','Please enter address').focus();
		return false;  
	}
	else
	{
		$("input[name=address]").css('border','#ccc 1px solid');
	}
	
	if (lat_lng==null || lat_lng=="")
    {
		$("input[name=lat_lng]").css('border','red 1px solid').attr('placeholder','Please drag lattitude and longitude');
	  return false; 
	}
	else
	{
		$("input[name=lat_lng]").css('border','#ccc 1px solid');
	}
	
	if (nearest==null || nearest=="")
    {
		$("#nearest_error").text('Select nearest city');
         return false;  
	}
	else
	{
		$("#nearest_error").hide();
	}	
	if (city_id==null || city_id=="")
    {
		$("input[name=city_id]").css('border','red 1px solid').attr('placeholder','Please enter city name');
			return false; 
	}
	else
	{
		$("input[name=city_id]").css('border','#ccc 1px solid');
	}
	
	if (contact_persons==null || contact_persons=="")
    {
		$("input[name=contact_person]").css('border','red 1px solid').attr('placeholder','Please enter contact person');
			return false; 
	}
	else
	{
		$("input[name=contact_person]").css('border','#ccc 1px solid');
	}
	if (contact_nos==null || contact_nos=="")
    {
		$("input[name=contact_no]").css('border','red 1px solid').attr('placeholder','Please enter contact number');
			return false; 
	}
	else if (contact_nos.length < 10)
	{
	$("input[name=contact_no]").css('border','red 1px solid').attr('placeholder','contact number length must be 10');
	return false; 
	}
	else if(contact_nos.charAt(0)!=9 && contact_nos.charAt(0)!=8 && contact_nos.charAt(0)!=7 && contact_nos.charAt(0)!=6)
	{
		$("input[name=contact_no]").css('border','red 1px solid').attr('placeholder','Please enter valid contact number');
		return false;
	}
	else
	{
		$("input[name=contact_no]").css('border','#ccc 1px solid');
	}
	if (emails==null || emails=="")
    {
		$("input[name=email]").css('border','red 1px solid').attr('placeholder','Please enter email id');
			return false; 
	}
	else if(!regex.test(emails))
	{
		$("input[name=email]").css('border','red 1px solid').attr('placeholder','Please enter correct email id');
			return false; 
	}
	else
	{
		$("input[name=email]").css('border','#ccc 1px solid');
	}
	if (joining_instruction==null || joining_instruction=="")
    {
		$("input[name=joining_instruction]").css('border','red 1px solid').attr('placeholder','Please enter joining instruction');
			return false; 
	}
	else
	{
		$("input[name=joining_instruction]").css('border','#ccc 1px solid');
	}
	if (isHighlight==null || isHighlight=="")
    {
		$("#isHighlight_error_check").text('Select is Highlight');
         return false;  
	}
	else
	{
		
		$("#isHighlight_error_check").hide();
	}
	if (short_description==null || short_description=="")
    {
		$("input[name=short_description]").css('border','red 1px solid').attr('placeholder','Please enter short description');
			return false; 
	}
	else
	{
		$("input[name=short_description]").css('border','#ccc 1px solid');
	}
	if (modes==null || modes=="")
    {
		$("#mode_error_check").text('Select is mode');
         return false;  
	}
	else
	{
		$("#mode_error_check").hide();
	}
	if (sitting_capacity==null || sitting_capacity=="")
    {
		$("input[name=sitting_capacity]").css('border','red 1px solid').attr('placeholder','Please enter sitting capacity');
			return false; 
	}
	else
	{
		$("input[name=sitting_capacity]").css('border','#ccc 1px solid');
	}
/* 	if (meeting_links==null || meeting_links=="")
    {
		$("input[name=meeting_links]").css('border','red 1px solid').attr('placeholder','Please enter meeting link');
			return false; 
	}
	else
	{
		$("input[name=meeting_links]").css('border','#ccc 1px solid');
	} */
	
	if (start_time==null || start_time=="")
    {
		$("input[name=start_time]").css('border','red 1px solid').attr('placeholder','Please enter start time');
			return false; 
	}
	else
	{
		$("input[name=start_time]").css('border','#ccc 1px solid');
	}
	if (end_time==null || end_time=="")
    {
		$("input[name=end_time]").css('border','red 1px solid').attr('placeholder','Please enter end time');
			return false; 
	}
	else
	{
		$("input[name=end_time]").css('border','#ccc 1px solid');
	} 
	//var CSRF_TOKEN=jQuery('meta[name="csrf-token"]').attr('content');
	//Fetch form to apply custom Bootstrap validation
	/* $('#event_name_error').text('');
	$('#address_error').text('');
	$('#near_error').text('');	
	$('#lat_lng_error').text('');
	$('#cities_id_hide_error').text('');
	$('#contact_person_error').text('');
	$('#contact_no_error').text('');
	$('#email_error').text('');
	$('#joining_instruction_error').text('');
	$('#isHighlight_error').text('');
	$('#short_description_error').text('');
	$('#mode').text('');
	$('#sitting_capacity').text('');
	$('#start_time_error').text('');
	$('#end_time_error').text('');
	var eventform = $("#add_event")[0]
	var formData = new FormData(eventform);
	var contact_person =$('#contact_person').val();
	var lower_email = $('#email').val().toLowerCase();
	var email = lower_email;
	var contact_no = $('#contact_no').val();
	
	formData.append('contact_person', contact_person);
	formData.append('email', email);
	formData.append('contact_no',contact_no);
	//formData.append('CSRF_TOKEN', CSRF_TOKEN);

		$.ajax({
			url: '/events/add',
			type: 'POST',			
			data: formData,
			processData: false,
			contentType: false, 
			dataType:'json',            			
			success: function (response)
			{						
				if(response.status=='false')
				{
				  $('#event_name_error').text(response.errors.event_name);
				  $('#address_error').text(response.errors.address);
				  $('#lat_lng_error').text(response.errors.lat_lng);
				  $('#near_error').text(response.errors.nearest);
				  $('#cities_id_hide_error').text(response.errors.cities_id_hide);
				  $('#contact_person_error').text(response.errors.contact_person);
				  $('#contact_no_error').text(response.errors.contact_no);
				  $('#email_error').text(response.errors.email);
				  $('#joining_instruction_error').text(response.errors.joining_instruction);
				  $('#isHighlight_error').text(response.errors.isHighlight);
				  $('#short_description_error').text(response.errors.short_description);
				  $('#mode_error').text(response.errors.mode);
				  $('#sitting_capacity_error').text(response.errors.sitting_capacity);
				  $('#start_time_error').text(response.errors.start_time);
				  $('#end_time_error').text(response.errors.end_time); 				  
					     	setTimeout(function(){ 
							$('.errors-event').hide();							
						},5000);
				
				}
				else
				{
					 
					  
					 
					  $("#add_event")[0].reset();
					     	
							$('.success-event').hide();	
							localStorage.setItem("msg",response.success);	
							window.location.href = "/events";
													
                           //$('#success_message').html(response.success);							
						
						
					
				}
			}
			
			

			
		}); */

	
		var IV = '{{config("app.admin_enc_iv")}}';
  function encrypt(str) {
							var KEY = jQuery('meta[name="csrf-token"]').attr('content');
							KEY = KEY.substring(0, 16);
							key = CryptoJS.enc.Utf8.parse(KEY);// Secret key
							var iv = CryptoJS.enc.Utf8.parse(IV);//Vector iv
							var encrypted = CryptoJS.AES.encrypt(str, key, {iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7});
							return encrypted.toString();
                        }

});

$('#address_input').on('click', function () {
  $('#map_modal').modal('show');
 })
$("#contact_no").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#contact").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   })
   $("#sitting_capacity").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#sitting").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   }) 

});	

 $(function () {
       $( "#sitting_capacity" ).change(function() {
          var max = parseInt($(this).attr('max'));
          var min = parseInt($(this).attr('min'));
          if ($(this).val() > max)
          {
              $(this).val(max);
			   $("#sitting_for_range").html("Please enter a value less than 99999").show().fadeOut("slow");
               return false;
			  
          }
          else if ($(this).val() < min)
          {
              $(this).val(min);
			   $("#sitting_for_range").html("Please enter a value greater than or equal to 10").show().fadeOut("slow");
               return false;
          }       
        }); 
    });
	
    function validUrl()
	{
		 var otherurl = $("#meeting_link").val();
	  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
		'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
		'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
		'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
		'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
		'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
	  if(!otherurl.match(pattern))
	  {
		$("#meeting_link").val('');
	   $("#meeting_link_error").html("Please enter correct link.").show();        
		return false;
	  }
	  else
	  {
		  //alert('else');
		  $("#meeting_link_error").hide();
	  }
}


</script>  
              <div class="modal fade" id="map_modal" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Map</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="address_address">Address</label>
							</div>
							
							<div class="col-md-9 col-sm-9 col-xs-12" style="width:100%;">
							<div id="map_canvas" style="width: auto; height: 300px;">
							<input type="hidden" id="current_lat" name="current_lat" value="28.644800"/>
							 <input type="hidden" id="current_lng" name="current_lng" value="77.216721"/>
							</div>
                           
							</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
			</div>
			

@endsection