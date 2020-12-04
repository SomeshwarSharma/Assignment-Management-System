<!-- EXTRA RECORD SAVED IN DATABASE WITH BLANK ENGAGEMENT POINT -->
	<!-- FIX LATER -->

<!-- MCODE AND MNAME ONLY SAVES THE LAST RECORD -->
	<!-- FIX LATER BUT WILL BE NEEDED FOR VALIDATION -->

<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/admin-navbar.php";
    	include "../db_handler.php";
	?>
	<?php
		$get = "SELECT module_code, module_name FROM module;";
		$got = mysqli_query($conn, $get);
		
		while($read = mysqli_fetch_array($got)) { 
        	$mcode = $read['module_code'];
        	$mname = $read['module_name'];
		}
	?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/css/bootstrap-slider.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/bootstrap-slider.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
	<title></title>
</head>
<body  style="background-color:lightblue">
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="container">
				    <h1>Add Module</h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <h3>Module Information</h3>
				        <form class="form-horizontal" role="form" method="post">
				        <div class="alert alert-danger" role="alert" style="display: none;" id="alertUser">
						  <strong>WARNING: </strong> The Module Code is already used. Please entered a different Module Code.
						</div>
						<div class="alert alert-danger" role="alert" style="display: none;" id="warnUser">
						  <strong>WARNING: </strong> The Module Name is already used. Please entered a different Module Name.
						</div>
				        <div class="form-group">
				            <label class="col-lg-3 control-label">Module Code:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="code" name="code" required>
				            </div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="name" name="name" required>
				            </div>
				          </div>
				          <div class="form-group">
							<label class="col-md-3 control-label" for="level">Module Level:</label>
							 <div class="col-md-8">
			                  <select id="rank" class="form-group form-control" data-show-subtext="true" data-live-search="true" name="level" style="margin-left: -1px;" required>
		                  	   <option value="" selected disabled>-- SELECT --</option>
		                  	   <option value="3">Level 3 (Foundation)</option>
		                  	   <option value="4">Level 4 (1st Year)</option>
		                  	   <option value="5">Level 5 (2nd Year)</option>
		                  	   <option value="6">Level 6 (3rd Year)</option>
			               	  </select>
		               	 	</div>
          				  </div>
          				  <div class="form-group">
				            <label class="col-lg-3 control-label">Module Leader:</label> 
				            <div class="col-lg-8">
							      <?php
										$query = "SELECT id, name, surname FROM users WHERE rank = 'lecturer' ORDER BY surname DESC";
										$result = mysqli_query($conn, $query);
								   ?>
									<select class="form-group form-control" data-show-subtext="true" data-live-search="true" id="leader" name="leader" style="margin-left: -1px;" required>
										<option selected="selected" disabled>-- SELECT --</option>
										<?php 
											while ($row = mysqli_fetch_array($result))
											{
											    echo "<option value='$row[0]'>$row[1] $row[2]</option>";
											}
										?>        
									</select>
				          	</div>
				          </div>
				          <div class="form-group">
				            <label class="col-lg-3 control-label">Module Description:</label>
				            <div class="col-lg-8">
				              <textarea class="form-control" onkeyup="textCounter(this,'counter',250);" type="text" id="description" name="description" rows="5" required></textarea>
				              <input disabled maxlength="3" size="3" value="250" id="counter">
					      		<small>Characters remaining.</small>
					      		<script>
									function textCounter(field,field2,maxlimit)
									{
									 	var countfield = document.getElementById(field2);
									 	if ( field.value.length > maxlimit ) {
									  		field.value = field.value.substring( 0, maxlimit );
									  		return false;
									 	} else {
									  		countfield.value = maxlimit - field.value.length;
									 	}
									}
						  		</script>
			            	</div>
				          </div>
          				  <?php
			                $query = "SELECT name FROM assessment GROUP BY name";
			                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
			                $choices = "";
			                while ($row = mysqli_fetch_array($result)) {
			                    $choices = $choices . "<option value='$row[0]'>Name: $row[0]</option>";
			                }
		            	  ?>
  				          <?php
			                $query = "SELECT name, surname FROM users WHERE rank = 'lecturer'";
			                $result = mysqli_query($conn, $query);
			                $options = "";
			                while ($row = mysqli_fetch_array($result)) {
			                    $options = $options . "<option value='$row[0]'>$row[0] $row[1]</option>";
			                }
		            	  ?>
		            	  <label class="col-lg-3 control-label"></label>
		            	  <div class="col-lg-8">
				        	  <div class="alert alert-info alert-dismissable">
					          	<i class="fa fa-warning"></i> <strong><u>NOTE:</u></strong> To select more than one option from the list, press the <strong>'Ctrl'</strong> button while selecting options in the selection boxes below.
				          	  </div>
			          	  </div>
			          	  <div class="form-group">
                        	<label class="col-lg-3 control-label">Lecturers Linked To Module:</label>
                        	<div class="col-lg-8">
                            	<select class="form-control" name="linked[]" multiple required>
                            		<option>All Lecturers</option>
	                                <?php
	                                	echo $options;
	                                ?>
                            	</select>
                        	</div>
                		  </div>
                		  <div class="form-group">
				            <label class="col-lg-3 control-label">Engagement points:</label>
				            <div class="col-lg-8"> 
						      	<div class="input-group control-group after-add-more">
								  <div class="input-group-btn"> 
									<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
								  </div>
							  	</div>
						        <div class="copy-fields hide">
						          <div class="control-group input-group" style="margin-top:10px">
						            <input type="text" name="addmore[]" class="form-control" placeholder="Add Engagement Point">
						            <div class="input-group-btn"> 
						              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
						            </div>
						          </div>
						        </div>
				          	</div>
				          </div>		          
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Add Module">
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
	textarea {
    	resize: none;
	}
	.table-sortable tbody tr {
    	cursor: move;
	}
