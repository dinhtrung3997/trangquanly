<?php 

session_start();
//Kiem tra phien
    if(!isset($_SESSION['username']) || ($_SESSION['level']) != 1)
        echo '<script language="javascript">alert("Chưa đăng nhập.. Hệ thống sẽ trở về trang đăng nhập!");
        window.location="../login.php"</script>';
        
require_once '../library/user.php';

//Lay id
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
if($user_id)
	delUser($user_id);

//Sau khi xoa xong thi tro ve list
header('Location: user_list.php');

disconnectDB();
?>
