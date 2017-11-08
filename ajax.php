<?php
	include 'functions.php';
	if(isset($_POST['code']) == true && empty($_POST['code'] ==false)){
		$con = connect();
		$sql= "SELECT t_data.ID as ID,emp_name,management,day_n
			   FROM t_data,t_day_n 
			   WHERE emp_code = '" . trim($_POST['code']) . "' and t_day_n.id = t_data.day_night"  ;
		$stmt = $con->prepare($sql);
		$stmt->execute(array($_POST['code']));
		$result = $stmt->fetchAll();
		if($result){
			foreach($result as $row){
		    	echo json_encode(array("empID"=>$row['ID'],"empName"=>$row['emp_name'],"subManagemnet"=>$row['management'],"day_night"=>$row['day_n']));
			}
		}else{
			echo "notfound";
		}

	}
	
	?>