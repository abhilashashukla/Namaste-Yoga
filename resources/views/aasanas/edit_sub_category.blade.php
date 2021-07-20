@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
@include('layout/errors')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Aasana Sub Category</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/') }}/aasana/updatesubcategory/{{$editsubcategory->id}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="subcategory_name" value="{{$editsubcategory->subcategory_name}}">
						   <span id="lblErrorSubCategoryName" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                        
                          <textarea class="form-control" rows="3" name="subcategory_description">{{$editsubcategory->subcategory_description}}</textarea>
						  <span id="lblErrorSubCategoryDescription" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="aasana_categories_id">
                          <option value="">Select Category</option>
                          @foreach($category as $categories)
                            <option value="{{ $categories->id}}" @if ($editsubcategory->aasana_categories_id==$categories->id) selected @endif>{{ $categories->category_name}}</option>
                            @endforeach
                          </select>                         
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="file" name="subcategory_image" value="{{$editsubcategory->subcategory_image}}">
                          <a href="{{ asset('images/aasana/' . $editsubcategory->subcategory_image) }}" target="_blank"><img src="{{ asset('images/aasana/' . $editsubcategory->subcategory_image) }}"/></a></br> 
                          <span style="color:red" id="subcategory_image"></span>                        
                        </div>
                      </div>

					 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/aasana/listsubcategory'">Cancel</button>                    
                          <button type="submit" class="btn btn-success submitSubCategory">Update</button>
                        </div>
                      </div>				
                    </form>
                  </div>
                </div>
              </div>
</div>
<script>
$('body').on('click','.submitSubCategory',function(){
		
		//var cond = true;
		//var cond1 = true;
    let aasana_categories_id = $("select[name=aasana_categories_id]").val();
		if(aasana_categories_id==''){
			$("select[name=aasana_categories_id]").css('border','red 1px solid').attr('placeholder','Please enter category name');
			return false;
		}
		let subcategory_name = $("input[name=subcategory_name]").val();
		if(subcategory_name==''){
			$("input[name=subcategory_name]").css('border','red 1px solid').attr('placeholder','Please enter sub category name');
			return false;
		}
    let subcategory_description = $("textarea[name=subcategory_description]").val();
  		if(subcategory_description==''){      
			$("textarea[name=subcategory_description]").css('border','red 1px solid').attr('placeholder','Please enter sub category description');
			return false;
		}
    // let subcategory_image = $("input[name=subcategory_image]").val();
  	// 	if(subcategory_image==''){      
		// 	$("input[name=subcategory_image]").css('border','red 1px solid').attr('placeholder','Please select sub category Image');
		// 	return false;
		// }

	});
	$("select[name=aasana_categories_id]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("input[name=subcategory_name]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  $("textarea[name=subcategory_description]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
  // $("input[name=subcategory_image]").focus(function(){
	// 	$(this).css('border','#ccc 1px solid');
	// });
  </script>
  <script>
				$('input[name="subcategory_image"]').change(function(e) {

	
          var fileName = e.target.files[0].name;
					extension = fileName.split('.').pop();
					var validExtensions = ['jpg', 'jpeg', 'png'];
					if (fileName != '') {
						//$('#app_portfolio').hide();
					}

					if ($.inArray(extension, validExtensions) == -1) {

						$("#subcategory_image").html("Please make sure your file is in jpg, jpeg or png format.");
						$('input[name=subcategory_image]').val('');
						$('#subcategory_image').show();
						return false;
					} else {
						$('#subcategory_image').hide();
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
          if (filewidth > 1500 && fileheight > 1500) {
             //alert(filewidth);
						$("#subcategory_image").html("File too Large, please select a file less than 1500*1500 px");
						$('#subcategory_image').show();
						$('input[name=subcategory_image]').val('');
						return false;
					} else {
						$('#subcategory_image').hide();
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
/*     function ValidateSubCategory(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorSubCategoryName = document.getElementById("lblErrorSubCategoryName");
        lblErrorSubCategoryName.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorSubCategoryName.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    }
	    function ValidateSubCategoryDesc(e) {
        var keyCode = e.keyCode || e.which;
        var lblErrorSubCategoryDescription = document.getElementById("lblErrorSubCategoryDescription");
        lblErrorSubCategoryDescription.innerHTML = "";
 
        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;
 
        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            lblErrorSubCategoryDescription.innerHTML = "Only Alphabets and Numbers allowed.";
        }
 
        return isValid;
    } */
</script>

@endsection