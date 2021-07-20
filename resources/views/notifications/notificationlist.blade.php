@extends('layout.app')
@section('content')

<div class="right_col" role="main">
    @include('layout/flash')
		@if(session('message'))
        <div class="alert alert-success" style="margin-top:15px;">
          {{ session('message') }}
        </div> 
        @endif
    <div class="x_panel">
        <div class="x_title">
            <h2>General Notification List</h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">		  
            <table id="NotificationData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
                <thead>
                    <tr>
                        <!--<th>Notification Id</th>-->
                        <th>Notification Name</th>
                        <th>Notification Message</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
              <!--<tfoot>
                    <tr>                              
						<th>Notification Id</th>
						<th>Notification Name</th>
						<th>Notification Message</th>
						<th>Created Date</th>
                  </tr>
              </tfoot>-->
            </table>                              
        </div>
    </div>


  
<script>
	var table = '';

	jQuery(document).ready(function() {
          table = jQuery('#NotificationData').DataTable({
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
					columns: [0, 1, 2]//"thead th:not(.noExport)"
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
              'url': '{{ url("/") }}/notificationIndexAjax',
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
					'data': 'notification_name',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.notification_name;
					}
				},
				{
					'data': 'notification_message',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.notification_message;
					}
				},
				{
					'data': 'created_date',
					'className': 'col-md-1',
					'render': function(data,type,row){
						return row.created_date;
					}
				},
            ]
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