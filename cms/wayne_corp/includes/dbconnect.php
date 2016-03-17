<?php
	#Use constants for better code
	define("DB_SERVER", "localhost");
	define("DB_USER", "bruce");
	define("DB_PASS", "darkknight");
	define("DB_NAME", "wayne_corp");

	$connection = mysqli_connect(DB_SERVER, DB_USER , DB_PASS, DB_NAME);
	// test if connection occured
	if (mysqli_connect_errno()) {
		#die is for exiting or break
		die("Database connection failed :" .
			mysqli_connect_error() . "(" . mysqli_connect_errno() . ")"
			);
	}


?>