@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
    @include('layout/flash')
	@if(session('message'))
        <div class="alert alert-success" style="margin-top:15px;">
          {{ session('message') }}
        </div> 
        @endif
		<?php if (session('flash_message_for_ayush_edit')){?>
  <div class="alert alert-danger" style="margin-top:15px;">
      {{ session('flash_message_for_ayush_edit') }}
  </div>
  <?php }?>
    <div class="x_panel">	
        <div class="x_title">
            <h2>Aayush Categories List</h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            {{ csrf_field() }}
            
            <div id="message"></div>
            
            <table id="categoryData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
                <thead>
                    <tr>
                        <th>Sr. no.</th>
                        <th>Category Name</th>
                        <th>Category Description</th>
                        <th>Category Image</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>                              
        </div>
    </div>


  
<script>
	var table = '';

	jQuery(document).ready(function() {
          table = jQuery('#categoryData').DataTable({
            'processing': true,
            'serverSide': true,
            'lengthMenu': [
               [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [
            {
				extend:'csvHtml5',
				exportOptions: {
					columns: [0, 1, 2, 4]//"thead th:not(.noExport)"
				}
            },
            'pageLength'
            ],
            'sPaginationType': "simple_numbers",
            'searching': false,
            "bSort": false,
            "fnDrawCallback": function (oSettings) {
				jQuery('.popoverData').popover();
            },
            'fnRowCallback': function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            },
			"initComplete": function(settings, json) {
            },
            'ajax': {
              'url': '{{ url("/") }}/categoriesIndexAjax',
              'headers': {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              'type': 'post',
              'data': function(d) {
                //d.userFilter = jQuery('#userFilter option:selected').text();
                //d.search = jQuery("#userListTable_filter input").val();
              },
            },
			
            'columns': [
                /*{
					'data': 'id',
					'className': 'col-md-1'
				},*/
				{
					'data': 'sr_no',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.sr_no;
					}
				},
				{
					'data': 'category_name',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.category_name;
					}
				},
				{
					'data': 'category_description',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.category_description;
					}
				},
				{
					'data': 'image',
					'className': 'col-md-1',
					'render': function(data,type,row){
                        
                        var html = '';
                        if(row.image != null) {
                            html = '<img src="'+row.image+'" width="75px;">';
                        }
						return html;
					}
				},
				{
					'data': 'created_date',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.created_date;
					}
				},
				{
					'data': 'status',
					'className': 'col-md-1',
					'render': function(data, type, row){
                        var html = '';
                        @if(Auth::user()->role_id==4)
                            if(row.status == 1){
                                html = '<i class="fa fa-toggle-on" onclick="changeMCStatus('+row.id+', 0)" style="color:green;font-size:20px;"></i>';
                            } else {
                                html = '<i class="fa fa-toggle-off" onclick="changeMCStatus('+row.id+', 1)" style="color:red;font-size:20px;"></i>';
                            }
                        @else 
                            html = (row.status == 1) ? 'Active' : 'Deactive';
                        @endIf
                        
                        return html;
                    }
				},
                {
                    'data': 'action',
                    'className': 'col-md-1',
                    'render': function(data, type, row) {
                        
                        var buttonHtml = '<a href="editaayushcategory/' + row.id + '" class="btn btn-success" title="Edit Category"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        
                        return buttonHtml;
                    }
                }
            ]
          });   
              
          
	});


    function changeMCStatus(id, status){
        $('#confirm').modal({
            backdrop: 'static',
            keyboard: false
        }).find('.modal-body').html('<p>Are you sure want to change the status of this record, do you want to continue?</p><input type="hidden" id="hidden_id" value="'+id+'"><input type="hidden" id="hidden_status" value="'+status+'">');
    }
    
    $(document).on('click','#continue1',function(){
        $('#message').html('').removeClass();

        var hidden_id = $('#hidden_id').val();
        var hidden_status = $('#hidden_status').val();

        jQuery.ajax({
            url: '{{ url("updateaayushcategorystatus") }}',
            type: "POST",
            //cache : false,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            data: {
                status: hidden_status, id: hidden_id
            },
            success: function(response) {
                //response = JSON.parse(response);
                $('#confirm').modal('hide');
                  table.draw();

                if(response.status==1){

                    $('#message').addClass('alert alert-success').html(response.message);

                } else {

                    $('#message').addClass('alert alert-error').html(response.message);

                }


                setTimeout(function(){
                    $('#message').html('').removeClass();
                }, 6500);

            },
            error: function() {
                //alert('Error!');
				window.relode();
            }
        });
    });

</script>

<style>
	.dataTables_paginate a {
	  background-color:#fff !important;
	}
	.dataTables_paginate .pagination>.active>a{
	  color: #fff !important;
	  background-color: #337ab7 !important;
	}
</style>

@endsection