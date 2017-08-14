/*global $, alert, console*/
$(document).ready(function(){

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

	$('#name').blur(function(){

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

	$('#dateTo').blur(function(){

		var startDate = $('#date').val();
		var endDate = $(this).val();
		// end - start returns difference in milliseconds 
		var diff = new Date(endDate) - new Date(startDate);
		console.log( diff);
		// get days
		var days = diff/1000/60/60/24;
		console.log(days);
		$('#duration').val(days);
	});

	// edit employees info modal
	$('a.edit').on('click', function() {
	    var myModal = $('#editEmp');

	    // now get the values from the table
	    var firstName = $(this).closest('tr').find('td.firstName').html();
	    var lastName = $(this).closest('tr').find('td.lastName').html();
	    // and set them in the modal:
	    $('.firstName', myModal).val(firstName);
	    $('.lastNameName', myModal).val(lastName);

	    // and finally show the modal
	    myModal.modal({ show: true });

	    return false;
	});	

	// //trial for ajax
	// $(".code").change(function()
 //            {
 //                $.ajax(
 //                {
 //                    url:"/index.php",
 //                    type:"post",
 //                    data:{code:$(this).val()},
 //                    success:function(response)
 //                    {
 //                        $("#zip").html(response);
 //                    }
 //                });
 //    });
 	$("input#code").bind("change", function(){
 		var empCode=$("#code").val();
 		if($.trim(empCode) != ''){
 			$.post('ajax.php',{code:empCode}, function(data){
 				alert(data.empID);
 				alert(data.empName);
 				if(data==="notfound"){
 					alert("رقم القيد غير مسجل \n من فضلك ادخل رقم صحيح!");
 				}else{

 					$('#name').val(data.empName);
 					$('#emp').val(data.empID); 					
 				}
 			},"json");
 		} 		
	});

	$( '#vacForm' ).each(function(){
		this.reset();
	});

});