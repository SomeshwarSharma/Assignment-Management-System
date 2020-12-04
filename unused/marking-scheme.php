<!-- NEED TO FIX DATABASE CONNECTION -->
<!-- FIX TABLE WIDTH - MAKE RESPONSIVE -->

<!-- SHOW ALERTS IF PERCENTAGE IS NOT 100 -->

<!-- ON ASSESSMENT PAGE SO THIS IS NOT NEEDED -->

<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/lecturer-navbar.php";
    	include "../db_handler.php";
	?>
<head>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/css/bootstrap-slider.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/bootstrap-slider.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
	<title></title>
</head>
<body>
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
				    <h1>Marking Scheme For <?php echo $mcode .' - '. $mname ?></h1>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <h3>Marking Scheme 2017/2018</h3>
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
				          <?php
			                $query = "SELECT name, weighs FROM assessment";
			                $result = mysqli_query($conn, $query);
			                $choices = "";
			                while ($row = mysqli_fetch_array($result)) {
			                    $choices = $choices . "<option value='$row[0]'>Name: $row[0]. Weighs: $row[1]</option>";
			                }
		            	  ?>
  				          <div class="form-group">
	                        	<label for="ModuleDetails" class="col-md-3 control-label">Assessment Name/Type:</label>
			                        <div class="col-md-8">
										<select name="assessment" id="assessment" class="selectpicker" data-show-subtext="true" required>
											<option selected="selected" disabled>-- SELECT --</option>
											<?php 
												$query = "SELECT name, weighs, sub_assessment FROM assessment";
									            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
									            while ($row = mysqli_fetch_array($result)) {
									                echo "<option value='$row[0]'>$row[0] $row[1] - Sub Assessment: $row[2]</option>";
									            }
											?>        
			                            </select>
			                        </div>
	                    	</div>
						  <div class="form-group">
						  	<label class="col-lg-3 control-label">Areas For Marking:</label>
				            <div class="col-lg-8">
								<button id="showit" class="btn btn-success" type="button">Add</button>
								<button id="hideit" class="btn btn-danger" type="button" style="display: none;">Cancel</button>
								<br>
								<br>
							    <div class="container">
						    		<div class="alert alert-danger" role="alert" style="display: none;" id="alertUser">
								  		<strong>ALERT:</strong> Sub assessments weigh 100% in total. Therefore no more can be added. If you edit the weights, <strong>click outside</strong> the table to be able to add more rows.
									</div>
									<div class="alert alert-danger" role="alert" style="display: none;" id="weightValue">
								  		<strong>WARNING:</strong> Sub assessments weigh <strong> more </strong> than 100% in total. Please check all the weight values and make sure they equal 100% in total.
									</div>
									<div class="alert alert-warning" role="alert" style="display: none;" id="weightAvaliable">
								  		<strong>ALERT:</strong> Sub assessments weigh <strong> less </strong> than 100% in total. Please change the values or add more rows to make sure they equal 100% in total.
									</div>
								    <div class="row clearfix" style="display: none;" id="myform">
										<div class="col-md-12 column">
											<table class="table table-bordered table-hover" id="tab_logic">
												<thead>
													<tr >
														<th class="text-center">#</th>
														<th class="text-center">Criteria</th>
														<th class="text-center">Description</th>
														<th class="text-center">Marks Percentage</th>
														<th class="text-center">Single Range?</th>
														<th class="text-center">Marks Range Value/s</th>
													</tr>
												</thead>
												<tbody>
													<tr id='addr0'>
														<td>1</td>
														<td>
															<input type="text" name='sname[]'  placeholder='Area Name' class="form-control"/>
														</td>
														<td>
															<input type="text" name='squestions[]' placeholder='Questions' class="form-control"/>
														</td>
														<td>
															<input type="number" name='spercentage[]' placeholder='  Percentage' class="spercentage"/>
														</td>
														<td>
															<select name="schoice[]" class="form-control">
																<option selected="selected" disabled="">-- SELECT --</option>
																<option value="Yes">Yes</option>
																<option value="No">No</option>
															</select>
														</td>
														<td>
															<input type="text" name='smarksrange[]' placeholder='Range' class="form-control"/>
														</td>
													</tr>
								                    <tr id='addr1'></tr>
												</tbody>
											</table>
										</div>
										<a id="add_row" class="btn btn-success pull-left">Add Row</a><a style="margin-left: 3px;" id='delete_row' class="pull-left btn btn-danger">Delete Row</a>
									</div>
								</div>
							</div>
						  </div>	         
				          <div class="form-group">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				              <input type="submit" name="submit" class="btn btn-primary" value="Save Marking Scheme">
				              <span></span>
				              <input type="reset" name="reset" class="btn btn-default" value="Cancel" onclick="goBack()">
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
			window.location.href = 'view-modules.php';
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
	.spercentage {
		width: 100%;
		height: 32px;
		border-radius: 5px;
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
    $(document).on('change', '.spercentage', function() {
        var atotal = 0;
        $('.spercentage').each(function(){
            atotal += parseFloat($(this).val());
        });
        if(atotal == 100) {
        	$('#add_row').hide();
        	$('#alertUser').show();
        	$('#weightValue').hide();
        	$('#weightAvaliable').hide();
        	$('.spercentage').css("color", "black");
        }
        else if(atotal < 100) {
        	$('#add_row').show();
        	$('#alertUser').hide();
        	$('#weightValue').hide();
        	$('#weightAvaliable').show();
        	$('.spercentage').css("color", "red");
        }
        else if(atotal > 100) {
        	$('#add_row').hide();
        	$('#alertUser').hide();
        	$('#weightValue').show();
        	$('#weightAvaliable').hide();
        	$('.spercentage').css("color", "red");
        }
    });
</script>

<script type="text/javascript">
     $(document).ready(function(){
      var i=1;
     $("#add_row").click(function(){
      $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='sname[]"+i+"' type='text' placeholder='Area Name' class='form-control input-md'  /> </td><td><input  name='squestions[]"+i+"' type='text' placeholder='Questions' class='form-control input-md'></td><td><input name='spercentage[]"+i+"' type='text' placeholder='  Percentage' class='spercentage'></td><td><select name='schoice[]' class='form-control'><option selected='selected' disabled=''>-- SELECT --</option><option value='Yes'>Yes</option><option value='No'>No</option></select></td><td><input type='text' name='smarksrange[]' placeholder='Range' class='form-control'/></td>");

      $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
      i++; 
	  });
	     $("#delete_row").click(function(){
	    	 if(i>1){
			 $("#addr"+(i-1)).html('');
			 i--;
			 }
		 });

	});
</script>

<?php 
	if(isset($_POST['submit'])) {
		$id = mysqli_insert_id($conn);
		$modulecode = mysqli_real_escape_string($conn, $_REQUEST['code']);
		$modulename = mysqli_real_escape_string($conn, $_REQUEST['name']);
		$totalmarks = mysqli_real_escape_string($conn, $_REQUEST['total']);

		$stones = mysqli_real_escape_string($conn, $_REQUEST['assessment']);
		$aquery = "SELECT assessment_code FROM assessment WHERE name = '$stones'"; // FINDS THE ASSESSMENT CODE BASED ON THE ASSESSMENT CHOSEN IN THE SELECTION LIST ABOVE

		$testing = mysqli_query($conn, $aquery); // SAVES 'sql' QUERY RESULT
		$atest = mysqli_fetch_array($testing); // FETCHES THE DATA FROM THAT RESULT

		$acode = $atest['assessment_code']; // SAVES THE ARRAY AS A STRING

		$totalMarksA = 0;

		if (isset($_POST['smarks'])) {
			foreach ($_POST['smarks'] as $key => $value) {
				$marksA = $_POST['smarks'][$key];

				$totalMarksA = $totalMarksA + $marksA;
			}

			if ($totalMarksA == $totalmarks) {
				foreach ($_POST['sname'] as $key => $value) {
					$asname = $_POST['sname'][$key];
					$asquestions = $_POST['squestions'][$key];
					$asmarks = $_POST['smarks'][$key];

					$query = "INSERT INTO marking_scheme (id, module_code, module_name, assessment_code, total_marks, area_name, questions, marks_avaliable) VALUES ('" . $id . "', '" . $modulecode . "', '" . $modulename . "', '" . $acode . "', '" . $totalmarks . "', '" . $asname . "', '" . $asquestions . "', '" . $asmarks . "')";
					
					$result = mysqli_query($conn, $query) or die(mysqli_error($conn));	
				}
			}

			else if ($totalMarksA < $totalmarks || $totalMarksA > $totalmarks) {
				$emessageS = "Marks avaliable in topic areas do not add up to total marks avaliable. Current total of avaliable marks: " . $totalMarksA . ". Total stated avaliable: " . $totalmarks;

				echo "<script type='text/javascript'>alert('$emessageS');history.go(-1);</script>";
			}
		}

		mysqli_close($conn);
		echo '<script type="text/javascript">','goBack();','</script>';
	}
?>