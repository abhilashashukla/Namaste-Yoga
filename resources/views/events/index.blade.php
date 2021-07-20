@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<style>
#eventsData {
  table-layout: fixed;
  width: 100% !important;
}
#eventsData td,
#eventsData th{
  width: auto !important;
  white-space: normal;
  text-overflow: ellipsis;
  overflow: hidden;
}

.success-event{
	color:#28a745;
    display: block;
    font-size: 1.3em;
	
}
</style>
<div class="right_col" role="main">
@include('layout/errors')
  <div class="x_panel">
        <?php if (Session::has('flash_message_for_event_edit')){?>

  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_event_edit') }}
  </div>
		<?php }?>
      <div class="x_title">
        <h2>Event List</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
		<p id="msgshowforstatus"> </p>	
	          {{ csrf_field() }}             
          <table id="eventsData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      
                      <th>Event Name</th>
                      <th>Phone</th>
                      <th>Contact Person</th>
                      <th>City/State/Country</th>
                      <th>Email</th>
                      <th>Address</th>                      
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Created Date</th> 
                      <th class="noExport">Status</th>
                      <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                    <tr>                              
                    <th>Event Name</th>
                      <th>Phone</th>
                      <th>Contact Person</th>
                      <th>City/State/Country</th>
                      <th>Email</th>
                      <th>Address</th>      
                      <th>Start Date</th>
                      <th>End Date</th>              
                      <th>Created Date</th>   
                      <th class="noExport">Status</th>
                      <th>Action</th> 
                  </tr>
              </tfoot>
          </table>                              
        </div>
</div>
</div>
          
<script>
        
        var table = '';
        jQuery(document).ready(function() {
				 
          
					//var permissonObj = '<%-JSON.stringify(permission)%>';
					//permissonObj = JSON.parse(permissonObj);


          table = jQuery('#eventsData').DataTable({
            'processing': true,
            'serverSide': true,                        
            'lengthMenu': [
              [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [                        
            {extend:'csvHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]//"thead th:not(.noExport)"
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

/*         "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        }, */

						"initComplete": function(settings, json) {						
              //jQuery('.popoverData').popover();
					  },
            'ajax': {
              'url': '{{ url("/") }}/events/eventIndexAjax',
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
                  'data': 'event_name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var event_name = (row.event_name.length > 30) ? row.event_name.substring(0,30)+'...' : row.event_name;
                    return '<a class="popoverData" data-content="'+row.event_name+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+event_name+'</a>';
                  }
              },
              {
                  'data': 'contact_no',
                  'className': 'col-md-1'
              },
              {
                  'data': 'contact_person',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.contact_person;
                  }
              },
              {
                'data': 'City/State/Country',
                'className': 'col-md-2',
                'render': function(data,type,row){
                    return row.city.name+'/'+row.state.name+'/'+row.country.name;
                  }
              },
			  {
                'data': 'email',
                'className': 'col-md-1',
                'render': function(data,type,row){
                    var email = (row.email.length > 30) ? row.email.substring(0,30)+'...' : row.email;
                    
                    return '<a class="popoverData" data-content="'+row.email+'" rel="popover" data-placement="bottom" data-original-title="email" data-trigger="hover">'+email+'</a>';
                  }              
              },
             /*  {
                'data': 'email',
                'className': 'col-md-1'
              }, */
              {
                'data': 'Address',
                'className': 'col-md-2',
                'render': function(data,type,row){
                    var address = (row.address.length > 30) ? row.address.substring(0,30)+'...' : row.address;
                    
                    return '<a class="popoverData" data-content="'+row.address+'" rel="popover" data-placement="bottom" data-original-title="Address" data-trigger="hover">'+address+'</a>';
                  }              
              },
              {
                'data': 'start_time',
                'className': 'col-md-1'           
              },
              {
                'data': 'end_time',
                'className': 'col-md-1'           
              },
              {
                'data': 'created_at',
                'className': 'col-md-1'           
              },			  
			 {
                    'data': 'status',
                    'className': 'col-md-4',
                    'render': function(data,type,row) {
                        var html = '';
                        if(row.status == '1') {
                        html += '<i class="fa fa-toggle-on" onclick="changeStatusToggle('+row.id+',1)" style="color:green;font-size:20px;"></i>';
                        } else if(row.status == '3'){
                         html += '<i class="fa fa-toggle-off" onclick="changeStatusToggle('+row.id+',3)" style="color:red;font-size:20px;"></i>';
                        }
                        return html;
                    }              
                }, 				
				{
                'data': 'Action',
                 'className': 'col-md-1',
                'render': function(data, type, row) 
				{
					//alert(row.isedit);
					
						  var buttonHtml = '<a href="/events/edit/' + row.id + '" class="btn btn-success" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>'	       
						  return buttonHtml;
					
					
					
               }
			   }
            ]
          });   
              
          
        });        

		 function changeStatusToggle(eventid,val){ 
		$('#confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).find('.modal-body').html('<p>Are you sure want to change the status of this record, do you want to continue?</p><input type="hidden" id="hidden_val" value="'+val+'"><input type="hidden" id="hidden_event_id" value="'+eventid+'">');
				
		}	

       $(document).on('click','#continue1',function(){
			var val = $('#hidden_val').val();
			var eventid = $('#hidden_event_id').val();
          jQuery.ajax({
              url: '/events/changestatustoggle',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"eventid": eventid
              },
              success: function(response) {
                //response = JSON.parse(response);                
             $('#confirm').modal('hide');
					table.draw();			
                if(response.status==1){
					 
					setTimeout(function(){
						$('#msgshowforstatus').html('<p id="msgshowforstatus" class="alert alert-success">'+response.message+'</p>');
					},1000);
                  //alert(response.message);
                  
                }else{
                 // alert('Technical Error!!');
				 $('#msgshowforstatus').html('<p id="msgshowforstatus" class="alert alert-success">'+response.message+'</p>');
                }
				
				setTimeout(function(){ $('#msgshowforstatus').html(''); },10000);
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
