<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/lecturer-navbar.php";
		include "../db_handler.php";
	?>
<head>
	<title></title>
</head>
<body style="background-color:lightblue">
	<?php 
	if (isset($_GET['id'])) {
		$user = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM module WHERE module_code = '$user'"; 
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
        while($row = mysqli_fetch_array($result)) { 
        	$mcode = $row['module_code'];
        	$mname = $row['module_name'];
        	$mleader = $row['module_leader'];
        	$desc = $row['description'];
        	$as1 = $row['assessment1'];
        	$as2 = $row['assessment2'];
		}
	}
	?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="container">
				    <h1>Remove Module</h1>
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
				            <label class="col-lg-3 control-label">Module Code:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" value="<?php if (isset($_GET['id'])) { print $mcode; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" value="<?php if (isset($_GET['id'])) { print $mname; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Leader:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" value="<?php if (isset($_GET['id'])) { print $mleader; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Delete">
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
			window.location = 'view-modules.php';
		}
	</script>
</body>

</html>

<?php 
	if(isset($_POST['submit'])) { 
		if (isset($_GET['id'])) {
			$module = mysqli_real_escape_string($conn, $_GET['id']);

			$query = "DELETE FROM module WHERE module_code = '$module'";
			$result= mysqli_query($conn, $query) or die(mysqli_error());
		}

		echo "<script>goBack();</script>";
	}
?>