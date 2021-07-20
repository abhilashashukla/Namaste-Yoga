@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<style>
#aasanaDataList {
  table-layout: fixed;
  width: 100% !important;
}
#aasanaDataList td,
#aasanaDataList th{
  width: auto !important;
  white-space: normal;
  text-overflow: ellipsis;
  overflow: hidden;
}
</style>
<div class="right_col clearfix" role="main">
@include('layout/errors')
  <div class="x_panel">
      <?php if (Session::has('flash_message_for_aasana_view')){?>

  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_aasana_view') }}
  </div>
<?php } else if (Session::has('flash_message_for_aasana_edit')){?>
  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_aasana_edit') }}
  </div>
<?php }?>
      <div class="x_title">
        <h2>Aasana List</h2>

        <div class="clearfix"></div>
			
      </div>
      <div class="x_content"> 
	  <p id="msgshowforstatus"> </p>
		<!--<div class="search-area pull-right width-auto">
			<a href="/aasana/addaasana" class="pull-right btn btn-success">Add Aasana</a>
		</div>-->
          {{ csrf_field() }}             
          <table id="aasanaDataList" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>Sr. No.</th>                      
                      <th>Aasana Name</th>                      
                      <!--<th>Aasana Description</th>-->
                      <th>Category</th>                        
                      <th>Subcategory</th>
                      <!--<th>Tags</th> --> 
                      <th>Link</th>                      
                      <th>Duration</th>
                      <!--<th>Benefits</th>-->                     
                      <!--<th>Instructions</th>-->                      
					   <th> Status </th>	
                    <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                 <tr>                              
                     <th>Sr. No.</th>
                     <th>Aasana Name</th>                      
                      <!--<th>Aasana Description</th>--> 
                      <th>Category</th>                      
                      <th>Subcategory</th>
                      <!--<th>Tags</th> -->  
                      <th>Link</th>                      
                      <th>Duration</th>
                       <!--<th>Benefits</th>-->                     
                      <!--<th>Instructions</th>-->                      
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


          table = jQuery('#aasanaDataList').DataTable({
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
                columns: [0, 1, 2, 3, 4, 5]//"thead th:not(.noExport)"
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
              'url': '{{ url("/") }}/aasana/aasanaIndexAjax',
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
                  'data': 'aasana_name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var aasana_name = (row.aasana_name.length > 30) ? row.aasana_name.substring(0,30)+'...' : row.aasana_name;
                    return '<a class="popoverData" data-content="'+row.aasana_name+'" rel="popover" data-placement="bottom" data-original-title="Aasana Name" data-trigger="hover">'+aasana_name+'</a>';
                  }
              },
			  /*   {
                  'data': 'aasana_description',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var aasana_description = (row.aasana_description.length > 30) ? row.aasana_description.substring(0,30)+'...' : row.aasana_description;
                    return '<a class="popoverData" data-content="'+row.aasana_description+'" rel="popover" data-placement="bottom" data-original-title="Aasana Description" data-trigger="hover">'+aasana_description+'</a>';
                  }
              }, */
             /*  {
                  'data': 'aasana_description',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.aasana_description;
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
                  'data': 'subcategory_name',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var subcategory_name = (row.subcategory_name.length > 30) ? row.category_name.substring(0,30)+'...' : row.subcategory_name;
                    return '<a class="popoverData" data-content="'+row.subcategory_name+'" rel="popover" data-placement="bottom" data-original-title="Sub Category Name" data-trigger="hover">'+subcategory_name+'</a>';
                  }
              },
			  /*   {
                  'data': 'assana_tag',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var assana_tag = (row.assana_tag.length > 30) ? row.assana_tag.substring(0,30)+'...' : row.assana_tag;
                    return '<a class="popoverData" data-content="'+row.assana_tag+'" rel="popover" data-placement="bottom" data-original-title="Aasana Tag" data-trigger="hover">'+assana_tag+'</a>';
                  }
              }, */
              
              
             /*  {
                  'data': 'assana_tag',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.assana_tag;
                  }
              }, */
              
              {
                  'data': 'assana_video_id',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    
                    return '<a href="'+row.assana_video_id+'" target="_blank">'+row.assana_video_id+'</a>';
                  }
              },
              {
                  'data': 'assana_video_duration',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.assana_video_duration;
                  }
              },
             /*  {
                  'data': 'assana_benifits',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.assana_benifits;
                  }
              }, */
			/*    {
                  'data': 'assana_benifits',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var assana_benifits = (row.assana_benifits.length > 30) ? row.assana_benifits.substring(0,30)+'...' : row.assana_benifits;
                    return '<a class="popoverData" data-content="'+row.assana_benifits+'" rel="popover" data-placement="bottom" data-original-title="Aasana Benefits" data-trigger="hover">'+assana_benifits+'</a>';
                  }
              }, */
			  /*  {
                  'data': 'assana_instruction',
                  'className': 'col-md-2',
                  'render': function(data,type,row){
                    var assana_instruction = (row.assana_instruction.length > 30) ? row.assana_instruction.substring(0,30)+'...' : row.assana_instruction;
                    return '<a class="popoverData" data-content="'+row.assana_instruction+'" rel="popover" data-placement="bottom" data-original-title="Assana Instruction" data-trigger="hover">'+assana_instruction+'</a>';
                  }
              }, */
             /*  {
                  'data': 'assana_instruction',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.assana_instruction;
                  }
              }, */
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
                  
				   var buttonHtml = '<a href="/aasana/viewaasana/' + row.id + '" class="btn btn-success" onclick="return statusconfirm();"><i class="fa fa-eye" aria-hidden="true"></i></a>';
				   if(row.status==0){
				   buttonHtml += '<a href="/aasana/editaasana/' + row.id + '" class="btn btn-success" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
				   /* <a href="/aasana/deleteaasana/' + row.id + '" onclick="return myFunction();" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> */
				 }
				  
                  return buttonHtml;
                }
              }
            ]
          });   
              
          
        });




  function myFunction() {
      if(!confirm("Are you sure, you want to delete this aasana?"))
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
		function changeStatus(aasana_id,val){ 
		$('#confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).find('.modal-body').html('<p>Are you sure want to change the status of this record, do you want to continue?</p><input type="hidden" id="hidden_val" value="'+val+'"><input type="hidden" id="hidden_aasana_id" value="'+aasana_id+'">');
				
		}

        $(document).on('click','#continue1',function(){
		var val = $('#hidden_val').val();
		var aasana_id = $('#hidden_aasana_id').val();
          jQuery.ajax({
              url: '/aasana/changestatusaasana',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"aasana_id": aasana_id
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
