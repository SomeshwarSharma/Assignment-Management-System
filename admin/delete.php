<?php

	require_once '../db_handler.php';
	
	// if ($_REQUEST['delete']) {
		
		// $pid = $_REQUEST['delete'];
		$user = mysqli_real_escape_string($conn, $_GET['id']);
		$query = "DELETE FROM users WHERE username='$user'";
		$stmt = $conn->prepare( $query );
		// $stmt->execute(array(':pid'=>$user));
		
		if ($stmt) {
			echo "User Deleted Successfully ...";
		}
		
	// }