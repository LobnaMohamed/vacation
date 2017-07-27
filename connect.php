<?php

	$dsn = 'mysql:host=localhost;dbname=vacation';//data source name
	$user= 'root';
	$pass='';
	$options = array (
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		);

	try{
		//new connection to db
		$con = new PDO($dsn, $user, $pass, $options);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		//QUERY
		$q = "INSERT INTO test(name,phone)VALUES('لبنى','محمد')";
		$con->exec($q);

	}
	catch(PDOexception $e){
		echo "failed" . $e->getMessage();
	}
	
