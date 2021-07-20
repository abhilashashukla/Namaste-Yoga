@extends('layout.app')

@section('content')
<div class="right_col clearfix" role="main">
  @include('layout/errors')
  
    <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Excel File</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" action="{{ url('/excel/import') }}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}  
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Import Excel File</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">                       
                        <input class="form-control" type="file" id="aasana_excel" name="aasana_excel" placeholder="Excel File"/>
                        <span id="organization_name_error" style="color:red"></span>
                        </div>
                      </div>                    
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <!-- <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/socialmedia/listssocialmedia'">Cancel</button> -->
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <button type="submit" class="btn btn-success submitSocialMedia">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
</div>

@endsection


