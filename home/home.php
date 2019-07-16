<?php 
  session_start();
  
  //Kiem tra phien
  if(!isset($_SESSION['username']) || ($_SESSION['level']) != 0)
    echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
        window.location="../login.php"</script>';    
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Trang chủ</title>

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
          <li class="nav-item">
            <a href="user_update.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">Sửa thông tin</a>
            <!-- <a href="user_edit.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">Sửa thông tin</a> -->
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Đăng xuất</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="mt-5">Chào mừng <b><font color="#f261"><?php echo $_SESSION['username'] ?></font></b> đã quay trở lại website của chúng tôi!</h2>
        
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="../assets/js/jquery.slim.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>
