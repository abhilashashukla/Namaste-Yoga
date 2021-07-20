@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
    @include('layout/flash')
				@if($errors->any())
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ implode(' ', $errors->all(':message')) }}
       </div>
      @endif
	  	@if(session('unsuccess'))
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ session('unsuccess') }}
       </div>
      @endif
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Aayush Product</h2>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                
                <form action="" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" name="ayush_categories_id" id="ayush_categories_id">
                                <option value="">Select Ayush Category</option>
                                @foreach($categorylist as $category)
                                    <option value="{{ $category->id }}" @if($category->id == $arrProduct->ayush_categories_id) selected="selected" @endif >{{ $category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Product Name" value="{{ $arrProduct->product_name }}" maxlength="100">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="product_description" id="product_description" class="form-control" rows="3" cols="250" placeholder="Product Description">{{ $arrProduct->product_description }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Key ingredients</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="key_ingredients" id="key_ingredients" class="form-control" rows="3" cols="250" placeholder="Key ingredients">{{ $arrProduct->key_ingredients }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Benefits of Product</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea name="direction" id="direction" class="form-control" rows="3" cols="250" placeholder="Benefits of Product">{{ $arrProduct->direction }}</textarea>
                        </div>
                    </div>
                    
                    <!--<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Product Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input class="form-control" type="file" name="product_image1" id="product_image1">
                            <input type="hidden" name="product_image" id="product_image" value="{{ $arrProduct->product_image }}">
                            <span id="imageError">Product image size should be 2MB.</span>
                            <br>
                            @if($arrProduct->product_image != '') 
                                <img src="{{ asset('images/aayush_products') }}/{{ $arrProduct->product_image }}" class="" width="180px;">
                            @endif 
                        </div>
                    </div>-->
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Image 1</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" name="old_image_one" id="old_image_one" value="{{ $arrProduct->image_one }}">
                            
                            <input class="form-control" type="file" name="image_one" id="image_one" onchange="return preview_image(this);">
                            <span id="imageError1">Product image size should be 2 MB.</span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="image_one_preview">
                                @if($arrProduct->image_one != '') 
                                <img src="{{ asset('images/aayush_products/' . $arrProduct->image_one) }}" width='80px'>
                                @endif 
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Image 2</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" name="old_image_two" id="old_image_two" value="{{ $arrProduct->image_two }}">
                            
                            <input class="form-control" type="file" name="image_two" id="image_two" onchange="return preview_image(this);">
                            <span id="imageError2">Product image size should be 2 MB.</span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="image_two_preview">
                                @if($arrProduct->image_two != '') 
                                <img src="{{ asset('images/aayush_products/' . $arrProduct->image_two) }}" width='80px'>
                                @endif 
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Image 3</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" name="old_image_three" id="old_image_three" value="{{ $arrProduct->image_three }}">
                            
                            <input class="form-control" type="file" name="image_three" id="image_three" onchange="return preview_image(this);">
                            <span id="imageError3">Product image size should be 2 MB.</span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="image_three_preview">
                                @if($arrProduct->image_three != '') 
                                <img src="{{ asset('images/aayush_products/' . $arrProduct->image_three) }}" width='80px'>
                                @endif 
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Image 4</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="hidden" name="old_image_four" id="old_image_four" value="{{ $arrProduct->image_four }}">
                            
                            <input class="form-control" type="file" name="image_four" id="image_four" onchange="return preview_image(this);">
                            <span id="imageError4">Product image size should be 2 MB.</span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="image_four_preview">
                                @if($arrProduct->image_four != '') 
                                <img src="{{ asset('images/aayush_products/' . $arrProduct->image_four) }}" width='80px'>
                                @endif 
                            </div>
                        </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ url('aayushproductlist') }}'">Cancel</button>
                            <input type="hidden" name="id" id="id" value="{{ $arrProduct->id }}">
                            <input type="hidden" name="ayush_product_images_id" id="ayush_product_images_id" value="{{ $arrProduct->ayush_product_images_id }}">
                            <button type="submit" class="btn btn-success editAayushProduct">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    
    
  	function preview_image(objThis) {
        var fieldId = objThis.id;
        
        var className = '';
        if(fieldId === 'image_one') {
            className = 'image_one_preview';
        } else if(fieldId === 'image_two') {
            className = 'image_two_preview';
        } else if(fieldId === 'image_three') {
            className = 'image_three_preview';
        } else if(fieldId === 'image_four') {
            className = 'image_four_preview';
        }
        
        $('.'+className).html("<img src='"+URL.createObjectURL(event.target.files[0])+"' width='80px'>");
	}
    
    
    $(document).ready(function(){
        
        //function define in "app.blade.php" file
        fieldValidation('product_name', 'alphaNumSpaceHyphen'); //for category name
        
        //field validate
        $('body').on('click', '.editAayushProduct', function(){
            
            /*var cond = true;

            if($("#ayush_categories_id").val() == ''){
                $("#ayush_categories_id").css('border','red 1px solid').attr('placeholder','Please select category');
                cond = false;
            } else {
                $("#ayush_categories_id").css('border','#ccc 1px solid');
            }

            if($("#product_name").val() == ''){
                $("#product_name").css('border','red 1px solid').attr('placeholder','Please enter product name');
                cond = false;
            } else {
                $("#product_name").css('border','#ccc 1px solid');
            }
            
            if($("#product_description").val() == ''){
                $("#product_description").css('border','red 1px solid').attr('title','Please enter product description');
                cond = false;
            } else {
                $("#product_description").css('border','#ccc 1px solid');
            }
            
            if($("#key_ingredients").val() == ''){
                $("#key_ingredients").css('border','red 1px solid').attr('title','Please enter product key ingredients');
                cond = false;
            } else {
                $("#key_ingredients").css('border','#ccc 1px solid');
            }
            
            if($("#direction").val() == ''){
                $("#direction").css('border','red 1px solid').attr('title','Please enter Benefits of product');
                cond = false;
            } else {
                $("#direction").css('border','#ccc 1px solid');
            }
            
            if($("#image_one").val() == '' && $("#old_image_one").val() == '' ){
                $("#image_one").css('border','red 1px solid').attr('title','Please select product image');
                cond = false;
            } else {
                if($("#image_one").val() != '') {
                    let filesize = $('#image_one')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_one").css('border','red 1px solid')
                        $('#imageError1').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_one").css('border','#ccc 1px solid');
                        $('#imageError1').css('color', '');
                    }
                }
            }
            
            if($("#image_two").val() == '' && $("#old_image_two").val() == '' ){
                $("#image_two").css('border','red 1px solid').attr('title','Please select product image');
                cond = false;
            } else {
                if($("#image_two").val() != '') {
                    let filesize = $('#image_two')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_two").css('border','red 1px solid')
                        $('#imageError2').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_two").css('border','#ccc 1px solid');
                        $('#imageError2').css('color', '');
                    }
                }
            }
            
            if($("#image_three").val() == '' && $("#old_image_three").val() == '' ){
                $("#image_three").css('border','red 1px solid').attr('title','Please select product image');
                cond = false;
            } else {
                if($("#image_three").val() != '') {
                    let filesize = $('#image_three')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_three").css('border','red 1px solid')
                        $('#imageError3').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_three").css('border','#ccc 1px solid');
                        $('#imageError3').css('color', '');
                    }
                }
            }
            
            if($("#image_four").val() == '' && $("#old_image_four").val() == '' ){
                $("#image_four").css('border','red 1px solid').attr('title','Please select product image');
                cond = false;//alert();//-------------------
            } else {
                if($("#image_four").val() != '') {
                    let filesize = $('#image_four')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_four").css('border','red 1px solid')
                        $('#imageError4').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_four").css('border','#ccc 1px solid');
                        $('#imageError4').css('color', '');
                    }
                }
            }*/
            
            var cond = true;

            if($("#ayush_categories_id").val() == ''){
                $("#ayush_categories_id").css('border','red 1px solid').attr('placeholder','Please select category');
                cond = false;
            } else {
                $("#ayush_categories_id").css('border','#ccc 1px solid');
            }

            if($("#product_name").val() == ''){
                $("#product_name").css('border','red 1px solid').attr('placeholder','Please enter product name');
                cond = false;
            } else {
                $("#product_name").css('border','#ccc 1px solid');
            }
            
            if($("#product_description").val() == ''){
                $("#product_description").css('border','red 1px solid').attr('title','Please enter product description');
                cond = false;
            } else {
                $("#product_description").css('border','#ccc 1px solid');
            }
            
            if($("#key_ingredients").val() == ''){
                $("#key_ingredients").css('border','red 1px solid').attr('title','Please enter product key ingredients');
                cond = false;
            } else {
                $("#key_ingredients").css('border','#ccc 1px solid');
            }
            
            if($("#direction").val() == ''){
                $("#direction").css('border','red 1px solid').attr('title','Please enter Benefits of product');
                cond = false;
            } else {
                $("#direction").css('border','#ccc 1px solid');
            }
            
            
            if($("#image_one").val() == '' && $("#old_image_one").val() == '' && $("#image_two").val() == '' && $("#old_image_two").val() == '' && $("#image_three").val() == '' && $("#old_image_three").val() == '' && $("#image_four").val() == '' && $("#old_image_four").val() == '') {
                
                $("#image_one").css('border','red 1px solid');
                $('#imageError1').html('Please select a product image.').css('color', 'red');
                
                cond = false;
                
            } else {
                $("#image_one").css('border','#ccc 1px solid');
                $('#imageError1').html('Product image size should be 2 MB.').css('color', '');
                
                if($("#image_one").val() != '') {
                    let filesize = $('#image_one')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_one").css('border','red 1px solid')
                        $('#imageError1').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_one").css('border','#ccc 1px solid');
                        $('#imageError1').css('color', '');
                    }
                }
                
                if($("#image_two").val() != '') {
                    let filesize = $('#image_two')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_two").css('border','red 1px solid')
                        $('#imageError2').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_two").css('border','#ccc 1px solid');
                        $('#imageError2').css('color', '');
                    }
                }
                
                if($("#image_three").val() != '') {
                    let filesize = $('#image_three')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_three").css('border','red 1px solid')
                        $('#imageError3').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_three").css('border','#ccc 1px solid');
                        $('#imageError3').css('color', '');
                    }
                }
                
                if($("#image_four").val() != '') {
                    let filesize = $('#image_four')[0].files[0].size; // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image_four").css('border','red 1px solid')
                        $('#imageError4').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image_four").css('border','#ccc 1px solid');
                        $('#imageError4').css('color', '');
                    }
                }
            }
            
            if(cond === false) return false;
            
        });
    });
</script>

@endsection