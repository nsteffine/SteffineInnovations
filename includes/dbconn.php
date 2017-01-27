<?php 

	/**
	* Connections are established by creating instances of the PDO base class
	* It doesn't matter which DB driver you want to use; you always use the PDO class name.
	* NOTE: to close the connection, simply set it to null
	*
	* Param 1) the DB source (known as the DSN)- type of DB; name of DB
	* Param 2) login name
	* Param 3) password
	*/
	//echo 'before connstring...'; 
	//connect to server and DB with username and password

	// $servername = "steffineinnovationsc.ipagemysql.com";
	// $username = "nsteffine";
	// $password = "NSgolf$21$";

	$servername = "localhost";
	$username = "root";
	$password = "";

	try {
		
		$conn = new PDO("mysql:host=$servername;dbname=steffineinnovations;port=3306;", $username, $password);

	} catch (PDOException $pdoe){echo 'msg3';
		echo $pdoe;
		die('no connection');   
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
		die('connection error'); 
	}
	//echo ' After try catch on connection';

?>