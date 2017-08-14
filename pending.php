<?php 
	include 'header.html';
	include 'functions.php';
?>
<!DOCTYPE html>
<html>
<html dir="rtl" lang="ar">
<head>
	<title>manager pending</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<nav class="navbar ">
		<div class="container-fluid">
			<ul class="nav navbar-nav pull-right">
			  <li class="active"><a href="#">الاجازات المعتمدة</a></li>
			  <li><a href="#">الاجازات المطلوب اعتمادها</a></li>
			  <li><a href="index.php">عمل اجازة</a></li>
			</ul>
		</div>
	</nav>
	<div class="container">
	    <header class="row text-center">
	    	<!-- <img class= "col-lg-2 logo" src="images/amoc2.png"> -->
	  	    <h1 class="col-lg-12">الاجازات المطلوب اعتمادها</h1>  
	    </header>
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
				<?php getPendingVac(); ?>
			</tbody>
		</table>		
	</div> 

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>

</html>