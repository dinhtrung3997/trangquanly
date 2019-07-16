<?php 
	session_start();

	//Kiem tra phien
	if(!isset($_SESSION['username']) || ($_SESSION['level']) != 1)
        echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
            window.location="../login.php"</script>';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Trang quản lý</title>

	<!-- Link -->
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/bootadmin.min.css">
	<!-- ================================================= -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/bootstrap.bundle.min.js"></script>
	<script src="../assets/js/bootadmin.min.js"></script>

</head>
<body class="bg-light">
	<nav class="navbar navbar-expand navbar-dark bg-dark">
		<a href="admin.php" class="navbar-brand">
			<img src="../assets/img/bootstrap-solid.svg" width="26" height="26" class="d-inline-block align-top" alt="">
			<b>Trang quản lý</b> 
		</a>
	<div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>Chào, <font color="#ACDDFF"><b><?php echo $_SESSION['username'] ?></b></font></a>
                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="user_edit.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="dropdown-item">Sửa thông tin</a>
                    <a href="../logout.php" class="dropdown-item">Đăng xuất</a>
                </div>
            </li>
        </ul>
    </div>
		
	</nav>

<div class="d-flex">
    <div class="sidebar sidebar-dark bg-secondary">
        <ul class="list-unstyled">
            <li><a href="user_add.php"><i class="fa fa-fw fa-link"></i>Thêm người dùng</a></li>
            <li><a href="user_list.php"><i class="fa fa-fw fa-link"></i>Danh sách người dùng</a></li>
            
        </ul>
    </div>

    <div class="content p-4">
        <h2 class="mb-4">Chào mừng <b><font color="#f261"><?php echo $_SESSION['username'] ?></font></b> đã quay trở lại trang quản lý!</h2>

        <div class="card mb-5">
            <div class="card-body">
                Mời bạn chọn một tính năng tại menu bên phải.
            </div>
        </div>
    </div>
</div>

</body>
</html>
