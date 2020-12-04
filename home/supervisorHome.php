<!DOCTYPE html>
<html>	
	<?php 
		include "../includes/navbar.php";
		include "../db_handler.php";
	?>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css?<?php echo time(); ?> /">
		<link rel="stylesheet" href="css/style1.css?<?php echo time(); ?> /">
		<link rel="stylesheet" href="css/tile.css?<?php echo time(); ?> /">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> 
		<title>Home</title>
	</head>
	<body style="background-color:lightblue;" >
		<div class="container">
			<div class="wrapper">
			<br><br><br><br>
			<h1>Welcome
			<?php 
				$user = $_SESSION['id'];
				$sql = "SELECT * FROM users WHERE username = '$user'"; 
				$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			
		        while($row = mysqli_fetch_array($result)) { 
		        	$name = $row['name'];
					echo " " . $name . " (Faculty)";
				}
			?>
		</h1>
		<hr>
		
		<div class="col-md-6">
				<h3>Aseessment </h3>
				<button type="button" class="btn btn-info"><a href="../supervisor/admin-view-modules.php">Add Assessment</a></button>
				<button type="button" class="btn btn-primary"><a href="../supervisor/view-assessments.php">View Assessments</a></button>
				<button type="button" class="btn btn-danger"><a href="../student/uploads/view-submit-assessments.php">View submitted assessment</a></button>
			</div>
				
				<div class="col-md-6">
				<h3>Students </h3>
                <button type="button" class="btn btn-info"><a href="../supervisor/view-students.php">View Students</a></button>
				<?php 
					$leader = $_SESSION['id'];

                     $select = "SELECT id FROM users WHERE username = '$leader'";
                     $res = mysqli_query($conn, $select);

                     while($getting = mysqli_fetch_array($res))
                     {
                        $leaderid = $getting['id'];
                     }

                     $query = "
                          SELECT DISTINCT module_code, module_name, description, assessment1, assessment2, assessment3 FROM module WHERE module_leader = '$leaderid' ORDER BY module_code asc
                         ";

                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) > 0) {
				?>
				<button type="button" class="btn btn-danger"><a href="../lecturer/manage-module.php">Manage Modules</a></button>
				<?php
                    }
				?>
		</div>
		</div>
	</body>
		
	</div>
</html>

<style type="text/css">
	a, a:hover, a:active, a:visited { 
		color: white;
	}
	body{
		background-color : lightblue;
	}		
</style>