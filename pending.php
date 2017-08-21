<?php 
	session_start();
	if(isset($_SESSION['Username'])){
		//echo "Welcome" . $_SESSION['Username'];
	}else{
		header('Location: index.php');//redirect
		exit();
	}
	include 'header.php';
	include 'functions.php';
?>
	<div class="container">
	    <header class="row text-center">
	    	<!-- <img class= "col-lg-2 logo" src="images/amoc2.png"> -->
	  	    <h1 class="col-lg-12">الاجازات المطلوب اعتمادها</h1>  
	    </header>
	    <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
			<table id="pendingVac" class="table table-striped table-bordered">	
				<thead>
					<tr>
						<th>رقم القيد</th>
						<th>الاسم</th>
						<th>الادارة</th>
						<th>نوع الاجازة</th>
						<th>من تاريخ</th>
						<th>الى تاريخ</th>
						<th>المدة</th>
						<th>موافقة الرئيس المباشر</th>
						<th>موافقة الرئيس الاعلى</th>
				    </tr>		
				</thead>
				<tbody>
					<?php
					//check if the logged in manager or top manager or admin then 
					//run the corresponding function 
						if($_SESSION['UserGroup']==1) {
							getPendingVacAsTopManager(); 
							
						}elseif($_SESSION['UserGroup']==2){
							getPendingVacAsManager(); 
							
						} 
					?>
				</tbody>
			</table>
			<input type="submit" name="vacationAgree" id="vacationAgree" class="btn btn-success" onclick="saveVacationAgree()">
		</form>		
	</div> 
	
	<?php include 'footer.php'; ?>