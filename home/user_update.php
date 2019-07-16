<?php 
  session_start();
  
  //Kiem tra phien
  if(!isset($_SESSION['username']) || ($_SESSION['level']) != 0)
        echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
        window.location="../login.php"</script>';
  
  require_once('../library/user.php');

    //Lay thong tin hien thi theo id tren thanh dia chi 
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    
    //Update: Neu co thi kiem tra voi $_SESSION['user_id'] xem co trung khong, neu khong trung thi khong cho thuc hien lenh duoi
    if($_SESSION['user_id'] == $user_id){
    
        //Neu co thi...
        if($user_id)
            //Truyen vao mang $data
            $data = getUserFromID($user_id);
            $data['old_username'] = $data['username'];
            $data['old_hash_password'] = $data['password'];
        //Neu khong co du lieu thi back lai trang home
        if(!$data)
            echo '<script language="javascript">alert("Cập nhật thông tin thành công"); 
            window.location="home.php"</script>';
    
    }
    //else header('Refresh: 0; url=home.php');
    

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
                editUserWithoutLevel($data['user_id'], $data['username'], $data['new_password'], $data['email']);
            
                //Back ve trang home
                // header('Location: home.php');
                echo '<script language="javascript">alert("Cập nhật thông tin thành công"); 
                                      window.location="home.php"</script>';
            }
    }
    disconnectDB();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sửa thông tin</title>

  <!-- Bootstrap core CSS -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="home.php">Trang chủ</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a href="user_update.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">Sửa thông tin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Đăng xuất</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container p-5">
    <h2 class="mb-4">Sửa thông tin</h2>
    <div class="row">
      <div class="card-body">
        
        <form class="form-horizontal" method="post" action="user_update.php?user_id=<?php echo $data['user_id']; ?>">

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

            <table width="270%" border="0" cellspacing="0" cellpadding="20">
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>"/>
                        <input class="btn btn-danger" type="submit" name="edit_user" value="Cập nhật"/>
                    </td>
                </tr>
            </table>
        </form>
        
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../assets/js/jquery.slim.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
