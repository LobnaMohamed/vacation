<?php
	// --------------connection to database function-------------
	function connect(){
		$dsn = 'mysql:host=localhost;dbname=vacation';//data source name
		$user= 'root';
		$pass='';
		$options = array (
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);

		try{
			//new connection to db
			static $con;
		    if ($con===NULL){ 
		        $con =  new PDO($dsn, $user, $pass, $options);
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		    }
			// $con = new PDO($dsn, $user, $pass, $options);
			// $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			//QUERY
			// $q = "INSERT INTO test(name,phone)VALUES('لبنى','محمد')";
			// $con->exec($q);
			echo "success";
			//print_r($con) ;

		}
		catch(PDOexception $e){
			echo "failed" . $e->getMessage();
		}
		return $con;
	}	
	//---------------get Managers function-----------------------
	function getManagers(){
		$con = connect();
		$sql= "SELECT ID,emp_code,emp_name FROM t_data" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['emp_code'] ."   ".$row['emp_name']. "</option>";
			}
	}
	//---------------get case function-----------------------
	function getCase(){
		$con = connect();
		$sql= "SELECT ID,case_desc FROM t_case" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['case_desc'] . "</option>";
			}
	}
	// --------------Add vacation function-----------------------
	function addVacation(){
		$con = connect();
		//check if user comming from a request
		 // $_SERVER['REQUEST_METHOD'] == 'POST'
		if(isset($_POST['submitVac'])){
			//assign variables
			$empName= isset($_POST['name'])? filter_var($_POST['name'],FILTER_SANITIZE_STRING) : '';
			$empCode= isset($_POST['code'])? filter_var($_POST['code'],FILTER_SANITIZE_NUMBER_INT):'';
			$management= isset($_POST['Management'])? filter_var($_POST['Management'],FILTER_SANITIZE_STRING):'';
			$duration= isset($_POST['duration'])? filter_var($_POST['duration'],FILTER_SANITIZE_NUMBER_FLOAT):'';
			$date= isset($_POST['vacDate'])? $_POST['vacDate'] :'';
			$dateTo = isset($_POST['vacDateTo'])? $_POST['vacDateTo'] :'';
			$topManager= isset($_POST['topManager'])? $_POST['topManager'] :'';
			$manager= isset($_POST['manager'])? $_POST['manager'] :'';
			$vacType= isset($_POST['case'])? $_POST['case'] :'';
			// creating array of errors
			$formErrors = array();

			if (empty($empName) || empty($empCode) ){
				//$formErrors[] = 'username must be larger than  chars';
				echo "name and code cant be empty";
				// print_r($formErrors) ;
			} else {
				$sql= "INSERT INTO t_transe(id_case,start_date,end_date,manager_id,top_manager_id,duration) 
					   VALUES ('".$vacType."','".$date."','".$dateTo."','".$manager."','".$topManager."','".$duration."')" ;
		        $stmt = $con->prepare($sql);
				$stmt->execute();		
			}
		}
	}

	// --------------Edit vacation function----------------------
	function editVacation(){

	}

	// --------------get Employee function-----------------------
	function getAllEmp(){
		$con = connect();
		$sql = "SELECT d.*, a.active as activeStatus, dn.day_n as shift 
		    FROM t_data d left JOIN t_active a on d.active = a.ID 
		    			  left Join t_day_n  dn  on d.day_night = dn.ID
		    ORDER BY id ASC";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row){
			echo"<tr>";
			echo"<td>".  $row['emp_code']. "</td>";
			echo"<td>".  $row['emp_name']. "</td>";
			echo"<td>".  $row['contract_type']. "</td>";
			echo"<td>".  $row['id_job']. "</td>";
			echo"<td>".  $row['g_management']. "</td>";
			echo"<td>".  $row['level']. "</td>";
			echo"<td>".  $row['shift']. "</td>";
			echo"<td>".  $row['activeStatus']. "</td>";
			echo'<td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editEmp">تعديل</button></td>';
			echo '</tr>';
		 } 
	}
	// --------------Add Employee function-----------------------
	function addEmp(){

	}	
	
	// --------------Edit Employee function-----------------------
	function editEmp(){

	}	