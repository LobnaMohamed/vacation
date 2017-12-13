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
	  	    <h1 class="col-lg-12">الاجازات المعتمدة</h1>  
	    </header>
	    <div class="table-responsive row">
	    	<form class="navbar-form row" role="search" id="searchEmp" method="GET">
			    <div class="form-group add-on ">
			    	<label for = "search">رقم القيد / الاسم :</label>
					<input class="form-control" placeholder="ابحث.." name="search" id="search" type="text">
					<label for = "searchDateFrom">التاريخ من:</label>
					<input class="form-control"  name="searchDateFrom" id="searchDateFrom" type="date">
					<label for = "searchDateTo">التاريخ الى:</label>
					<input class="form-control"  name="searchDateTo" id="searchDateTo" type="date"> 
			    </div>   
		    </form>
			<table id="confirmedVac" class="table table-striped table-bordered table-responsive">	
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
							if($_SESSION['UserGroup']==2){
								echo"
									<th>الرئيس المباشر</th>
									<th>موافقة الرئيس المباشر</th>
									<th>موافقة الرئيس الاعلى</th>
									<th>اعتماد الاستحقاقت</th>";
							}
							elseif($_SESSION['UserGroup']==1){
								echo"
									<th>موافقة الرئيس المباشر</th>
									<th>الرئيس الاعلى</th>
									<th>موافقة الرئيس الاعلى</th>
									<th>اعتماد الاستحقاقت</th>";
							} 
							elseif($_SESSION['UserGroup']==3){
								echo"
									<th>الرئيس المباشر</th>
									<th>موافقة الرئيس المباشر</th>
									<th>الرئيس الاعلى</th>
									<th>موافقة الرئيس الاعلى</th>
									<th>اعتماد الاستحقاقت</th>";
							}
						?>

				    </tr>		
				</thead>
				<tbody id="confirmedVacbody">
					<?php
					//check if the logged in manager or top manager or admin then 
					//run the corresponding function 
						if($_SESSION['UserGroup']==2) {
							getConfirmedVacAsTopManager(); 
						}elseif($_SESSION['UserGroup']==1){
							getConfirmedVacAsManager(); 
						}elseif($_SESSION['UserGroup']==3){
							getConfirmedVacAsAdmin(); 
						} 
					?>
				</tbody>
			</table>	
		</div>	
	</div> 
	<?php	include 'footer.php'; ?>