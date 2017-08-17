<?php 
	include 'header.html';
	require 'functions.php';        
?>
	<div class="container">
	    <header class="row text-center">
	    	<!-- <img class= "col-lg-2 logo" src="images/amoc2.png"> -->
	  	    <h1 class="col-lg-12">بيانات العاملين</h1>  
	    </header>
	    <div class="table-responsive row">
		    <form class="navbar-form" role="search">
			    <div class="input-group add-on">
					<input class="form-control" placeholder="البحث" name="search" id="search" type="text">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</div>
			    </div>
		    </form>
			<table id="empData" class="table table-striped table-bordered">
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
				      <th><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addEmp">إضافة</button></th>
				    </tr>
			  	</thead>
				<tbody>
					<?php getAllEmp(); ?>
				</tbody>
			</table>	
	    </div>	  
		<!-- add Modal -->
		<div id="addEmp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> إضافة عامل جديد </h4>
					</div>
					<div class="modal-body">
						<p>Some text in the modal.</p>
					</div>
					<div class="modal-footer">
						<a href="#" type="button" class="btn btn-default add" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>
		<!-- Edit Modal -->
		<div id="editEmp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> تعديل البيانات </h4>
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
	<?php include 'footer.php'; ?>