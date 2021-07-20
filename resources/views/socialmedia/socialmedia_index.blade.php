@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<style>
#SocialMediaDataList {
  table-layout: fixed;
  width: 100% !important;
}
#SocialMediaDataList td,
#SocialMediaDataList th{
  width: auto !important;
  white-space: normal;
  text-overflow: ellipsis;
  overflow: hidden;
}
</style>
<div class="right_col clearfix" role="main">
@include('layout/errors')
  <div class="x_panel">
      <?php if (Session::has('flash_message_for_media_view')){?>

  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_media_view') }}
  </div>
<?php } else if (Session::has('flash_message_for_media_edit')){?>
  <div class="alert {{ Session::get('flash_type') }}">
      {{ Session::get('flash_message_for_media_edit') }}
  </div>
<?php }?>
      <div class="x_title">
        <h2>Social Media List</h2>

        <div class="clearfix"></div>
			
      </div>
      <div class="x_content"> 
	  <p id="msgshowforstatus"> </p>
		<!--<div class="search-area pull-right width-auto">
			<a href="/socialmedia/addsocialmedia" class="pull-right btn btn-success">Add Social Media</a>
		</div>-->
          {{ csrf_field() }}             
          <table id="SocialMediaDataList" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important">
              <thead>
                  <tr>
                      <th>Sr. No.</th>                      
                      <th>Organization</th>                      
                      <th>facebook Link</th>  
                      <th>Twitter Link</th>                      
                      <th>Instagram Link</th>
                      <th>Youtube Link</th>
                      <th>Other Link</th>                                                 
					  <th> Status </th>	
                    <th>Action</th> 
                  </tr>
              </thead>
              <tbody>
                            
              </tbody>
              <tfoot>
                 <tr>                              
                     <th>Sr. No.</th>
                     <th>Organization</th>                      
                      <th>facebook Link</th>  
                      <th>Twitter Link</th>                      
                      <th>Instagram Link</th>
                      <th>Youtube Link</th>
                      <th>Other Link</th>
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


          table = jQuery('#SocialMediaDataList').DataTable({
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
              'url': '{{ url("/") }}/socialmedia/socialmediaIndexAjax',
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
                  'data': 'organization_name',
                  //'className': 'col-md-2',
                  'render': function(data,type,row){
                    var organization_name = (row.organization_name.length > 30) ? row.organization_name.substring(0,30)+'...' : row.organization_name;
                    return '<a class="popoverData" data-content="'+row.organization_name+'" rel="popover" data-placement="bottom" data-original-title="Organization Name" data-trigger="hover">'+organization_name+'</a>';
                  }
              },
			  {
                  'data': 'org_facebook',
                 // 'className': 'col-md-1',
                  'render': function(data,type,row){
                    var org_facebook = (row.org_facebook.length > 30) ? row.org_facebook.substring(0,30)+'...' : row.org_facebook;
                    return '<a class="popoverData" data-content="'+row.org_facebook+'" rel="popover" data-placement="bottom" data-original-title="Facebook Link" data-trigger="hover">'+org_facebook+'</a>';
                  }
              },
             
			   {
                  'data': 'org_twitter',
                  //'className': 'col-md-1',
                  'render': function(data,type,row){
                    var org_twitter = (row.org_twitter.length > 30) ? row.org_twitter.substring(0,30)+'...' : row.org_twitter;
                    return '<a class="popoverData" data-content="'+row.org_twitter+'" rel="popover" data-placement="bottom" data-original-title="Twitter Link" data-trigger="hover">'+org_twitter+'</a>';
                  }
              },
              
                {
                    'data': 'org_instagram',
                    //'className': 'col-md-1',
                    'render': function(data,type,row){
                      var org_instagram = (row.org_instagram.length > 30) ? row.org_instagram.substring(0,30)+'...' : row.org_instagram;
                      return '<a class="popoverData" data-content="'+row.org_instagram+'" rel="popover" data-placement="bottom" data-original-title="Instagram Link" data-trigger="hover">'+org_instagram+'</a>';
                    }
                },
                {
                    'data': 'org_youtube',
                    'render': function(data,type,row){
                      var org_youtube = (row.org_youtube.length > 30) ? row.org_youtube.substring(0,30)+'...' : row.org_youtube;
                      return '<a class="popoverData" data-content="'+row.org_youtube+'" rel="popover" data-placement="bottom" data-original-title="Youtube Link" data-trigger="hover">'+org_youtube+'</a>';
                    }
                },
           
			   {
                  'data': 'org_other',
                  //'className': 'col-md-1',
                  'render': function(data,type,row){
                    var org_other = (row.org_other.length > 30) ? row.org_other.substring(0,30)+'...' : row.org_other;
                    return '<a class="popoverData" data-content="'+row.org_other+'" rel="popover" data-placement="bottom" data-original-title="Other Link" data-trigger="hover">'+org_other+'</a>';
                  }
              },
             
               
              {
                'data': 'Status',
                //'className': 'col-md-1',
                'render': function(data,type,row){
                    var html = '';
                    @if(Auth::user()->role_id==1)
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
                  
				   var buttonHtml = '<a href="/socialmedia/viewsocialmedia/' + row.id + '" class="btn btn-success" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
				   if(row.status==0){
				   buttonHtml += '<a href="/socialmedia/editsocialmedia/' + row.id + '" class="btn btn-success" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><a href="/socialmedia/deletesocialmedia/' + row.id + '" onclick="return myFunction();" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				 }
				   return buttonHtml;
                }
              }
            ]
          });   
              
          
        });


  function myFunction() {
      if(!confirm("Are you sure, you want to delete this social media?"))
      event.preventDefault();
  }
  
 

//  $(document).on('click','.aasana_deleteSubCategory',function(){ 
//         let id = $(this).attr('id');
//         if(confirm('Are you sure, you want to delete this sub category?')==true){
//             $.ajax({
//                 url:'deletesubcategory/'+id,
//                 type:'POST',
//                 headers:{
//                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
//                 },
//                 data:{id},
//                 success:(data)=>{
// 				       alertr(data);
				   
//                 }
//             })
//         }
//     });
 

        
        function ValidateEmail(email){
          if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            return true;
          }
          return false;
        }

/*         function changeStatus(social_media_id,val){ 
          jQuery.ajax({
              url: '/socialmedia/changestatussocialmedia',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"social_media_id": social_media_id
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
        } */
		
		function changeStatus(social_media_id,val){ 
		$('#confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).find('.modal-body').html('<p>Are you sure want to change the status of this record, do you want to continue?</p><input type="hidden" id="hidden_val" value="'+val+'"><input type="hidden" id="hidden_social_media_id" value="'+social_media_id+'">');
				
		}
		
		$(document).on('click','#continue1',function(){
			var val = $('#hidden_val').val();
			var social_media_id = $('#hidden_social_media_id').val();	
          jQuery.ajax({
              url: '/socialmedia/changestatussocialmedia',
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              data: {
                "status": val,"social_media_id": social_media_id
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
