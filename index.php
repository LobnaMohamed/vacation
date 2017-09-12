<?php
	session_start();
	if(isset($_SESSION['Username'])){
		//echo "Welcome" . $_SESSION['Username'];
		header('Location: vacationmodel.php');//redirect
		exit();
	}
	//else{
		//header('Location: index.php');//redirect
		//exit();
	//}
	require 'functions.php';
	include 'header.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		login();
	}

?>
	<div class="container">
		<h2 class="text-center">تسجيل الدخول لبرنامج الاجازات</h2>
			<form class="form-signin" action ="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<label for="username" >رقم القيد:</label>
				<input class="form-control" type="number" name="username" required autocomplete="off"><br>
				<label for="password" >كلمة السر:</label>
				<input class="form-control" type="password" name="password" required autocomplete="new-password"><br>
				<input class="btn btn-primary btn-block btn-lg" type="submit" name="login" value="دخول"><br>
				<input class="btn btn-danger btn-block btn-lg" type="button" name="changePass" value="تغيير كلمة السر" data-toggle="modal" data-target="#changePassModal">	
			</form>
			<div id="changePassModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content ">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">تغيير كلمة السر: </h4>
					</div>
					<div class="modal-body row">
						<form method="POST" id="changePassForm" >
							<div class="form-group col-md-10 col-md-offset-1 ">

								<label for="newpassword" >كلمة السر:</label>
								<input class="form-control" type="password" name="newpassword" id= "newpassword" required autocomplete="new-password"><br>

								<label for="confirmpassword" >تأكيد كلمة السر:</label>
								<input class="form-control" type="password" name="confirmpassword" id= "confirmpassword" required autocomplete="new-password"><br>	

							</div>	
							<div class="form-group col-md-4 col-md-offset-4 ">
								<input type="submit" name="savePass" class="btn btn-success btn-lg" value="حفظ">
							</div>	
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>
