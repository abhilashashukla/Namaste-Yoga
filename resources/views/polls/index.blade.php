@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
  @include('layout/flash')
  
  
  <div class="x_panel">
  @if ( Session::has('flash_message') )

  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message') }}
  </div>
  
@endif
      <div class="x_title">
        <h2>Poll List</h2>

        <div class="clearfix"></div>
			
      </div>
      <div class="x_content"> 
		<p id="msgsection"> </p>
          {{ csrf_field() }}             
          <table id="pollsData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>Sr. No.</th>
                      <th>Poll Name</th>
                      <th>Total No. of Submission</th> 			  
                      <th>Start Date</th>
                      <th>End Date</th>
					  <th> Status </th>	
                      <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                 <tr>                              
                    <th>Sr. No.</th>
                      <th>Poll Name</th>
                      <th>Total No. of Submission</th> 					  
                      <th>Start Date</th>
                      <th>End Date</th>
					  <th> Status </th>	
                      <th>Action</th>
                  </tr>
              </tfoot>
          </table>                              
        </div>
</div>

          
<script>   
var table = '';

        jQuery(document).ready(function() {
         
					//var permissonObj = '<%-JSON.stringify(permission)%>';
					//permissonObj = JSON.parse(permissonObj);


          table = jQuery('#pollsData').DataTable({
            'processing': true,
            'serverSide': true,                        
            'lengthMenu': [
               [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [                        
            {extend:'csvHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3, 4]//"thead th:not(.noExport)"
              }
            },
            'pageLength'
            ],
            'sPaginationType': "simple_numbers",
            'searching': true,
            "bSort": false,
            "fnDrawCallback": function (oSettings) {
              jQuery('.popoverData').popover();
              // if(jQuery("#userTabButton").parent('li').hasClass('active')){
              //   jQuery("#userTabButton").trigger("click");
              // }
              // jQuery("#userListTable_wrapper").removeClass( "form-inline" );
            },
            'fnRowCallback': function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
              //if (aData["status"] == "1") {
                //jQuery('td', nRow).css('background-color', '#6fdc6f');
              //} else if (aData["status"] == "0") {
                //jQuery('td', nRow).css('background-color', '#ff7f7f');
              //}
              //jQuery('.popoverData').popover();
            },
						"initComplete": function(settings, json) {						
              //jQuery('.popoverData').popover();
					  },
            'ajax': {
              'url': '{{ url("/") }}/polls/pollsIndexAjax',
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
                {
				'data': 'Sr.No.',
				 'className': 'col-md-1',
				"sortable": false,
				'render': function(data,type,row){
						return row.sr_no;
				}
			  }, 
              {
                  'data': 'poll_name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var poll_name = (row.poll_name.length > 30) ? row.poll_name.substring(0,30)+'...' : row.poll_name;
                    return '<a class="popoverData" data-content="'+row.poll_name+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+poll_name+'</a>';
                  }
              },
              {
                  'data': 'total_no_of_submission',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.total_no_of_submission;
                  }
              },
              
              {
                  'data': 'start_date',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    return row.start_date;
                  }
              },
			{
                  'data': 'end_date',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    return row.end_date;
                  }
              }	,
{
                'data': 'Status',
                'className': 'col-md-1',
                'render': function(data,type,row){
                    var html = '';
                    @if(Auth::user()->role_id==4)
                      if(row.status==1){
                        html = '<i class="fa fa-toggle-on" title="De-active" onclick="changeStatus('+row.id+',0,'+row.is_editable+')" style="color:green;font-size:20px;"></i>';
                      }else{
						  var OCEvent ='';
						  var title = 'title="Poll Expired"';
						  if(row.is_publishable==1){
							   OCEvent = 'onclick="changeStatus('+row.id+',1,'+row.is_editable+')"';
							   title = 'title="Active"';
						  }
                        html = '<i class="fa fa-toggle-off" '+title+' '+OCEvent+' style="color:red;font-size:20px;"></i>';
                      }  
                    @else
                        html = (row.status=='1') ? 'Active' : 'Deactive';   
                    @endIf             
                    return html
                  }  
              },			  
               {
                 'data': 'Action',
                 'className': 'col-md-2',
                 'render': function(data, type, row) {
                  
				   var buttonHtml = '<a href="/polls/view/' + row.id + '" class="btn btn-success" title="View" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
				   if(row.is_editable==1){
				   buttonHtml += '<a href="/polls/edit/' + row.id + '" class="btn btn-success" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <button type="button" id="' + row.id + '" class="btn btn-danger deletePolls" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
				 }else{
					  buttonHtml += '<a href="/polls/viewresult/' + row.id + '" class="btn btn-success" title="View result" ><i class="fa fa-pie-chart" aria-hidden="true"></i></a>';
				 }
				  
                  return buttonHtml;
                }
              }
            ]
          });   
              
           $('.buttons-csv').attr('title','Download');
        });

        function ValidateEmail(email){
          if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
          }
          return false;
        }

        function changeStatus(poll_id,val,is_editable){ 
		if(val==1 && is_editable==1){
			$('#confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).on('click','#continue1',function(){
					changeStatus1(poll_id,val,is_editable);
				}).find('.modal-body').html('<p>You will not be able to edit this poll again, do you want to continue?</p>');
		}else{
			changeStatus1(poll_id,val,is_editable);
		}
          
        }
		function changeStatus1(poll_id,val,is_editable){
			jQuery.ajax({
              url: '/polls/changestatus',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"poll_id": poll_id
              },
              success: function(response) {
                //response = JSON.parse(response); 
					$('#confirm').modal('hide');					
					table.draw();			
                if(response.status==1){
					 
					setTimeout(function(){
						$('#msgsection').html('<p id="msgsection" class="alert alert-success">'+response.message+'</p>');
					},1000);
                  //alert(response.message);
                  
                }else{
                 // alert('Technical Error!!');
				 $('#msgsection').html('<p id="msgsection" class="alert alert-success">'+response.message+'</p>');
                }
				
				setTimeout(function(){ $('#msgsection').html(''); },10000);
              },
              error: function() {
                //alert('Error!');
				window.relode();
              }
            });
		}

        
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
