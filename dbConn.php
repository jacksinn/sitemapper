<?php
	$conn = mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	if (!$conn){
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($DB_NAME, $conn);
?>
