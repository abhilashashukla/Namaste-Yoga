@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="right_col" role="main">
    @include('layout/flash')
    <div class="x_panel">
        <div class="x_title">
            <h2>Rejected Centers</h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <p id="msgshowforstatus"></p>	  
            {{ csrf_field() }}
            
            <table id="usersData" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>User Type</th>
                        <th>City/State/Country</th>
                        <th>Email</th>
                        <!--<th>Seating Capacity</th>-->
                        <th>Approval Status</th>
                        <!--<th>User Status</th>-->
                    </tr>
                </thead>
                
                <tbody></tbody>
                
                <tfoot>
                    <tr>                              
                        <th>Name</th>
                        <th>Phone</th>                      
                        <th>User Type</th>
                        <th>City/State/Country</th>
                        <th>Email</th>
                        <!--<th>Seating Capacity</th>-->
                        <th>Approval Status</th>
                        <!--<th>User Status</th>-->
                    </tr>
                </tfoot>
            </table>                              
        </div>
    </div>
    
    
    <script>
        var table = '';
        
        jQuery(document).ready(function() {
                    
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
                'url': '{{ url("/") }}/rejectedCentersAjax',
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
                    return row.city.name + ' / ' + row.state.name + ' / ' + row.country.name;
                }
                },
                {
                    'data': 'email',
                    'className': 'col-md-1'
                },
                /*{
                    'data': 'sitting_capacity',
                    'className': 'col-md-1'
                },*/
                {
                    'data': 'approved_status',
                    'className': 'col-md-4',
                    'render': function(data,type,row) {
                        var html = '';
                        if(row.status == '0') {
                            html += 'Pending';
                        } else if(row.status == '1') {
                            html += 'Approved';
                        } else if(row.status == '2') {
                            html += 'Reject';
                        }
                        return html;
                    }              
                },
                /*{
                    'data': 'status',
                    'className': 'col-md-4',
                    'render': function(data,type,row) {
                        var html = '';
                        if(row.status == '0') {
                            html += 'Pending';
                        } else if(row.status == '1') {
                            html += 'Approve';
                        }
                        return html;
                    }              
                }*/
            ]
            });
        });
        
    </script>
      
    <style>
        .dataTables_paginate a {
            background-color:#fff !important;
        }
        .dataTables_paginate .pagination>.active>a {
            color: #fff !important;
            background-color: #337ab7 !important;
        }

        #usersData {
            table-layout: fixed;
            width: 100% !important;
        }
        #usersData td, #usersData th{
            width: auto !important;
            white-space: normal;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>
    
@endsection 