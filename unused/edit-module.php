<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/lecturer-navbar.php";
	?>
<head>
	<title></title>
</head>
<body>
	<?php 
	if (isset($_GET['id'])) {
        $conn = mysqli_connect("localhost","root","","project");
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$module = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM module WHERE module_code = '$module'"; 
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
				    <h1>Edit Module Information</h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <div class="alert alert-info alert-dismissable">
				          <a class="panel-close close" data-dismiss="alert">×</a> 
				          <i class="fa fa-warning" style="color: red;"></i> Changes can <strong >NOT</strong> be undone after saving. Any fields left blank will go back to the old information stored if there is any.
			          	</div>
				        <h3>Module Information</h3>
				        
				        <form class="form-horizontal" role="form" method="post">
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Code:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" name="mcode" value="<?php if (isset($_GET['id'])) { print $mcode; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" name="mname" value="<?php if (isset($_GET['id'])) { print $mname; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Leader:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" name="mleader" value="<?php if (isset($_GET['id'])) { print $mleader; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Description:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="text" name="desc" value="<?php if (isset($_GET['id'])) { print $desc; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Assessment 1:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="text" name="as1" value="<?php if (isset($_GET['id'])) { print $as1; }?>">
				            </div>
				          </div>
  				          <div class="form-group">
				            <label class="col-md-3 control-label">Assessment 2:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="text" name="as2" value="<?php if (isset($_GET['id'])) { print $as2; }?>">
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
			window.location = '../home/adminHome.php';
		}
	</script>
</body>

</html>

<?php 
	$conn = mysqli_connect("localhost","root","","project");
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if(isset($_POST['submit'])) {
		if (isset($_GET['id'])) {

			$module = mysqli_real_escape_string($conn, $_GET['id']);
			$get = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
			$mcode = mysqli_real_escape_string($conn, $_REQUEST['mcode']);
			$mname = mysqli_real_escape_string($conn, $_REQUEST['mname']);
			$mleader = mysqli_real_escape_string($conn, $_REQUEST['mleader']);
			$desc = mysqli_real_escape_string($conn, $_REQUEST['desc']);
			$as1 = mysqli_real_escape_string($conn, $_REQUEST['as1']);
			$as2 = mysqli_real_escape_string($conn, $_REQUEST['as2']);

			$query = "UPDATE module SET module_code='$mcode', module_name='$mname', module_leader='$mleader', description='$desc', assessment1='$as1', assessment2='$as2' WHERE module_code='$module'";

			$result= mysqli_query($conn, $query) or die(mysqli_error());
			mysqli_close($conn);
			
			echo "<script>goBack();</script>";
		}
	}
?>