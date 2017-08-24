<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>vacations</title>
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
			<div class="navbar-header ">
			  <a class="navbar-brand" href="#">.Alexandria Minaral Oils Co</a>
			</div>

			
			<div class="navbar-header navbar-right">
			  <span class="navbar-brand">شركة الأسكندرية للزيوت المعدنية ( أموك )</span>
			</div>
			<ul class="nav navbar-nav pull-right">
			<?php
				if (isset($_SESSION['Username']))
				{
			?>
			  <li><a href="logout.php">خروج</a></li>
			  <li><a href="vacationmodel.php">عمل اجازة</a></li>
			<?php if($_SESSION['UserGroup']==3){ ?>
					<li><a href="empdata.php">بيانات العاملين</a></li>
			<?php 
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