</style>

<script type="text/javascript">
	$(function(){
	   $('button#showit').on('click',function(){  
	      $('#myform').show();
	      $('#showit').hide();
	      $('#hideit').show();
	   });
	   $('button#hideit').on('click',function(){  
	      $('#myform').hide();
	      $('#showit').show();
	      $('#hideit').hide();
	   });
	});
</script>

<script type="text/javascript">
    $(document).ready(function() {
 
      $(".add-more").click(function(){ 
          var html = $(".copy-fields").html();
          $(".after-add-more").after(html);
      });

      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });
 
    });
</script>

<script type="text/javascript">
	$(function() {
	    $('#alertUser').hide(); 
	    $('#code').change(function() {
	    	var amcode = <?php echo json_encode($mcode); ?>;
	    	 if($('#code').val() == amcode) {
		        $('#alertUser').show(); 
		    } else {
		        $('#alertUser').hide(); 
		    } 
	    });
	});
</script>

<script type="text/javascript">
	$(function() {
	    $('#alertUser').hide(); 
	    $('#name').change(function() {
	    	var amname = <?php echo json_encode($mname); ?>;
			if($('#name').val() == amname) {
		        $('#warnUser').show(); 
		    } else {
		        $('#warnUser').hide(); 
		    } 
	    });
	});	
</script>

<script type="text/javascript">
	function YNconfirm() { 
	 if (window.confirm('Module Saved!'))
	 {
	   window.location.href = '../home/adminHome.php';
	 }
	}
</script>

<?php 
	if(isset($_POST['submit'])) {
		$lid = mysqli_insert_id($conn);
		$id = mysqli_real_escape_string($conn, $_REQUEST['code']);
		$mname = mysqli_real_escape_string($conn, $_REQUEST['name']);
		$mlevel = mysqli_real_escape_string($conn, $_REQUEST['level']);
		$mleader = mysqli_real_escape_string($conn, $_REQUEST['leader']);
		$mdesc = mysqli_real_escape_string($conn, $_REQUEST['description']);

		foreach ($_POST['linked'] as $mlecturers) {
			foreach ($_POST['addmore'] as $mpoints) {
				$query = "INSERT INTO module (id, module_code, module_name, module_leader, description, level, assessment1, assessment2, assessment3, lecturers_linked, engagement_points) VALUES ('" . $lid . "', '" . $id . "', '" . $mname . "', '" . $mleader . "', '" . $mdesc . "', '" . $mlevel . "', ' ', ' ', ' ', '" . $mlecturers . "', '" . $mpoints . "')";

				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
			}
		}
		mysqli_close($conn);
		echo '<script type="text/javascript">','YNconfirm();','</script>';
	}
?>