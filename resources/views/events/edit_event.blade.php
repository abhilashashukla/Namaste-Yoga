@extends('layout.app')

@section('content')
<?php
$readonly='';
$iseditable = '';
$lat_and_lng_diable='readonly="readonly"';

if(date('Y-m-d H:i:s') > $editevent->start_time){
	$readonly='readonly="readonly"';
    
	$lat_and_lng_diable='disabled="disabled"';
    
	$iseditable = false;
	//echo'11';exit;
	
}
else if(date('Y-m-d H:i:s') <= $editevent->start_time)
{
	$readonly = '';
    
	//$lat_and_lng_diable='readonly="readonly"';
    
    $iseditable = true;
    //echo'22';exit;
}

//echo (date('Y-m-d H:i:s')).'<br>'.($editevent->start_time).'<br>'.($editevent->end_time);


?>
<div class="right_col clearfix" role="main">
@include('layout/errors')
<div class="col-md-12 col-sm-12 col-xs-12">  
<span class="image_success_msg text-center"></span> 
<span class="image_unsuccess_msg text-center"></span>
</div>
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Events</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
					
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/events/update/{{$editevent->id}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
					  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Event Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="event_name" value="{{$editevent->event_name}}" <?php echo $readonly;?>>
						   <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">						 
                          <input class="form-control" rows="3" name="address" value="{{$editevent->address}}" <?php echo $readonly;?>>
						 <span id="lblErrorDescription" style="color: red"></span>
                        </div>
                      </div>
						<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Get Location</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" id="address_input" placeholder="Get Location" type="text" value="{{ $editevent->lat.','.$editevent->lng }}" autocomplete="off" <?php echo $lat_and_lng_diable;?> / >
						 <input id="lat_lng" type="hidden" name="lat_lng" value="{{ $editevent->lat.','.$editevent->lng }}"/ >
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Nearest City</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<div class="clearfix">
						  <div class="column">
							<input type="radio" name="nearest" value="0" {{ ($editevent->nearest=="0")? "checked" : "" }} >							
							<label for="currentrow-in">Current City</label>
						  </div>
						  <div class="column">
							<input type="radio" name="nearest" value="1" {{ ($editevent->nearest=="1")? "checked" : "" }} >								
							<label for="nearby">Nearby City</label>	 
						  </div>
						</div>						 								  
						  <span id="nearest_error" style="color:red"></span>					  
						</div>											
                      </div>
					    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select City</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control cities_id" placeholder="Get City" type="text" id="cities" name="city_id" value="{{ $city->name . ' , '.$state->name . ' , '.$country->name}}" <?php echo $readonly;?>/>
						   <input type="hidden" id="cities_id_hide" name="cities_id_hide" value="{{ $city->id }}"/>
						    <input type="hidden" id="city_lat" name="city_lat" value="{{ $editevent->city_lat}}"/>
							 <input type="hidden" id="city_lng" name="city_lng" value="{{ $editevent->city_lng}}"/>
						</div>					
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Contact Name" type="text" name="contact_person" value="{{$contact_person }}" autocomplete="off" <?php echo $readonly;?>/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone Number</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Phone Number" maxlength="10" id="contact_no" type="text" name="contact_no" value="{{ $contact_no }}" autocomplete="off" <?php echo $readonly;?>/>
						   <span id="contact" style="color: red"></span>
                        </div>
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email Id</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Email Id" type="text" name="email" value="{{ $email }}" autocomplete="off" <?php echo $readonly;?> />
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Joining Instruction</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Joining Instruction" type="text" name="joining_instruction" value="{{ $editevent->joining_instruction }}" autocomplete="off" <?php echo $readonly;?>/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Highlight</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<div class="clearfix">
						  <div class="column">
							<input type="radio" name="isHighlight" value="1" {{ ($editevent->isHighlight=="1")? "checked" : "" }} >
							
							
							<label for="yes">Yes</label>
						  </div>
						  <div class="column">
							<input type="radio" name="isHighlight" value="0" {{ ($editevent->isHighlight=="0")? "checked" : "" }}>
													
							<label for="no">No</label>	 
						  </div>
						</div>
						 								  
						  <span id="isHighlight_error" style="color:red"></span>
						</div>
											
                      </div>
					   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Short Description" type="text" name="short_description" value="{{ $editevent->short_description }}" autocomplete="off" <?php echo $readonly;?>/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					
					  	<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Mode</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<div class="clearfix">
						  <div class="column">
							<input type="radio" name="mode" value="FREE" {{ ($editevent->mode=="FREE")? "checked" : "" }} >
							<label for="free">FREE</label>
						  </div>
						  <div class="column">
							<input type="radio" name="mode" value="PAID" {{ ($editevent->mode=="PAID")? "checked" : "" }} >						  
							<label for="paid">PAID</label>	 
						  </div>
						</div>						 								  
						  <span id="nearest_error" style="color:red"></span>					  
						</div>											
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Seating Capacity</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Seating Capacity" type="number" id="sitting_capacity" name="sitting_capacity" value="{{ $editevent->sitting_capacity }}" min="10" max="99999" autocomplete="off" <?php echo $readonly;?>/>
						  <span id="sitting" style="color: red"></span>
						   <span id="sitting_for_range" style="color: red"></span>
						  
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meeting link</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Meeting link" id="meeting_link" type="text" name="meeting_link" value="{{ $editevent->meeting_link }}" onchange="return validUrl();" autocomplete="off" <?php echo $readonly;?>/>	
							<span id="meeting_link_error" style="color:red"></span>								  
                        </div>
                      </div>
					     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Start Date" id="start_time" type="text" name="start_time"  value="{{ $editevent->start_time }}" <?php echo $readonly;?>/>						   
						  <span id="start_time_error" style="color: red"></span>
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">End Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="End Date" type="text" id="end_time" name="end_time"  value="{{ $editevent->end_time }}" <?php echo $readonly;?>/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					<?php if(date('Y-m-d H:i:s') > $editevent->start_time){?>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Path</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Video Path" type="text" id="videoId" name="videoId"  value="{{ $editevent->videoId }}"/>
						   <input type="hidden" id="iseditable" name="iseditable"  value="true"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
					  	<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 custom-img-label">Image 1</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control custom-img-fileupload" type="file" name="image_one" onchange="return preview_image_one();">
                        </div>						
						<?php if($editevent->image_one){?>
                        <div class="col-md-3 col-sm-3 col-xs-12 image_one_hide">
                          <input type="hidden" name="image_one_old" id="image_one_old" value="{{ $editevent->image_one }}">
                          <a href="{{ asset('images/event/' . $editevent->image_one) }}" target="_blank"><img src="{{ asset('images/event') }}/{{ $editevent->image_one }}" class="custom-img-preview"/></a>						  
						  <a class="btn btn-danger deleteImages" data-id="{{ $editevent->img_id .','.$editevent->events_id .','.$editevent->image_one }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
						<?php }?>
						 <div class="col-md-3 col-sm-3 col-xs-12 image_one_preview">                          
                        </div>
						 
						
					   </div>					  
						<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 custom-img-label">Image 2</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control custom-img-fileupload" type="file" id="image_two" name="image_two" onchange="return preview_image_two();">
                        </div>
						<?php if($editevent->image_two){?>
                        <div class="col-md-3 col-sm-3 col-xs-12 image_two_hide">
                          <input type="hidden" name="image_two_old" id="image_two_old" value="{{ $editevent->image_two }}">
                          <a href="{{ asset('images/event/' . $editevent->image_two) }}" target="_blank"><img src="{{ asset('images/event') }}/{{ $editevent->image_two }}" class="custom-img-preview"/></a>
						   <a class="btn btn-danger deleteImages" data-id="{{ $editevent->img_id .','.$editevent->events_id .','.$editevent->image_two }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
						<?php }?>
						<div class="col-md-3 col-sm-3 col-xs-12 image_two_preview">                          
                        </div>						
						</div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 custom-img-label">Image 3</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control custom-img-fileupload" type="file" id="image_three" name="image_three" onchange="return preview_image_three();">
                            </div>
							<?php if($editevent->image_three){?>
                            <div class="col-md-3 col-sm-3 col-xs-12 image_three_hide">
                              <input type="hidden" name="image_three_old" id="image_three_old" value="{{ $editevent->image_three }}">
                              <a href="{{ asset('images/event/' . $editevent->image_three) }}" target="_blank"><img src="{{ asset('images/event') }}/{{ $editevent->image_three }}" class="custom-img-preview"/></a>
							   <a class="btn btn-danger deleteImages" data-id="{{ $editevent->img_id .','.$editevent->events_id .','.$editevent->image_three }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
							<?php }?>
							<div class="col-md-3 col-sm-3 col-xs-12 image_three_preview">                          
							</div>
						</div>
						<div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 custom-img-label">Image 4</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input class="form-control custom-img-fileupload" type="file" id="image_four" name="image_four" onchange="return preview_image_four();">
                            </div>
							<?php if($editevent->image_four){?>
                            <div class="col-md-3 col-sm-3 col-xs-12 image_four_hide">
                              <input type="hidden" name="image_four_old" id="image_four_old" value="{{ $editevent->image_four }}">
                              <a href="{{ asset('images/event/' . $editevent->image_four) }}" target="_blank"><img src="{{ asset('images/event') }}/{{ $editevent->image_four }}" class="custom-img-preview"/></a>
							  <a class="btn btn-danger deleteImages" data-id="{{ $editevent->img_id .','.$editevent->events_id .','.$editevent->image_four }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>						
							<?php }?>
							<div class="col-md-3 col-sm-3 col-xs-12 image_four_preview">                          
							</div>
                        </div>
					   
					<?php } ?>
					 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/events'">Cancel</button>                    
                          <button type="submit" class="btn btn-success submitEvents">Update</button>
                        </div>
                      </div>				
                    </form>
                  </div>
                </div>
              </div>
