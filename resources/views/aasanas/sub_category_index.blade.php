@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="right_col clearfix" role="main">
@include('layout/errors')
  <div class="x_panel">
    <?php if (Session::has('flash_message_for_aasana_subcategory_view')){?>

  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_aasana_subcategory_view') }}
  </div>
<?php } else if (Session::has('flash_message_for_aasana_subcategory_edit')){?>
  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_aasana_subcategory_edit') }}
  </div>
<?php }?>
      <div class="x_title">
        <h2>Aasana Sub Category List</h2>

        <div class="clearfix"></div>
			
      </div>
      <div class="x_content"> 
	  <p id="msgshowforstatus"> </p>
		<!--<div class="search-area pull-right width-auto">
			<a href="/aasana/addsubcategory" class="pull-right btn btn-success">Add Sub Category</a>
		</div>-->
          {{ csrf_field() }}             
          <table id="aasanaCategoryDataList" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>Sr. No.</th>                      
                      <th>Sub Category Name</th>                      
                      <th>Category Description</th>
                      <th>Category Name</th>                        
                      <th>Image</th>
					           <th> Status </th>	
                    <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                 <tr>                              
                     <th>Sr. No.</th>
                     <th>Sub Category Name</th>                      
                      <th>Sub Category Description</th>  
                      <th>Category Name</th>                      
                      <th>Image</th>
					            <th> Status </th>	
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


          table = jQuery('#aasanaCategoryDataList').DataTable({
            'processing': true,
            'serverSide': true,
			//'scrollX':true,
            'lengthMenu': [
              [10, 25, 50, -1], [10, 25, 50, 'All']
            ],
            dom: 'Bfrtip',
            buttons: [                        
            {extend:'csvHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3]//"thead th:not(.noExport)"
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
              'url': '{{ url("/") }}/aasana/subcategoryIndexAjax',
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
                  'data': 'subcategory_name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var subcategory_name = (row.subcategory_name.length > 30) ? row.category_name.substring(0,30)+'...' : row.subcategory_name;
                    return '<a class="popoverData" data-content="'+row.subcategory_name+'" rel="popover" data-placement="bottom" data-original-title="Sub Category Name" data-trigger="hover">'+subcategory_name+'</a>';
                  }
              },
			   {
                  'data': 'subcategory_description',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var subcategory_description = (row.subcategory_description.length > 30) ? row.subcategory_description.substring(0,30)+'...' : row.subcategory_description;
                    return '<a class="popoverData" data-content="'+row.subcategory_description+'" rel="popover" data-placement="bottom" data-original-title="Sub Category Description" data-trigger="hover">'+subcategory_description+'</a>';
                  }
              },
            /*   {
                  'data': 'subcategory_description',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.subcategory_description;
                  }
              }, */
              
              {
                  'data': 'category_name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var category_name = (row.category_name.length > 30) ? row.category_name.substring(0,30)+'...' : row.category_name;
                    return '<a class="popoverData" data-content="'+row.category_name+'" rel="popover" data-placement="bottom" data-original-title="Category Name" data-trigger="hover">'+category_name+'</a>';
                  }
              },
              
              {
                  'data': 'subcategory_image',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    if(row.subcategory_image){						
                    return '<a href="'+row.subcategory_image+'" target="_blank"><img src="'+row.subcategory_image+'" width="100" height="100"></a>';
					}
					else
					{
						return '';
					}
                  }
              },
              {
                'data': 'Status',
                'className': 'col-md-1',
                'render': function(data,type,row){
                    var html = '';
                    @if(Auth::user()->role_id==4)
                      if(row.status==1){
                        html = '<i class="fa fa-toggle-on" onclick="changeStatus('+row.id+',0)" style="color:green;font-size:20px;"></i>';
                      }else{
                        html = '<i class="fa fa-toggle-off" onclick="changeStatus('+row.id+',1)" style="color:red;font-size:20px;"></i>';
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
                  
				   var buttonHtml = '<a href="/aasana/viewsubcategory/' + row.id + '" class="btn btn-success" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
				   if(row.status==0){
				   buttonHtml += '<a href="/aasana/editsubcategory/' + row.id + '" class="btn btn-success" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				   /* <a href="/aasana/deletesubcategory/' + row.id + '" onclick="return myFunction();" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> */
				 }
				  
                  return buttonHtml;
                }
              }
            ]
          });   
              
          
        });


  function myFunction() {
      if(!confirm("Are you sure, you want to delete this sub category?"))
      event.preventDefault();
  }
 

 $(document).on('click','.aasana_deleteSubCategory',function(){ 
        let id = $(this).attr('id');
        if(confirm('Are you sure, you want to delete this sub category?')==true){
            $.ajax({
                url:'deletesubcategory/'+id,
                type:'POST',
                headers:{
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data:{id},
                success:(data)=>{
				       alertr(data);
				   
                }
            })
        }
    });
 

        
        function ValidateEmail(email){
          if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
          }
          return false;
        }
		function changeStatus(subcategory_id,val){ 
		$('#confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).find('.modal-body').html('<p>Are you sure want to change the status of this record, do you want to continue?</p><input type="hidden" id="hidden_val" value="'+val+'"><input type="hidden" id="hidden_sub_category_id" value="'+subcategory_id+'">');
				
		}	
        $(document).on('click','#continue1',function(){
		var val = $('#hidden_val').val();
		var subcategory_id = $('#hidden_sub_category_id').val();	
          jQuery.ajax({
              url: '/aasana/changestatussubcategory',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"subcategory_id": subcategory_id
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
