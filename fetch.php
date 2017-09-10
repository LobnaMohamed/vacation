<?php
	require 'functions.php';  


	 if(isset($_POST["empID"]))  
	 {  
		$con = connect();
		$sql= '';
		//$sql .= "SELECT * FROM empdata"
		$sql = "SELECT * FROM t_data WHERE id = '".$_POST["empID"]."'";  
		$stmt = $con->prepare($sql);
		$stmt->execute(array($_POST["empID"]));
		$result = $stmt->fetch(); //PDO::FETCH_ASSOC
		//print_r($result) ;
		echo json_encode($result); 
	 }  else {
	 	echo "emp id is not set";
	 }
 ?>
 