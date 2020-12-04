<!DOCTYPE html>
<html>
  <?php 
    include "../includes/header.php";
    include "../includes/lecturer-navbar.php";
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
<body style="background-color:lightblue">
<div class="container">
    <div class="row">
        
    	<h1>Manage Modules</h1>
    	<hr>
      <div class="alert alert-danger" role="alert" id="alertUser" style="display: none;">
        <strong>IMPORTANT:</strong> Some modules are red as they do not weigh 100%.
      </div>
        <div class="panel panel-primary filterable" style="border-color: #00bdaa;">
            <div class="panel-heading" style="background-color: #00bdaa;">
                <h3 class="panel-title">Modules</h3>
               
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Module Code" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Module Name" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Description" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Weight" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Manage Module" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $output = '';
                        if(isset($_POST["query"]))
                        {
                         $search = mysqli_real_escape_string($conn, $_POST["query"]);
                         $query = "
                          SELECT * FROM module 
                          WHERE module_code LIKE '%".$search."%'
                          OR module_name LIKE '%".$search."%' 
                         ";
                        }
                        else
                        {
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
                        }
                        $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result) > 0)
                        {

                         while($row = mysqli_fetch_array($result))
                         {
                        $module = $row["module_code"];
                            
                        $sql = "SELECT assessment1, assessment2, assessment3 FROM module WHERE module_code = '$module'";

                            $answer = mysqli_query($conn, $sql); // SAVES 'sql' QUERY RESULT
                            $test = mysqli_fetch_array($answer); // FETCHES THE DATA FROM THAT RESULT

                            $a1 = $test['assessment1']; // SAVES THE ARRAY AS A STRING
                            $a2 = $test['assessment2']; // SAVES THE ARRAY AS A STRING
                            $a3 = $test['assessment3']; // SAVES THE ARRAY AS A STRING

                            $get = "SELECT weighs FROM assessment WHERE assessment_code = '$a1'";
                            $recieve = "SELECT weighs FROM assessment WHERE assessment_code = '$a2'";
                            $go = "SELECT weighs FROM assessment WHERE assessment_code = '$a3'";

                            $got = mysqli_query($conn, $get);
                            $recieved = mysqli_query($conn, $recieve);
                            $stay = mysqli_query($conn, $go);

                            $a1weight = 0;
                            $a2weight = 0;
                            $a3weight = 0;
							$int1=0;
							$int2=0;
							$int3=0;

                            $moduleSize = 0;

                            while ($row1 = mysqli_fetch_array($got)) {
                              $a1weight = $row1['weighs'];
							  $int1=(int)$a1weight;
                            }

                            while ($row2 = mysqli_fetch_array($recieved)) {
                              $a2weight = $row2['weighs'];
							  $int2=(int)$a2weight;
                            }

                            while ($row3 = mysqli_fetch_array($stay)) {
                              $a3weight = $row3['weighs'];
							  $int3=(int)$a3weight;
                            }

                            $moduleSize = $moduleSize + $int1 + $int2+ $int3;

                            if($moduleSize < 100) {
                              echo '<body onLoad="informUser()">';

                              $output .= '
                              <tr style="color: red">
                                <td>'.$row["module_code"].'</td>
                                <td>'.$row["module_name"].'</td>
                                <td>'.$row["description"].'</td>
                                <td>'. $moduleSize .'%</td>
                                <td class="text-center">
                                <div class="btn-group">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" role="menu">
                                        <li>
                                          <a href="add-assessment.php?id=' . $module . '">Add Assessment</a>
                                        </li>
                                        <li>
                                          <a href="view-assessments-marking-scheme.php?id=' . $module . '">Create Marking Scheme</a>
                                        </li>
                                        <li>
                                          <a href="assign-students.php?id=' . $module . '">Assign Students To Lecturers</a>
                                        </li>
                                        <li>
                                          <a href="view-marks.php?id=' . $module . '">View Student Marks</a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                 </td>
                             </tr>';
                            }

                            else {
                            $output .= '
                             <tr>
                              <td>'.$row["module_code"].'</td>
                              <td>'.$row["module_name"].'</td>
                              <td>'.$row["description"].'</td>
                              <td>'.$moduleSize.'%</td>
                                <td class="text-center">
                                <div class="btn-group">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" role="menu">
                                        <li>
                                          <a href="add-assessment.php?id=' . $module . '">Add Assessment</a>
                                        </li>
                                        <li>
                                          <a href="view-assessments-marking-scheme.php?id=' . $module . '">Create Marking Scheme</a>
                                        </li>
                                        <li>
                                          <a href="assign-students.php?id=' . $module . '">Assign Students To Lecturers</a>
                                        </li>
                                        <li>
                                          <a href="view-marks.php?id=' . $module . '">View Student Marks</a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                 </td>
                                </tr>
                              </div>
                            ';
                         }
                       }
                      }
                      echo $output;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

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



<?php 
   if(isset($_POST["export"])){
     
      $result = "SELECT * FROM module";
      $row = mysqli_query($conn, $result) or die(mysqli_error($conn));

      $fp = fopen('../spreadsheets/modules.csv', 'w');

      while($val = mysqli_fetch_array($row, MYSQLI_ASSOC)){
          fputcsv($fp, $val);
      }
      fclose($fp); 
    }  
?>