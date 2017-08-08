<?php
	include 'header.html';
	// Include config file
	include 'functions.php';
	if(isset($_POST['submitVac'])){
		addVacation();
		echo "<h1>تم ارسال الاجازة بنجاح !</h1>";
	}

?>


	