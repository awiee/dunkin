<?php
   if ($_SERVER["SERVER_NAME"] == "thesis-dd.rf.gd"){
      $servername = "sql206.epizy.com";
      $username = "epiz_21349325";
      $password = "awie12345";
      $dbname = "epiz_21349325_thesis";
   } else {
      $servername = "localhost";
      $username = "awie";
      $password = "dd2017";
      $dbname = "dunkin";   
   }
	
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection OOP
	if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   } 
   
   // create connection
   $dbcon = $conn;
   //mysql_select_db($dbname, $dbcon);
   
   $db = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8mb4',$username,$password);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   
?> 