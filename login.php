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
		
		//Ket noi voi csdl de co the su dung ham loc mysqli_real_escape_string
		connectDB();
		//Loc ky tu
		$_POST['username'] = strip_tags(mysqli_real_escape_string($conn, trim($_POST['username'])));
		$_POST['password'] = strip_tags(mysqli_real_escape_string($conn, trim($_POST['password'])));
		//Lay data va kiem tra du lieu
	    $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
	    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';

	    //Long thong tin username vao de check xem co trung khong
    	$numRow = getNumRowOfUser($data['username']);

		//Mang chua thong bao loi
	    $errors = array();
	    if($numRow <= 0)
	    	$errors['report'] = $errors['username'] = 'Sai mật khẩu hoặc tài khoản';
	    if(!$errors)	
        {
        	$row = getARow($data['username']);
            $user_id_session = $row['user_id'];
			//Lay du lieu username
			$user_session = $row['username'];
			//Lay du lieu cot password
			$hash_val = $row['password'];
			//Lay du lieu cot level
			$user_level = $row['level'];

			//Thuc hien md5 password va so sanh voi $hash_val
			if(md5($data['password']) != $hash_val)
				$errors['report'] = $errors['password'] = 'Sai mật khẩu hoặc tài khoản';
			else
			{
				// Luu thong tin vao phien
				$_SESSION['user_id'] = $user_id_session;
				$_SESSION['username'] = $user_session;
				$_SESSION['level'] = $user_level;
				// $_SESSION['password'] = $data['password'];

				if ($user_level == 1) header('Location: admin/admin.php'); else header('Location: home/home.php');
			}
				
				
	    }

	    //Ket thuc DB
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

    <title>Đăng nhập</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.custom.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form method="post" class="form-signin">
      <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="80" height="80">
      <h1 class="h3 mb-3 font-weight-normal">Đăng Nhập</h1>
      <!-- <label for="inputUsername" class="sr-only">Username</label> -->
      <input type="text" name="username" class="form-control" placeholder="Tài khoản" value="<?php echo !empty($data['username']) ? $const['username'] : ''; ?>" required autofocus>
      <p></p>
      <!-- <label for="inputPassword" class="sr-only">Password</label> -->
      <input type="password" name="password" class="form-control" placeholder="Nhập lại Mật khẩu" value="<?php echo !empty($data['password']) ? '' : ''; ?>" required>
      
      <p><font color="#FF3A3A" size="2"><b><i><?php if (!empty($errors['password']) || !empty($errors['username'])) echo $errors['report']; ?></i></b></font></p>
      <font size="2px"><p class="message">Bạn chưa có tài khoản, <a href="register.php">Đăng ký ngay</a></p></font>

      <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn_submit">Đăng Nhập</button>
      <br>
      <a href="index.php">>> Về trang chính <<</a>
      <br><br>
      <font size="2px">© <?php echo date("Y");?></font>
    </form>
</body>
</html>