</div>
<style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }
   .form-horizontal .control-label.custom-img-label{padding-top:20px;}
   .custom-img-fileupload{margin-top:10px ;}
   .image_one_hide, .image_two_hide, .image_three_hide, .image_four_hide{display:flex; align-items:center;}
   .image_one_hide .deleteImages, .image_two_hide .deleteImages, .image_three_hide .deleteImages,
   .image_four_hide .deleteImages{margin-bottom:0; margin-left:10px;} 
   .custom-img-preview{width:100px; height:50px; object-fit:cover;-moz-object-fit:cover;-webkit-object-fit:cover;-o-object-fit:cover;} 
	.image_success_msg, .image_unsuccess_msg{display: table; margin: 10px auto;}
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<style>
.column{
	margin-top:10px;
	padding:0 10px;
	float:left;
}
.bootstrap-datetimepicker-widget{
	width:320px!important;
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

    <script type="text/javascript">
	//localStorage.removeItem("msg");	
	$('#start_time').datetimepicker({
		//defaultDate: false,				
		 format: 'YYYY-MM-DD HH:mm:ss',	
	});
	var end= new Date();
	 $('#end_time').datetimepicker({	
		 //defaultDate: false,			
		 format: 'YYYY-MM-DD HH:mm:ss',				  
		//minDate:new Date(),  
	});  
	
/* 	$("#start_time").datetimepicker({
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
	

		
/* 			uiLibrary: 'bootstrap4',
   iconsLibrary: 'fontawesome',
   format: 'yyyy-mm-dd',
   minDate: function(){
       var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
       return today
   }, */
   
			//$('#start_time').val('');
						
			//var end_time = $('#end_time').val();
			
			//$('#end_time').val('');
	    $(document).ready(function(){		 

      $( "#cities" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url:'/events/cities',
            type: 'POST',
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



 $('body').on('click','.submitEvents',function(){

    let event_name = $("input[name=event_name]").val();
		if(event_name==''){
			$("input[name=event_name]").css('border','red 1px solid').attr('placeholder','Please enter Event name');
			return false;
		}
    let address = $("input[name=address]").val();
		if(address==''){
			$("input[name=address]").css('border','red 1px solid').attr('placeholder','Please enter address');
			return false;
		}

       if ($('input[name="nearest"]:checked').length == 0) {
        $("#nearest_error").text('Select nearest city');
         return false; 
		 } 

    let city_id = $("input[name=city_id]").val();
  		if(city_id==''){      
			$("input[name=city_id]").css('border','red 1px solid').attr('placeholder','Please enter city name');
			return false;
		}
    let contact_person = $("input[name=contact_person]").val();
    if(contact_person==''){
			$("input[name=contact_person]").css('border','red 1px solid').attr('placeholder','Please enter contact person name');
			return false;
		}
    let contact_nos = $("input[name=contact_no]").val();
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
    let emails = $("input[name=email]").val();
	let regex = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
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
	let joining_instruction = $("input[name=joining_instruction]").val();
    if(joining_instruction==''){
			$("input[name=joining_instruction]").css('border','red 1px solid').attr('placeholder','Please enter joining instruction');
			return false;
		}
		 if ($('input[name="isHighlight"]:checked').length == 0) {
        $("#isHighlight_error").text('Select is highlight');
         return false; 
		 }

	let short_description = $("input[name=short_description]").val();
    if(short_description==''){
			$("input[name=short_description]").css('border','red 1px solid').attr('placeholder','Please enter short description');
			return false;
		}
	let sitting_capacity = $("input[name=sitting_capacity]").val();
    if(sitting_capacity==''){
			$("input[name=sitting_capacity]").css('border','red 1px solid').attr('placeholder','Please enter sitting capacity');
			return false;
		}
    let start_time = $("input[name=start_time]").val();
    if(start_time=='')
	{
			$("input[name=start_time]").css('border','red 1px solid').attr('placeholder','Please select start time');
			return false;
	}
	
    let end_time = $("input[name=end_time]").val();
  		if(end_time==''){      
			$("input[name=end_time]").css('border','red 1px solid').attr('placeholder','Please select end time');
			return false;
		}

	});

	
	$("input[name=event_name]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("input[name=address]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});

  $("input[name=city_id]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});

  $("input[name=contact_person]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
	 $("input[name=joining_instruction]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
	 $("input[name=short_description]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
	$("input[name=sitting_capacity]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("input[name=start_time]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("input[name=end_time]").focus(function(){
		$(this).css('border','#ccc 1px solid');
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
   });
   
<?php if($iseditable===false){ ?>
    $('input:radio').prop('disabled', function(){ return !this.checked; });
<?php } ?>
    
});
  </script>
  <script>
  	function preview_image_one() 
	{
		 var total_file=document.getElementById("image_one");	 
		 $('.image_one_preview').append("<img src='"+URL.createObjectURL(event.target.files[0])+"' class='custom-img-preview' /><br>");
		 $(".image_one_hide").hide();	 
	}
	function preview_image_two() 
	{
		 var total_file=document.getElementById("image_two");	 
		 $('.image_two_preview').append("<img src='"+URL.createObjectURL(event.target.files[0])+"' class='custom-img-preview' /><br>");
		 $(".image_two_hide").hide();	 
	}
	function preview_image_three() 
	{
		 var total_file=document.getElementById("image_three");	 
		 $('.image_three_preview').append("<img src='"+URL.createObjectURL(event.target.files[0])+"' class='custom-img-preview' /><br>");
		 $(".image_three_hide").hide();	 
	}
	function preview_image_four() 
	{
		 var total_file=document.getElementById("image_four");	 
		 $('.image_four_preview').append("<img src='"+URL.createObjectURL(event.target.files[0])+"' class='custom-img-preview' /><br>");
		 $(".image_four_hide").hide();	 
	}
	</script>
<script>
	$(".deleteImages").click(function(){
		
        var images_data_id_name = $(this).data("id");		
        $.ajax(
        {
			url: '{{ url("events/deleteimages") }}',           
            type: 'POST',
            dataType: 'json',
			 headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
            data: {
                "images_data_id_name": images_data_id_name,       
            },
            success: function (data)
            {
				if(data.image_success)
				{
					$('.image_success_msg').html(data.image_success).css('color','#28a745').css('font-size','14px');
						setTimeout(function(){ 
							location.reload();	
						},5000);
					//location.reload();
				}
				else
				{
					$('.image_unsuccess_msg').html(data.image_unsucees).css('color','#dc3545').css('font-size','14px');
						setTimeout(function(){ 
							location.reload();	
						},5000);
				}
            }
        });

        console.log("It failed");
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