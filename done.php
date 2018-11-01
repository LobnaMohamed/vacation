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
	
	// delete vacation
	elseif (isset($_POST['vac_id'])){
		deleteVacationAsEmp();
		//header("Location:myvacationstatus.php");
	}
	else
	{
	    // Form has not been submitted
	    echo"nothing";
	}
