<?php 
	//Khai bao bien toan cuc
	$conn;

	function connectDB(){
		global $conn;

		require_once('db_connect.php');
	}

	function disconnectDB(){
		global $conn;

		if($conn)
			mysqli_close($conn);
	}

	function getNumRowOfUser($username){
		global $conn;

		connectDB();

		//Kiem tra xem username da co san trong do chua
		//Lay username da nhap dem so voi username trong csdl
		$sql_getIn4 = " SELECT * FROM user WHERE username = '$username' ";
		$query = mysqli_query($conn, $sql_getIn4);
		//Kiem tra dong query tren co trong csdl khong
		$num_row = mysqli_num_rows($query);

		return $num_row;
	}

	function getARow($username){
		global $conn;

		connectDB();

		$sql = "SELECT * FROM user WHERE username = '$username' ";
		$query = mysqli_query($conn, $sql);

		$row = mysqli_fetch_array($query);

		return $row;

	}

	function getUserFromID($user_id){
		//Dung bien toan cuc
		global $conn;

		connectDB();

		$sql = "SELECT * FROM user WHERE user_id = '$user_id'"; 

		$query = mysqli_query($conn, $sql);
		$num_row = mysqli_num_rows($query);

		$result = array();

		if($num_row > 0){

			$row = mysqli_fetch_assoc($query);
			$result = $row;
		}

		return $result;
	}

	function showList(){
		//Dung bien toan cuc
		global $conn;

		connectDB();

		$sql = "SELECT * FROM user"; 

		$query = mysqli_query($conn, $sql);

		$result = array();

		if($query)
			while($row = mysqli_fetch_assoc($query))
				$result[] = $row;

		return $result;
	}

	function addUser($username, $password, $email, $level){
		global $conn;

		connectDB();

		$username = strip_tags(mysqli_real_escape_string($conn, trim($username)));
		$password = strip_tags(mysqli_real_escape_string($conn, trim($password)));
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$level = filter_var($level, FILTER_VALIDATE_INT);

		$hash_pass = md5($password);

		$sql = "INSERT INTO user(username, password, email, level) VALUES ('$username', '$hash_pass', '$email', '$level')";

		$query = mysqli_query($conn, $sql);

		return $query;
	}
	
		function addUserWithoutLevel($username, $password, $email){
		global $conn;

		connectDB();

		$username = strip_tags(mysqli_real_escape_string($conn, trim($username)));
		$password = strip_tags(mysqli_real_escape_string($conn, trim($password)));
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		$hash_pass = md5($password);

		$sql = "INSERT INTO user(username, password, email, level) VALUES ('$username', '$hash_pass', '$email', 0)";

		$query = mysqli_query($conn, $sql);

		return $query;
	}

	function delUser($user_id){
		global $conn;

		connectDB();

		$sql = "DELETE FROM user WHERE user_id = '$user_id'";

		$query = mysqli_query($conn, $sql);

		return $query;

	}

	function editUser($user_id, $username, $password, $email, $level){
		global $conn;

		connectDB();

		$username = strip_tags(mysqli_real_escape_string($conn, trim($username)));
		$password = strip_tags(mysqli_real_escape_string($conn, trim($password)));
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$level = filter_var($level, FILTER_VALIDATE_INT);

		//hash pass
		$hash_pass = md5($password);

		$sql = "
			UPDATE user SET
			username = '$username',
			password = '$hash_pass',
			email = '$email',
			level = '$level'
			WHERE user_id = $user_id
		";

		$query = mysqli_query($conn, $sql);

		return $query;
	}

	function editUserWithoutLevel($user_id, $username, $password, $email){
		global $conn;

		connectDB();

		$username = strip_tags(mysqli_real_escape_string($conn, trim($username)));
		$password = strip_tags(mysqli_real_escape_string($conn, trim($password)));
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		//hash pass
		$hash_pass = md5($password);

		$sql = "
			UPDATE user SET
			username = '$username',
			password = '$hash_pass',
			email = '$email'
			WHERE user_id = $user_id
		";

		$query = mysqli_query($conn, $sql);

		return $query;
	}

?>
