@extends('layout.app')

@section('content')
<style>
.button-center-align
{	
	display: table;
    margin: auto;
}
</style>
<div class="right_col clearfix" role="main">
  @include('layout/flash')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Social Media</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left"  method="POST">
                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Organization Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="organization_name" value="{{$viewsocialmedia->organization_name}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Facebook Link <i class="fa fa-facebook-square"></i></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="org_facebook" value="{{$viewsocialmedia->org_facebook}}" readonly>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Twitter Link  <i class="fa fa-twitter"></i></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="org_twitter" value="{{$viewsocialmedia->org_twitter}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Instagram Link  <i class="fa fa-instagram"></i></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="org_instagram" value="{{$viewsocialmedia->org_instagram}}" readonly>
                        </div>
                      </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Youtube Link <i class="fa fa-youtube"></i></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input class="form-control"  type="text" name="org_youtube" value="{{ $viewsocialmedia->org_youtube }}" readonly>
                            </div>
                        </div>
                        
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Other Link</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="org_other" value="{{$viewsocialmedia->org_other}}" readonly>
                        </div>
                      </div>
                       <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <button type="button" class="btn btn-primary button-center-align" onclick="location.href='{{ url('/') }}/socialmedia/listssocialmedia'">Back</button>
                    
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>


@endsection