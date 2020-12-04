<!-- MAKE A POP UP INSTEAD OF FORM -->

<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/navbar.php";
		include "../db_handler.php";
	?>
<head>
	<title></title>
</head>
<body style="background-color:lightblue">
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
				    <h1>Remove Students</h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <div class="alert alert-info alert-dismissable">
				          <a class="panel-close close" data-dismiss="alert">×</a> 
				          <i class="fa fa-warning" style="color: red;"></i> Records deleted are <strong>NOT</strong> recoverable.
			          	</div>
				        <h3>Account Information</h3>
				        
				        <form class="form-horizontal" role="form" method="post">
				          <div class="form-group">
				            <label class="col-lg-3 control-label">First name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" value="<?php if (isset($_GET['id'])) { print $name; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Surname:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" value="<?php if (isset($_GET['id'])) { print $sname; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Email:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="email" value="<?php if (isset($_GET['id'])) { print $email; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Username:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="text" value="<?php if (isset($_GET['id'])) { print $user; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Password:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="password" value="<?php if (isset($_GET['id'])) { print $pass; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Delete" readonly>
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
			window.location = 'students-view.php';
		}
	</script>
</body>

</html>

<?php 
	if(isset($_POST['submit'])) { 
		if (isset($_GET['id'])) {
			$user = mysqli_real_escape_string($conn, $_GET['id']);

			$query = "DELETE FROM users WHERE username = '$user'";
			$result= mysqli_query($conn, $query) or die(mysqli_error());
		}

		include "../back.php";
	}
?>