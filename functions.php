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
		    if ($con===NULL){ 
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

		//check if user exist

		$con = connect();
		$stmt = $con->prepare("SELECT emp_code,password,id_userGroup,ID,emp_name From t_data WHERE emp_code=? and password=?");
		$stmt->execute(array($username,$hashedPass));
		$count = $stmt->rowCount();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$userGroup= $row["id_userGroup"];
		$userID= $row["ID"];
		$user_fullName=$row["emp_name"];
		//if count >0 then the user exists
		if($count>0){
			$_SESSION['Username'] = $username;//register session
			$_SESSION['UserGroup'] = $userGroup;
			$_SESSION['UserID'] = $userID;
			$_SESSION['UserFullName'] = $user_fullName;
			//redirect according to privillage
			if($userGroup==3){
				header('Location: empdata.php');//redirect
			}else{
				header('Location: vacationmodel.php');//redirect
				
			}	
		}
	}
	//---------------get All Managers who can approve vacations as both manager and top manager in manager combobox function-----------------------
	function getManagers(){
		$con = connect();
		$sql= "SELECT ID,emp_code,emp_name FROM t_data where id_userGroup in(1,2)" ;
    	$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	    	foreach($result as $row){
			    echo "<option value=" .$row['ID'].">" . $row['emp_code'] ."   ".$row['emp_name']. "</option>";
			}
	}
	//------get Top Managers function-----------
	function getTopManagers(){
		$con = connect();
		$sql= "SELECT ID,emp_code,emp_name FROM t_data where id_userGroup=1" ;
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
			$manager= isset($_POST['manager'])? $_POST['manager'] :'';
			$vacType= isset($_POST['case'])? $_POST['case'] :'';
			// creating array of errors
			$formErrors = array();

			if (empty($empName) || empty($empCode) ){
				//$formErrors[] = 'username must be larger than  chars';
				echo "name and code cant be empty";
				// print_r($formErrors) ;
			} else {
				$con = connect();
				$sql= "INSERT INTO t_transe(emp_id,id_case,start_date,end_date,manager_id,top_manager_id,duration,mang_id) 
					   VALUES ('".$empID."','".$vacType."','".$date."','".$dateTo."','".$manager."','".$topManager."','".$duration."' ,'".$management."')" ;
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
		$sql= '';
		// $sql .= "SELECT d.ID,d.emp_code,d.emp_name,d.desc_job,d.management, a.active as activeStatus, dn.day_n as shift,m.management as g_management,j.job as job,l.level as level, c.contractType as contract
		//     FROM t_data d left JOIN t_active a on d.active = a.ID 
		//     			  left Join t_day_n  dn  on d.day_night = dn.ID
		//     			  left Join managements m  on d.g_management_id = m.ID
		//     			  left Join t_job j on d.id_job = j.ID
		//     			  left Join t_level l on d.level_id = l.ID
		//     			  left Join contract c on d.contract_type = c.ID";
		$sql .= "SELECT * FROM empdata"; //view
		if(isset($_POST['search'])){
			$sql .='WHERE emp_name LIKE "%'. $_POST['search'].'%"' ;
		}
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row){
			echo"<tr>";
			echo"<td>".  $row['emp_code']. "</td>";
			echo"<td>".  $row['emp_name']. "</td>";
			echo"<td>".  $row['contract']. "</td>";
			echo"<td>".  $row['job']. "</td>";
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
		//check if user comming from a request
		 // $_SERVER['REQUEST_METHOD'] == 'POST'
		if(isset($_POST['insertEmp'])){
			//assign variables

			$empName= isset($_POST['empName'])? filter_var($_POST['empName'],FILTER_SANITIZE_STRING) : '';
			$empCode= isset($_POST['empCode'])? filter_var($_POST['empCode'],FILTER_SANITIZE_NUMBER_INT):'';
			$contractType= isset($_POST['contractType'])? filter_var($_POST['contractType'],FILTER_SANITIZE_NUMBER_INT):'';
			$job= isset($_POST['job'])? filter_var($_POST['job'],FILTER_SANITIZE_NUMBER_INT):'';
			$job= $_POST['job'];
			echo $job;
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
		$con = connect();
		$sql= '';
		$sql .= "SELECT d.*, a.active as activeStatus, dn.day_n as shift 
		    FROM t_data d left JOIN t_active a on d.active = a.ID 
		    			  left Join t_day_n  dn  on d.day_night = dn.ID";
		if(isset($_POST['search'])){
			$sql .='WHERE emp_name LIKE "%'. $_POST['search'].'%"' ;
		}
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
		$sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status,t.topManager_agree,d2.emp_name as MgrName  
				FROM t_data d,t_data d2 ,t_transe t ,t_case c ,managements m , vac_status vs 
				WHERE t.emp_id=d.ID 
				and t.id_case=c.ID 
				and  (t.top_manager_id={$_SESSION['UserID']} or t.manager_id={$_SESSION['UserID']})
				and t.topManager_agree=3 
				and t.Mang_id=m.ID 
				and t.Manager_agree=vs.ID
				and t.manager_id=d2.ID";
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
		$sql .= "SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.Manager_agree,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,t.topManager_agree ,vs2.status as topAgreeStatus,t.AdminConfirm,d2.emp_name as MgrName ,d3.emp_name as TopMgrName
				FROM 	t_data d,t_data d2,t_data d3 ,t_transe t ,t_case c ,managements m , vac_status vs, vac_status vs2 
				WHERE 	t.emp_id=d.ID 
						and t.id_case=c.ID 
						and t.topManager_agree in (1,2) 
						and t.AdminConfirm=3
						and t.Mang_id=m.ID 
						and t.Manager_agree=vs.ID
						and t.topManager_agree=vs2.ID
						and t.manager_id=d2.ID
						and t.top_manager_id=d3.ID";
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
		$sql .= "SELECT t.id, t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,d2.emp_name as TopMgrName
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
		$sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,d2.emp_name as MgrName
				FROM t_data d,t_data d2,t_transe t ,t_case c ,managements m , vac_status vs ,vac_status vs2,vac_status vs3
				WHERE t.emp_id=d.ID 
				and t.id_case=c.ID 
				and  (t.top_manager_id={$_SESSION['UserID']} or t.manager_id={$_SESSION['UserID']})
				and (t.topManager_agree in (1,2) or  t.topManager_agree in (1,2))
				and t.Mang_id=m.ID 
				and t.Manager_agree=vs.ID
				and t.topManager_agree=vs2.ID
				and t.AdminConfirm=vs3.ID
				and t.manager_id=d2.ID";
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
		$sql .= "SELECT t.id,t.start_date,t.end_date,t.duration,d.emp_code,d.emp_name,c.case_desc,t.manager_id,t.top_manager_id,m.Management,vs.status as mgrAgreeStatus,vs2.status as topAgreeStatus,vs3.status as AdminAgreeStatus,d2.emp_name as MgrName,d3.emp_name as TopMgrName
				FROM t_data d,t_data d2,t_data d3 ,t_transe t ,t_case c ,managements m , vac_status vs ,vac_status vs2,vac_status vs3
				WHERE t.emp_id=d.ID 
				and t.id_case=c.ID 
				and t.AdminConfirm in(1,2)
				and t.Mang_id=m.ID 
				and t.Manager_agree=vs.ID
				and t.topManager_agree=vs2.ID
				and t.AdminConfirm=vs3.ID
				and t.manager_id=d2.ID
				and t.top_manager_id=d3.ID";
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