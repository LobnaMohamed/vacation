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
	//SUBMIT AGREE	ON VACATION
	if (isset($_POST['update']))
	{
	    // Form has been submitted

		saveVacationAgree();
		header("Location:pending.php");
	}
	//SUBMIT AGREE ON PERMITS
	if (isset($_POST['updatePermit']))
	{
	    // Form has been submitted

		saveVacationAgree();
		header("Location:pendingPermit.php");
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
