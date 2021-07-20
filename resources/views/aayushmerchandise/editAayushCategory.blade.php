@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
    @include('layout/flash')
			@if($errors->any())
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ implode(' ', $errors->all(':message')) }}
       </div>
      @endif
	  	   @if(session('dublicate_category'))
        <div class="alert alert-danger" style="margin-top:15px;">
        {{ session('dublicate_category') }}
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
                <h2>Edit Category</h2>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">               
                
                <form action="" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" value="{{ $arrCat->category_name }}" maxlength="100">
                            <input type="hidden" name="category_name_old" id="category_name_old" value="{{ $arrCat->category_name }}">
                        </div>
                    </div>
                    
                    <div class="dynamicFields">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Description</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <textarea name="category_description" id="category_description" class="form-control" rows="3" cols="250" placeholder="Category Description">{{ $arrCat->category_description }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Category Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input class="form-control" type="file" name="image1" id="image1">
                            <input type="hidden" name="image" id="image" value="{{ $arrCat->image }}">
                            <span id="imageError">Category image size should be 2MB.</span>
                            <br>
                            @if($arrCat->image != '') 
                                <img src="{{ asset('images/aayush_products') }}/{{ $arrCat->image }}" class="" width="180px;">
                            @endif 
                        </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ url('listaayushcategories') }}'">Cancel</button>
                            <input class="form-control" type="hidden" name="id" id="id" value="{{ $arrCat->id }}">
                            <button type="submit" class="btn btn-success updateAayushCategory">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        
        //function define in "app.blade.php" file
        fieldValidation('category_name', 'alphaNumSpaceHyphen'); //for category name
        fieldValidation('category_description', 'all'); //for category description
        
        
        //field validate
        $('body').on('click', '.updateAayushCategory', function(){

            var cond = true;
            var category_name = $("#category_name").val();
            
            if(category_name == ''){
                $("#category_name").css('border','red 1px solid').attr('placeholder','Please enter category name');
                cond = false;
            } else {
                $("#category_name").css('border','#ccc 1px solid');
            }
            
            
            /*var category_description = $("#category_description").val();
            if(category_description == ''){
                $("#category_description").css('border','red 1px solid').attr('placeholder','Please enter category description');
                cond = false;
            } else {
                $("#category_description").css('border','#ccc 1px solid');
            }*/
            
            if($("#image1").val() == '' && $("#image").val() == ''){
                $("#image1").css('border','red 1px solid');
                $('#imageError').html('Please select a category image.').css('color', 'red');
                
                cond = false;
            } else {
                
                $('#imageError').html('Product image size should be 2 MB.').css('color', '');
                
                if($("#image1").val() != '') {
                    let filesize = $('#image1')[0].files[0].size // On older browsers this can return NULL.
                    let filesizeMB = (filesize / (1024*1024)).toFixed(2);

                    if(filesizeMB > 2) {
                        $("#image1").css('border','red 1px solid');
                        $('#imageError').css('color', 'red');
                        cond = false;
                    } else {
                        $("#image1").css('border','#ccc 1px solid');
                        $('#imageError').css('color', '');
                    }
                }
            }

            if(cond==false) return false;
            
        });

    });
</script>

@endsection