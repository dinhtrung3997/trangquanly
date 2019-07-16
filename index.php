<?php 
	session_start();

	//Kiem tra phien
	if(isset($_SESSION['username'])){
		if($_SESSION['level'] == 1) header('Location:admin/admin.php');
		elseif($_SESSION['level'] == 0) header('Location:home/home.php');
	}
	else
        header('Location: login.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to my PHP website</title>
</head>
<body>

	<h1>Welcome to my PHP website</h1>
	<a href="login.php">Đăng Nhập</a>
		

</body>
</html>
