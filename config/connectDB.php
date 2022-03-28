<?php
	$servername = "localhost";
	$username = "root";

	// $password = "!1Thatsmypassword";

	$dbname = "Library";

	// Create connection
	$conn = mysqli_connect($servername, $username, "", $dbname);
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	//echo "Connected successfully";
?>