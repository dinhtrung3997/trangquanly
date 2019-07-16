<?php
	$hostname = 'localhost';
	$username = 'root';
	$password = 'w3l0stm0stch4nc3';
	$db_using = 'web1';

	//Ket noi
	$conn = mysqli_connect($hostname, $username, $password, $db_using)
	or
		die ("Không thể kết nối tới DB");
	mysqli_query($conn, "SET NAME 'UTF8'");

?>