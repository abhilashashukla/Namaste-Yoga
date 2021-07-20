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
                <h2>View Aayush Product</h2>
              <div class="clearfix"></div>
            </div>
            
            <div class="form-horizontal form-label-left">
                <div class="x_content">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" value="{{ $arrProduct->category_name }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" value="{{ $arrProduct->product_name }}" readonly="readonly">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" rows="3" cols="250" readonly="readonly">{{ $arrProduct->product_description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Key ingredients</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" rows="3" cols="250" readonly="readonly">{{ $arrProduct->key_ingredients }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Benefits of Product</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" rows="3" cols="250" readonly="readonly">{{ $arrProduct->direction }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Product Image</label>
                        <div class="col-md-2 col-sm-2">
                            @if($arrProduct->image_one != '')
                                <img src="{{ $arrProduct->image_one }}" class="" width="160px;">
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2">
                            @if($arrProduct->image_two != '')
                                <img src="{{ $arrProduct->image_two }}" class="" width="160px;">
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2">
                            @if($arrProduct->image_three != '')
                                <img src="{{ $arrProduct->image_three }}" class="" width="160px;">
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-2">
                            @if($arrProduct->image_four != '')
                                <img src="{{ $arrProduct->image_four }}" class="" width="160px;">
                            @endif
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" class="btn btn-primary button-center-align" onclick="location.href='{{ url('aayushproductlist') }}'">Back</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection