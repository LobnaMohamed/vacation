<?php
	include 'header.php';
	// Include config file
	include 'functions.php';


	if(isset($_POST['insertEmp'])){ // insert new employee
		 addEmp();
		echo "<h1>Emp inserted!</h1>";
	}elseif(isset($_POST['UpdateEmp'])){ //update existing employee
		editEmp();
		echo "<h1>Emp updated!</h1>";
	}
	include 'footer.php';
?>
