<?php
session_start();

//Remove toan bo phien
session_unset();

//Destroy 1 phien
session_destroy();

echo '<script class="javascript">alert("Đăng xuất thành công, hệ thống chuyển về trang chính");
	window.location="index.php"</script>';

?>