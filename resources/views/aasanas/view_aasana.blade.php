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
                    <h2>View Aasana</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left"  method="POST">
                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="aasana_categories_id" value="{{$viewaasana->category_name}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="aasana_sub_categories_id" value="{{$viewaasana->subcategory_name}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aasana Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">             
                          <input class="form-control"  type="text" name="aasana_name" value="{{$viewaasana->aasana_name}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Aasana Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                         
                          <textarea class="form-control" rows="3" name="aasana_description" readonly>{{$viewaasana->aasana_description}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tag</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">             
                          <input class="form-control"  type="text" name="assana_tag" value="{{$viewaasana->assana_tag}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Key</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">             
                          <input class="form-control"  type="text" name="assana_video_id" value="{{$viewaasana->assana_video_id}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Video Duration</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">             
                          <input class="form-control"  type="text" name="assana_video_duration" value="{{$viewaasana->assana_video_duration}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Benefits</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                         
                          <textarea class="form-control" rows="3" name="assana_benifits" readonly>{{$viewaasana->assana_benifits}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Instructions</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                         
                          <textarea class="form-control" rows="3" name="assana_instruction" readonly>{{$viewaasana->assana_instruction}}</textarea>
                        </div>
                      </div>                     
                     <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <button type="button" class="btn btn-primary button-center-align" onclick="location.href='{{ url('/') }}/aasana/listsaasana'">Back</button>
                    
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>


@endsection