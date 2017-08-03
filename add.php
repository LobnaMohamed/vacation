<?php
	// Include config file
	include 'functions.php';
	if(isset($_POST['submitVac'])){
		addVacation();
		echo "vacation inserted";
	}

?>


	