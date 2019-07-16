<?php 
	session_start();

    //Kiem tra phien
    if(!isset($_SESSION['username']) || ($_SESSION['level']) != 1)
        echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
        window.location="../login.php"</script>';

    require_once('../library/user.php');
?>

<?php 
	if(isset($_POST['add_user'])){
        $const['username'] = $_POST['username'];
		$const['email'] = $_POST['email'];
        
        //Lay data va kiem tra du lieu
        $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
        $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
        $data['re_password'] = isset($_POST['re_password']) ? $_POST['re_password'] : '';
        $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
        $data['level'] = isset($_POST['level']) ? $_POST['level'] : '';

        //Long thong tin username vao de check xem co trung khong
        $numRow = getNumRowOfUser($data['username']);

        //Mang chua thong bao loi
        $errors = array();
        if(empty($data['username']))
            $errors['username'] = 'Chưa nhập tài khoản';
        elseif($numRow > 0)
            $errors['username'] = 'Đã có tài khoản này rồi, mời nhập username khác';
        if(empty($data['password']))
            $errors['password'] = 'Chưa nhập mật khẩu';
        if(empty($data['re_password']))
            $errors['re_password'] = 'Chưa nhập lại mật khẩu';
        if(empty($data['email']))
            $errors['email'] = 'Chưa nhập email';
        elseif(filter_var($data['email'], FILTER_VALIDATE_EMAIL) == false)
            $errors['email'] = 'Nhập sai dạng email rồi... ';
        if($data['password'] != $data['re_password'])
            $errors['re_password'] = 'Mật khẩu không trùng nhau';
        if(!$errors){
            //Goi ham addUser va truyen vao tham so
            addUser($data['username'], $data['password'], $data['email'], $data['level']);
        
            //Tro ve list
            header('Location: user_list.php');
        }
    }
    disconnectDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm User</title>

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
            <li class="active"><a href="user_add.php"><i class="fa fa-fw fa-link"></i>Thêm người dùng</a></li>
            <li><a href="user_list.php"><i class="fa fa-fw fa-link"></i>Danh sách người dùng</a></li>
            
        </ul>
    </div>
    
    <div class="content p-5">
        <h2 class="mb-4">Thêm người dùng</h2>

        <div class="card mb-4">

            <div class="card-body">
                
                <form action="user_list.php" method="POST">
                    <button type="submit" class="btn btn-info">Xem danh sách</button><br> </br>
                </form>

                <form class="form-horizontal" method="post">  

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="username">Tài khoản:</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo !empty($data['username']) ? $const['username'] : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['username'])) echo $errors['username']; ?></i></b></font>
                        </div>
                    </div>
   
                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="password">Mật khẩu:</label>
                        <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo !empty($data['password']) ? '' : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['password'])) echo $errors['password']; ?></i></b></font>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="re_password">Nhập lại mật khẩu:</label>
                        <div class="col-sm-8">
                        <input type="password" class="form-control" id="re_password" name="re_password" value="<?php echo !empty($data['re_password']) ? '' : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['re_password'])) echo $errors['re_password']; ?></i></b></font>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="email">Email:</label>
                        <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo !empty($data['email']) ? $const['email'] : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['email'])) echo $errors['email']; ?></i></b></font>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <tr>
                        <label class="col-sm-2 col-form-label" for="level">Quyền:</label>
                        <div class="col-sm-8">
                        <td>
                            <select class="form-control" style="width:100%" name="level">
                                <option value="0">Thành Viên (User)</option>
                                <option value="1">Quản trị viên (Admin)</option>
                            </select>
                            <!-- <?php if (!empty($errors['level'])) echo $errors['level']; ?> -->
                        </td>
                        </div>
                        </tr> 
                    </div>

                    <table width="270%" border="0" cellspacing="0" cellpadding="15">
                        <tr>
                            <td></td>
                            <td>                             
                                <input class="btn btn-success" type="submit" name="add_user" value="Lưu"/>
                            </td>
                        </tr>
                    </table>
                </form>

        </div>
    </div>

</div>

</body>
</html>
