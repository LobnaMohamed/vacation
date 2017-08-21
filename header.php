<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>vacations</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<nav class="navbar navbar-inverse">
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
				   <li><a href="#">الاجازات المعتمدة</a></li>
				   	<li><a href="pending.php">الاجازات المطلوب اعتمادها</a></li>
			<?php 	   

				   		}
				}
			 ?>
			</ul>
		</div>
	</nav>

