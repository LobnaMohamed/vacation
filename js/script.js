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
 		alert(empCode);
 		if($.trim(empCode) != ''){
 			alert("hi");
 			$.post('ajax.php',{code:empCode}, function(data){
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

	// $("#addEmpForm").on('submit',function(e){
	// 	e.preventDefault();
	// 	//alert("hi");
	// 	if($('#empName').val()==''){
	// 		alert ("Name is empty");
	// 	}else if($('#empCode').val()==''){
	// 		alert ("code is empty");
	// 	}else if($('#contractType').val()==''){
	// 		alert ("contract is empty");
	// 	}else if($('#job').val()==''){
	// 		alert ("job is empty");
	// 	}else if($('#GManagement').val()==''){
	// 		alert ("GManagement is empty");
	// 	}else if($('#level').val()==''){
	// 		alert ("level is empty");
	// 	}else if($('#day_n').val()==''){
	// 		alert ("day_n is empty");
	// 	}else if($('#active').val()==''){
	// 		alert ("active is empty");
	// 	}else{
	// 		$.ajax({
	// 			url:"insertEmp.php",
	// 			method:"POST",
	// 			data:$('#addEmpForm').serialize(),
	// 			success:function(data){
	// 				$('#addEmpForm')[0].reset();
	// 				$('#addEmpModal').modal('hide');
	// 				$('#empData').html(data);
	// 			} 
	// 			// error: function(){ //makes error when uncommented
	// 	  //           alert("Something went wrong!");
	// 	  //       }
	// 		});
	// 	}
	// });


	//get employee data in edit modal
	$(document).on('click','.editEmpData', function(){
		var employee_id=$(this).attr("id");
		console.log(employee_id);
		$.ajax({
			url:"fetch.php",
			method:"POST",
			data:{empID:employee_id},
			dataType:"json",
			success:function(data){
				console.log(data);
				$('#employee_id').val(data.ID);
				$('#empNameEdit').val(data.emp_name);
				$('#empCodeEdit').val(data.emp_code);
				$('#managementEdit').val(data.management);
				$('#desc_jobEdit').val(data.desc_job);
				$('#levelEdit').val(data.level_id);
				$('#activeEdit').val(data.active);
				$('#GManagementEdit').val(data.g_management_id);
				$('#contractTypeEdit').val(data.contract_type);
				$('#jobEdit').val(data.id_job);
				$('#day_nEdit').val(data.day_night);
				$('#userGrpEdit').val(data.id_userGroup);
			}
		});
	});
	//onsubmit edit form
	$(document).on('submit','#editEmpForm', function(){
		alert("hi");
		//e.preventDefault();
		var $form = $('#editEmpForm');

		$.ajax({
			url:"insertEmp.php",
			method:"POST",
			data: $('form#editEmpForm').serialize(),
			//dataType:"json",

			success:function(data){
				console.log(data);
				$("#editEmpModal").modal('hide');
				
			},
			error: function(error) {
            	alert(error);
        	}
		});		
	});

	$('#changePassModal').on('show.bs.modal', function(e) {
		alert ("hi");
	    var user = $(e.relatedTarget).data('user');
	    $(e.currentTarget).find('input[name="user"]').val(user);
	    console.log (user);
	    var oldPass = $(e.relatedTarget).data('oldPass');
	    $(e.currentTarget).find('input[name="oldPass"]').val(oldPass);
	    console.log(oldPass);


	});
});