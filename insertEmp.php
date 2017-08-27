<?php
	include 'header.php';
	// Include config file
	include 'functions.php';
	if(isset($_POST['insertEmp'])){
		 addEmp();
		echo "<h1>Emp inserted!</h1>";
	}
	include 'footer.php';
?>
