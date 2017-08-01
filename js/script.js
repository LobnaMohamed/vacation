/*global $, alert, console*/
$(function(){

	'use strict';
	var nameError = true ,
		codeError = true,
		daterror = true;


	function checkErrors() {

		if(nameError === true || codeError === true || daterror === true){
			console.log('there is  errors');
			// alert("name cant be less than 3");

		} else {
			console.log('form is valid');
		}
	}

	$('.name').blur(function(){

	 	if($(this).val().length <= 3){ //show error
	 		$(this).css('border', '1px solid #F00').parent().find('.custom-alert').fadeIn(300)
	 		.end().find('.asterisx').fadeIn(50);
	 		
	 		nameError = true;

	 	}else {  //no errors
	 		
	 		$(this).css('border', '1px solid #080');
	 		$(this).parent().find('.custom-alert').fadeOut(300);
	 		$(this).parent().find('.asterisx').fadeOut(50);
	 		nameError = false;
	 	}
	 	checkErrors();
	});

	$('.dateTo').blur(function(){

		var startDate = $('.date').val();
		var endDate = $(this).val();
		// end - start returns difference in milliseconds 
		var diff = new Date(endDate) - new Date(startDate);
		console.log( diff);
		// get days
		var days = diff/1000/60/60/24;
		console.log(days);
		$('.duration').val(days);
	});	
});