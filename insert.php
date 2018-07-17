<?php
	include 'header.php';
	// Include config file
	include 'functions.php';

	//echo $_POST['UpdateEmp'];
	if(isset($_POST['insertEmp'])){ // insert new employee
		 addEmp();
		 header("Location:empData.php");
		
	}elseif(isset($_POST['UpdateEmp'])){ //update existing employee
		//echo "<h1>Emp updated!</h1>";
		editEmp();
		header("Location:empData.php");
		
	}elseif(isset($_POST['ResetPassword'])){ //reset password
		resetPassword();
		header("Location:empData.php");
	}
	if(isset($_POST['insertManagement'])){ // insert new management
		addManagement();
		header("Location:managements.php");

    }elseif(isset($_POST['updateManagement'])){ // edit management
		editManagement();
		header("Location:managements.php");
    }
	include 'footer.php';
?>
