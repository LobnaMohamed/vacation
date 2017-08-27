<?php
	session_start();
		if(isset($_SESSION['Username'])){
		//echo "Welcome" . $_SESSION['Username'];
	}else{
		header('Location: index.php');//redirect
		exit();
	}
	include 'header.php';
	include 'functions.php';

	if (isset($_POST['update']))
	{
	    // Form has been submitted

		saveVacationAgree();
		header("Location:pending.php");
	}
	else
	{
	    // Form has not been submitted
	    echo"nothing";
	}
