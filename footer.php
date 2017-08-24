<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
			
	<footer  class="footer navbar-fixed-bottom">
		<div class="navbar-header ">
	  		<a class="navbar-brand" href="#">Computer UserName: <?php echo getenv("username"); ?></a>

	  		 <?php if (isset($_SESSION['Username'])){ ?>
		  		 	<a class="navbar-brand" href="#"><?php echo $_SESSION['UserFullName'] ;?></a>
		  	<?php	} ?>
		</div>
	</footer>

</body>
</html>