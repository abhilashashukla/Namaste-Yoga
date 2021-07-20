@extends('layout.app')

@section('content')
<div class="right_col" role="main">
  @include('layout/flash')
  <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Quiz Result</h2>

                    <div class="clearfix"></div>
                  </div>
				   <div class="form-group">
                        
                        <div class="col-md-9 col-sm-9 col-xs-12">
						<h4>Quiz Name - {{ucwords($quiz->quiz_name)}}</h4>
                          
                        </div>
                      </div>
					   <div class="clearfix"></div>
                  <div class="x_content">        
					<table id="quizResultTbl" class="table-responsive table table-striped table-bordered" style="font-size:12px;width:100% !important;">
						<thead>
							<tr>
							<th>Sr.No.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Marks Obtained</th>
                            <th>Time Taken</th>
							<th>Details</th>
							</tr>
						</thead>
						<tbody>
						{{-- @if($userArr)
					  @foreach($userArr as $k=>$users)
						<tr>
                            <td>{{$k+1}}</td>
                            <td>{{ucwords($users['name'])}}</td>
                            <td>{{$users['email']}}</td>
                            <td>{{$users['correct_answer']}}</td>
                            <td>{{$users['quiz_responses_time']}}</td>
                            <td><a href="javascript:void(0)" class="btn btn-success viewQuizDetilsByUser"  data-user-id="{{$users['user_id']}}" data-quiz-id="{{$users['quiz_id']}}" title="View details" ><i class="fa fa-eye" aria-hidden="true"></i></a></td>
						</tr>
						@endforeach
						@endif
						--}}
						</tbody>
						<tfoot>
							<tr>
							<th>Sr.No.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Marks Obtained</th>
                            <th>Time Taken</th>
							<th>Details</th>
							</tr>
							
						</tfoot>
					</table>
					<div class="form-group" style="text-align: center;">
					
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="button" class="btn btn-primary" onclick="location.href='{{ url('/') }}/quiz'">Back</button>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
			  
			  
			  
</div>

<script>   
var table = '';
let quiz_id = '{{$quiz->id}}'; //alert(id)
        $(document).ready(function() {
          
					//var permissonObj = '<%-JSON.stringify(permission)%>';
					//permissonObj = JSON.parse(permissonObj);


          table = $('#quizResultTbl').DataTable({
            'processing': true,
            'serverSide': true,                        
            'lengthMenu': [
              [10, 25, 50], [10, 25, 50]
            ],
            dom: 'Bfrtip',
            buttons: [                        
            {extend:'csvHtml5',
              exportOptions: {
                columns: [0, 1, 2, 3,4]//"thead th:not(.noExport)"
              }
            },
            'pageLength'
            ],
            'sPaginationType': "simple_numbers",
            'searching': true,
            "bSort": false, 			
            'ajax': {
              'url': '{{ url("/") }}/quiz/getResultbyQuiz',
              'headers': {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              'type': 'post',
              'data':  {quiz_id},
            },          

            'columns': [
                {
				'data': 'Sr.No.',
				"sortable": false,
				'render': function(data,type,row){
						return row.sr_no;
				}
			  }, 
              {
                  'data': 'name',
                  'render': function(data,type,row){
                    var name = (row.name.length > 30) ? row.name.substring(0,30)+'...' : row.name;
                    return '<a class="popoverData" data-content="'+row.name+'" rel="popover" data-placement="bottom" data-original-title="Name" data-trigger="hover">'+name+'</a>';
                  }
              },
              {
                  'data': 'email',
                  'className': 'col-md-1',
                  'render': function(data,type,row){
                    return row.email;
                  }
              },
              
              {
                  'data': 'marks obtained',
                  'render': function(data,type,row){
                    return row.correct_answer;
                  }
              },
			  {
                  'data': 'time taken',
                  'render': function(data,type,row){
                    return row.quiz_responses_time;
                  }
              },			  
               {
                 'data': 'Details',
                 'className': 'col-md-1',
                 'render': function(data, type, row) {
                  
				   var buttonHtml = '<a href="javascript:void(0)" class="btn btn-success viewQuizDetilsByUser"  data-user-id="' + row.user_id + '" data-quiz-id="' + row.quiz_id + '" title="View details" ><i class="fa fa-eye" aria-hidden="true"></i></a>';
				  
				
                  return buttonHtml;
                }
              }
            ]
          });   
              
          $('.buttons-csv').attr('title','Download');
  });
</script>
@endsection