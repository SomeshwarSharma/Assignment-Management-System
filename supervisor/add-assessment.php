<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/navbar.php";
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
<body onload="SetDate();"  style="background-color:lightblue">
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
				    <h1>Add Assessment</h1>
			    	<?php 
						$sql = "SELECT assessment1, assessment2, assessment3 FROM module WHERE module_code = '$mcode'";

						$answer = mysqli_query($conn, $sql); // SAVES 'sql' QUERY RESULT
						$test = mysqli_fetch_array($answer); // FETCHES THE DATA FROM THAT RESULT

						$a1 = $test['assessment1']; // SAVES THE ARRAY AS A STRING
						$a2 = $test['assessment2']; // SAVES THE ARRAY AS A STRING
						$a3 = $test['assessment3']; // SAVES THE ARRAY AS A STRING

						$a1weight = "";
						$a2weight = "";
						$a3weight = "";
						
						if($a1 != "") {
							$get = "SELECT DISTINCT weighs FROM assessment WHERE assessment_code = '$a1'";

							$got = mysqli_query($conn, $get);

							while ($row1 = mysqli_fetch_array($got)) {
								$a1weight = $row1['weighs'];
							}
						}

						if($a2 != "") {
							$recieve = "SELECT DISTINCT weighs FROM assessment WHERE assessment_code = '$a2'";

							$recieved = mysqli_query($conn, $recieve);

							while ($row2 = mysqli_fetch_array($recieved)) {
								$a2weight = $row2['weighs'];
							}
						}

						if($a3 != "") {
							$go = "SELECT DISTINCT weighs FROM assessment WHERE assessment_code = '$a3'";

							$stay = mysqli_query($conn, $go);

							while ($row3 = mysqli_fetch_array($stay)) {
								$a3weight = $row3['weighs'];
							}
						}

						$totalWeight = 0;

						if ($a1weight == "" && $a2weight == "" && $a3weight == "") {
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: 0% for Assessment 1, 0% for Assessment 2 and 0% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else if ($a1weight == "" && $a2weight == "") {
							$totalWeight = $totalWeight + $a3weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: 0% for Assessment 1, 0% for Assessment 2 and " . $a3weight . "% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else if ($a1weight == "" && $a3weight == "") {
							$totalWeight = $totalWeight + $a2weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: 0% for Assessment 1, ". $a2weight ."% for Assessment 2 and 0% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else if ($a2weight == "" && $a3weight == "") {
							$totalWeight = $totalWeight + $a1weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: " . $a1weight . "% for Assessment 1, 0% for Assessment 2 and 0% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else if ($a1weight == "") {
							$totalWeight = $totalWeight + $a2weight + $a3weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: 0% for Assessment 1, " . $a2weight . "% for Assessment 2 and " . $a3weight . "% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else if ($a2weight == "") {
							$totalWeight = $totalWeight + $a1weight + $a3weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: " . $a1weight . "% for Assessment 1, 0% for Assessment 2 and " . $a3weight . "% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else if ($a3weight == "") {
							$totalWeight = $totalWeight + $a1weight + $a2weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: " . $a1weight . "% for Assessment 1, " . $a2weight . "% for Assessment 2 and 0% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
						else {
							$totalWeight = $totalWeight + $a1weight + $a2weight + $a3weight;
							echo "<b style='color: red;'>ALERT : </b>Current weight for Module " . $mcode . " - " . $mname . " is: " . $a1weight . "% for Assessment 1, " . $a2weight . "% for Assessment 2 and " . $a3weight . "% for Assessment 3. Total weight: " . $totalWeight . "%";
						}
					?>
				  	<hr>
					<div class="row">
				      <div class="col-md-9 personal-info">
				        <h3>Assessment Information</h3>
				        <?php 
					        if ($totalWeight == "100") {
								?> 
									<div class="alert alert-danger" role="alert">
									  <strong>IMPORTANT NOTICE: </strong> The module selected already has assessments weighing 100%. Therefore <b style='color: red;'>no more can be added</b>.
									</div>
								<?php
							}
				        	else if ($totalWeight != "100") {
				        		?>
				        		<div class="alert alert-warning" role="alert">
								  <strong>IMPORTANT NOTICE: </strong> The module selected can only weigh 100%. The remaining weight avaliable is: <b style='color: red;'><?php echo (100 - $totalWeight) ?>%</b><br>.
								</div>
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
								<label class="col-md-3 control-label" for="aname">Assessment Name:</label>
								 <div class="col-md-8">
				                  <input class="form-control" type="text" id="aname" name="aname" required>
				               	 </div>
	          				  </div>
	          				  <div class="form-group">
					            <label class="col-lg-3 control-label">Assessment Deadline:</label>
					            <div class="col-lg-8">
					              <input class="form-control" type="date" id="adeadline" name="adeadline" required>
					            </div>
					          </div>
					          <div class="alert alert-danger" role="alert" id="weight_div" style="display: none;">
						  		<strong>ALERT:</strong> Assessment weight chosen is invalid. Please enter a value <strong> equalled to or less than <?php echo (100 - $totalWeight) ?></strong>.
							</div>
	  				          <div class="form-group">
					            <label class="col-lg-3 control-label">Assessment Weight:</label>
					            <div class="col-lg-8">
					              <input class="form-control" id="aweight" type="number" min="0" name="aweight" required>
					            </div>
					          </div>
					          <div class="form-group">
								<label class="col-md-3 control-label" for="nmarks">Number Of Markers:</label>
								 <div class="col-md-8">
				                  <select id="rank" class="form-group form-control" data-show-subtext="true" data-live-search="true" name="nmarks" style="margin-left: -1px;" required>
			                  	   <option value="1">1</option>
			                  	   <option selected value="2">2</option>
			                  	   <option value="3">3</option>
				               	  </select>
				               	 </div>
	          				  </div>
	          				  <div class="form-group">
								<label class="col-md-3 control-label" for="ascheme">Marking Scheme:</label>
								 <div class="col-md-8">
				                  <select id="ascheme" class="form-group form-control" data-show-subtext="true" data-live-search="true" name="ascheme" style="margin-left: -1px;" onchange="showDiv(this)" required>
			                  	   <option value="" selected disabled>-- SELECT --</option>
			                  	   <option value="yes">Yes</option>
			                  	   <option value="no">No</option>
				               	  </select>
			               	 	</div>
	          				  </div>

	          				  <div id="hidden_div" style="display: none;">
	          				  <hr>
		          				<div id="wrapper">
									<div id="page-wrapper">
										<div class="container-fluid">
											<div class="container">
											    <h3>Marking Scheme For <?php echo $mcode .' - '. $mname ?></h3>
												<div class="row">
											      <div class="col-md-9 personal-info">
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
													  	<label class="col-lg-3 control-label">Areas For Marking:</label>
											            <div class="col-lg-8">
															<button id="showtable" class="btn btn-success" type="button">Add</button>
															<button id="hidetable" class="btn btn-danger" type="button" style="display: none;">Cancel</button>
															<br>
															<br>
															<div class="container"> 
																<div class="alert alert-danger" role="alert" style="display: none; width: 100%;" id="notifyUser">
															  		<strong>ALERT:</strong> Percentage is 100% in total. Therefore no more criteria's can be added. If you edit the percentage values, <strong>click outside</strong> the table to be able to add more rows.
																</div>
																<div class="alert alert-danger" role="alert" style="display: none; width: 100%;" id="percentageValue">
															  		<strong>WARNING:</strong> Percentage is <strong> higher </strong> than 100% in total. Please check all the percentage values and make sure they equal 100% in total.
																</div>
																<div class="alert alert-warning" role="alert" style="display: none; width: 100%;" id="percentageAvaliable">
															  		<strong>ALERT:</strong> Percentage is <strong> less </strong> than 100% in total. Please change the values or add more rows to make sure they equal 100% in total.
																</div>
															    <div class="row clearfix" style="display: none;" id="myform1">
																	<div class="col-md-12 column">
																		<div class="table-responsive">
																			<table class="table table-bordered table-hover" id="table_logic">
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
																					<tr id='addrow0'>
																						<td>1</td>
																						<td>
																							<input type="text" name='criteria[]'  placeholder='Criteria' class="form-control"/>
																						</td>
																						<td>
																							<input type="text" name='mdesc[]' placeholder='Description' class="form-control"/>
																						</td>
																						<td>
																							<input type="number" min="0" name='spercentage[]' placeholder='Percentage' class="percentage"/>
																						</td>
																						<td>
																							<select name="mchoice[]" class="form-control">
																								<option selected="selected" disabled="">-- SELECT --</option>
																								<option value="Yes">Yes</option>
																								<option value="No">No</option>
																							</select>
																						</td>
																						<td>
																							<input type="text" name='smarksrange[]' placeholder='Range' class="form-control"/>
																						</td>
																					</tr>
																                    <tr id='addrow1'></tr>
																				</tbody>
																			</table>
																		<br>
																		</div>
																	</div>
																	<a id="add_more_row" class="btn btn-success pull-left">Add Row</a><a style="margin-left: 3px;" id='delete_this_row' class="pull-left btn btn-danger">Delete Row</a>
																</div>
															</div>
														</div>
													  </div>	         
											      </div>
											  </div>
											</div>
											<hr>
										</div>
									</div>
								</div>
	          				  </div>

					          <div class="form-group">
					            <label class="col-lg-3 control-label">Assessment Description:</label>
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
				                $query = "SELECT name, surname FROM users WHERE rank = 'lecturer'";
				                $result = mysqli_query($conn, $query);
				                $options = "";
				                while ($row = mysqli_fetch_array($result)) {
				                    $options = $options . "<option value='$row[0]'>$row[0] $row[1]</option>";
				                }
			            	  ?>
			            	  <label class="col-lg-3 control-label"></label>
			            	  <div class="col-lg-8">
			            	  <br>
				        	  <div class="alert alert-info alert-dismissable">
					          	<i class="fa fa-warning"></i> <strong><u>NOTE:</u></strong> To select more than one option from the list, press the <strong>'Ctrl'</strong> button while selecting options in the selection boxes below.
				          	  </div>
				          	  </div>
		                      <div class="form-group">
	                        	<label class="col-lg-3 control-label">Lecturers Who Can Mark This Assessment:</label>
	                        	<div class="col-lg-8">
	                            	<select class="form-control" name="lecturers[]" multiple required>
	                            		<option>All Lecturers</option>
		                                <?php
		                                	echo $options;
		                                ?>
	                            	</select>
	                        	</div>
	                		  </div>
							  <div class="form-group">
					            <label style="margin-top: 25px;" class="col-lg-3 control-label">Sub-Assessments:</label>
					            <div class="col-lg-8">
					            <br>
									<button id="showit" class="btn btn-success" type="button">Add</button>
									<button id="hideit" class="btn btn-danger" type="button" style="display: none;">Cancel</button>
									<br>
									<br>
									<div class="container">
										<div class="alert alert-danger" role="alert" style="display: none; width: 100%;" id="alertUser">
									  		<strong>ALERT:</strong> Sub assessments weigh 100% in total. Therefore no more can be added. If you edit the weights, <strong>click outside</strong> the table to be able to add more rows.
										</div>
										<div class="alert alert-danger" role="alert" style="display: none; width: 100%;" id="weightValue">
									  		<strong>WARNING:</strong> Sub assessments weigh <strong> more </strong> than 100% in total. Please check all the weight values and make sure they equal 100% in total.
										</div>
										<div class="alert alert-warning" role="alert" style="display: none; width: 100%;" id="weightAvaliable">
									  		<strong>ALERT:</strong> Sub assessments weigh <strong> less </strong> than 100% in total. Please change the values or add more rows to make sure they equal 100% in total.
										</div>
									    <div class="row clearfix" style="display: none;" id="myform">
											<div class="col-md-12 column">
												<div class="table-responsive">
													<table class="table table-bordered table-hover" id="tab_logic">
														<thead>
															<tr >
																<th class="text-center">#</th>
																<th class="text-center">Name</th>
																<th class="text-center">Description</th>
																<th class="text-center">Weight</th>
																<th class="text-center">Marking Scheme</th>
																<th class="text-center">Deadline</th>
															</tr>
														</thead>
														<tbody>
															<tr id='addr0'>
																<td>1</td>
																<td>
																	<input type="text" name='sname[]'  placeholder='Name' class="form-control"/>
																</td>
																<td>
																	<input type="text" name='sdesc[]' placeholder='Description' class="form-control"/>
																</td>
																<td>
																	<input type="number" min="0" name='sweight[]' id='sweight' placeholder='Weight' class="sweight"/>
																</td>
																<td>
																	<select name="schoice[]" class="form-control">
																		<option selected="selected" disabled="">-- SELECT --</option>
																		<option value="Yes">Yes</option>
																		<option value="">No (Single Marking)</option>
																	</select>
																</td>
																<td>
																	<input type="date" name='sdeadline[]' id="sdeadline" placeholder='Deadline' class="form-control"/>
																</td>
															</tr>
										                    <tr id='addr1'></tr>
														</tbody>
													</table>
												</div>
											</div>
											<a id="add_row" class="btn btn-success pull-left">Add Row</a><a style="margin-left: 3px;" id='delete_row' class="pull-left btn btn-danger">Delete Row</a>
										</div>
									</div>
								</div>
							  </div>		          
					          <div class="form-group">
					            <label class="col-md-3 control-label"></label>
					            <div class="col-md-8">
					            <br>
					            <hr>
					              <input type="submit" name="submit" class="btn btn-primary" value="Add Assessment">
					              <span></span>
					              <input type="reset" class="btn btn-default" value="Cancel" onclick="goBack()">
					            </div>
					          </div>
					        </form>
				        		<?php
				        	}
				        ?>
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
			window.location.href = '../home/supervisorHome.php';
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
	.percentage, .sweight {
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
	$(function() {
	   $('button#showtable').on('click',function(){  
	      $('#myform1').show();
	      $('#showtable').hide();
	      $('#hidetable').show();
	   });
	   $('button#hidetable').on('click',function(){  
	      $('#myform1').hide();
	      $('#showtable').show();
	      $('#hidetable').hide();
	   });
	});
</script>

<script type="text/javascript">
     $(document).ready(function(){
      var x=1;
     $("#add_more_row").click(function(){
      $('#addrow'+x).html("<td>"+ (x+1) +"</td><td><input name='criteria[]"+x+"' type='text' placeholder='Criteria' class='form-control input-md' /> </td><td><input name='mdesc[]"+x+"' type='text' placeholder='Description' class='form-control input-md'></td><td><input type='number' min='0' name='spercentage[]"+x+"' placeholder='Percentage' class='percentage'></td><td><select name='mchoice[]' class='form-control'><option selected='selected' disabled=''>-- SELECT --</option><option value='Yes'>Yes</option><option value='No'>No</option></select></td><td><input type='number' min='0' name='smarksrange[]' placeholder='Range' class='form-control'/></td>");

      $('#table_logic').append('<tr id="addrow'+(x+1)+'"></tr>');
      x++; 
	  });
	     $("#delete_this_row").click(function(){
	    	 if(x>1){
			 $("#addrow"+(x-1)).html('');
			 x--;
			 }
		 });

	});
</script>

<script type="text/javascript">
     $(document).ready(function(){
      var i=1;
     $("#add_row").click(function(){
      $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='sname[]"+i+"' type='text' placeholder='Name' class='form-control input-md'  /> </td><td><input  name='sdesc[]"+i+"' type='text' placeholder='Description'  class='form-control input-md'></td><td><input type='number' min='0' name='sweight[]"+i+"' placeholder='Weight' id='sweight' class='sweight'></td><td><select name='schoice[]' class='form-control'><option selected='selected' disabled=''>-- SELECT --</option><option value='Yes'>Yes</option><option value='No'>No (Single Marking)</option></select></td><td><input type='date' name='sdeadline[]' id='sdeadline' placeholder='Deadline' class='form-control'/></td>");

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

<script type="text/javascript">
    $(document).on('change', '.sweight', function() {
        var atotal = 0;
        $('.sweight').each(function(){
            atotal += parseFloat($(this).val());
        });
        if(atotal == 100) {
        	$('#add_row').hide();
        	$('#alertUser').show();
        	$('#weightValue').hide();
        	$('#weightAvaliable').hide();
        	$('.sweight').css("color", "black");
        }
        else if(atotal < 100) {
        	$('#add_row').show();
        	$('#alertUser').hide();
        	$('#weightValue').hide();
        	$('#weightAvaliable').show();
        	$('.sweight').css("color", "red");
        }
        else if(atotal > 100) {
        	$('#add_row').hide();
        	$('#alertUser').hide();
        	$('#weightValue').show();
        	$('#weightAvaliable').hide();
        	$('.sweight').css("color", "red");
        }
    });
</script>

<script type="text/javascript">
    $(document).on('change', '.percentage', function() {
        var ntotal = 0;
        $('.percentage').each(function(){
            ntotal += parseFloat($(this).val());
        });
        if(ntotal == 100) {
        	$('#add_more_row').hide();
        	$('#notifyUser').show();
        	$('#percentageValue').hide();
        	$('#percentageAvaliable').hide();
        	$('.percentage').css("color", "black");
        }
        else if(ntotal < 100) {
        	$('#add_more_row').show();
        	$('#notifyUser').hide();
        	$('#percentageValue').hide();
        	$('#percentageAvaliable').show();
        	$('.percentage').css("color", "red");
        }
        else if(ntotal > 100) {
        	$('#add_more_row').hide();
        	$('#notifyUser').hide();
        	$('#percentageValue').show();
        	$('#percentageAvaliable').hide();
        	$('.percentage').css("color", "red");
        }
    });
</script>

<script type="text/javascript">
	 $(function() {
	    $('#weight_div').hide(); 
	    $('#aweight').change(function(){
	    	var myvar = <?php echo json_encode($totalWeight); ?>;
	    	var ftotal = 100 - myvar;
	        if($('#aweight').val() > ftotal) {
	            $('#weight_div').show(); 
	        } else {
	            $('#weight_div').hide(); 
	        } 
	    });
	});
</script>

<script type="text/javascript">
	$(function() {
	    $('#hidden_div').hide(); 
	    $('#ascheme').change(function(){
	        if($('#ascheme').val() == 'yes') {
	            $('#hidden_div').show(); 
	        } else {
	            $('#hidden_div').hide(); 
	        } 
	    });
	});
</script>

<script type="text/javascript">
	function SetDate()
	{
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();

		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;

		var today = year + "-" + month + "-" + day;
		document.getElementById('adeadline').value = today;
		document.getElementById('sdeadline').value = today;
		var today1 = new Date().toISOString().split('T')[0];
    	document.getElementsByName("adeadline")[0].setAttribute('min', today1);
    	document.getElementsByName("sdeadline[]")[0].setAttribute('min', today1);

	}
</script>

<script type="text/javascript">
	function YNconfirm() { 
	 if (window.confirm('Assessment Saved!'))
	 {
	   window.location.href = '../home/supervisorHome.php';
	 }
	}
</script>

<?php 
	if(isset($_POST['submit'])) {
		$remainingWeight = 100 - $totalWeight;
		$aweight1 = mysqli_real_escape_string($conn, $_REQUEST['aweight']);

		$id = mysqli_insert_id($conn);

		if($aweight1 <= $remainingWeight) {
			$aname1 = mysqli_real_escape_string($conn, $_REQUEST['aname']);
			$adesc = mysqli_real_escape_string($conn, $_REQUEST['description']);
			$anmarkers = mysqli_real_escape_string($conn, $_REQUEST['nmarks']);
			$amscheme = mysqli_real_escape_string($conn, $_REQUEST['ascheme']);
			$adeadline1 = mysqli_real_escape_string($conn, $_REQUEST['adeadline']);

			if(isset($_POST['aname']) && isset($_POST['description']) && isset($_POST['nmarks']) && isset($_POST['ascheme'])) {				
				foreach ($_POST['lecturers'] as $amarkers) {
					if (isset($_POST['sname']) && isset($_POST['sdesc']) && isset($_POST['sweight']) && isset($_POST['schoice']) && isset($_POST['sdeadline'])) {

						$lid = mysqli_insert_id($conn);
						
						foreach ($_POST['sname'] as $key => $value) {
							$asdname = $_POST['sname'][$key];
							$asdesc = $_POST['sdesc'][$key];
							$asweight = $_POST['sweight'][$key];
							$asmarking = $_POST['schoice'][$key];
							$sdeadline1 = $_POST['sdeadline'][$key];

							$query = "INSERT INTO assessment (assessment_code, module_code, name, number_markers, marking_scheme, weighs, description, deadline, markers, sub_assessment, sub_assessment_description, sub_assessment_weight, sub_assessment_marking_scheme, sub_assessment_deadline) VALUES ('" . $id . "', '" . $mcode . "', '" . $aname1 . "', '" . $anmarkers . "', '" . $amscheme . "', '" . $aweight1 . "%', '" . $adesc . "', '" . $adeadline1 . "', '" . $amarkers . "','" . $asdname . "', '" . $asdesc . "', '" . $asweight . "%', '" . $asmarking . "', '" . $sdeadline1 . "')";

							$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
						}

						if(mysqli_query($conn, $query)) {
							$lid = mysqli_insert_id($conn);

							$get = "SELECT assessment1, assessment2, assessment3 FROM module WHERE module_code = '$mcode'";
							$got = mysqli_query($conn, $get) or dir(mysqli_error($conn));

							while($row = mysqli_fetch_array($got)) { 
					        	$a1set = $row['assessment1'];
					        	$a2set = $row['assessment2'];
					        	$a3set = $row['assessment3'];
							}

								if($a1set == "") {
									$sql = "UPDATE module SET assessment1 = '$lid' WHERE module_code = '$mcode'";
									$result1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								}
								else if($a1set != "") {
									$sql = "UPDATE module SET assessment2 = '$lid' WHERE module_code = '$mcode'";
									$result1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								}
								else if($a1set != "" && $a2set != "") {
									$sql = "UPDATE module SET assessment3 = '$lid' WHERE module_code = '$mcode'";
									$result1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								}
							}
						}

						else {
							$query2 = "INSERT INTO assessment (assessment_code, module_code, name, number_markers, marking_scheme, weighs, description, deadline, markers, sub_assessment, sub_assessment_description, sub_assessment_weight, sub_assessment_marking_scheme, sub_assessment_deadline) VALUES ('" . $id . "', '" . $mcode . "', '" . $aname1 . "', '" . $anmarkers . "', '" . $amscheme . "', '" . $aweight1 . "%', '" . $adesc . "', '" . $adeadline1 . "', '" . $amarkers . "', ' ', ' ', ' ', ' ', ' ')";

							if(mysqli_query($conn, $query2)) {
								$lid = mysqli_insert_id($conn);

								$get = "SELECT assessment1, assessment2, assessment3 FROM module WHERE module_code = '$mcode'";
								$got = mysqli_query($conn, $get) or dir(mysqli_error($conn));

								while($row = mysqli_fetch_array($got)) { 
						        	$a1set = $row['assessment1'];
						        	$a2set = $row['assessment2'];
						        	$a3set = $row['assessment3'];
								}

								if($a1set == "") {
									$sql = "UPDATE module SET assessment1 = '$lid' WHERE module_code = '$mcode'";
									$result1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								}
								else if($a1set != "") {
									$sql = "UPDATE module SET assessment2 = '$lid' WHERE module_code = '$mcode'";
									$result1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								}
								else if($a1set != "" && $a2set != "") {
									$sql = "UPDATE module SET assessment3 = '$lid' WHERE module_code = '$mcode'";
									$result1 = mysqli_query($conn, $sql) or die(mysqli_error($conn));
								}
							}
						}
				}
				if (isset($_POST['criteria']) && isset($_POST['mdesc']) && isset($_POST['spercentage']) && isset($_POST['mchoice']) && isset($_POST['smarksrange'])) {
						
					$mid = mysqli_insert_id($conn);

					foreach ($_POST['criteria'] as $key => $value) {
						$mcriteria = $_POST['criteria'][$key];
						$mmdesc = $_POST['mdesc'][$key];
						$spercent = $_POST['spercentage'][$key];
						$mchosen = $_POST['mchoice'][$key];
						$mmarks = $_POST['smarksrange'][$key];

						$mquery = "INSERT INTO marking_scheme (id, module_code, module_name, assessment_code, criteria, description, percentage, range_type, marks_range) VALUES ('". $mid ."', '" . $mcode . "', '" . $mname . "', '" . $lid . "', '" . $mcriteria . "', '" . $mmdesc . "', '" . $spercent . "', '" . $mchosen . "', '" . $mmarks . "')";

						$result = mysqli_query($conn, $mquery) or die(mysqli_error($conn));
					}
				}
			}
		}
		mysqli_close($conn);
		echo '<script type="text/javascript">','YNconfirm();','</script>';
	}
?>