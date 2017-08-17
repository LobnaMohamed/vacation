<?php 
	include 'header.html';
	include 'functions.php';
?>
	<nav class="navbar">
		<div class="container-fluid">
			<ul class="nav navbar-nav pull-right">
			  <li class="active"><a href="#">الاجازات المعتمدة</a></li>
			  <li><a href="#">الاجازات المطلوب اعتمادها</a></li>
			</ul>
		</div>
	</nav>
	<div class="container">
	    <header class="row text-center">
	    	<!-- <img class= "col-lg-2 logo" src="images/amoc2.png"> -->
	  	    <h1 class="col-lg-12">الاجازات المطلوب اعتمادها</h1>  
	    </header>
	    <form class="form-horizontal">
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
						getPendingVacAsManager(); 
					?>
				</tbody>
			</table>
			<input type="submit" name="vacationAgree" id="vacationAgree" class="btn btn-success" onclick="saveVacationAgree()">
		</form>		
	</div> 
	
	<?php include 'footer.php'; ?>