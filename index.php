<?php 
	require 'connect.php';
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>vacations</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
	    <header class="row text-center">
	  	    <h1 class="col-lg-9 pull-right">نموذج الاجـــــازة</h1>
	  	    <img class= "col-lg-2 logo pull-left" src="images/amoc.jpg">
	    </header>	  
	    <form action="add.php" method="POST">
	    	<div class="row">	    
			    <div class="col-lg-4">
			    	<label for="address" >العنوان</label>
			    	<input type="text" class="address" name="address" placeholder="Your address..">
			    	<label for="topManager">الرئيس الاعلى</label>
				    <select class="topManager" name="topManager" required>
				    	<option selected disabled hidden style='display: none' value=''></option>
			   		    <?php
			   		    	$sql= "SELECT ID,emp_code,emp_name FROM t_data" ;
			   		    	$stmt = $con->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll();
			   		    	    foreach($result as $row){
								    echo "<option value=" .$row['ID'].">" . $row['emp_code'] ."   ".$row['emp_name']. "</option>";
								}
			   		    ?>			    
			   		</select>
			   		<label for="duration" >مدة الاجازة:</label>
					<input type="text" class="duration" name="duration" placeholder="duration..">	
			    </div>
			    <div class="col-lg-4">
			    	<div class="form-group">
						<label for="code">رقم القيد</label>
				    	<input type="text" class="code form-control" name="code" placeholder="Your Code..">
			    	</div>
					<div class="form-group">
						<label for="manager">المدير المباشر</label>
					    <select class="manager form-control" name="manager">
					    	<option selected disabled hidden style='display: none' value=''></option>
				   		    <?php
				   		    	$sql= "SELECT ID,emp_code,emp_name FROM t_data" ;
				   		    	$stmt = $con->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetchAll();
				   		    	    foreach($result as $row){
									    echo "<option value=" .$row['ID'].">" . $row['emp_code'] ."   ".$row['emp_name']. "</option>";
									}
				   		    ?>
						</select>
					</div>
			    	<div class="form-group">
				    	<label for="date" >التاريخ من</label>
						<input type="date" class="date form-control" name="vacDate" placeholder="date..">
					</div>
					<div class="form-group">	
						<label for="dateTo" >التاريخ الى</label>
						<input type="date" class="dateTo form-control" name="vacDateTo" placeholder="date to..">
			    	</div>
				</div> 					
				<div class="col-lg-4">
					<label for="name" >الاســـــم</label>
			    	<input type="text" class="name " name="name" placeholder="Your name..">
			    	<label for="Management" >الادارة:</label>
					<input type="text" class="Management" name="Management" placeholder="Management..">
					<label for="vacation">نوع الاجازة</label>
		   		    <select class="vacType" name="case">
		   		    	<option selected disabled hidden style='display: none' value=''></option>
			   		    <?php
			   		    	$sql= "SELECT ID,case_desc FROM t_case" ;
			   		    	$stmt = $con->prepare($sql);
							$stmt->execute();
							$result = $stmt->fetchAll();
			   		    	    foreach($result as $row){
								    echo "<option value=" .$row['ID'].">" . $row['case_desc'] . "</option>";
								}
			   		    ?>
				    </select>		
				</div>
			</div>

			<div class = "row">
				<div class="col-lg-6">
					<input class ="btn btn-success" type="Submit" value="ارسال">
					<!-- <i class="fa fa-send fa-fw send-icon"></i>			 -->
				</div>	
			</div>
				

	    </form>
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>