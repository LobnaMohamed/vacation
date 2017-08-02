<?php 
	include 'header.html';
	require 'connect.php';
	
	$sql = "SELECT d.*, a.active as activeStatus, dn.day_n as shift 
		    FROM t_data d left JOIN t_active a on d.active = a.ID 
		    			  left Join t_day_n  dn  on d.day_night = dn.ID
		    ORDER BY id ASC";
	$stmt = $con->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();	        
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>emp data</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
	    <header class="row text-center">
	    	<!-- <img class= "col-lg-2 logo" src="images/amoc2.png"> -->
	  	    <h1 class="col-lg-12">بيانات العاملين</h1>	    
	    </header>	  
		<table class="table table-striped table-bordered">
		  	<thead>
			    <tr>
			      <th>رقم القيد</th>
			      <th>الاسم</th>
			      <th>نوع العقد</th>
			      <th>الوظيفة</th>
			      <th>الادارة العامة</th>
			      <th>المستوى</th>
			      <th>نهارى/ورادى</th>
			      <th>بالخدمة/خارج الخدمة</th>
			    </tr>
		  	</thead>
			<tbody>
				<?php
				   foreach($result as $row){
				?>
				<tr>
					<td><?php echo $row['emp_code']; ?></td>
					<td><?php echo $row['emp_name']; ?></td>
					<td><?php echo $row['contract_type']; ?></td>
					<td><?php echo $row['id_job']; ?></td>
					<td><?php echo $row['g_management']; ?></td>
					<td><?php echo $row['level']; ?></td>
					<td><?php echo $row['shift']; ?></td>
					<td><?php echo $row['activeStatus']; ?></td>
					<td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editEmp">تعديل</button></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<!-- Modal -->
		<div id="editEmp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">تعديل البيانات</h4>
					</div>
					<div class="modal-body">
						<p>Some text in the modal.</p>
					</div>
					<div class="modal-footer">
						<a href="#" type="button" class="btn btn-default edit" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>