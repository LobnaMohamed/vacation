<?php
	include 'functions.php';
	if(isset($_POST['code']) === true && empty($_POST['code'] ===false)){
		$con = connect();
		$sql= "SELECT emp_name 
			   FROM t_data 
			   WHERE emp_code = '" . trim($_POST['code']) . "' "  ;
		$stmt = $con->prepare($sql);
		$stmt->execute(array($_POST['code']));
		$result = $stmt->fetchAll();
		if($result){
			foreach($result as $row){
		    	echo($row['emp_name']);
			}
		}else{
			echo "notfound";
		}

	}
	
	?>