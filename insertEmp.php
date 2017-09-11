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
		
	}
	include 'footer.php';
?>
