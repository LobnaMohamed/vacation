<?php 
	require 'connect.php';
	include 'header.html';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Manager home</title>
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
	<table class="table table-striped table-bordered">	
		<thead>
			
		</thead>
		<tbody>
			<?php getPendingVac(); ?>
		</tbody>
	</table>
</body>
</html>