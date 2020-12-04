<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/admin-navbar.php";
    	include "../db_handler.php";
	?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
	<title></title>
</head>
<body  style="background-color:lightblue">
	<?php 
	if (isset($_GET['id'])) {
		$module = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM module WHERE module_code = '$module'"; 
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
        while($row = mysqli_fetch_array($result)) { 
        	$mcode = $row['module_code'];
        	$mname = $row['module_name'];
		}
	}
	?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="container">
				    <h1>Assign Students To Lecturers</h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <form class="form-horizontal" role="form" method="post">
				        <div class="form-group">
				            <label class="col-lg-3 control-label">Module Code:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="code" name="code" value="<?php if (isset($_GET['id'])) { print $mcode; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="name" name="name" value="<?php if (isset($_GET['id'])) { print $mname; }?>" readonly>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Lecturer Name:</label> 
				            <div class="col-lg-8">
							      <?php
									$query = "SELECT name, surname FROM users WHERE rank = 'lecturer' ORDER BY id ASC";
									$result = mysqli_query($conn, $query);
								   ?>
									<select class="form-group form-control" data-show-subtext="true" data-live-search="true" id="lecturer" name="lecturer" style="margin-left: -1px;" required>
										<option selected="selected" disabled>-- SELECT --</option>
										<?php 
										while ($row = mysqli_fetch_array($result))
										{
										    echo "<option value='$row[0]'>$row[0] $row[1]</option>";
										}
										?>        
									</select>
				          	</div>
				          </div>
  				          <?php
  				          	$sql = "SELECT level FROM module WHERE module_code = '$mcode'"; 

							$res = mysqli_query($conn, $sql); // SAVES 'sql' QUERY RESULT
							$test = mysqli_fetch_array($res); // FETCHES THE DATA FROM THAT RESULT

							$mlevel = $test['level']; // SAVES THE ARRAY AS A STRING
		            	  ?>
		            	  <label class="col-lg-3 control-label"></label>
		            	  <div class="col-lg-8">
			        	  <div class="alert alert-info alert-dismissable">
				          	<i class="fa fa-warning"></i> <strong><u>NOTE:</u></strong> To select more than one option from the list, press the <strong>'Ctrl'</strong> button while selecting options in the selection boxes below.
			          	  </div>
			          	  </div>
	                      <div class="form-group">
                        	<label class="col-lg-3 control-label">Students:</label>
                        	<div class="col-lg-8">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="table-container">
											<table class="table table-filter">
												<tbody>
													<th>Student Name</th>
													<th>Assign To Lecturer?</th>
													<tr data-status="pagado">
													<?php
					                                    $sql = "SELECT * FROM users WHERE rank = 'student' AND level ='$mlevel'"; 
					                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

					                                    $output = '';
					                                    if(mysqli_num_rows($result) > 0)
					                                    {

					                                     while($row = mysqli_fetch_array($result))
					                                     {
					                                        
					                                      $output .= '
					                                       <tr>
					                                            <td value="'.$row['id'].'">'.$row["name"]." ".$row["surname"].'</td>
					                                            <td>
																	<input type="checkbox" id="cbtest" name="cbtest[]" value="'.$row['id'].'" />
				    												<label for="cbtest" class="check-box"></label> 
					                                            </td>
					                                      </tr>';
					                                     }
					                                     echo $output;
					                                    }
				                                	?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
                        	</div>
                		  </div>		          
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Assign Students">
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
			window.location.href = '../home/adminHome.php';
		}
	</script>
</body>
</html>

<style type="text/css">
	.entry:not(:first-of-type)
	{
	    margin-top: 10px;
	}
	.glyphicon
	{
	    font-size: 12px;
	}
	#counter {
	    padding: 2px;
	    border: 1px solid #eee;
	    font: 1em 'Trebuchet MS',verdana,sans-serif;
	    color: black;
	    border: none;
	}

</style>

<?php 
	if(isset($_POST['submit'])) {
		$id = mysqli_insert_id($conn);
		$lname = mysqli_real_escape_string($conn, $_REQUEST['lecturer']); 

		$query = "SELECT id FROM users WHERE name = '$lname'";

		$res = mysqli_query($conn, $query); // SAVES 'sql' QUERY RESULT
		$test = mysqli_fetch_array($res); // FETCHES THE DATA FROM THAT RESULT

		$lid = $test['id']; // SAVES THE ARRAY AS A STRING

		foreach ($_POST['cbtest'] as $key => $value) {
			$sid = $_POST['cbtest'][$key];

			$sql = "INSERT INTO lecturers (id, lecturer_id, student_id, module_code, module_name) VALUES ('" . $id . "', '" . $lid . "', '" . $sid . "', '" . $mcode . "', '" . $mname . "')";
			$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		}

		mysqli_close($conn);
		echo '<script type="text/javascript">','goBack();','</script>';
	}
?>