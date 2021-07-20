@extends('layout.app')
@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/errors')
  
    <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Social Media</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left disableonsubmit" action="{{ url('/socialmedia/savesocialmedia') }}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Organization Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control" type="text" id="organization_name" name="organization_name" placeholder="Organization name" value="{{ old('organization_name') }}"/>
                        <span id="organization_name_error" style="color:red"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook Link <i class="fa fa-facebook-square"></i></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control social_media_common_field_error" onchange="return validateFUrl();" type="text" id="org_facebook" name="org_facebook" placeholder="Facebook link" value="{{ old('org_facebook') }}"/>
                        <span id="social_media_facebook" style="color:red"></span>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Twitter Link <i class="fa fa-twitter"></i></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control social_media_common_field_error" onchange="return validateTUrl();" type="text" id="org_twitter" name="org_twitter" placeholder="Twitter link" value="{{ old('org_twitter') }}"/>
                        <span id="social_media_twitter" style="color:red"></span>
                        </div>
                      </div>
                      
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Instagram Link <i class="fa fa-instagram"></i></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">                       
                                <input class="form-control social_media_common_field_error" type="text" onchange="return validateIUrl();" id="org_instagram" name="org_instagram" placeholder="Instagram link" value="{{ old('org_instagram') }}"/>
                                <span id="social_media_instagram" style="color:red"></span>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube Link <i class="fa fa-youtube"></i></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input class="form-control social_media_common_field_error" type="text" onchange="return matchYoutubeUrl();" id="org_youtube" name="org_youtube" placeholder="Youtube link" value="{{ old('org_youtube') }}" />
                                <span id="social_media_youtube" style="color:red"></span>
                            </div>
                        </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Other Link <i class="fa fa-share-square"></i></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control" type="text" id="org_other" name="org_other" onchange="return validUrl();" placeholder="Other link" value="{{ old('org_other') }}"/>
                       <span id="social_media_other" style="color:red"></span>
                        </div>
                      </div> 
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                      <div class="col-md-9 col-sm-9 col-xs-12">   
                      <span class="social_media" style="color:red"></span>
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
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/socialmedia/listssocialmedia'">Cancel</button>
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success submitSocialMedia">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>
<script>
    $('body').on('click','.submitSocialMedia',function()
    { 

        let organization_name = $("input[name=organization_name]").val();      
        let input_organization_name= $("#organization_name").val().length;   
        
        if(organization_name==''){
            $("input[name=organization_name]").css('border','red 1px solid').attr('placeholder','Please enter organization name');
            return false;
        }
    
        let org_facebook=  $("input[name=org_facebook]").val(); 
        let org_twitter=  $("input[name=org_twitter]").val(); 
        let org_instagram=  $("input[name=org_instagram]").val();
        let org_youtube=  $("input[name=org_youtube]").val();
        let org_other=  $("input[name=org_other]").val(); 
  
        if(org_facebook=='' && org_twitter=='' && org_instagram =='' && org_youtube == '' && org_other==''){
            $(".social_media").html("Please enter atleast on social media link.");
            //$(".social_media").css('border','red 1px solid').attr('placeholder','Please enter atleast on social media link');
            return false;
        }
    });
 
    
    $("input[name=organization_name]").focus(function()
    {
      $(this).css('border','#ccc 1px solid');
    });
  
 
</script>

<script>
 function validateTUrl()
 {

	 var turl = $("#org_twitter").val();

	 var TWurl =/^(http|https)\:\/\/(www.|)twitter.com\/.*/i;

	  if (!turl.match(TWurl))
	  {
		$("#org_twitter").val('');
		 $("#social_media_twitter").html("Please enter correct twitter link.").show();        
			return false;
	  }
	  else
	  {
		 
		  
		  $("#social_media_twitter").hide();
	  }
 } 
 function validateFUrl()
 {
	
	 var furl = $("#org_facebook").val();
	 var FBurl = /^(http|https)\:\/\/www.facebook.com\/.*/i;
	  if (!furl.match(FBurl))
	  {
		 $("#org_facebook").val('');
		 $("#social_media_facebook").html("Please enter correct facebook link.").show();        
			return false;
	  }
	  else
	  {
		  $("#social_media_facebook").hide();
	  }

 }
  function validateIUrl()
 {
	
	 var iurl = $("#org_instagram").val();
	 //alert(iurl)
	 var IBurl = /^(http|https)\:\/\/www.instagram.com\/.*/i;
	 //alert(IBurl);
	  if (!iurl.match(IBurl))
	  {
		  $("#org_instagram").val('');
		 $("#social_media_instagram").html("Please enter correct instagram link.").show();        
			return false;
	  }
	  else
	  {
		  //alert('else');
		  $("#social_media_instagram").hide();
	  }

 }
 function validUrl() {
	 var otherurl = $("#org_other").val();
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  if(!otherurl.match(pattern))
  {
	  $("#org_other").val('');
   $("#social_media_other").html("Please enter correct link.").show();        
			return false;
  }
  else
  {
	  //alert('else');
	  $("#social_media_other").hide();
  }
}
 
    function matchYoutubeUrl() {
        var url = $("#org_youtube").val();
        
        //var regExp = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;//only for videoId
        
        //var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var regExp = /^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+/;   //https://www.regextester.com/94360
        
        if(url.match(regExp)){
            
            $("#social_media_youtube").hide();
            
            return true;//url.match(p)[1];
        } else {
            $("#org_youtube").val('');
            $("#social_media_youtube").html("Please enter correct link.").show();
            
            return false;
        }
    }
</script>
@endsection


