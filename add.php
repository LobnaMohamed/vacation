<?php
	include 'header.php';
	// Include config file
	include 'functions.php';
	if(isset($_POST['submitVac'])){
		addVacation();
		echo "<h1>تم ارسال الاجازة بنجاح !</h1>";
		header('Location: vacationmodel.php');//redirect
	}

?>


	