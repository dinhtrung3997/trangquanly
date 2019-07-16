<?php 
	session_start();

	//Kiem tra phien
	if(!isset($_SESSION['username']) || ($_SESSION['level']) != 1)
        echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
        window.location="../login.php"</script>';

	require_once('../library/user.php');
	$showUser = showList(); 
	disconnectDB();
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List người dùng</title>

	<!-- Link -->
	<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/bootadmin.min.css">
	<!-- ================================================= -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery-1.12.4.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
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
            <li class="active"><b><a href="user-list.php"><i class="fa fa-fw fa-link"></i>Danh sách người dùng</a></b></li>
            
        </ul>
    </div>

    <div class="content p-5">
        <h2 class="mb-4">Danh sách người dùng</h2>
        
        <div class="card mb-5">
            <div class="card-body">
            	<form action="user_add.php" method="POST">
                    <button type="submit" class="btn btn-primary">Thêm mới</button><br> </br>
                </form>

				<table id="userList" class="table table-striped table-bordered table-responsive " >
               		<thead class="thead-dark">
	                <tr class="text-center">
	                    <th style="width: 22%">Username</th>
	                    <th style="width: 28%">Password (MD5)</th>
	                    <th style="width: 30%">Email</th>
	                    <!-- <th style="width: 15%">Số điện thoại</th> -->
	                    <th style="width: 10%">Quyền</th>
	                    <th>Tuỳ chọn</th>
	                </tr>       
                    </thead>   	
                    <tbody>
		            <?php foreach ($showUser as $item){ ?>
    		            <tr>
    		                <td class="align-middle"><?php echo $item['username']; ?></td>
    		                <td class="align-middle"><?php echo $item['password']; ?></td>
    		                <td class="align-middle"><?php echo $item['email']; ?></td>
    		                <!-- <td><?php echo $item['tel']; ?></td> -->
    		                <td class="text-center align-middle"><?php if ($item['level']==0) echo 'Thành viên'; elseif($item['level']==1) echo 'Quản trị viên'; ?></td>
    		                
    		                <td class="text-center">
								<form method="post" action="user_del.php">
									<!-- Truyen user_id len thanh dia chi -->
    		                        <input onclick="window.location = 'user_edit.php?user_id=<?php echo $item['user_id']; ?>'" type="button" class="btn btn-outline-success" value="Sửa"/>
									<!-- Dung bien user_id der goi ham xoa -->
    		                        <input type="hidden" name="user_id" value="<?php echo $item['user_id']; ?>"/>
    		                        <input onclick="return confirm('Bạn chắc chắn xoá chứ?');" type="submit" name="delete" class="btn btn-outline-danger" value="Xóa"/>
    		                    </form>			                
    		                </td>
    		            </tr>
		            <?php } ?>
                    </tbody>
		        </table>               
            </div>
        </div>
    </div>
</div>

</body>
</html>

<script>  
 $(document).ready(function(){  
      $('#userList').DataTable();  
 });  
 </script> 
