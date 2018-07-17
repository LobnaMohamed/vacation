/*global $, alert, console*/
$(document).ready(function(){



	'use strict';
	var nameError = true ,
		codeError = true,
		daterror = true;
	function checkErrors() {

		if(nameError == true || codeError == true || daterror == true){
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

	$('#dateTo').change(function(){

		var startDate = $('#date').val();
		var endDate = $(this).val();
		// end - start returns difference in milliseconds 
		var diff = new Date(endDate) - new Date(startDate);
		// console.log( diff);
		// get days
		var days = (diff/1000/60/60/24)+1;
		// console.log(days);
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

 	$("input#code").bind("change", function(){
 		var empCode=$("#code").val();
 		// alert(empCode);
 		if($.trim(empCode) != ''){
 			// alert("hi");
 			$.post('ajax.php',{code:empCode}, function(data){
 				if(data == "notfound"){
 					alert("رقم القيد غير مسجل \n من فضلك ادخل رقم صحيح!");
 				}else{
 					$('#name').val(data.empName);
 					$('#emp').val(data.empID); 	
 					$('#subManagment').val(data.subManagemnet); 
 					$('#day_n').val(data.day_night);
 					$('#Management').val(data.g_manag);
 					$('#ManagementName').val(data.g_manag_name);  				
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


	//--------------get employee data in edit modal---------------
	$(document).on('click','.editEmpData', function(){
		var employee_id=$(this).attr("id");
		// console.log(employee_id);
		$.ajax({
			url:"fetch.php",
			method:"POST",
			data:{empID:employee_id},
			dataType:"json",
			success:function(data){
				// console.log(data);
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
	//--------------onsubmit edit form-----------------------------
	$(document).on('submit','#editEmpForm', function(){
		//alert("hi");
		//e.preventDefault();
		var $form = $('#editEmpForm');

		$.ajax({
			url:"insertEmp.php",
			method:"POST",
			data: $('form#editEmpForm').serialize(),
			//dataType:"json",

			success:function(data){
				//console.log(data);
				$("#editEmpModal").modal('hide');	
			},
			error: function(error) {
            	alert(error);
        	}
		});		
	});
	//--------------get management data in edit modal---------------
	$(document).on('click','.editManagementData', function(){
		var management_id=$(this).attr("id");
		 console.log(management_id);
		$.ajax({
			url:"fetch_Mang.php",
			method:"POST",
			data:{managementID:management_id},
			dataType:"json",
			success:function(data){
				 console.log(data);
				$('#management_id').val(data.ID);
				$('#managementEdit').val(data.Management);
			},
			error:function(data){
				console.log( data);
			}
		});
	});
	//--------------check in change password modal------------------
	$('#changePassModal').on('show.bs.modal', function(e) {
		//alert ("hi");
		var username = $('input[name="username"]').val();
		var password = $('input[name="password"]').val();
		//check if username or password are empty
		if(username == "" || password == ""){
			alert ("أدخل بياناتك!");
			e.preventDefault();//stop modal from showing
		}else{
		    $(e.currentTarget).find('input[name="user"]').val(username);
		    $(e.currentTarget).find('input[name="oldPass"]').val(password);
		    // on form submit
		    $('#changePassForm').on('submit', function(e){
		    	//e.preventDefault();
		    	var newPass = $.trim($(e.currentTarget).find('input[name="newpassword"]').val());
			    var confirmPass = $.trim($(e.currentTarget).find('input[name="confirmpassword"]').val());
			    if(newPass == confirmPass && newPass.length >= 7 && newPass != 1234567){
					//ajax to update password:
				    $.ajax({
				    	url:document.location.url,
						method:"POST",
						data: $('form#changePassForm').serialize(),
						success:function(data){
							 alert("تم تغيير كلمة السر بنجاح");
							 // console.log(data.result);
						},
						error: function(error) {
			            	// alert("error");
			            	 // console.log(error);
			        	}
					});	
			    }else{
			    	e.preventDefault();
			    	//console.log("slidedown");
			    	$('#modalAlert').removeClass("hide");
			    	$('#changePassForm')[0].reset();
			    }
			    $('#changePassForm').on('keyup',function(){
			    	$('#modalAlert').addClass("hide");
			    });
		    });
		}
	});
 	
 	//---------------check if pass = 1234567 on login----------------

 	$('#signin').on('submit', function(e){

 		//var password = $("input[name=password]");
 		//check if pass == 1234567
 		e.preventDefault();
		$.ajax({
			url:'checkpassAjax.php',
			method:"POST",
			data: $('form#signin').serialize(),
			dataType:"json",
			success:function(data){
				console.log(data);			
				if(data.response == "changePass"){
					alert("يجب تغيير كلمة السر!");
					$("#changePassModal").modal('show');					
				}
				if(data.response == "noouser"){
					alert ("من فضلك أدخل بيانات صحيحة");
					$( 'input[name=password]' ).val('');
					// $( '#signin' ).each(function(){
					// 	this.reset();
					// });
				}
				if(data.response == "nothing3" || data.response == "nothing"){
					 window.location.replace(data.redirect) ;
				}
			},
			error: function(error) {
				//alert("error");
				console.log(error);
			}
		});	
 	});
 	//------------search through emp data by code-----------------
 // 	$('#search').on('keyup',function(){
 // 		var value = $(this).val();
 // 		var currentURL = document.location.href.match(/[^\/]+$/)[0];
 // 		// alert(currentURL);
	// 	$.ajax({
	// 		url:'searchAjax.php',
	// 		method:"GET",
	// 		data: {search:value,pageurl:currentURL},
	// 		// dataType:"json",
	// 		success:function(data){
	// 			// console.log(data);
				
	// 			if(currentURL == 'empdata.php'){
	// 				console.log(data);
	// 				$('#empDatabody').html(data);
	// 			}else if(currentURL == 'confirmed.php'){
	// 				console.log(data);
	// 				$('#confirmedVacbody').html(data);

	// 			}else if(currentURL == 'pending.php'){
	// 				$('#pendingVacbody').html(data);
	// 			}
				
	// 		},
	// 		error: function(error) {
 //            	console.log(error);
 //        	}
	// 	});	
	// });

 	//------------search through emp vacation data by date from and to-----------------
 // 	$('#searchDateTo').datepicker({
 //     onSelect: function(){
 //     	var dateTo_value = $(this).val();
 // 		var dateFrom_value = $('#searchDateFrom').val();
 // 		var currentURL = document.location.href.match(/[^\/]+$/)[0];
 // 		// alert(currentURL);
	// 	$.ajax({
	// 		url:'datesearchAjax.php',
	// 		method:"GET",
	// 		data: {dateFrom:dateFrom_value,
	// 			    dateTo:dateTo_value,
	// 			    pageurl:currentURL},
	// 		// dataType:"json",
	// 		success:function(data){
	// 			// console.log(data);
				
	// 			if(currentURL == 'confirmed.php'){
	// 				console.log(data);
	// 				$('#confirmedVacbody').html(data);
					
	// 			}
	// 			//else if(currentURL == 'empdata.php'){
	// 			// 	console.log(data);
	// 			// 	$('#empDatabody').html(data);

	// 			// }else if(currentURL == 'pending.php'){
	// 			// 	$('#pendingVacbody').html(data);
	// 			// }
				
	// 		},
	// 		error: function(error) {
 //            	console.log(error);
 //        	}
	// 	});	
 //     }
	// });
	//-----------search confirmed vacs---------------------------- 
 	$('#searchDateTo,#searchDateFrom,#search').bind('change keyup',function(){
 		//get dates between 2 dates
 		var value = $('#search').val();
 		var dateTo_value = $('#searchDateTo').val();
 		var dateFrom_value = $('#searchDateFrom').val();
 		var currentURL = document.location.href.match(/[^\/]+$/)[0];
		$.ajax({
			url:'searchAjax.php',
			method:"GET",
			data: {search:value,
					dateFrom:dateFrom_value,
				    dateTo:dateTo_value,
				    pageurl:currentURL},
			// dataType:"json",
			success:function(data){
				// console.log(data);
				
				if(currentURL == 'confirmed.php'){
					console.log(data);
					$('#confirmedVacbody').html(data);
					
				}
				else if(currentURL == 'empdata.php'){
					console.log(data);
					$('#empDatabody').html(data);

				 }
				 else if(currentURL == 'myvacationstatus.php'){
					$('#VacStatusbody').html(data);
				}
				
			},
			error: function(error) {
            	console.log(error);
        	}
		});	
	});
});