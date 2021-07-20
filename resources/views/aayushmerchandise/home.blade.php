@extends('layout.app')

@section('content')
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
        <div class="col-md-6 col-sm-3 col-xs-9 tile_stats_count">
            <span class="count_top"><i class="fa fa-users"></i> Total Aayush Categories</span>
            <div class="count">{{$total_aayush_merchandise}}</div>
        </div>    
        <div class="col-md-6 col-sm-3 col-xs-9 tile_stats_count">
            <span class="count_top"><i class="fa fa-users"></i> Total Aayush Products</span>
            <div class="count green">{{$total_aayush_products}}</div>
        </div>
    </div>
  <!-- /top tiles -->
  
  
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title" style="color:#000;">
                            <h2>Welcome</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="dashboard-widget-content">
                                <div class="col-md-12 hidden-small" style="text-align: center;font-size: 30px; min-height: 400px;color:#000;">
                                    <h2 class="line_30"></h2>Welcome to Aayush Merchandise panel of Namaste-Yoga app
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection