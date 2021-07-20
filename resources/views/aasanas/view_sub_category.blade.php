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
                    <h2>View Aasana Sub Category</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left"  method="POST">
                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input class="form-control"  type="text" name="subcategory_name" value="{{$viewsubcategory->subcategory_name}}" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                         
                          <textarea class="form-control" rows="3" name="subcategory_description" readonly>{{$viewsubcategory->subcategory_description}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                         
                          <textarea class="form-control" rows="3" name="aasana_categories_id" readonly>{{$viewsubcategory->category_name}}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Category Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                        <a href="{{ asset('images/aasana/' . $viewsubcategory->subcategory_image) }}" target="_blank"><img src="{{ asset('images/aasana'.'/'.$viewsubcategory->subcategory_image ?? '') }}" alt=""/></a>
                        </div>
                      </div>
                     <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <button type="button" class="btn btn-primary button-center-align" onclick="location.href='{{ url('/') }}/aasana/listsubcategory'">Back</button>
                    
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>


@endsection