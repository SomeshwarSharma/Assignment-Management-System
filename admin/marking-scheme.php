<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/admin-navbar.php";
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
<body  style="background-color:lightblue">
	<?php 
	if (isset($_GET['id'])) {
		$assess = mysqli_real_escape_string($conn, $_GET['id']);

		$sql = "SELECT * FROM assessment WHERE assessment_code = '$assess'"; 
		$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
        while($row = mysqli_fetch_array($result)) { 
        	$mcode = $row['module_code'];
        	$aname = $row['name'];
        	$asuba = $row['sub_assessment'];
		}

		$sql1 = "SELECT module_name FROM module WHERE module_code = '$mcode'";
		$result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));

		while($row1 = mysqli_fetch_array($result1)) { 
        	$mname = $row1['module_name'];
		}
	}
	?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="container">
				    <h1>Marking Scheme For <?php echo $mcode .' - '. $aname; if($asuba != " ") {echo ": " . $asuba;} ?></h1>
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
				              <input class="form-control" type="text" id="name" name="name" value="<?php print $mname; ?>" readonly>
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
				            <label class="col-lg-3 control-label">Assessment Name:</label>
				            <div class="col-lg-8">
				              <input class="form-control" type="text" id="assessment" name="assessment" value="<?php print $aname; if($asuba != " ") {echo ": " . $asuba;} ?>" readonly>
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
											<div class="table-responsive">
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
																<input type="text" name='sname[]'  placeholder='Criteria' class="form-control"/>
															</td>
															<td>
																<input type="text" name='squestions[]' placeholder='Description' class="form-control"/>
															</td>
															<td>
																<input type="number" name='spercent[]' placeholder='  Percentage' class="spercentage"/>
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
      $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='sname[]"+i+"' type='text' placeholder='Criteria' class='form-control input-md'  /> </td><td><input  name='squestions[]"+i+"' type='text' placeholder='Description' class='form-control input-md'></td><td><input name='spercent[]"+i+"' type='text' placeholder='  Percentage' class='spercentage'></td><td><select name='schoice[]' class='form-control'><option selected='selected' disabled=''>-- SELECT --</option><option value='Yes'>Yes</option><option value='No'>No</option></select></td><td><input type='text' name='smarksrange[]' placeholder='Range' class='form-control'/></td>");

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
			foreach ($_POST['sname'] as $key => $value) {
				$asname = $_POST['sname'][$key];
				$asquestions = $_POST['squestions'][$key];
				$aspercent = $_POST['spercent'][$key];
				$art = $_POST['schoice'][$key];
				$amr = $_POST['smarksrange'][$key];

				$query = "INSERT INTO marking_scheme (id, module_code, module_name, assessment_code, criteria, description, percentage, range_type, marks_range) VALUES ('" . $id . "', '" . $mcode . "', '" . $mname . "', '" . $assess . "', '" . $asname . "', '" . $asquestions . "', '" . $aspercent . "', '" . $art . "', '" . $amr . "')";
				
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn));	
			}
		mysqli_close($conn);
		echo '<script type="text/javascript">','goBack();','</script>';
	}
?>