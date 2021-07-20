
<style>

#loader {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  background: rgba(0,0,0,0.75) url(images/loader.gif) no-repeat center center;
  z-index: 10000;
}

</style>



@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/flash')

  <div class="col-md-12 col-xs-12">
    @if($errors->any())
    <span class="alert alert-danger">{{ implode('', $errors->all(' :message')) }}</span>
    @endif
        <div class="x_panel">
            <div class="x_title">
                <h2>Import Category and Product</h2>
                <div class="clearfix"></div>
            </div>
            <br>
            <div class="x_content">
                <form class="form-horizontal form-label-left ayush_form" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Import Category and Product</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div id="loader"></div>
                            <input type="file" class="form-control" id="file_id" name="doc" />
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/listaayushcategories'">Cancel</button>
                            <button type="button" class="btn btn-success import_btn">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<script src="/vendors/jquery/dist/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $(".import_btn").click(function () {
        var tainerform = $(".ayush_form")[0]
        var formData = new FormData(tainerform);
        $('#loader').show();
        window.setTimeout(function(){
        $.ajax({
            url: '/importCategoryProduct',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                $('#loader').hide();
              	$('#alertBox').modal('show');
                if(data.success == true){
                  $('.modal_body_text').html(data.message);
                  window.setTimeout(function(){
                    location.href = '/listaayushcategories';
                  }, 3000);
                    $('#file_id').val('');
                }else{
                    $('.modal_body_text').html(data.message);
                    $('#file_id').val('');
                }
            }
        });
      }, 1000);
    });
});
</script>
@endsection