<?php 
	include 'connect.php';
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
	<title>vacations</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
	  <header>
	  	<h1>نموذج الاجـــــازة</h1>
	  </header>
	  
	    <form action="/action_page.php">	    
			<div class="right">
			    <label for="name">الاســـــم</label>
			    <input type="text" id="name" name="name" placeholder="Your name..">
			   
			    <label for="code">رقم القيد</label>
			    <input type="text" id="code" name="code" placeholder="Your Code..">
			    
			    <label for="address">العنوان</label>
			    <input type="text" id="address" name="address" placeholder="Your address..">

				<label for="date" >التاريخ</label>
				<br>
				<input type="date" id="date" name="date" placeholder="date.."><br><br>

				<label for="duration" >مدة الاجازة:</label>
				<input type="text" id="duration" name="duration" placeholder="duration..">
				<input type="submit" value="ارسال">
			</div>
			<div class="left">
				
				<label for="Management" >الادارة:</label>
				<input type="text" id="Management" name="Management" placeholder="Management..">
				<label for="manager">المدير المباشر</label>
			    <select id="manager" name="manager">
				    <option value="australia">Australia</option>
				    <option value="canada">Canada</option> 
				    <option value="usa">USA</option>
				</select>
			    <label for="topManager">الرئيس الاعلى</label>
			    <select id="topManager" name="topManager">
				    <option value="australia">Australia</option>
				    <option value="canada">Canada</option>
				    <option value="usa">USA</option>
			    </select>

			    <label for="vacation">نوع الاجازة</label>
			    <select id="vacType" name="vacType">
				    <option value="annual">سنوى</option>
				    <option value="sick">عارضة</option>
			        <option value="badl">بدل</option>
			        <option value="hours">ساعات</option>
			    </select>
			</div>
	    </form>
	</div>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>