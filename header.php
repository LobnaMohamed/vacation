<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>الاجازات</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<nav class="navbar navbar-inverse fixed-top">
		<div class="container-fluid">
<!-- 			<div class="navbar-header ">
			  <a class="navbar-brand" href="#">.Alexandria Minaral Oils Co</a>
			</div> -->
			<div class="navbar-header ">
		  		<!-- <a class="navbar-brand" href="#">Computer Name: <?php  
						if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
					    {
					      $ip=$_SERVER['HTTP_CLIENT_IP'];
					    }
					    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
					    {
					      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
					    }
					    else
					    {
					      $ip=$_SERVER['REMOTE_ADDR'];
					    }
					    echo $ip;
					  
					   
		  		 ?></a> -->
		  		<a class="navbar-brand" href="#">Computer Name: <?php echo gethostbyaddr($_SERVER['REMOTE_ADDR']); ?></a>
		  		<br>
		  		<?php if (isset($_SESSION['Username'])){ ?>
			  		 	<a class="navbar-brand" href="#"><?php echo $_SESSION['UserFullName'] ;?></a>
			  	<?php	} ?>
			</div>
			
			<div class="navbar-header navbar-right">
			  <span class="navbar-brand">شركة الأسكندرية للزيوت المعدنية ( أموك )</span>
			</div><br>
			<ul class="nav navbar-nav pull-right">
				<?php
					if (isset($_SESSION['Username']))
					{
				?>

			  <li><a href="logout.php">خروج</a></li>
			  <li><a href="myvacationstatus.php">اجازاتى</a></li>
			  <li><a href="vacationmodel.php">عمل اجازة</a></li>
			   <!-- emp or manager or top manager in adminstration -->
				<?php if($_SESSION['UserGroup']==3  || $_SESSION['UserGroup']==5 || $_SESSION['UserGroup']==6){ ?>
						<li><a href="empdata.php">بيانات العاملين</a></li>
						<li><a href="pending.php">الاجازات المطلوب تسجيلها</a></li>
						<li><a href="confirmed.php">الاجازات المسجلة</a></li>
				<?php 
				// direct manager or top manager
				   }elseif($_SESSION['UserGroup']==1 || $_SESSION['UserGroup']==2){ ?>
				   	<li><a href="confirmed.php">الاجازات المعتمدة</a></li>
				   	<li><a href="pending.php">الاجازات المطلوب اعتمادها</a></li>
				<?php 	   

				   	}
				}
			 ?>
			</ul>
		</div>
	</nav>

