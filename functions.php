<?php
	//include 'connect.php';
	// --------------connection to database function-------------
	function connect(){
		$dsn = 'mysql:host=localhost;dbname=vacation';//data source name
		$user= 'root';
		$pass='';
		$options = array (
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
				PDO::ATTR_PERSISTENT => true
			);

		try{
			//new connection to db
				static $con;
			    if ($con == NULL){ 
			        $con =  new PDO($dsn, $user, $pass, $options);
					$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		    }
			// $con = new PDO($dsn, $user, $pass, $options);
			// $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			//QUERY
			// $q = "INSERT INTO test(name,phone)VALUES('لبنى','محمد')";
			// $con->exec($q);
			//echo "success";
			//print_r($con) ;

		}
		catch(PDOexception $e){
			echo "failed" . $e->getMessage();
		}
		return $con;
	}	
	//---------------login function------------------------------
	function login(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashedPass = sha1($password);
		$response = "";
		$page = "";

		//check if user exist

		$con = connect();
		$stmt = $con->prepare("SELECT emp_code,password,id_userGroup,ID,emp_name From t_data WHERE emp_code=? and password=?");
		$stmt->execute(array($username,$hashedPass));
		$count = $stmt->rowCount();
		
		//if count >0 then the user exists
		if($count>0){
			//user found and pass = 1234567
			if($hashedPass == sha1(1234567)){
				$response = "changePass";
			}else{
				// $response = "nothing";
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$userGroup= $row["id_userGroup"];
				$userID= $row["ID"];
				$user_fullName=$row["emp_name"];
				$_SESSION['Username'] = $username;//register session
				$_SESSION['UserGroup'] = $userGroup;
				$_SESSION['UserID'] = $userID;
				$_SESSION['UserFullName'] = $user_fullName;
				//redirect according to privillage
				if($userGroup==3){
					$response = "nothing3";
					$page = "empdata.php";
					// header('Location: empdata.php');//redirect
				}else{
					$response = "nothing";
					$page = "vacationmodel.php";
					// header('Location: vacationmodel.php');//redirect	
				}				
			}
		}else{
			//no user found
			$response = "noouser";
		}
		echo json_encode(array("response"=>$response,"redirect"=>$page)) ;
	}
	//---------------change password function----------------------
	function changePassword(){
		//check if this user exists:
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		$username = $_POST['user'];
		$password = $_POST['oldPass'];
		$hashedPass = sha1($password);
		$con = connect();
		$stmt = $con->prepare("SELECT emp_code,password,id_userGroup,ID,emp_name 
								From t_data 
								WHERE emp_code=? and password=?");
		$stmt->execute(array($username,$hashedPass));
		$count = $stmt->rowCount();
		//echo $count;
		if($count>0){
			//echo "hi";
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$userGroup= $row["id_userGroup"];
			$userID= $row["ID"];
			$user_fullName=$row["emp_name"];
			$_SESSION['Username'] = $username;//register session
			$_SESSION['UserGroup'] = $userGroup;
			$_SESSION['UserID'] = $userID;
			$_SESSION['UserFullName'] = $user_fullName;

			//start changing password

			$newPassword = $_POST['newpassword'];
			$confirmPassword = $_POST['confirmpassword'];

			if ($newPassword == $confirmPassword ){
				$hashedNewPass = sha1($newPassword);
				//update password in database
				$stmt = $con->prepare("UPDATE  t_data
									   SET password = ? 
									   WHERE emp_code=? ");
				$stmt->execute(array($hashedNewPass,$username));
			}else{
				echo "write ur password correctly";
			}
		}else{
			echo"no user found";
		}

	}
	function resetPassword(){
		$empID=isset($_POST['employee_id'])? filter_var($_POST['employee_id'],FILTER_SANITIZE_NUMBER_INT):'';
			
		$con = connect();
		$sql= '';
		$sql .= "UPDATE t_data
				 SET Password = sha1(1234567)
				 WHERE ID= '$empID'";
		$stmt = $con->prepare($sql);
		$stmt->execute();
	}
	//---------get All Managers who can approve vacations as both manager and top manager in manager combobox --------------
	function getManagers(){
		$con = connect();
		$sql= "SELECT ID,emp_code,emp_name FROM t_data where id_userGroup in(1,2,5)" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		// echo "<option value='0'>لا يوجد</option>";//option if no direct manager
		echo "<option selected  value='0'>لا يوجد</option>";//option if no direct manager
	    	foreach($result as $row){

			    echo "<option value=" .$row['ID'].">" . $row['emp_code'] ."   ".$row['emp_name']. "</option>";
			}
	}
	//------get Top Managers function-----------
	function getTopManagers(){
		$con = connect();
		$sql= "SELECT ID,emp_code,emp_name FROM t_data where id_userGroup=2" ;
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
	//---------------get active status function-----------------------
	function getActive(){
		$con = connect();
		$sql= "SELECT ID,active FROM t_active" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['active'] . "</option>";
			}
	}
	//---------------get day/night status function-----------------------
	function getDayN(){
		$con = connect();
		$sql= "SELECT ID,day_n FROM t_day_n" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['day_n'] . "</option>";
			}
	}
	//---------------get emp level function-----------------------
	function getLevel(){
		$con = connect();
		$sql= "SELECT ID,level FROM t_level" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['level'] . "</option>";
			}
	}
	//---------------get contract type function-----------------------
	function getContract(){
		$con = connect();
		$sql= "SELECT ID,contractType FROM contract" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['contractType'] . "</option>";
			}
	}
	//---------------get user group function-----------------------
	function getUserGroup(){
		$con = connect();
		$sql= "SELECT ID,userGroup FROM user_group" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['userGroup'] . "</option>";
			}
	}
	//---------------get econtract type function-----------------------
	function getJob(){
		$con = connect();
		$sql= "SELECT ID,job FROM t_job" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['job'] . "</option>";
			}
	}
	// --------------Add vacation function-----------------------
	function addVacation(){
		
		//check if user comming from a request
		 // $_SERVER['REQUEST_METHOD'] == 'POST'
		if(isset($_POST['submitVac'])){
			//assign variables
			$empID=isset($_POST['empID'])? filter_var($_POST['empID'],FILTER_SANITIZE_NUMBER_INT):'';
			$empName= isset($_POST['name'])? filter_var($_POST['name'],FILTER_SANITIZE_STRING) : '';
			$empCode= isset($_POST['code'])? filter_var($_POST['code'],FILTER_SANITIZE_NUMBER_INT):'';
			$management= isset($_POST['Management'])? filter_var($_POST['Management'],FILTER_SANITIZE_STRING):'';
			$duration= isset($_POST['duration'])? filter_var($_POST['duration'],FILTER_SANITIZE_NUMBER_FLOAT):'';
			$date= isset($_POST['vacDate'])? $_POST['vacDate'] :'';
			$dateTo = isset($_POST['vacDateTo'])? $_POST['vacDateTo'] :'';
			$topManager= isset($_POST['topManager'])? $_POST['topManager'] :'';
			$manager= isset($_POST['manager'])? filter_var($_POST['manager'],FILTER_SANITIZE_NUMBER_INT) :'';
			$vacType= isset($_POST['case'])? $_POST['case'] :'';
			// creating array of errors
			$formErrors = array();
			$manager_vacStatus = 3;
			echo $manager;
			if( $manager == 0){
				echo "manager is zero";
				$manager = 'NULL';
				echo"new manager is ".$manager;
				$manager_vacStatus = 4;
				echo $manager_vacStatus;
			}
			if (empty($empName) || empty($empCode) ){
				//$formErrors[] = 'username must be larger than  chars';
				echo "name and code cant be empty";
				// print_r($formErrors) ;
			} else {
				

				$con = connect();
				$sql= "INSERT INTO t_transe(emp_id,id_case,start_date,end_date,manager_id,top_manager_id,duration,mang_id,	Manager_agree) 
					   VALUES (".$empID.",".$vacType.",'".$date."','".$dateTo."',".$manager.",".$topManager.",".$duration." ,".$management.",".$manager_vacStatus.")" ;
					   echo $sql;
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
		$output="";
		$con = connect();
		$sql= '';
		// $sql .= "SELECT d.ID,d.emp_code,d.emp_name,d.desc_job,d.management, a.active as activeStatus, dn.day_n as shift,m.management as g_management,j.job as job,l.level as level, c.contractType as contract
		//     FROM t_data d left JOIN t_active a on d.active = a.ID 
		//     			  left Join t_day_n  dn  on d.day_night = dn.ID
		//     			  left Join managements m  on d.g_management_id = m.ID
		//     			  left Join t_job j on d.id_job = j.ID
		//     			  left Join t_level l on d.level_id = l.ID
		//     			  left Join contract c on d.contract_type = c.ID";

		
		if(!empty($_GET['search'])){
			$sql = "SELECT * 
					FROM empdata 	
					WHERE emp_code like '%". $_GET['search'] ."%' 
					OR emp_name like '%". $_GET['search'] ."%' 
					ORDER BY emp_code";
		}else{
			$sql = "SELECT * FROM empdata ORDER BY emp_code"; //view
		}
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		// foreach($result as $row){
		// 	echo"<tr>";
		// 	echo"<td>".  $row['emp_code']. "</td>";
		// 	echo"<td>".  $row['emp_name']. "</td>";
		// 	echo"<td>".  $row['contract']. "</td>";
		// 	echo"<td>".  $row['job']. "</td>";
		// 	echo"<td>".  $row['g_management']. "</td>";
		// 	echo"<td>".  $row['level']. "</td>";
		// 	echo"<td>".  $row['shift']. "</td>";
		// 	echo"<td>".  $row['activeStatus']. "</td>";
		// 	echo'<td><button type="button" class="btn btn-info btn-sm editEmpData" data-toggle="modal" data-target="#editEmpModal" id="'.$row['ID'].'">تعديل</button></td>';
		// 	echo '</tr>';
		//  } 
		// echo "<pre>";
		// print_r($result) ;
		// echo "</pre>";
		foreach($result as $row){
			$output .= 
			"<tr>
				<td>".  $row['emp_code']. "</td>
				<td>".  $row['emp_name']. "</td>
				<td>".  $row['contract']. "</td>
				<td>".  $row['job']. "</td>
				<td>".  $row['g_management']. "</td>
				<td>".  $row['level']. "</td>
				<td>".  $row['shift']. "</td>
				<td>".  $row['activeStatus']. '</td>
				<td><button type="button" class="btn btn-info btn-sm editEmpData" data-toggle="modal" data-target="#editEmpModal" id="'.$row['ID'].'">تعديل</button></td>
			 </tr>';
			
		 }
		echo $output;
	}
	function getEmpCount(){
		$con = connect();		
		$sql = "SELECT count(*) FROM empdata "; //count emp from view
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchColumn();
		echo $result;
	}

	// --------------Add Employee function-----------------------
	function addEmp(){
		//check if user comming from a request
		 // $_SERVER['REQUEST_METHOD'] == 'POST'
		if(isset($_POST['insertEmp'])){
			//assign variables

			$empName= isset($_POST['empName'])? filter_var($_POST['empName'],FILTER_SANITIZE_STRING) : '';
			$empCode= isset($_POST['empCode'])? filter_var($_POST['empCode'],FILTER_SANITIZE_NUMBER_INT):'';
			$contractType= isset($_POST['contractType'])? filter_var($_POST['contractType'],FILTER_SANITIZE_NUMBER_INT):'';
			$job= isset($_POST['job'])? filter_var($_POST['job'],FILTER_SANITIZE_NUMBER_INT):'';
			// $job= $_POST['job'];
			// echo $job;
			$GManagement= isset($_POST['GManagement'])? filter_var($_POST['GManagement'],FILTER_SANITIZE_NUMBER_INT) :'';
			$level = isset($_POST['level'])? filter_var($_POST['level'],FILTER_SANITIZE_NUMBER_INT):'';
			$day_n= isset($_POST['day_n'])? filter_var($_POST['day_n'],FILTER_SANITIZE_NUMBER_INT) :'';
			$active= isset($_POST['active'])? filter_var($_POST['active'],FILTER_SANITIZE_NUMBER_INT) :'';
			$management= isset($_POST['management'])? filter_var($_POST['management'],FILTER_SANITIZE_STRING) :'';
			$jobDesc= isset($_POST['desc_job'])? filter_var($_POST['desc_job'],FILTER_SANITIZE_STRING) : '';
			$userGroup=isset($_POST['userGrp'])? filter_var($_POST['userGrp'],FILTER_SANITIZE_NUMBER_INT):'';
			$defaultPass=sha1(1234567);
			// creating array of errors
			$formErrors = array();

			if (empty($empName) || empty($empCode) ){
				//$formErrors[] = 'username must be larger than  chars';
				echo "name and code cant be empty";
				// print_r($formErrors) ;
			} else {
				$con = connect();
				$sql= "INSERT INTO t_data(emp_code,emp_name,contract_type,id_job,desc_job,level_id,management,g_management_id,day_night,active,password,id_userGroup) 
					   VALUES ('".$empCode."','".$empName."','".$contractType."','".$job."','".$jobDesc."','".$level."','".$management."','".$GManagement."' ,'".$day_n."','".$active."','".$defaultPass."','".$userGroup."')" ;
		        $stmt = $con->prepare($sql);
				$stmt->execute();
				echo "done";
			}
		}
	}	
	
	// --------------Edit Employee function-----------------------
	function editEmp(){
		$empID=isset($_POST['employee_id'])? filter_var($_POST['employee_id'],FILTER_SANITIZE_NUMBER_INT):'';
		$empName= isset($_POST['empNameEdit'])? filter_var($_POST['empNameEdit'],FILTER_SANITIZE_STRING) : '';
		$empCode= isset($_POST['empCodeEdit'])? filter_var($_POST['empCodeEdit'],FILTER_SANITIZE_NUMBER_INT):'';
		$contractType= isset($_POST['contractTypeEdit'])? filter_var($_POST['contractTypeEdit'],FILTER_SANITIZE_NUMBER_INT):'';
		$job= isset($_POST['jobEdit'])? filter_var($_POST['jobEdit'],FILTER_SANITIZE_NUMBER_INT):'';
		$GManagement= isset($_POST['GManagementEdit'])? filter_var($_POST['GManagementEdit'],FILTER_SANITIZE_NUMBER_INT) :'';
		$level = isset($_POST['levelEdit'])? filter_var($_POST['levelEdit'],FILTER_SANITIZE_NUMBER_INT):'';
		$day_n= isset($_POST['day_nEdit'])? filter_var($_POST['day_nEdit'],FILTER_SANITIZE_NUMBER_INT) :'';
		$active= isset($_POST['activeEdit'])? filter_var($_POST['activeEdit'],FILTER_SANITIZE_NUMBER_INT) :'';
		$management= isset($_POST['managementEdit'])? filter_var($_POST['managementEdit'],FILTER_SANITIZE_STRING) :'';
		$jobDesc= isset($_POST['desc_jobEdit'])? filter_var($_POST['desc_jobEdit'],FILTER_SANITIZE_STRING) : '';
		$userGroup=isset($_POST['userGrpEdit'])? filter_var($_POST['userGrpEdit'],FILTER_SANITIZE_NUMBER_INT):'';		
		$con = connect();
		$sql= '';
		$sql .= "UPDATE t_data
				 SET emp_code = '$empCode' ,
					 emp_name = '$empName',
					 contract_type = '$contractType',
					 id_job = '$job',
					 desc_job = '$jobDesc',
					 level_id = '$level',
					 management = '$management',
					 g_management_id = '$GManagement',
					 day_night = '$day_n',
					 active = '$active',
					 id_userGroup= '$userGroup'
				 WHERE ID= '$empID'";
		$stmt = $con->prepare($sql);
		$stmt->execute();
	}	
	//---------------get managments function-----------------------
	function getManagement(){
		$con = connect();
		$sql= "SELECT ID,Management FROM managements" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['Management'] . "</option>";
			}		
	}
	//---------------get pending vacations
	function getPendingVacAsManager(){
		$con = connect();
		$sql= '';
		$sql .= "SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,t.topManager_agree ,vs2.status as topAgreeStatus,d2.emp_name as TopMgrName
				FROM 	t_data d,t_data d2 ,t_transe t ,t_case c ,managements m , vac_status vs, vac_status vs2 
				WHERE 	t.emp_id=d.ID 
						and t.id_case=c.ID 
						and t.manager_id={$_SESSION['UserID']}
						and t.Manager_agree=3 
						and t.Mang_id=m.ID 
						and t.Manager_agree=vs.ID
						and t.topManager_agree=vs2.ID
						and t.top_manager_id=d2.ID";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$vacStatus= "SELECT ID,status FROM vac_status  where ID NOT IN (4,5,6)";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo'<td>'; 
					foreach($agreement as $row2){
						echo '<label >'.$row2['status'].'
					            <input type="radio" class="radio-inline" name="MangrAgree['.$index.']" class="MangrAgreeRadio" value="'.$row2['ID'].'"';
					            if($row['Manager_agree'] == $row2['ID']){ echo "checked"; }
					    echo'></label>';	  
					};
					//name="MangrAgree'.$row['id'].'"
				echo'</td>';
				echo"<td>".  $row['TopMgrName']. "</td>";
				echo"<td>".  $row['topAgreeStatus']. "</td>";
			echo "</tr>";
		} 
		//$_POST = array();
	}	
	//--------------get pending as top manager----------------------- 
	function getPendingVacAsTopManager(){
		$con = connect();
		$sql= '';
		$sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status,t.topManager_agree,IFNull( d2.emp_name,'لا يوجد') as MgrName 
			FROM t_case c ,managements m , vac_status vs,t_data d 
			RIGHT OUTER JOIN t_transe t ON d.ID = t.emp_id LEFT OUTER JOIN  t_data d2 ON t.manager_id=d2.ID
			WHERE t.id_case=c.ID 
			and t.Mang_id=m.ID 
			and t.topManager_agree=3
			and t.Manager_agree=vs.ID
			and t.Manager_agree in(1,4)
			and (t.top_manager_id={$_SESSION['UserID']} or t.manager_id ={$_SESSION['UserID']} ) ";
          //-------------OLD SQL----------------//
		// SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,IFNULL(t.manager_id,'no manager')as directManger,t.Manager_agree,t.top_manager_id,m.Management,vs.status,t.topManager_agree,d2.emp_name as MgrName  
		// 		FROM t_data d,t_data d2 ,t_transe t ,t_case c ,managements m , vac_status vs 
		// 		WHERE t.emp_id=d.ID 
		// 		and t.id_case=c.ID 
		// 		and  (t.top_manager_id={$_SESSION['UserID']} or t.manager_id={$_SESSION['UserID']})
		// 		and t.topManager_agree=3 
		// 		and t.Mang_id=m.ID 
		// 		and t.Manager_agree=vs.ID
		// 		and t.manager_id=d2.ID

		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$count= $stmt->rowCount();
		$vacStatus= "SELECT ID,status FROM vac_status where ID NOT IN (4,5,6)";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['MgrName']. "</td>";
				if($row['manager_id']==$_SESSION['UserID']){
					echo'<td>'; 
					foreach($agreement as $row2){
						echo '<label >'.$row2['status']. '
					            <input type="radio" class="radio-inline" name="MangrAgree['.$index.']" class="MangrAgreeRadio" value="'.$row2['ID'].'"';
					            if($row['Manager_agree'] == $row2['ID']){ echo "checked"; }
					    echo'></label>';	  
					};
				}else{
					echo"<td>".  $row['status']. "</td>";
				}
				echo'<td>'; 
				foreach($agreement as $row2){
					echo '<label >'.$row2['status']. '
				            <input type="radio" class="radio-inline" name="TopMangrAgree['.$index.']" class="TopMangrAgreeRadio" value="'.$row2['ID'].'"';
				            if($row['topManager_agree'] == $row2['ID']){ echo "checked"; }
				    echo'></label>';	  
				};
				echo'</td>';
			echo "</tr>";
		} 
	}	

	//-----get pending vacations as admin--------------
	function getPendingVacAsAdmin(){
		$con = connect();
		$sql= '';
		//-----old sql-----------
		// $sql .= "SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,t.topManager_agree ,vs2.status as topAgreeStatus,t.AdminConfirm,d2.emp_name as MgrName ,d3.emp_name as TopMgrName
		// 		FROM 	t_data d,t_data d2,t_data d3 ,t_transe t ,t_case c ,managements m , vac_status vs, vac_status vs2 
		// 		WHERE 	t.emp_id=d.ID 
		// 				and t.id_case=c.ID 
		// 				and t.topManager_agree in (1,2) 
		// 				and t.AdminConfirm=3
		// 				and t.Mang_id=m.ID 
		// 				and t.Manager_agree=vs.ID
		// 				and t.topManager_agree=vs2.ID
		// 				and t.manager_id=d2.ID
		// 				and t.top_manager_id=d3.ID";

		$sql .="SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,t.topManager_agree ,vs2.status as topAgreeStatus,t.AdminConfirm,IFNULL(d2.emp_name,'لا يوجد') as MgrName ,d3.emp_name as TopMgrName
				FROM t_data d3 ,t_case c ,managements m , vac_status vs, vac_status vs2,t_data d 
				RIGHT OUTER JOIN t_transe t ON d.ID = t.emp_id LEFT OUTER JOIN  t_data d2 ON t.manager_id=d2.ID
				WHERE t.id_case=c.ID 
						and t.topManager_agree in (1,2) 
						and t.AdminConfirm=3
						and t.Mang_id=m.ID 
						and t.Manager_agree=vs.ID
						and t.topManager_agree=vs2.ID
						and t.topManager_agree = 1
						and t.top_manager_id=d3.ID";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$vacStatus= "SELECT ID,status FROM vac_status  where ID != 4";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['MgrName']. "</td>";
				echo"<td>".  $row['mgrAgreeStatus']. "</td>";
				echo"<td>".  $row['TopMgrName']. "</td>";
				echo"<td>".  $row['topAgreeStatus']. "</td>";
				echo'<td>'; 
					foreach($agreement as $row2){
						echo '<label >'.$row2['status'].'
					            <input type="radio" class="radio-inline" name="AdminAgree['.$index.']" class="AdminAgreeRadio" value="'.$row2['ID'].'"';
					            if($row['AdminConfirm'] == $row2['ID']){ echo "checked"; }
					    echo'></label>';	  
					};
				echo'</td>';
			echo "</tr>";
		} 
	}

		//-----get pending vacations as admin and manager --------------
	function getPendingVacAsAdminandManager(){
		$con = connect();
		$sql= '';
		$sql .="SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,t.topManager_agree ,vs2.status as topAgreeStatus,t.AdminConfirm,vs3.status as AdminAgreeStatus,d2.emp_name as MgrName ,d3.emp_name as TopMgrName
				FROM t_data d3 ,t_case c ,managements m , vac_status vs, vac_status vs2,vac_status vs3,t_data d 
				RIGHT OUTER JOIN t_transe t ON d.ID = t.emp_id LEFT OUTER JOIN  t_data d2 ON t.manager_id=d2.ID
				WHERE t.id_case=c.ID 
						and t.topManager_agree in (1,2,3)
						and t.AdminConfirm =vs3.ID
						and t.AdminConfirm =3
						and t.manager_id={$_SESSION['UserID']}
						and t.Mang_id=m.ID 
						and t.Manager_agree=vs.ID
						and t.topManager_agree=vs2.ID
						and t.topManager_agree in(1,2,3)
						and t.top_manager_id=d3.ID";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$vacStatus= "SELECT ID,status FROM vac_status  where ID != 4";
		//status for manager
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		//status for admin
		$stmt3 = $con->prepare($vacStatus);
		$stmt3->execute();
		$agreement2 = $stmt3->fetchAll();
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['MgrName']. "</td>";
				echo'<td>'; 
					if($row['Manager_agree'] ==3){
						foreach($agreement as $row2){
							if( $row2['ID']<4){
								echo '<label >'.$row2['status'].'
					            <input type="radio" class="radio-inline" name="MangrAgree['.$index.']" class="MangrAgreeRadio" value="'.$row2['ID'].'"';
					            if($row['Manager_agree'] == $row2['ID']){ echo "checked"; }
					    		echo'></label>';
							}	  
					    }
					}else{
						echo  $row['mgrAgreeStatus'] ;
					}
				echo'</td>';
				echo"<td>".  $row['TopMgrName']. "</td>";
				echo"<td>".  $row['topAgreeStatus']. "</td>";
				echo'<td>'; 
					if($row['topManager_agree']<3){
						foreach($agreement2 as $row2){
							if($row2['ID']!=4){
								echo '<label >'.$row2['status'].'
							        <input type="radio" class="radio-inline" name="AdminAgree['.$index.']" class="AdminAgreeRadio" value="'.$row2['ID'].'"';
							    if($row['AdminConfirm'] == $row2['ID']){ echo "checked"; }
							    echo'></label>';
							}		  
						}
					}else{
						echo $row['AdminAgreeStatus'];
					}
					
				echo'</td>';
			echo "</tr>";
		} 
	}


	//------------reply to vacations function------------
	function saveVacationAgree(){
		if(isset($_POST['TopMangrAgree']) && isset($_POST['MangrAgree'])){
			echo "in TOP manager agree";
			$Topanswers = isset($_POST['TopMangrAgree']) ? $_POST['TopMangrAgree'] : array();
			$answers = isset($_POST['MangrAgree']) ? $_POST['MangrAgree'] : array();
			//$answers = $_POST['TopMangrAgree'];
			print_r($Topanswers);
			$con = connect();
			$sql= '';
			
			//Iterate through each answer
			foreach($Topanswers as $key => $answer) {
				echo"1st foreach";
				print_r($answer) ;
				echo $key;
				$sql = "UPDATE t_transe SET topManager_agree =:Agree where ID= :key";
				$stmt = $con->prepare($sql);
			    $stmt->bindParam(':Agree', $answer, PDO::PARAM_INT);
			    $stmt->bindParam(':key', $key, PDO::PARAM_INT);
				//$stmt->execute(array($answer));
				$stmt->execute();
				//echo $sql;
				if($stmt){
				    echo 'Row inserted!<br>';
				    //echo $answer;
				}
				elseif(!$stmt){
					echo 'error!<br>';
				}
			}
			foreach($answers as $key => $answer) {
				echo"2nd foreach";
				print_r($answer) ;
				echo $key;
				$sql = "UPDATE t_transe SET Manager_agree =:Agree where ID= :key";
				$stmt = $con->prepare($sql);
			    $stmt->bindParam(':Agree', $answer, PDO::PARAM_INT);
			    $stmt->bindParam(':key', $key, PDO::PARAM_INT);
				//$stmt->execute(array($answer));
				$stmt->execute();
				//echo $sql;
				if($stmt){
				    echo 'Row inserted!<br>';
				    //echo $answer;
				}
				elseif(!$stmt){
					echo 'error!<br>';
				}
			}
		}elseif(isset($_POST['TopMangrAgree'])){
			echo "in TOP manager agree only";
			$Topanswers = isset($_POST['TopMangrAgree']) ? $_POST['TopMangrAgree'] : array();
			$answers = isset($_POST['MangrAgree']) ? $_POST['MangrAgree'] : array();
			//$answers = $_POST['TopMangrAgree'];
			print_r($Topanswers);
			$con = connect();
			$sql= '';
			
			//Iterate through each answer
			foreach($Topanswers as $key => $answer) {
				echo"1st foreach";
				print_r($answer) ;
				echo $key;
				$sql = "UPDATE t_transe SET topManager_agree =:Agree where ID= :key";
				$stmt = $con->prepare($sql);
			    $stmt->bindParam(':Agree', $answer, PDO::PARAM_INT);
			    $stmt->bindParam(':key', $key, PDO::PARAM_INT);
				//$stmt->execute(array($answer));
				$stmt->execute();
				//echo $sql;
				if($stmt){
				    echo 'Row inserted!<br>';
				    //echo $answer;
				}
				elseif(!$stmt){
					echo 'error!<br>';
				}
			}
		}
		elseif(isset($_POST['MangrAgree'])){
			echo "in manager agree";
			$answers = isset($_POST['MangrAgree']) ? $_POST['MangrAgree'] : array();
			//$answers = $_POST['MangrAgree'];
			$con = connect();
			$sql= '';
			
			//Iterate through each answer
			foreach($answers as $key => $answer) {
				print_r($answer) ;
				echo $key;
				$sql = "UPDATE t_transe SET Manager_agree =:Agree where ID= :key";
				$stmt = $con->prepare($sql);
			    $stmt->bindParam(':Agree', $answer, PDO::PARAM_INT);
			    $stmt->bindParam(':key', $key, PDO::PARAM_INT);
				//$stmt->execute(array($answer));
				$stmt->execute();
				//echo $sql;
				if($stmt){
				    echo 'Row inserted!<br>';
				    //echo $answer;
				}
				elseif(!$stmt){
					echo 'error!<br>';
				}
			}
		}elseif(isset($_POST['AdminAgree'])){ //admin
			echo "in admin agree";
			$answers = isset($_POST['AdminAgree']) ? $_POST['AdminAgree'] : array();
			//$answers = $_POST['AdminAgree'];
			$con = connect();
			$sql= '';
			
			//Iterate through each answer
			foreach($answers as $key => $answer) {
				print_r($answer) ;
				echo $key;
				$sql = "UPDATE t_transe SET AdminConfirm =:Agree where ID= :key";
				$stmt = $con->prepare($sql);
			    $stmt->bindParam(':Agree', $answer, PDO::PARAM_INT);
			    $stmt->bindParam(':key', $key, PDO::PARAM_INT);
				//$stmt->execute(array($answer));
				$stmt->execute();
				//echo $sql;
				if($stmt){
				    echo 'Row inserted!<br>';
				    //echo $answer;
				}
				elseif(!$stmt){
					echo 'error!<br>';
				}
			}
		}
	}

	//------------get confirmed vacations as manager------------ 

	function getConfirmedVacAsManager(){
		$con = connect();
		$sql= '';
		$sql .= "SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,t.AdminConfirm,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,d2.emp_name as TopMgrName
				FROM 	t_data d,t_data d2,t_transe t ,t_case c ,managements m , vac_status vs, vac_status vs2 ,vac_status vs3
				WHERE 	t.emp_id=d.ID 
						and t.id_case=c.ID 
						and t.manager_id={$_SESSION['UserID']}
						and t.Manager_agree in(1,2) 
						and t.Mang_id=m.ID 
						and t.Manager_agree=vs.ID
						and t.topManager_agree=vs2.ID
						and t.AdminConfirm=vs3.ID
						and t.top_manager_id=d2.ID";
		if(!empty($_GET['search'])){
			$sql .= " and (d.emp_code like '%". $_GET['search'] ."%' OR d.emp_name like '%". $_GET['search'] ."%')";	
		}
		if(!empty($_GET['dateTo']) && !empty($_GET['dateFrom']) ){
			$sql .= " and (t.start_date between '".$_GET['dateFrom']."' and '".$_GET['dateTo'] ."')";
		}

		$sql .= " Order By t.start_date desc";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$vacStatus= "SELECT ID,status FROM vac_status ";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		foreach($result as $row){
			$index= $row['id'];
			// if( $row['AdminConfirm'] == 5 || $row['AdminConfirm'] == 6){
				
			// }
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['mgrAgreeStatus']. "</td>";
				echo"<td>".  $row['TopMgrName']. "</td>";
				echo"<td>".  $row['topAgreeStatus']. "</td>";
				echo"<td>".  $row['AdminAgreeStatus']. "</td>";
			echo "</tr>";
		} 
	}	
	//------------get confirmed vacations as Top manager------------ 
	function getConfirmedVacAsTopManager(){
		$con = connect();
		$sql= '';
		$sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,IFnull(d2.emp_name,'لا يوجد') as MgrName
			FROM t_case c ,managements m , vac_status vs ,vac_status vs2,vac_status vs3,t_data d
			RIGHT OUTER JOIN t_transe t ON d.ID = t.emp_id 
            LEFT OUTER JOIN  t_data d2 ON t.manager_id=d2.ID
			WHERE  t.id_case=c.ID 
			and t.Mang_id=m.ID
			and t.topManager_agree in (1,2)
			and t.Manager_agree = 1
			and t.Manager_agree=vs.ID
			and t.topManager_agree=vs2.ID
			and t.AdminConfirm=vs3.ID
            and  t.top_manager_id={$_SESSION['UserID']} ";
			//old sql
			// $sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,d2.emp_name as MgrName
			// FROM t_data d,t_data d2,t_transe t ,t_case c ,managements m , vac_status vs ,vac_status vs2,vac_status vs3
			// WHERE t.emp_id=d.ID 
			// and t.id_case=c.ID 
			// and  (t.top_manager_id={$_SESSION['UserID']} or t.manager_id={$_SESSION['UserID']})
			// and (t.topManager_agree in (1,2) )
			// and t.Mang_id=m.ID 
			// and t.Manager_agree=vs.ID
			// and t.topManager_agree=vs2.ID
			// and t.AdminConfirm=vs3.ID
			// and t.manager_id=d2.ID";


		if(!empty($_GET['search'])){
			$sql .= " and (d.emp_code like '%". $_GET['search'] ."%' OR d.emp_name like '%". $_GET['search'] ."%')";	
		}
		if(!empty($_GET['dateTo']) && !empty($_GET['dateFrom']) ){
			$sql .= " and (t.start_date between '".$_GET['dateFrom']."' and '".$_GET['dateTo'] ."')";
		}

		$sql .=" Order By  t.start_date desc";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$count= $stmt->rowCount();
		$vacStatus= "SELECT ID,status FROM vac_status ";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['MgrName']. "</td>";
				echo"<td>".  $row['mgrAgreeStatus']. "</td>"; 
				echo"<td>".  $row['topAgreeStatus']. "</td>";
				echo"<td>".  $row['AdminAgreeStatus']. "</td>";
			echo "</tr>";
		} 
	}
	//------------get confirmed vacations as Admin------------ 
	function getConfirmedVacAsAdmin(){
		$con = connect();
		$sql= '';
		//--------old sql------------
		// $sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,d2.emp_name as MgrName,d3.emp_name as TopMgrName
		// 	FROM t_data d,t_data d2,t_data d3 ,t_transe t ,t_case c ,managements m , vac_status vs ,vac_status vs2,vac_status vs3
		// 	WHERE t.emp_id=d.ID 
		// 	and t.id_case=c.ID 
		// 	and t.AdminConfirm in(1,2)
		// 	and t.Mang_id=m.ID 
		// 	and t.Manager_agree=vs.ID
		// 	and t.topManager_agree=vs2.ID
		// 	and t.AdminConfirm=vs3.ID
		// 	and t.manager_id=d2.ID
		// 	and t.top_manager_id=d3.ID";

		$sql .="SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,IFNULL(d2.emp_name,'لا يوجد' )as MgrName,d3.emp_name as TopMgrName
			FROM t_data d3, t_case c ,managements m , vac_status vs ,vac_status vs2,vac_status vs3,t_data d 			
			RIGHT OUTER JOIN t_transe t ON d.ID = t.emp_id LEFT OUTER JOIN  t_data d2 ON t.manager_id=d2.ID
			WHERE t.id_case=c.ID 
			and t.AdminConfirm not in(3,4)
			and t.Mang_id=m.ID 
			and t.Manager_agree=vs.ID
			and t.topManager_agree=vs2.ID
			and t.AdminConfirm=vs3.ID
			and t.top_manager_id=d3.ID";

		if(!empty($_GET['search'])){
			$sql .= " and (d.emp_code like '%". $_GET['search'] ."%' OR d.emp_name like '%". $_GET['search'] ."%')";	
		}
		if(!empty($_GET['dateTo']) && !empty($_GET['dateFrom']) ){
			$sql .= " and (t.start_date between '".$_GET['dateFrom']."' and '".$_GET['dateTo'] ."')";
		}
		$sql .=" Order By  t.start_date desc ,d.emp_code";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$count= $stmt->rowCount();
		$vacStatus= "SELECT ID,status FROM vac_status ";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['emp_code']. "</td>";
				echo"<td>".  $row['emp_name']. "</td>";
				echo"<td>".  $row['Management']. "</td>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['MgrName']. "</td>";
				echo"<td>".  $row['mgrAgreeStatus']. "</td>"; 
				echo"<td>".  $row['TopMgrName']. "</td>";
				echo"<td>".  $row['topAgreeStatus']. "</td>";
				echo"<td>".  $row['AdminAgreeStatus']. "</td>";
			echo "</tr>";
		} 
	}
	
	//-------------- get report for admin-------------------

	function getConfirmedVacAsAdminReport(){
		$con = connect();
		$sql= "";
		$output1="";
		$sql .="SELECT t.id,d.emp_code,d.emp_name,t.start_date,t.end_date,t.duration,c.case_desc,dn.day_n
				FROM t_case c RIGHT OUTER JOIN t_transe t ON c.ID = t.id_case 
							  LEFT OUTER JOIN t_data d ON t.emp_id = d.ID 
							  LEFT OUTER JOIN t_day_n DN ON d.day_night = dn.ID	
				WHERE t.AdminConfirm not in(3,4)";

		if(!empty($_GET['search'])){
			$sql .= " and (d.emp_code like '%". $_GET['search'] ."%' OR d.emp_name like '%". $_GET['search'] ."%')";	
		}
		if(!empty($_GET['month'])){
			$sql .= " and MONTH(t.start_date)= ". $_GET['month'] ."";	
		}
		if(!empty($_GET['year'])){
			$sql .= " and YEAR(t.start_date)= ". $_GET['year'] ."";	
		}
		// if(!empty($_GET['dateTo']) && !empty($_GET['dateFrom']) ){
		// 	$sql .= " and (t.start_date between '".$_GET['dateFrom']."' and '".$_GET['dateTo'] ."')";
		// }
		$sql .= " GROUP BY t.start_date
				  ORDER BY t.start_date asc , d.emp_code desc";
				  // echo $sql;
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$count= $stmt->rowCount();		
		foreach($result as $row){
			//$index= $row['id'];
			$output1 .= "<tr><td class='bg-info'><div class='col-sm-12'>".$row['start_date']."</div></td></tr>".
						 "<tr>
						 	<td></td>
							<td>".  $row['emp_code']. "</td>
							<td>".  $row['emp_name']. "</td>
							<td>".  $row['day_n']. "</td>
							<td>".  $row['case_desc']. "</td>
							<td>".  $row['start_date']. "</td>
							<td>".  $row['end_date']. "</td>
							<td>".  $row['duration']. "</td>
						 </tr>";				
		} 
		echo $output1 ;
		 // echo $sql;
	}
	//------------get vacations' status feedback as Employee------------ 
	function getVacationStatusAsEmp(){
		$con = connect();
		$sql= '';
		$sql .= "SELECT  t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,vs.status as mgrAgreeStatus ,vs2.status as topAgreeStatus,IFNULL(d2.emp_name,'لا يوجد') as MgrName ,d3.emp_name as TopMgrName,vs3.status as AdminAgreeStatus
				FROM t_data d3 ,t_case c, vac_status vs, vac_status vs2,vac_status vs3,t_data d 
				RIGHT OUTER JOIN t_transe t ON d.ID = t.emp_id LEFT OUTER JOIN  t_data d2 ON t.manager_id=d2.ID
				WHERE   t.emp_id = {$_SESSION['UserID']}
                		and t.id_case=c.ID 
						and t.Manager_agree=vs.ID
						and t.topManager_agree=vs2.ID
                        AND t.AdminConfirm= vs3.ID
						and t.top_manager_id=d3.ID";
		// if(!empty($_GET['search'])){
		// 	$sql .= " and (d.emp_code like '%". $_GET['search'] ."%' OR d.emp_name like '%". $_GET['search'] ."%')";	
		// }
		if(!empty($_GET['dateTo']) && !empty($_GET['dateFrom']) ){
			$sql .= " and (t.start_date between '".$_GET['dateFrom']."' and '".$_GET['dateTo'] ."')";
		}

		$sql .= " Order By  t.start_date desc";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$vacStatus= "SELECT ID,status FROM vac_status ";
		$stmt2 = $con->prepare($vacStatus);
		$stmt2->execute();
		$agreement = $stmt2->fetchAll();
		foreach($result as $row){
			$index= $row['id'];
			echo"<tr>";
				echo"<td>".  $row['case_desc']. "</td>";
				echo"<td>".  $row['start_date']. "</td>";
				echo"<td>".  $row['end_date']. "</td>";
				echo"<td>".  $row['duration']. "</td>";
				echo"<td>".  $row['MgrName']. "</td>";
				echo"<td>".  $row['mgrAgreeStatus']. "</td>";
				echo"<td>".  $row['TopMgrName']. "</td>";
				echo"<td>".  $row['topAgreeStatus']. "</td>";
				echo"<td>".  $row['AdminAgreeStatus']. "</td>";
			echo "</tr>";
		}	
	}