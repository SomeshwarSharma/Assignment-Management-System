<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/admin-navbar.php";
		include "../db_handler.php";
	?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/css/bootstrap-slider.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/bootstrap-slider.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<title></title>
</head>
<body  style="background-color:lightblue">
	<?php 
	if (isset($_GET['id'])) {
		$user = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM users WHERE username = '$user'"; 
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
        while($row = mysqli_fetch_array($result)) { 
        	$name = $row['name'];
        	$sname = $row['surname'];
        	$email = $row['email'];
        	$user = $row['username'];
        	$pass = $row['password'];
		}
	}
	?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="container">
				    <h1>Edit User Profile</h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <div class="alert alert-info alert-dismissable">
				          <a class="panel-close close" data-dismiss="alert">×</a> 
				          <i class="fa fa-warning" style="color: red;"></i> Changes can <strong >NOT</strong> be undone after saving. Any fields left blank will go back to the old information stored if there is any.
			          	</div>
				        <h3>Account Information</h3>
				        
				        <form class="form-horizontal" role="form" method="post">
				          <div class="form-group">
				            <label class="col-lg-3 control-label">First name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" name="name" value="<?php if (isset($_GET['id'])) { print $name; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Surname:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" name="sname" value="<?php if (isset($_GET['id'])) { print $sname; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Email:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="email" name="email" value="<?php if (isset($_GET['id'])) { print $email; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Username:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="text" name="username" value="<?php if (isset($_GET['id'])) { print $user; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Password:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="password" readonly name="password" value="<?php if (isset($_GET['id'])) { print $pass; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Save Changes">
				              <span></span>
				              <input type="reset" class="btn btn-default" value="Cancel" onclick="goBack()">
				            </div>
				          </div>
				        </form>
				      </div>
				  </div>
				</div>
				<hr>
			</div>
		</div>
	</div>
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		function goBack() {
			window.location = 'view-users.php';
		}
	</script>
</body>

</html>

<?php 
	if(isset($_POST['submit'])) {
		if (isset($_GET['id'])) {

			$user = mysqli_real_escape_string($conn, $_GET['id']);
			$get = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
	        while($row = mysqli_fetch_array($get)) { 
	        	$level = $row['rank'];
			}

			$name1 = mysqli_real_escape_string($conn, $_REQUEST['name']);
			$sname1 = mysqli_real_escape_string($conn, $_REQUEST['sname']);
			$email1 = mysqli_real_escape_string($conn, $_REQUEST['email']);
			$username1 = mysqli_real_escape_string($conn, $_REQUEST['username']);
			$password1 = mysqli_real_escape_string($conn, $_REQUEST['password']);

			$query = "UPDATE users SET name='$name1', surname='$sname1', email='$email1', username='$username1', password='$password1', rank='$level' WHERE username='$user'";

			$result= mysqli_query($conn, $query) or die(mysqli_error());
			mysqli_close($conn);
			
			echo "<script>goBack();</script>";
		}
	}
?>