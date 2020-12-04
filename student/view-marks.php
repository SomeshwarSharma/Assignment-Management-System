<!DOCTYPE html>
<html>
  <?php 
    include "../includes/header.php";
    include "../includes/student-navbar.php";
    include "../db_handler.php";
  ?>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <title></title>
</head>
<body  style="background-color:lightblue">
<div class="container">
    <div class="row">
    	<h3>Marks and Feedback</h3>
            <div class="panel panel-primary filterable" style="border-color: #00bdaa;">
            <div class="panel-heading" style="background-color: #00bdaa;">
                <h3 class="panel-title">Marks:</h3>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th>Module Code</th>
                        <th>Module Name</th>
                        <th>Assessment Name</th>
                        <th>Mark</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                	<?php  				
						$user = $_SESSION['id'];
						$query = "SELECT id FROM users WHERE username = '$user'";
						
						$res = mysqli_query($conn, $query); // SAVES 'sql' QUERY RESULT
						$test = mysqli_fetch_array($res); // FETCHES THE DATA FROM THAT RESULT

						$sid = $test['id']; // SAVES THE ARRAY AS A STRING

						$sql = "SELECT module_code, sub_assessment, final_mark, feedback FROM marks WHERE student_id = '$sid'"; 
						$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

						$check = mysqli_query($conn, $sql); // SAVES 'sql' QUERY RESULT
						$acheck = mysqli_fetch_array($check); // FETCHES THE DATA FROM THAT 

						$mcode = $acheck['module_code'];

						$state = "SELECT module_name FROM module WHERE module_code = '$mcode'";
						$aresult = mysqli_query($conn, $state);

						$acode = $acheck['sub_assessment'];

						$astate = "SELECT sub_assessment FROM assessment WHERE sub_assessment = '$acode'";
						$bresult = mysqli_query($conn, $astate);

						$output = '';				
				        while($row = mysqli_fetch_array($result)) {                               
	                    	$output .= '
	                    	<tr>
	                        	<td>'.$row["module_code"].'</td>	                    
	                          ';

	  	                    while($arow = mysqli_fetch_array($aresult)) {                               
		                    	$output .= '
		                            <td>'.$arow["module_name"].'</td>
		                          ';
		                    }

		                    $state = "SELECT module_name FROM module WHERE module_code = '$mcode'";
							$aresult = mysqli_query($conn, $state);

							$acode = $acheck['sub_assessment'];

							$astate = "SELECT sub_assessment FROM assessment WHERE sub_assessment = '$acode'";
							$bresult = mysqli_query($conn, $astate);

		                    $output .= '
		                    	<td>'.$row["sub_assessment"].'</td>
		                    	<td>'.$row["final_mark"].'</td>
		                    	<td>'.$row["feedback"].'</td>
		                    </tr>
		                    ';
	                    }

	                    $sql1 = "SELECT DISTINCT module_code, assessment_code, total_marks, feedback FROM marking_scheme_marks WHERE student_id = '$sid'";
						$result1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));

						$get = mysqli_query($conn, $sql1); // SAVES 'sql' QUERY RESULT
						$got = mysqli_fetch_array($get); // FETCHES THE DATA FROM THAT 

						$mcode = $got['module_code'];
						$acode = $got['assessment_code'];

						$sql2 = "SELECT module_name FROM module WHERE module_code = '$mcode'";
						$result2 = mysqli_query($conn, $sql2);

						$sql3 = "SELECT name FROM assessment WHERE assessment_code = '$acode'";
						$result3 = mysqli_query($conn, $sql3);

	                    while($row1 = mysqli_fetch_array($result1)) {                               
	                    	$output .= '
	                    	<tr>
	                        	<td>'.$row1["module_code"].'</td>';

	                        	while($arow = mysqli_fetch_array($result2)) {
			                    	$output .= '
			                            <td>'.$arow["module_name"].'</td>
			                          ';
			                    }

			                    while($arow1 = mysqli_fetch_array($result3)) {
			                    	$output .= '
			                            <td>'.$arow1["name"].'</td>
			                          ';
			                    }

	                        	$output .='	                    
		                    	<td>'.$row1["total_marks"].'</td>
		                    	<td>
                                	
                             	</td>
	                    	</tr>
		                    ';
	                    }
	                    echo $output;
                    ?>
                    </tbody>
                </table>
            </div>
		</div>
	</body>
	</div>
</html>
<style type="text/css">
    .filterable {
    margin-top: 15px;
    }
    .filterable .panel-heading .pull-right {
        margin-top: -20px;
    }
    .filterable .filters input[disabled] {
        background-color: transparent;
        border: none;
        cursor: auto;
        box-shadow: none;
        padding: 0;
        height: auto;
    }
    .filterable .filters input[disabled]::-webkit-input-placeholder {
        color: #333;
    }
    .filterable .filters input[disabled]::-moz-placeholder {
        color: #333;
    }
    .filterable .filters input[disabled]:-ms-input-placeholder {
        color: #333;
    }
</style>

<script type="text/javascript">
  function informUser() {
    $('#alertUser').show();
  }
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.filterable .btn-filter').click(function(){
            var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody');
            if ($filters.prop('disabled') == true) {
                $filters.prop('disabled', false);
                $filters.first().focus();
            } else {
                $filters.val('').prop('disabled', true);
                $tbody.find('.no-result').remove();
                $tbody.find('tr').show();
            }
        });

        $('.filterable .filters input').keyup(function(e){
            var code = e.keyCode || e.which;
            if (code == '9') return;

            var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');

            var $filteredRows = $rows.filter(function(){
                var value = $(this).find('td').eq(column).text().toLowerCase();
                return value.indexOf(inputContent) === -1;
            });

            $table.find('tbody .no-result').remove();
            
            $rows.show();
            $filteredRows.hide();
            if ($filteredRows.length === $rows.length) {
                $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
            }
        });
    });
</script>