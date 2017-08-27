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
	    <form class="form-horizontal" method="POST" action="done.php"> 
	    <!-- action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" -->
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
						<?php
							if($_SESSION['UserGroup']==1) { //top manager
								 echo"<th>الرئيس المباشر</th>";
								 echo"<th>موافقة الرئيس المباشر</th>";
								 echo"<th>موافقة الرئيس الاعلى</th>";
							
							}elseif($_SESSION['UserGroup']==2){//direct manager
								 echo"<th>موافقة الرئيس المباشر</th>";
								 echo"<th>الرئيس الاعلى</th>";
								 echo"<th>موافقة الرئيس الاعلى</th>";
							}  
							if($_SESSION['UserGroup']==3){ //est72a2at
								echo"<th>الرئيس المباشر</th>";
								echo"<th>موافقة الرئيس المباشر</th>";
								echo"<th>الرئيس الاعلى</th>";
							    echo"<th>موافقة الرئيس الاعلى</th>";
								echo"<th>اعتماد الاستحقاقات</th>";
							}
						?>
				    </tr>		
				</thead>
				<tbody>
					<?php
					//check if the logged in manager or top manager or admin then 
					//run the corresponding function 
						if($_SESSION['UserGroup']==1) { //top manager
							getPendingVacAsTopManager(); 
							
						}elseif($_SESSION['UserGroup']==2){//direct manager
							getPendingVacAsManager(); 
						}elseif($_SESSION['UserGroup']==3){ //est72a2at
							getPendingVacAsAdmin(); 
						}  
					?>
				</tbody>
			</table>
			<input type="submit" name="update" id="vacationAgree" class="btn btn-success">
		 </form>		
	</div> 
	<?php	include 'footer.php'; ?>