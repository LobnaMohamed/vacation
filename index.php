<?php
	// session_start();
	// if(isset($_SESSION['Username'])){
	// 	header('Location: index.php');//redirect
	// }
	require 'functions.php';
	include 'header.html';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		login();
	}
?>
	<div class="container">
	<h3 class="text-center">تسجيل الدخول لبرنامج الاجازات</h3>
		<form class="form-signin" action ="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<label for="username" >رقم القيد:</label>
			<input class="form-control" type="number" name="username" required autocomplete="off"><br>
			<label for="password" >كلمة السر:</label>
			<input class="form-control" type="password" name="password" required autocomplete="new-password"><br>
			<input class="btn btn-primary btn-block btn-lg" type="submit" name="login" value="دخول"><br>
			<input class="btn btn-danger btn-block btn-lg" type="submit" name="changePass" value="تغيير كلمة السر">
		</form>
	</div>
<?php include 'footer.php'; ?>
