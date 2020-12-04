<!-- IF STUDENT ALREADY HAS SUPERVISOR, ALERT USER-->
<!-- IF SUPERVISOR HAS 5 STUDENTS ASSIGNED TO THEM, DONT ALLOW ANY MORE, INFORM USER AND DONT SAVE 
		MAYBE HAVE A COUNT ON THE SIDE OF THE SUPERVISORS NAME IN THE DROP DOWN LIST STATING HOW MANY STUDENTS THEY HAVE ASSIGNED TO THEM ALREADY, IF 5, NO SELECTABLE -->
<!-- MAKE SELECT FIELD REQUIRED TO BE SELECTED BEFORE SUBMITTING -->
<!-- NEED TO GO TO VIEW-STUDENTS BASED ON SUPERVISOR LOGGED IN -->

<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/lecturer-navbar.php";
	?>
<head>
	<title></title>
</head>
<body style="background-color:lightblue">
	<?php 
	if (isset($_GET['id'])) {
        $conn = mysqli_connect("localhost","root","","project");
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

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
				    <h1>Assign Supervisor to 				    
					    <?php 
			                if (isset($_GET['id'])) {
						        $conn = mysqli_connect("localhost","root","","project");
								if (mysqli_connect_errno()) {
								  echo "Failed to connect to MySQL: " . mysqli_connect_error();
								}

			                    $user = mysqli_real_escape_string($conn, $_GET['id']);
			                    $sfull = "SELECT name, surname FROM users WHERE username = '$user' ";

	                    		$result = mysqli_query($conn, $sfull) or die(mysqli_error($conn));
		
						        while($row = mysqli_fetch_array($result)) { 
						        	$name = $row['name'];
						        	$sname = $row['surname'];
								}

			                    echo " " . $name . " " . $sname . "";
			                }
			            ?></h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <h3><?php echo " " . $name . " " . $sname . "'s "; ?>Information</h3>
				        
				        <form class="form-horizontal" role="form" method="post">
				          <div class="form-group">
				            <label class="col-lg-3 control-label">First name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" readonly name="name" value="<?php if (isset($_GET['id'])) { print $name; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Surname:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" readonly name="sname" value="<?php if (isset($_GET['id'])) { print $sname; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Email:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="email" readonly name="email" value="<?php if (isset($_GET['id'])) { print $email; }?>">
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-md-3 control-label">Username:</label>
				            <div class="col-md-8">
				              <input class="form-control" type="text" readonly name="username" value="<?php if (isset($_GET['id'])) { print $user; }?>">
				            </div>
				          </div>
                    	  <div class="form-group">
	                        <label for="supervisor1" class="col-md-3 control-label">Supervisor:</label>
		                        <div class="col-md-8">
		                            <select class="form-control" name="supervisor1">
		                            <option selected="selected" selected disabled>-- SELECT ONE -- </option>
		                                <?php
									        $conn = mysqli_connect("localhost","root","","project");
											if (mysqli_connect_errno()) {
											  echo "Failed to connect to MySQL: " . mysqli_connect_error();
											}

								            $query = "SELECT name, surname FROM users WHERE rank = 'supervisor'";
								            
								            $result = mysqli_query($conn, $query);
								            $supervisors = "";
								            while ($row = mysqli_fetch_array($result)) {
								                $supervisors = $supervisors . "<option value='$row[0] $row[1]'>$row[0] $row[1]</option>";
								            }
	                            			echo $supervisors;
                                		?>
		                            </select>
		                        </div>
	                    	</div>
                    	  <div class="form-group">
	                        <label for="supervisor2" class="col-md-3 control-label">Second Supervisor:</label>
		                        <div class="col-md-8">
		                            <select class="form-control" name="supervisor2">
		                            <option selected="selected" selected disabled>-- SELECT ONE -- </option>
		                            <option value="Not assigned/No one">None (If student has not got a second supervisor, select this option)</option>
		                                <?php
	                            			echo $supervisors;
                                		?>
		                            </select>
		                        </div>
	                    	</div>	                    	
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Assign Supervisor">
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
	$conn = mysqli_connect("localhost","root","","project");
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if(isset($_POST['submit'])) {
		if (isset($_GET['id'])) {

			$user = mysqli_real_escape_string($conn, $_GET['id']);
			$get = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
	        while($row = mysqli_fetch_array($get)) { 
	        	$level = $row['rank'];
	        	$pass = $row['password'];
			}

			$name1 = mysqli_real_escape_string($conn, $_REQUEST['name']);
			$sname1 = mysqli_real_escape_string($conn, $_REQUEST['sname']);
			$email1 = mysqli_real_escape_string($conn, $_REQUEST['email']);
			$username1 = mysqli_real_escape_string($conn, $_REQUEST['username']);
			$fs = mysqli_real_escape_string($conn, $_REQUEST['supervisor1']);
			$ss = mysqli_real_escape_string($conn, $_REQUEST['supervisor2']);

			$query = "UPDATE users SET name='$name1', surname='$sname1', email='$email1', username='$username1', password='$pass', rank='$level', supervisor='$fs', second_supervisor='$ss' WHERE username='$user'";

			$result= mysqli_query($conn, $query) or die(mysqli_error());
			mysqli_close($conn);

			echo "<script>goBack();</script>";
		}
	}
?>