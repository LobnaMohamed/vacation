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
	  	    <h1 class="col-lg-12">اجازاتى</h1>  
	    </header>
	    <div class="table-responsive row">
	    	<form class="navbar-form row" role="search" id="searchEmp" method="GET">
			    <div class="form-group add-on ">
			    	
					<label for = "searchDateFrom">التاريخ من:</label>
					<input class="form-control"  name="searchDateFrom" id="searchDateFrom" type="date">
					<label for = "searchDateTo">التاريخ الى:</label>
					<input class="form-control"  name="searchDateTo" id="searchDateTo" type="date"> 
			    </div>   
		    </form>
			<table id="confirmedVac" class="table table-striped table-bordered table-responsive">	
				<thead>
					<tr>
						<th>تاريخ تحرير الاجازة </th>
						<th>نوع الاجازة</th>
						<th>من تاريخ</th>
						<th>الى تاريخ</th>
						<th>المدة</th>
						<?php
							echo"
								<th>الرئيس المباشر</th>
								<th>موافقة الرئيس المباشر</th>
								<th>الرئيس الاعلى</th>
								<th>موافقة الرئيس الاعلى</th>
								<th>اعتماد الاستحقاقت</th>";
						?>
				    </tr>		
				</thead>
				<tbody id="VacStatusbody">
					<?php
					//check if the logged in manager or top manager or admin then 
					//run the corresponding function 
						getVacationStatusAsEmp(); 
					?>
				</tbody>
			</table>	
		</div>	
	</div> 
	<?php	include 'footer.php'; ?>