@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<style>
#usersData {
  table-layout: fixed;
  width: 100% !important;
}
#usersData td,
#usersData th{
  width: auto !important;
  white-space: normal;
  text-overflow: ellipsis;
  overflow: hidden;
}
</style>
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
      <div class="x_title">
        <h2>User List</h2>

        <div class="clearfix"></div>
		
      </div>
	  
      <div class="x_content"> 
	<p id="msgshowforstatus"> </p>	  
          {{ csrf_field() }}             
          <table id="usersData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      
                      <th>Name</th>
                      <th>Phone</th>                      
                      <th>User Type</th>
                      <th>City/State/Country</th>
                      <th>Email</th>
                      <th>YCB Number</th>                           
					  <th>YCB Approval Status</th>                      
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                    <tr>                              
                      <th>Name</th>
                      <th>Phone</th>                      
                      <th>User Type</th>
                      <th>City/State/Country</th>
                      <th>Email</th>
                      <th>YCB Number</th>     
					  <th>YCB Approval Status</th>				                        
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


          table = jQuery('#usersData').DataTable({
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
					columns: [0, 1, 2, 3, 4, 5]//"thead th:not(.noExport)"
				}
            },
       /*      { extend: 'pdfHtml5',
              exportOptions: {
                columns: "thead th:not(.noExport)"
              },
              customize : function(doc){
                    var colCount = new Array();
                    var length = $('#reports_show tbody tr:first-child td').length;
                    //console.log('length / number of td in report one record = '+length);
                    $('#reports_show').find('tbody tr:first-child td').each(function(){
                        if($(this).attr('colspan')){
                            for(var i=1;i<=$(this).attr('colspan');$i++){
                                colCount.push('*');
                            }
                        }else{ colCount.push(parseFloat(100 / length)+'%'); }
                    });
              }
            }, */
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
              'url': '{{ url("/") }}/userPendingIndexAjax',
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
                  'data': 'name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var name = (row.name.length > 30) ? row.name.substring(0,30)+'...' : row.name;
                    return '<a class="popoverData" data-content="'+row.name+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+name+'</a>';
                  }
              },
              {
                  'data': 'phone',
                  'className': 'col-md-1'
              },
              {
                  'data': 'role_id',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.role.role;
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
                'className': 'col-md-1'
              },
              {
                'data': 'ycb_number',
                'className': 'col-md-2',
                'render': function(data,type,row){
                                        
                    return row.ycb_number;
                  }              
              },
              {
                'data': 'ycb_approved',
                'className': 'col-md-4',
                'render': function(data,type,row){
                    var html = '';       
                    @if(Auth::user()->role_id==4)             
                    if(row.ycb_approved=='0'){
                      html = '<input type="radio" value="0" onclick="changeYCBStatus('+row.id+',0)" checked> Pending | ';
					  html += '<input type="radio" name="approve" value="1" onclick="changeYCBStatus('+row.id+',1)"> Approve | ';
					  html += '<input type="radio" name="reject" value="2" onclick="changeYCBStatus('+row.id+',2)"> Reject  ';
                    }   
                    @else
                        html = (row.ycb_approved=='1') ? 'Approved' : 'Not-Approved';      
                    @endIf              
                    return html;
                  }              
              }            
              // {
              //   'data': 'Action',
              //   'className': 'col-md-2',
              //   'render': function(data, type, row) {
              //     var buttonHtml = '<button type="button" data-id="' + row.id + '" class="btn btn-success update_user roleActionHTML user_addupdateuser" data-toggle="modal" data-target="#userModel" data-whatever="@mdo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> <button type="button" id="' + row.id + '" class="btn btn-danger delete_user roleActionHTML user_deleteUser"><i class="fa fa-trash" aria-hidden="true"></i></button>';
              //     return buttonHtml;
              //   }
              // }
            ]
          });   
              
          
        });

        

        jQuery("body").on("click", ".delete_user", function() {
          var id = jQuery(this).attr("id");

          $.confirm({
              title: '',
              content: 'Are you sure want to delete this user?',
              buttons: {
                  confirm: function () {
                    jQuery.ajax({
                      url: '/users/deleteUser/',
                      type: "POST",
                      data: {
                        "id": id
                      },
                      success: function(response) {
                        if (response["affectedRows"] == 1) {
                          jQuery("#userFilter").trigger("change");
                          table.draw();
                        } else {
                          jQuery.alert({
                            title: "",
                            content: 'Problem in deleted',
                          });
                        }
                        return false;
                      },
                      error: function() {
                        jQuery.alert({
                          title: "",
                          content: 'Technical error',
                        });
                      }
                    });
                  },
                  cancel: function () {
                      return true;
                  }
              }
          });
        });

        function changeStatus(userid,val){
          jQuery.ajax({
              url: '/users/changestatus',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"userid": userid
              },
              success: function(response) {
                //response = JSON.parse(response);                
                if(response.status){
                  alert(response.message);
                  table.draw();
                }else{
                  alert('Technical Error!!');
                }
              },
              error: function() {
                alert('Error!');
              }
            });
        }
		
		function changeYCBStatus(userid,val){ 
		$('#confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).find('.modal-body').html('<p>Are you sure want to change the status of this record, do you want to continue?</p><input type="hidden" id="hidden_val" value="'+val+'"><input type="hidden" id="hidden_user_id" value="'+userid+'">');
				
		}	
		$(document).on('click','#cancel',function(){
		$('input[name="approve"]').prop('checked', false);
		$('input[name="reject"]').prop('checked', false);
		});
				
		$(document).on('click','#continue1',function(){
			var val = $('#hidden_val').val();
			var userid = $('#hidden_user_id').val();		

		  if(val==0){
			  return false;
		  } 	
          jQuery.ajax({
              url: '/users/changeycbstatus',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"userid": userid
              },
              success: function(response) {
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
		
		

        function ValidateEmail(email){
          if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
          }
          return false;
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
