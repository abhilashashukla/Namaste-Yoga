<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="/vendors/jquery/dist/jquery.min.js"></script>
</head>
<body>

  <form method="post" enctype="multipart/form-data"  class="main_form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  	<input type="file" name="doc"/>
    {{$errors->first('doc')}}
  	<input type="button" class="import_btn" name="submit" value="save"/>
  </form>

</body>
</html>
<script>
$(document).ready(function(){
  $(".import_btn").click(function () {
      var tainerform = $(".main_form")[0]
      var formData = new FormData(tainerform);
          $.ajax({
              url: '/importSave',
              data: formData,
              processData: false,
              contentType: false,
              type: 'POST',
              success: function (data) {
                if(data.success == true){
                 alert(data.message)
                }else{
                  alert(data.message)
                }


              }
          });








  });

})


</script>
