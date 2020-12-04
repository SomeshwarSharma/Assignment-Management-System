<!DOCTYPE html>
<html>
	<?php 
	    include "../includes/header.php";
		include "../includes/student-navbar.php";
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
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
		<title>Home</title>
	</head>
	<body style="background-color:lightblue;">
		<div class="container">
			<div class="wrapper">
			<h1>Welcome
			<?php 
				$user = $_SESSION['id'];
				$sql = "SELECT * FROM users WHERE username = '$user'"; 
				$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			
		        while($row = mysqli_fetch_array($result)) { 
		        	$name = $row['name'];
					echo " " . $name . " (Student)";
				}
			?>
			</h1>
			<div>
			<br>
			<hr>
			<br><br>
			<div class="col-md-6">
				<h3>Aseessment </h3>
				<button type="button" class="btn btn-primary"><a href="../student/view-assessments.php">View Assessments</a></button>
				<button type="button" class="btn btn-danger"><a href="../student/submit.php">submit-assessment</a></button>
			</div>
			<div class="col-md-6">
				<h3>Modules </h3>
				<button type="button" class="btn btn-info"><a href="../student/view-mod.php">View Modules</a></button>
			</div>
			<br><br>
			<hr>
		</body>
		</html>
<style type="text/css">
	a, a:hover, a:active, a:visited { 
		color: white;
	}
</style>