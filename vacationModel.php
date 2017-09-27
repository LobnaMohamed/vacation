<?php
	session_start();
	if(!isset($_SESSION['Username'])){
		header('Location: index.php');//redirect
		exit();
	}
	require 'functions.php';
	include 'header.php';

?>
<div class="container">
    <header class="row text-center">
    	<img class= "col-sm-2 logo" src="images/amoc2.png">
  	    <h1 class="col-sm-4 col-sm-offset-2 ">نموذج الاجـــــازة</h1>	    
    </header>	  
    <form  method="POST" action="add.php" id="vacForm" onsubmit="return confirm('تأكيد ارسال الاجازة');">
    	<div class="row form-group">	    
		    <div class="col-sm-4">
	    		<label class="col-form-label" for="address" >العنوان</label>
		    	<input type="text" class="form-control" id="address" name="address" value="بالملف">
		    	<label for="topManager">الرئيس الاعلى</label>
			    <select class="form-control" id="topManager" name="topManager" required>
			    	<option selected disabled hidden style='display: none' value=''></option>
		   		    <?php 	getTopManagers();   ?>			    
		   		</select>				    	
		   	</div> 	
		    <div class="col-sm-4">
	    		<label for="name" >الاســـــم</label>
	    		<input type="text" class="form-control" id="name" name="name" placeholder="Your name.." required>
				<label for="manager">المدير المباشر</label>
			    <select class="form-control" id="manager" name="manager">
			    	<option selected disabled hidden style='display: none' value=''></option>
		   		    <?php  	getManagers();   ?>
				</select>	
		    </div>					
			<div class="col-sm-4">
				<label for="code">رقم القيد</label>
		    	<input type="number" class="form-control" id="code" name="code" placeholder="Your Code..">
		    	<input hidden type="text" id="emp" name="empID"/>
	    		<label for="Management" >الادارة:</label>
				<select class="form-control" id="Management" name="Management">
			    	<option selected disabled hidden style='display: none' value=''></option>
		   		    <?php  	getManagement();   ?>
				</select>
			</div>
		</div>
		<div class="row form-group">					
			<div class="col-sm-3">
				<label for="duration " >مدة الاجازة:</label>
				<input type="text" class="form-control" id="duration" name="duration" placeholder="duration..">	
			</div>
			<div class="col-sm-3">
				<label for="dateTo" >التاريخ الى</label>
				<input type="date" class="form-control" id="dateTo" name="vacDateTo" placeholder="date to..">
			</div>
			<div class="col-sm-3">
				<label for="date" >التاريخ من</label>
				<input type="date" class="form-control" id="date" name="vacDate" placeholder="date.." required>
			</div>
			<div class="col-sm-3">
				<label for="vacType">نوع الاجازة</label>
	   		    <select class="form-control" id="vacType" name="case" required>
	   		    	<option selected disabled hidden style='display: none' value='' ></option>
		   		    <?php getCase();   ?>
			    </select>
			</div>						
		</div>
		<div class = "row form-group">
			<div class="col-sm-6 col-sm-offset-3">
				<input class ="btn btn-info form-control" type="Submit" value="ارسال" name="submitVac">
				<!-- <i class="fa fa-send fa-fw send-icon"></i>			 -->
			</div>	
		</div>
    </form>
</div>
	<?php include 'footer.php'; ?>
