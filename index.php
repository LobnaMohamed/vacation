<?php
	require 'functions.php';
	include 'header.html';
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>vacations</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
	    <header class="row text-center">
	    	<img class= "col-lg-2 logo" src="images/amoc2.png">
	  	    <h1 class="col-lg-4 col-lg-offset-1 ">نموذج الاجـــــازة</h1>	    
	    </header>	  
	    <form  method="POST" action="add.php">
	    	<div class="row">	    
			    <div class="col-lg-4">
			    	<div class= "form-group">
			    		<label for="address" >العنوان</label>
				    	<input type="text" class="address form-control" name="address" placeholder="Your address..">
				    	<label for="topManager">الرئيس الاعلى</label>
					    <select class="topManager form-control" name="topManager" required>
					    	<option selected disabled hidden style='display: none' value=''></option>
				   		    <?php 	getManagers();   ?>			    
				   		</select>
						
			    	</div>			    	
			   	</div> 	
			    <div class="col-lg-4">
			    	<div class="form-group">
						<label for="code">رقم القيد</label>
				    	<input type="text" class="code form-control" name="code" placeholder="Your Code..">
						<label for="manager">المدير المباشر</label>
					    <select class="manager form-control" name="manager">
					    	<option selected disabled hidden style='display: none' value=''></option>
				   		    <?php  	getManagers();   ?>
						</select>
					</div>		
			    </div>					
				<div class="col-lg-4">
					<div class="form-group">
						<label for="name" >الاســـــم</label>
			    		<input type="text" class="name form-control" name="name" placeholder="Your name.." required>
			    		<label for="Management" >الادارة:</label>
						<input type="text" class="Management form-control" name="Management" placeholder="Management.." required>
						
					</div>	
				</div>
			</div>
			<div class="row form-group">					
					<div class="col-lg-3">
						<label for="duration " >مدة الاجازة:</label>
						<input type="text" class="duration form-control" name="duration" placeholder="duration..">	
					</div>
					<div class="col-lg-3">
						<label for="dateTo" >التاريخ الى</label>
						<input type="date" class="dateTo form-control" name="vacDateTo" placeholder="date to..">
					</div>
					<div class="col-lg-3">
						<label for="date" >التاريخ من</label>
						<input type="date" class="date form-control" name="vacDate" placeholder="date.." required>
					</div>
					<div class="col-lg-3">
						<label for="vacation">نوع الاجازة</label>
			   		    <select class="vacType form-control" name="case" required>
			   		    	<option selected disabled hidden style='display: none' value='' ></option>
				   		    <?php getCase();   ?>
					    </select>
					</div>						
			</div>
			<div class = "row form-group">
				<div class="col-lg-6 col-lg-offset-3">
					<input class ="btn btn-info form-control" type="Submit" value="ارسال" name="submitVac">
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