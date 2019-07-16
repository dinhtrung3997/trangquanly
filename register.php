<?php 
	session_start();

	//Kiem tra phien
	if(isset($_SESSION['username'])){
		if($_SESSION['level'] == 1) header('Location:admin/admin.php');
		elseif($_SESSION['level'] == 0) header('Location:home/home.php');
	}
?>

<?php 
	//Ket noi toi csdl
	// require_once('library/db_connect.php');
	require_once('library/user.php');

	//Kiem tra xem da nhap gi chua
	if(isset($_POST['btn_submit'])){
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
	    	$errors['username'] = 'Tài khoản đã có sẵn, mời nhập username khác';
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
            
	    if(!$errors)	
            {
           		//Goi ham addUser va truyen vao tham so
                addUserWithoutLevel($data['username'], $data['password'], $data['email']);
            
                //Tro ve trang login
                // header('Location: login.php');}
                echo '<script language="javascript">alert("Đăng ký thành công.. Hệ thống chuyển về trang Đăng nhập");
	 				window.location="login.php";</script>';
	    	}
        
	    //Ngat ket noi DB
	    disconnectDB();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/favicon.ico">

    <title>Đăng Ký</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.custom.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form method="post" class="form-signin">
      <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="80" height="80">
      <h1 class="h3 mb-3 font-weight-normal">Đăng Ký</h1>
      <!-- <label for="inputUsername" class="sr-only">Username</label> -->
      <input type="text" name="username" class="form-control" placeholder="Tài khoản" value="<?php echo !empty($data['username']) ? $const['username'] : ''; ?>" required autofocus>
      <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['username'])) echo $errors['username']; ?></i></b></font>
      <p></p>
      <!-- <label for="inputPassword" class="sr-only">Password</label> -->
      <input type="password" name="password" class="form-control" placeholder="Mật khẩu" value="<?php echo !empty($data['password']) ? '' : ''; ?>" required>
      <p></p>
      <!-- <label for="inputREPassword" class="sr-only">REPassword</label> -->
      <input type="password" name="re_password" class="form-control" placeholder="Nhập lại Mật khẩu" value="<?php echo !empty($data['re_password']) ? '' : ''; ?>" required>
      <font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['re_password'])) echo $errors['re_password']; ?></i></b></font>
      <p></p>
      <!-- <label for="inputEmail" class="sr-only">Email</label> -->
      <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo !empty($data['email']) ? $const['email'] : ''; ?>" required>
      <p></p>

      <p></p>
      <font size="2px"><p class="message">Đã có tài khoản, <a href="login.php">Đăng nhập tại đây</a></p></font>

      <button class="btn btn-lg btn-primary btn-block" name="btn_submit" type="submit">Đăng Ký Ngay</button>
      <p></p>
      <a href="index.php">>> Về trang chính <<</a>
      <p></p>
      <font size="2px">© <?php echo date("Y");?></font>
    </form>
	


</body>
</html>
