@extends('layout.app')
@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/errors')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Aasanas Category</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/aasana/savecategoy') }}" method="POST"  enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Category Name" type="text" name="category_name" value="{{ old('category_name') }}"/>
						  <span id="lblErrorCategoryName" style="color: red"></span>
                        </div>
                      </div>
                      <!--<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <textarea class="form-control" rows="3" name="category_description" placeholder="Category Description">{{{ old('category_description') }}}</textarea>
						 <span id="lblErrorDescription" style="color: red"></span>
                        </div>
                      </div>-->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control" placeholder="Upload Image" type="file" name="category_image">
                          <span style="color:red" id="category_image"></span>
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
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
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

/* let category_description = $("textarea[name=category_description]").val();
  if(category_description==''){      
  $("textarea[name=category_description]").css('border','red 1px solid').attr('placeholder','Please enter category description');
  return false;
} */
let category_image = $("input[name=category_image]").val();
  if(category_image==''){      
  $("input[name=category_image]").css('border','red 1px solid').attr('placeholder','Please select category Image');
  return false;
}

});

$("input[name=category_name]").focus(function(){
$(this).css('border','#ccc 1px solid');
});
/* $("textarea[name=category_description]").focus(function(){
$(this).css('border','#ccc 1px solid');
}); */
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
			
@endsection
