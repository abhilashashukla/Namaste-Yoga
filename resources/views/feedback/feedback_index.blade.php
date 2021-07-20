@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="x_panel">
    @if ( Session::has('flash_message_feedback') )

  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_feedback') }}
  </div>
  
@endif
      <div class="x_title">
        <h2>Feedback List</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">     
          {{ csrf_field() }}             
          <table id="usersData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                    <th>Sr. No.</th>    
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Date Of Submission</th> 
					  <th>Rating</th>
					  <th>Description</th>
                      <th>Action</th>                   
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                    <tr>                              
                    <th>Sr. No.</th>    
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Date Of Submission</th>  
					  <th>Rating</th>
					  <th>Description</th>					  
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


          table = jQuery('#usersData').DataTable({
            'processing': true,
            'serverSide': true,                        
            'lengthMenu': [
              [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            dom: 'Bfrtip',
          buttons: [                        
            {extend:'csvHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3,4,5,6]//"thead th:not(.noExport)"
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
              'url': '{{ url("/") }}/feedback/feedbackIndexAjax',
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
              //'className': 'col-md-1',
              "sortable": false,
              'render': function(data,type,row){
                  return row.sr_no;
              }
              },
                
              {
                  'data': 'name',
                  //'className': 'col-md-3',
                  'render': function(data,type,row){
                    var name = (row.name.length > 30) ? row.name.substring(0,30)+'...' : row.name;
                    return '<a class="popoverData" data-content="'+row.name+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+name+'</a>';
                  }
              },
              {
                'data': 'email',
                //'className': 'col-md-1'
              },
              {
                  'data': 'phone',
                 // 'className': 'col-md-1'
              },
              {
                  'data': 'created_at',
                  //'className': 'col-md-1',
                  /* 'render': function(data,type,row){
                    return row.created_at; 
                  }*/
              },
			  {
                  'data': 'rating',
                  //'className': 'col-md-1',
                  /* 'render': function(data,type,row){
                    return row.created_at; 
                  }*/
              },
			  {
                  'data': 'rating_description',
                  //'className': 'col-md-3',
                  'render': function(data,type,row){
                    var rating_description = (row.rating_description.length > 30) ? row.rating_description.substring(0,30)+'...' : row.rating_description;
                    return '<a class="popoverData" data-content="'+row.rating_description+'" rel="popover" data-placement="bottom" data-original-title="Rating description" data-trigger="hover">'+rating_description+'</a>';
                  }
              },
			{
                 'data': 'Action',
                 //'className': 'col-md-2',
                 'render': function(data, type, row) {
                  
				   var buttonHtml = '<a href="/feedback/viewfeedback/' + row.id + '" class="btn btn-success" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
				   /* if(row.status==0){
				   buttonHtml += '<a href="/aasana/editaasana/' + row.id + '" class="btn btn-success" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';  */
          //  <a href="/aasana/deleteaasana/' + row.id + '" onclick="return myFunction();" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
				 //}
				  
                  return buttonHtml;
                }
              }
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
