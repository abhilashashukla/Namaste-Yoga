
<div class="right_col clearfix" role="main">
    
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Import excel</h2>
              <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                
                <form action="" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload Excel</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input class="form-control" type="file" name="import" id="import">
                        </div>
                    </div>
                    
                    
                    <div class="ln_solid"></div>
                    
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success ">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>