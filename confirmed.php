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
			<table id="confirmedVac" class="table table-striped table-bordered">	
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
							if($_SESSION['UserGroup']==1){
								echo"
									<th>الرئيس المباشر</th>
									<th>موافقة الرئيس المباشر</th>
									<th>موافقة الرئيس الاعلى</th>
									<th>اعتماد الاستحقاقت</th>";
							}
							elseif($_SESSION['UserGroup']==2){
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
				<tbody>
					<?php
					//check if the logged in manager or top manager or admin then 
					//run the corresponding function 
						if($_SESSION['UserGroup']==1) {
							getConfirmedVacAsTopManager(); 
						}elseif($_SESSION['UserGroup']==2){
							getConfirmedVacAsManager(); 
						}elseif($_SESSION['UserGroup']==3){
							getConfirmedVacAsAdmin(); 
						} 
					?>
				</tbody>
			</table>		
	</div> 
	<?php	include 'footer.php'; ?>