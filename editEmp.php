<?php
	include 'header.php';
	// Include config file
	include 'functions.php';
	if(isset($_POST['insertEmp'])){
		 editEmp();
		echo "<h1>Emp updated!</h1>";
	}
	include 'footer.php';
?>
