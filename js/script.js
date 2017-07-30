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
});