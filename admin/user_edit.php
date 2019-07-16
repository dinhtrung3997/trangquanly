<?php 
	session_start();

    //Kiem tra phien
    if(!isset($_SESSION['username']) || ($_SESSION['level']) != 1)
        echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
        window.location="../login.php"</script>';

    require_once('../library/user.php');

    //Lay thong tin hien thi theo id tren thanh dia chi 
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    //Neu co thi...
    if($user_id)
        //Truyen vao mang $data
        $data = getUserFromID($user_id);
        $data['old_username'] = $data['username'];
        $data['old_hash_password'] = $data['password'];
        // $data['re_password'] = $data['password'];
    //Neu khong co du lieu thi back lai trang list
    if(!$data)
        header('Location: user_list.php');
?>

<?php 
	if(isset($_POST['edit_user'])){

    //Lay data va kiem tra du lieu
    $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
    $data['old_password'] = isset($_POST['old_password']) ? $_POST['old_password'] : '';
    $data['new_password'] = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $data['re_password'] = isset($_POST['re_password']) ? $_POST['re_password'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['level'] = isset($_POST['level']) ? $_POST['level'] : '';

    //Long thong tin username vao de check xem co trung khong
    $numRow = getNumRowOfUser($data['username']);

    //Mang chua thong bao loi
    $errors = array();
    if(empty($data['username']))
        $errors['username'] = 'Chưa nhập tài khoản';
    // elseif()
    elseif($data['username'] != $data['old_username'] && $numRow > 0)
    	$errors['username'] = 'Đã có tài khoản này rồi, mời nhập username khác';
    if(empty($data['old_password']))
        $errors['old_password'] = 'Chưa nhập mật khẩu hiện tại';
    elseif(md5($data['old_password']) != $data['old_hash_password'])
        $errors['old_password'] = 'Nhập sai mật khẩu hiện tại';
    if(empty($data['new_password']))
        $errors['new_password'] = 'Chưa nhập mật khẩu mới';
    elseif($data['new_password'] == $data['old_password'])
        $errors['new_password'] = 'Vui lòng nhập mật khẩu khác với mật khẩu hiện tại';
    if(empty($data['re_password']))
        $errors['re_password'] = 'Chưa nhập lại mật khẩu';
    elseif($data['new_password'] != $data['re_password'])
        $errors['re_password'] = 'Nhập lại mật khẩu không trùng';
    if(empty($data['email']))
        $errors['email'] = 'Chưa nhập email';
    elseif(filter_var($data['email'], FILTER_VALIDATE_EMAIL) == false)
        $errors['email'] = 'Nhập sai dạng email rồi... ';
    
    if(!$errors)	
            {
           		//Goi ham addUser va truyen vao tham so
                editUser($data['user_id'], $data['username'], $data['new_password'], $data['email'], $data['level']);
            
                //Tro ve list
                // header('Location: user_list.php');
                echo '<script language="javascript">alert("Cập nhật thông tin thành công"); 
                                      window.location="user_list.php"</script>';
            }
    }
    disconnectDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sửa User</title>

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
            <li class="active"><a href="user_list.php"><i class="fa fa-fw fa-link"></i>Danh sách người dùng</a></li>
            
        </ul>
    </div>
    
    <div class="content p-5">
        <h2 class="mb-4">Sửa người dùng</h2>

        <div class="card mb-4">

            <div class="card-body">
                
                <form action="user_list.php" method="POST">
                    <button type="submit" class="btn btn-primary">Huỷ Sửa</button><br> </br>
                </form>

                <form class="form-horizontal" method="post" action="user_edit.php?user_id=<?php echo $data['user_id']; ?>">
                   
                    <!-- <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="user_id">STT:</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo !empty($data['user_id']) ? $data['user_id'] : ''; ?>">
                        <?php if (!empty($errors['user_id'])) echo $errors['user_id']; ?>
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="username">Tài khoản:</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo !empty($data['username']) ? $data['username'] : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['username'])) echo $errors['username']; ?></i></b></font>
                        </div>
                    </div>
   
                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="old_password">Mật khẩu hiện tại:</label>
                        <div class="col-sm-8">
                        <input type="password" class="form-control" id="old_password" name="old_password" value="<?php echo !empty($data['old_password']) ? $data['old_password'] : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['old_password'])) echo $errors['old_password']; ?></i></b></font>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="new_password">Mật khẩu mới:</label>
                        <div class="col-sm-8">
                        <input type="password" class="form-control" id="new_password" name="new_password" value="<?php echo !empty($data['new_password']) ? $data['new_password'] : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['new_password'])) echo $errors['new_password']; ?></i></b></font>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="re_password">Nhập lại mật khẩu:</label>
                        <div class="col-sm-8">
                        <input type="password" class="form-control" id="re_password" name="re_password" value="<?php echo !empty($data['re_password']) ? $data['re_password'] : ''; ?>">
                        <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['re_password'])) echo $errors['re_password']; ?></i></b></font>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-1"> </div>
                        <label class="col-sm-2 col-form-label" for="email">Email:</label>
                        <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo !empty($data['email']) ? $data['email'] : ''; ?>">
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
                                <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>"/>
                                <!-- <input type="hidden" name="user_id" value="$user_id"/> -->
                                <input class="btn btn-danger" type="submit" name="edit_user" value="Cập nhật"/>
                            </td>
                        </tr>
                    </table>
                </form>

        </div>
    </div>

</div>

</body>
</html>
