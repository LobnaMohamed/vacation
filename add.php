<?php
	// Include config file
	require_once 'connect.php';
	//check if user comming from a request
	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		//assign variables

		$empName= filter_var($_POST['name'],FILTER_SANITIZE_STRING);
		$empCode= filter_var($_POST['code'],FILTER_SANITIZE_NUMBER_INT);
		$management= filter_var($_POST['Management'],FILTER_SANITIZE_STRING);
		$duration= filter_var($_POST['duration'],FILTER_SANITIZE_NUMBER_FLOAT);
		$date= $_POST['vacDate'];
		$dateTo = $_POST['vacDateTo'];
		$topManager= $_POST['topManager'];
		$manager= $_POST['manager'];
		$vacType=$_POST['case'];
		// creating array of errors
		$formErrors = array();

		if (empty($empName) || empty($empCode) ){
			//$formErrors[] = 'username must be larger than  chars';
			echo "name and code cant be empty";
			// print_r($formErrors) ;
		} else {
			$sql= "INSERT INTO t_transe(emp_name,emp_code,id_case,start_date,end_date,manager_id,top_manager_id) 
				   VALUES ('".$empName."','".$empCode."','".$vacType."','".$date."','".$dateTo."','".$manager."','".$topManager."')" ;
	        $stmt = $con->prepare($sql);
			$stmt->execute();		
		}
	}
?>


	