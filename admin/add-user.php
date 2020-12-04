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
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="container">
				    <h1>Add User</h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <h3>Account Information</h3>
				        
				        <form class="form-horizontal" role="form" method="post">
				          <div class="form-group">
				            <label class="col-lg-3 control-label">First name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="name" name="name" required>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Last name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="sname" name="sname" required>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Email:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="email" id="email" name="email" required>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Password:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="password" id="password" name="password" required>
				            </div>
				          </div>
		          		  <div class="form-group">
							 <label class="col-md-3 control-label" for="rank">Account Level:</label>
							 <div class="col-md-8">
			                  <select id="rank" class="form-group form-control" data-show-subtext="true" data-live-search="true" name="rank" style="margin-left: -1px;" required>
		                  		<option value="" selected disabled>-- SELECT --</option>
		                  		<option value="one">Student</option>
		                  		<option value="two">Lecturer</option>
								  <option value="three">Admin</option>
									<option value="four">Faculty</option>
			               	  </select>
			               	  </div>
          				  </div>
          				  
          				  <div class="form-group" id="hideDiv" style="display: none;">
							 <label class="col-md-3 control-label" for="level">Student Study Level:</label>
							 <div class="col-md-8"><div class="alert alert-info alert-dismissable">
				          			<a class="panel-close close" data-dismiss="alert">×</a> 
				          			<i class="fa fa-warning" style="color: red;"></i> Please choose level of student study.
	          		  		  </div>
			                  <select id="level" class="form-group form-control" data-show-subtext="true" data-live-search="true" name="level" style="margin-left: -1px;">
		                  		<option value="" selected disabled>-- SELECT --</option>
		                  		<option value="3">Level 3 (Foundation)</option>
		                  		<option value="4">Level 4 (1st Year)</option>
		                  		<option value="5">Level 5 (2nd Year)</option>
		                  		<option value="6">Level 6 (3rd Year)</option>
			               	  </select>
			               	  </div>
          				  </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Add User">
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

<script type="text/javascript">
	$(function() {
	    $('#hideDiv').hide(); 
	    $('#rank').change(function(){
	        if($('#rank').val() == 'one') {
	            $('#hideDiv').show(); 
	        } else {
	            $('#hideDiv').hide(); 
	        } 
	    });
	});
</script>

<script type="text/javascript">
	function YNconfirm() { 
	 if (window.confirm('User Saved!'))
	 {
	   window.location.href = '../home/adminHome.php';
	 }
	}
</script>

<?php 
	if(isset($_POST['submit'])) {

		$uid = mysqli_insert_id($conn);
		$name1 = mysqli_real_escape_string($conn, $_REQUEST['name']);
		$sname1 = mysqli_real_escape_string($conn, $_REQUEST['sname']);
		$email1 = mysqli_real_escape_string($conn, $_REQUEST['email']);
		$username1 = mysqli_real_escape_string($conn, $_REQUEST['email']);
		$password1 = mysqli_real_escape_string($conn, $_REQUEST['password']);
		$rank1 = mysqli_real_escape_string($conn, $_REQUEST['rank']);
		
		if($rank1 == 'one') {
			$level1 = mysqli_real_escape_string($conn, $_REQUEST['level']);
		}

		else { 
			$level1 = "0";
		}

		if($rank1 == 'one') {
			$query = "INSERT INTO users (id, name, surname, email, username, password, rank, level) VALUES ('" . $uid . "', '" . $name1 . "', '" . $sname1 . "', '" . $email1 . "', '" . $username1 . "', '" . $password1 . "', 'student', '" . $level1 . "')";
		}

		if($rank1 == 'two') {
			$query = "INSERT INTO users (id, name, surname, email, username, password, rank, level) VALUES ('" . $uid . "', '" . $name1 . "', '" . $sname1 . "', '" . $email1 . "', '" . $username1 . "', '" . $password1 . "', 'lecturer', '0')";
		}

		if($rank1 == 'three') {
			$query = "INSERT INTO users (id, name, surname, email, username, password, rank, level) VALUES ('" . $uid . "', '" . $name1 . "', '" . $sname1 . "', '" . $email1 . "', '" . $username1 . "', '" . $password1 . "', 'admin', '0')";
		}
		if($rank1 == 'four') {
			$query = "INSERT INTO users (id, name, surname, email, username, password, rank, level) VALUES ('" . $uid . "', '" . $name1 . "', '" . $sname1 . "', '" . $email1 . "', '" . $username1 . "', '" . $password1 . "', 'supervisor', '0')";
		}

		$result= mysqli_query($conn, $query) or die(mysqli_error($conn));
		mysqli_close($conn);
		
		echo '<script type="text/javascript">','YNconfirm();','</script>';
	}
?>