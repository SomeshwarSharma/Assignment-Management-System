<?php
  if(!isset($_SESSION)) { 
        session_start(); 
    } 

	$conn = mysqli_connect('localhost', 'root', '', 'project');

	if (!$conn) {
		die("Connection failed: ".mysqli_connect_err());
	}

	$username = $_POST['userid'];
	$pass = $_POST['password'];

	$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$pass'";
	$result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

	if (!$row = $result->fetch_assoc()) {
		echo "Your username or passowrd is incorrect"; // Make a pop up instead of another page
	} else {
		$_SESSION['id'] = $row['username'];
		// $getUser = $_SESSION['username'];

		if($row['rank'] == 'Admin' || $row['rank'] == 'admin' || $row['rank'] == 'Lecturer' || $row['rank'] == 'lecturer' || $row['rank'] == 'Supervisor' || $row['rank'] == 'supervisor' || $row['rank'] == 'Student' || $row['rank'] == 'student') {
			session_start();
			$_SESSION['rank'] = $row['rank'];

			if(isset($_SESSION['rank'])) {
				if($_SESSION['rank'] == 'Admin' || $row['rank'] == 'admin') {
					header("Location: home/adminHome.php?id=$username");
				}
				else if($_SESSION['rank'] == 'Supervisor' || $row['rank'] == 'supervisor') {
					header("Location: home/supervisorHome.php?id=$username");
				}
				else if($_SESSION['rank'] == 'Student' || $row['rank'] == 'student') {
					header("Location: home/studentHome.php?id=$username");
				}
				else if($_SESSION['rank'] == 'Lecturer' || $row['rank'] == 'Lecturer') {
					header("Location: home/lecturerHome.php?id=$username");
			}
		}
		else {
			echo "Role not found.";
		}
	}
?>