//poll add more functionality
$(document).ready(function(){
	$('.submitPolls').removeAttr('disabled');
	$('.submitQuiz').removeAttr('disabled');
	$('.submitQuestions').removeAttr('disabled');


	$('.sendNotification').removeAttr('disabled');
	$('.validateModerator').removeAttr('disabled');
	
	
	$('body').on('click','#addMorebtn',function(){
		let len = $('.dynamicFields').length; 
		let ques_count = len+1;
		let key = parseInt($('#lastKey').val());
		let c = key+1;
		
		
		if(len<=4){
			let html = '<div class="dynamicFields"><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12 qlabel">Question '+c+'</label><div class="col-md-8 col-sm-8 col-xs-12"><input type="text" name="questions['+key+']" id="question_'+key+'" class="form-control questions"></div><label class="col-md-1 col-sm-1 col-xs-12"><button type="button" id="" class="btn btn-danger deleteRow"><i class="fa fa-trash" aria-hidden="true"></i></button></label></div> <div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 1"></div><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 2"></div></div></div></div> <div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 3"></div><div class="col-md-6 col-sm-6 col-xs-12"> <input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 4"></div> </div></div></div></div>';
			$('.dynamicFields:last').after(html);
			let k = key+1;
			$('#lastKey').val(k);
		}
		if(ques_count==5)
		$(this).hide();
		
		$('.qlabel').each(function(i,v){
			let j =i+1;
			$(this).text('Question '+j);
		});
	});
	
	/*$('body').on('click','#addMoreQuestions',function(){
		let len = $('.dynamicFields').length; 
		let ques_count = len+1;
		let key = parseInt($('#lastKey').val()); 
		let c = key+1;
		//alert(c);
		if(len<=4){
			let html = '<div class="dynamicFields"><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12 qlabel">Question '+c+'</label><div class="col-md-8 col-sm-8 col-xs-12"><input type="text" name="questions['+key+']" id="question_'+key+'" class="form-control questions"></div><label class="col-md-1 col-sm-1 col-xs-12"><button type="button" id="" class="btn btn-danger deleteRow"><i class="fa fa-trash" aria-hidden="true"></i></button></label></div> <div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 1"></div><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 2"></div></div></div></div> <div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 3"></div><div class="col-md-6 col-sm-6 col-xs-12"> <input type="text" name="options['+key+'][]" class="form-control margin-bottom options_'+key+'" placeholder="Option 4"></div> </div></div></div></div>';
			$('.dynamicFields:last').after(html);
			let k = key+1;
			$('#lastKey').val(k);
		}
		if(ques_count==5)
		$(this).hide();
		
		$('.qlabel').each(function(i,v){
			let j =i+1;
			$(this).text('Question '+j);
		});
	});*/
	$('body').on('click','.deleteRow',function(){
		var $this = this;
		$('#delete_confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).on('click','#continue2',function(){
					$('#delete_confirm').modal('hide');	
					$($this).closest(".dynamicFields").remove();
					let len = $('.dynamicFields').length;
					if(len<5){
					//$('#addMorebtn').show();
					var url_string = location.href;
						let arr = url_string.split('/');
						let el = arr[arr.length-1];
						if($.isNumeric(el))
						{
							let qCount = parseInt($('#qCount').val());
							if(qCount==5){
								$('.ln_solid').html('<div class="form-group"><a href="javascript:void(0)" id="addMorebtn" class="btn btn-primary pull-right">Add More</a></div><div class="ln_solid"></div>');
							}else
								$('#addMorebtn').show(); 
						}
						else
						$('#addMorebtn').show(); 
					}
					
					$('.qlabel').each(function(i,v){
						let j =i+1;
						$(this).text('Question '+j);
					});
		}).find('.modal-body').html('<p>Are you sure?</p>');
		
	});
	
	$('body').on('click','.submitPolls',function(){
		
		var cond = true;
		var cond1 = true;
		let poll_name = $("input[name=poll_name]").val();
		
		if(poll_name==''){
			$("input[name=poll_name]").css('border','red 1px solid').attr('placeholder','Please enter poll name');
			return false;
		}
		if(poll_name.length>255){
			$("input[name=poll_name]").css('border','red 1px solid').attr('title','Poll name should be greate than 255');
			return false;
		}
		$('.questions').each(function(i,v){
			var ids = $(this).attr('id'); 
			var idArr = ids.split('_');
			var id =  idArr[1];
			if($(this).val()==''){
				$(this).css('border','red 1px solid').attr('placeholder','Please enter question');
				cond = false;
			}
			if($(this).val().length>255){
				$(this).css('border','red 1px solid').attr('title','Question should be greate than 255');
				cond = false;
			}
			$('.options_'+id).each(function(){
				if($(this).val()==''){
					$(this).css('border','red 1px solid').attr('placeholder','Please enter option');
					cond1 = false;
				}
				if($(this).val().length>255){
				$(this).css('border','red 1px solid').attr('title','Option should be greate than 255');
				cond1 = false;
			}
			})
		});
		
		if(cond==false)
			return false;
		if(cond1==false)
			return false;

	});
	$("input[name=poll_name]").focus(function(){
		$(this).css('border','#ccc 1px solid');
	});
	$('.questions').each(function(i,v){
		var thisID = $(this).attr('id');
		$('#'+thisID).focus(function(){
			$(this).css('border','#ccc 1px solid');
		});
		
		$('.options_'+i).each(function(){
			$('.options_'+i).focus(function(){
				$('.options_'+i).css('border','#ccc 1px solid');
			});
		});
	});
	
	
	$(document).on('click','.deletePolls',function(){ 
        let id = $(this).attr('id');
		$('#delete_confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).on('click','#continue2',function(){
					$.ajax({
						url:'/polls/destroy',
						type:'POST',
						headers:{
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						},
						data:{id},
						success:(data)=>{
							$('#delete_confirm').modal('hide');	
							table.draw();
							setTimeout(function(){
								$('#msgsection').html('<p id="msgsection" class="alert alert-success">'+data+'</p>');
							},1000);
						   //alert(data);
						   setTimeout(function(){ $('#msgsection').html(''); },10000);
						}
					});
				}).find('.modal-body').html('<p>Are you sure, you want to delete this poll?</p>');
        
    });
	//Poll Module ends here
	
	//Quis module start from here
	$('body').on('click','.submitQuiz',function(){
		let quiz_name = $("input[name=quiz_name]").val();
		let quiz_time = $("input[name=quiz_time]").val();
		let valid_for = $("input[name=valid_for]").val();
		let max = parseInt($("#valid_for").attr('max'));
        let min = parseInt($("#valid_for").attr('min'));
		
		if(quiz_name==''){
			$("input[name=quiz_name]").css('border','red 1px solid').attr('placeholder','Please enter quiz name');
			return false;
		}
		if(quiz_name.length>255){
			$("input[name=quiz_name]").css('border','red 1px solid').attr('title','Length of a quiz name should not be greater then 255 characters');
			return false;
		}
		/* if(quiz_time==''){
			$("input[name=quiz_time]").css('border','red 1px solid').attr('placeholder','Please enter quiz time');
			return false;
		}
		if(isNaN(quiz_time)){
			$("input[name=quiz_time]").css('border','red 1px solid').val('').attr('placeholder','Invlaid input');
			return false;
		} */
		if(valid_for==''){
			$("input[name=valid_for]").css('border','red 1px solid').attr('placeholder','Please enter quiz valid for');
			return false;
		}
		if(isNaN(valid_for)){
			$("input[name=valid_for]").css('border','red 1px solid').val('').attr('placeholder','Invlaid input');
			return false;
		}
		
        if ($("#valid_for").val() > max)
        {
              $("#valid_for").val(max);
			  $("input[name=valid_for]").css('border','red 1px solid').val('').attr('placeholder','Please enter days less than or equal 365');
               return false;
			  
			  
        }
        if ($("#valid_for").val() < min)
        {
              $("#valid_for").val(min);
			   $("input[name=valid_for]").css('border','red 1px solid').val('').attr('placeholder','Please enter days greater than 0');			 
               return false;
        } 
	});
	$("input[name=quiz_name],input[name=valid_for]").focus(function(){
		$(this).css('border','#ccc 1px solid').attr('placeholder','')
	});
	//add more questions
	$('body').on('click','#addMoreRows',function(){
		let len = $('.dynamicFields').length; 
		let ques_count = len+1;
		let key = parseInt($('#lastKey').val()); 
		let c = key+1;
		
		
		if(len<=4){
			let html = '<div class="dynamicFields"><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12 qlabel">Question 1</label><div class="col-md-8 col-sm-8 col-xs-12"><input type="text" name="questions['+key+']" id="question_'+key+'" class="form-control questions"></div><label class="col-md-1 col-sm-1 col-xs-12"><button type="button" id="" class="btn btn-danger deleteRow"><i class="fa fa-trash" aria-hidden="true"></i></button></label> </div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-12 col-sm-12 col-xs-12 radio-txtbox-row">	<input class="form-check-input answer_'+key+'" type="radio" name="answer['+key+']" value="0" title="Choose Correct Answer"><input type="text" name="options['+key+'][]" class="form-control options_'+key+'" placeholder="Option 1"></div></div></div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-12 col-sm-12 col-xs-12 radio-txtbox-row"><input class="form-check-input answer_'+key+'" type="radio" name="answer['+key+']" value="1" title="Choose Correct Answer"><input type="text" name="options['+key+'][]" class="form-control options_'+key+'" placeholder="Option 2"></div></div></div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-12 col-sm-12 col-xs-12 radio-txtbox-row"><input class="form-check-input answer_'+key+'" type="radio" name="answer['+key+']" value="2" title="Choose Correct Answer"><input type="text" name="options['+key+'][]" class="form-control options_'+key+'" placeholder="Option 3"></div></div></div></div> <div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12"></label><div class="col-md-9 col-sm-9 col-xs-12"><div class="row"><div class="col-md-12 col-sm-12 col-xs-12 radio-txtbox-row"><input class="form-check-input answer_'+key+'" type="radio" name="answer['+key+']" value="3" title="Choose Correct Answer"><input type="text" name="options['+key+'][]" class="form-control options_'+key+'" placeholder="Option 4"></div></div></div></div></div>';
			$('.dynamicFields:last').after(html);
			let k = key+1;
			$('#lastKey').val(k);
		}
		if(ques_count==5)
		$(this).hide();
		
		$('.qlabel').each(function(i,v){
			let j =i+1;
			$(this).text('Question '+j);
		});
	});
	
	// Delete a row
	$('body').on('click','.deleteQuizRow',function(){
		var $this = this;
		$('#delete_confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).on('click','#continue2',function(){
					$('#delete_confirm').modal('hide');	
					$($this).closest(".dynamicFields").remove();
					let len = $('.dynamicFields').length;
					if(len<5){
					//$('#addMorebtn').show();
					var url_string = location.href;
						let arr = url_string.split('/');
						let el = arr[arr.length-1];
						if($.isNumeric(el))
						{
							let qCount = parseInt($('#qCount').val());
							if(qCount==5){
								$('.ln_solid').html('<div class="form-group"><a href="javascript:void(0)" id="addMoreRows" class="btn btn-primary pull-right">Add More</a></div><div class="ln_solid"></div>');
							}else
								$('#addMoreRows').show(); 
						}
						else
						$('#addMoreRows').show(); 
					}
					
					$('.qlabel').each(function(i,v){
						let j =i+1;
						$(this).text('Question '+j);
					});
		}).find('.modal-body').html('<p>Are you sure?</p>');
		
	});
	
	//submit questions
	$('body').on('click','.submitQuestions',function(){
		var cond = true;
		var cond1 = true;
		var cond2 = true
		
		$('.questions').each(function(i,v){
			var ids = $(this).attr('id'); 
			var idArr = ids.split('_');
			var id =  idArr[1];
			if($(this).val()==''){
				$(this).css('border','red 1px solid').attr('placeholder','Please enter question');
				cond = false;
				return false;
			}
			if($(this).val().length>255){
				$(this).css('border','red 1px solid').attr('title','Question should be greate than 255');
				cond = false;
				return false;
			}
			$('.options_'+id).each(function(){
				if($(this).val()==''){
					$(this).css('border','red 1px solid').attr('placeholder','Please enter option');
					cond1 = false;
					return false;
				}
				if($(this).val().length>255){
					$(this).css('border','red 1px solid').attr('title','Option should be greate than 255');
					cond1 = false;
					return false;
				}
			});
			$('.answer_'+id).each(function(){
				if($('.answer_'+id+':checked').length==0){
						cond2 = false;
						return false;
				}
			});
		});		
			if(cond==false)
				return false;
			if(cond1==false)
				return false;
				
			if(cond2==false){
				$('#alertBox').modal({backdrop: 'static',keyboard: false}).find('.modal-body').html('<h5>Please choose correct answer</h5>');
				return false;
			}
			let quiz_name = $("input[name=quiz_name]").val();
			let valid_for = $("input[name=valid_for]").val();
			let max = parseInt($("#valid_for").attr('max'));
            let min = parseInt($("#valid_for").attr('min'));
			if(quiz_name=='')
			{
				$("input[name=quiz_name]").css('border','red 1px solid').attr('placeholder','Please enter quiz name');
				return false;
			}
			if(valid_for=='')
			{
				
				$("input[name=valid_for]").css('border','red 1px solid').attr('placeholder','Please enter valid days');
				return false;
			}
			if ($("#valid_for").val() > max)
			{
              $("#valid_for").val(max);
			  $("input[name=valid_for]").css('border','red 1px solid').val('').attr('placeholder','Please enter days less than or equal 365');
               return false;
			  
			  
			}
			if ($("#valid_for").val() < min)
			{
              $("#valid_for").val(min);
			   $("input[name=valid_for]").css('border','red 1px solid').val('').attr('placeholder','Please enter days greater than 0');			 
               return false;
			} 
			
	});
	$(document).on('click','.deleteQuiz',function(){ 
        let id = $(this).attr('id');
		$('#delete_confirm').modal({
				  backdrop: 'static',
				  keyboard: false
				}).on('click','#continue2',function(){
					$.ajax({
						url:'/quiz/destroy',
						type:'POST',
						headers:{
							'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
						},
						data:{id},
						success:(data)=>{
							$('#delete_confirm').modal('hide');	
							table.draw();
							setTimeout(function(){
								$('#msgsection').html('<p id="msgsection" class="alert alert-success">'+data+'</p>');
							},1000);
						   //alert(data);
						   setTimeout(function(){ $('#msgsection').html(''); },10000);
						}
					});
				}).find('.modal-body').html('<p>Are you sure, you want to delete this Quiz?</p>');
        
    });
	
	//open modal to view quiz details for user
  $('body').on('click','.viewQuizDetilsByUser',function(){
	  var quiz_id = $(this).data('quiz-id');
	  var user_id = $(this).data('user-id');
	  $.ajax({
		url:'/quiz/viewQuizDetailsByUser',
		type:'POST',
		headers:{
			'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
		},
		data:{quiz_id,user_id},
		success:(data)=>{
			 $('#viewQuizDetilsByUserModal').modal().find('.modal-body').html(data);
		}
	});
	 
  });
	
    
    //Notification module
	$('body').on('click', '.sendNotification', function(){
		
		var cond = true;
		var notification_name = $("#notification_name").val();
        var notification_message = $("#notification_message").val();
		
		if(notification_name ==''){
			$("#notification_name").css('border','red 1px solid').attr('placeholder','Please enter notification name');
			return false;
		} else {
            $("#notification_name").css('border','#ccc 1px solid');
        }
		if(notification_message == ''){
			$("#notification_message").css('border','red 1px solid').attr('title','Please enter notification message');
			return false;
		} else {
            $("#notification_message").css('border','#ccc 1px solid');
        }
		let captcha = $("input[name=captcha]").val();
		if(captcha==''){
			$("input[name=captcha]").css('border','red 1px solid').attr('placeholder','Please enter captcha');
			return false;
		}
		 else {
            $("input[name=captcha]").css('border','#ccc 1px solid');
        }
		
		if(cond==false) return false;
        
	});
	
    
    //Moderator(user) module
	$('body').on('click', '.validateModerator', function(){
		var cond = true;
        
		var name = $.trim($("#name").val());
        var phone = $.trim($("#phone").val());
        var email = $.trim($("#email").val());
        var password = $.trim($("#password").val());
        var organization_name = $.trim($("#organization_name").val());
        var designation = $.trim($("#designation").val());
        
        var is_blocked = $("#is_blocked").val();
        var moderator_id = $("#moderator_id").val();
		
        if(moderator_id == ''){
			$("#moderator_id").css('border','red 1px solid');
			return false;
		} else {
            $("#moderator_id").css('border','#ccc 1px solid');
        }
        
		if(name == ''){
			$("#name").css('border','red 1px solid').attr('placeholder','Please enter name');
			return false;
		} else {
            $("#name").css('border','#ccc 1px solid');
        }
		if(phone == ''){
			$("#phone").css('border','red 1px solid').attr('title','Please enter phone');
			return false;
		} else {
            $("#phone").css('border','#ccc 1px solid');
        }
        
		if(email == ''){
			$("#email").css('border','red 1px solid').attr('placeholder','Please enter emaill');
			return false;
		} else {
            if(ValidateEmail(email)) {
                $("#email").css('border','#ccc 1px solid');
            } else{
                $("#email").css('border','red 1px solid').attr('placeholder','Please enter valid emaill');
                return false;
            }
            
        }
		if(password == ''){
			$("#password").css('border','red 1px solid').attr('title','Please enter password');
			return false;
		} else {
            $("#password").css('border','#ccc 1px solid');
        }
				
		if(organization_name == ''){
			$("#organization_name").css('border','red 1px solid').attr('placeholder','Please enter organization name');
			return false;
		} else {
            $("#organization_name").css('border','#ccc 1px solid');
        }
		if(designation == ''){
			$("#designation").css('border','red 1px solid').attr('title','Please enter designation');
			return false;
		} else {
            $("#designation").css('border','#ccc 1px solid');
        }
        
        if(is_blocked == ''){
			$("#is_blocked").css('border','red 1px solid');
			return false;
		} else {
            $("#is_blocked").css('border','#ccc 1px solid');
        }
        
        
		if(cond==false) return false;
	});






	setTimeout(function(){ 
		$('.alert-success').hide();
		$('.alert-danger').hide();
	},5000);
	
	        $('form.disableonsubmit').submit(function(e) {
            if ($(this).data('submitted') === true) {
                // Form is already submitted
                console.log('Form is already submitted, waiting response.');
                // Stop form from submitting again
                e.preventDefault();
            } else {
                // Set the data-submitted attribute to true for record
                $(this).data('submitted', true);
            }
        });
	
});





function ValidateEmail(email){
    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        return true;
    }
    return false;
}






