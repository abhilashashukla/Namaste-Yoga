@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
@include('layout/errors')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Aasana</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/aasana/updateaasana/{{$editaasana->id}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="aasana_categories_id" id="aasana_categories_id">
                          <option value="">Select Category</option>
                          @foreach($categorylist as $category)
                            <option value="{{ $category->id}}" @if ($editaasana->aasana_categories_id==$category->id) selected @endif>{{ $category->category_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="aasana_sub_categories_id" id="aasana_sub_categories_id"> 
                          @foreach($subcategorylist as $subcategory)
                            <option value="{{ $subcategory->id}}" @if ($editaasana->aasana_sub_categories_id==$subcategory->id) selected @endif>{{ $subcategory->subcategory_name}}</option>
                            @endforeach                                            
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aasana Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="aasana_name" value="{{$editaasana->aasana_name}}">
						  <span id="lblErrorAasanaName" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aasana Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                        
                          <textarea class="form-control" rows="3" name="aasana_description">{{$editaasana->aasana_description}}</textarea>
						  <span id="lblErrorAasanadesc" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tag</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="assana_tag" value="{{$editaasana->assana_tag}}">
						  <span id="lblErrorAasanatags" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Path</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="assana_video_id" value="{{$editaasana->assana_video_id}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Duration</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="assana_video_duration" value="{{$editaasana->assana_video_duration}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Benefits</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                        
                          <textarea class="form-control" rows="3" name="assana_benifits">{{$editaasana->assana_benifits}}</textarea>
						  <span id="lblError_b" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Instructions</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                        
                          <textarea class="form-control" rows="3" name="assana_instruction">{{$editaasana->assana_instruction}}</textarea>
						  <span id="lblError_Instructions" style="color: red"></span>
                        </div>
                      </div>                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/aasana/listsaasana'">Cancel</button>                    
                          <button type="submit" class="btn btn-success submitAasana">Update</button>
                        </div>
                      </div>				
                    </form>
                  </div>
                </div>
              </div>
</div>
<script>
$('body').on('click','.submitAasana',function(){

    let aasana_categories_id = $("select[name=aasana_categories_id]").val();
		if(aasana_categories_id==''){
			$("select[name=aasana_categories_id]").css('border','red 1px solid').attr('placeholder','Please enter category name');
			return false;
		}
    let aasana_sub_categories_id = $("select[name=aasana_sub_categories_id]").val();
		if(aasana_sub_categories_id==''){
			$("select[name=aasana_sub_categories_id]").css('border','red 1px solid').attr('placeholder','Please enter sub category name');
			return false;
		}
		let aasana_name = $("input[name=aasana_name]").val();
		if(aasana_name==''){
			$("input[name=aasana_name]").css('border','red 1px solid').attr('placeholder','Please enter aasana name');
			return false;
		}
    let aasana_description = $("textarea[name=aasana_description]").val();
  		if(aasana_description==''){      
			$("textarea[name=aasana_description]").css('border','red 1px solid').attr('placeholder','Please enter aasana description');
			return false;
		}
    // let aasana_image = $("input[name=aasana_image]").val();
  	// 	if(aasana_image==''){      
		// 	$("input[name=aasana_image]").css('border','red 1px solid').attr('placeholder','Please select aasana Image');
		// 	return false;
		// }
    let assana_tag = $("input[name=assana_tag]").val();
    if(assana_tag==''){
			$("input[name=assana_tag]").css('border','red 1px solid').attr('placeholder','Please enter aasana tag');
			return false;
		}
    let assana_video_id = $("input[name=assana_video_id]").val();
    if(assana_video_id==''){
			$("input[name=assana_video_id]").css('border','red 1px solid').attr('placeholder','Please enter aasana key');
			return false;
		}
    let assana_video_duration = $("input[name=assana_video_duration]").val();
    if(assana_video_duration==''){
			$("input[name=assana_video_duration]").css('border','red 1px solid').attr('placeholder','Please enter aasana video duration');
			return false;
		}
    
    let assana_benifits = $("textarea[name=assana_benifits]").val();
    if(assana_benifits==''){
			$("textarea[name=assana_benifits]").css('border','red 1px solid').attr('placeholder','Please enter aasana benifits');
			return false;
		}
    let assana_instruction = $("textarea[name=assana_instruction]").val();
  		if(assana_instruction==''){      
			$("textarea[name=assana_instruction]").css('border','red 1px solid').attr('placeholder','Please enter aasana instruction');
			return false;
		}

	});
	$("select[name=aasana_categories_id]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("select[name=aasana_sub_categories_id]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  
  $("input[name=aasana_name]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("textarea[name=aasana_description]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  // $("input[name=aasana_image]").focus(function(){
	// 	$(this).css('border','#ccc 1px solid');
	// });
  $("input[name=assana_tag]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("input[name=assana_video_id]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("input[name=assana_video_duration]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("textarea[name=assana_benifits]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("textarea[name=assana_instruction]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  </script>

<script>
  $(document).ready(function() {   
  $('#aasana_categories_id').on('change', function() {
    
  var aasana_categories_id = this.value;
  //alert(aasana_categories_id);
  $("#aasana_sub_categories_id").html('');
  $.ajax({
    url:'../geteditsubcategorybycategory',
    type:'POST',
     headers:{
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
     },
  data:{aasana_categories_id},
  success: function(result){
  $('#aasana_sub_categories_id').html('<option value="">Select Sub Category</option>'); 
  $.each(result.subcategory,function(key,value){
  $("#aasana_sub_categories_id").append('<option value="'+value.id+'">'+value.subcategory_name+'</option>');
  });
  }
  });
  });
});
</script>
<script>
/*     function ValidateAasanaName(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorAasanaName = document.getElementById("lblErrorAasanaName");
        lblErrorAasanaName.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorAasanaName.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    }
    function ValidateAasanaDesc(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorAasanadesc = document.getElementById("lblErrorAasanadesc");
        lblErrorAasanadesc.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorAasanadesc.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    }
    function ValidateAasanaTags(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorAasanatags = document.getElementById("lblErrorAasanatags");
        lblErrorAasanatags.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorAasanatags.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    }
    function ValidateBenefits(e) {
        var keyCode = e.keyCode || e.which;
        var lblError_b = document.getElementById("lblError_b");
        lblError_b.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblError_b.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    }
	function ValidateInst(e) {
        var keyCode = e.keyCode || e.which;
        var lblError_Instructions = document.getElementById("lblError_Instructions");
        lblError_Instructions.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblError_Instructions.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    } */

</script>

@endsection