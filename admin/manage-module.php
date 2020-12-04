<!DOCTYPE html>
<html>
  <?php 
    include "../includes/header.php";
    include "../includes/admin-navbar.php";
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
        <form class="form-horizontal" style="float: right;" action="view-modules.php" method="post" name="export" enctype="multipart/form-data">
          <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
              <input type="submit" name="export" class="btn btn-success" value="Export As CSV File"/>
            </div>
          </div>                    
        </form> 
    	<h1>Manage Modules</h1>
    	<hr>
      <div class="alert alert-danger" role="alert" id="alertUser" style="display: none;">
        <strong>IMPORTANT:</strong> Some modules are red as they do not weigh 100%.
      </div>
        <div class="panel panel-primary filterable" style="border-color: #00bdaa;">
            <div class="panel-heading" style="background-color: #00bdaa;">
                <h3 class="panel-title">Modules</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter Search</button>
                </div>
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

                            $a1weight = "";
                            $a2weight = "";
                            $a3weight = "";

                            $moduleSize = 0;

                            while ($row1 = mysqli_fetch_array($got)) {
                              $a1weight = $row1['weighs'];
                            }

                            while ($row2 = mysqli_fetch_array($recieved)) {
                              $a2weight = $row2['weighs'];
                            }

                            while ($row3 = mysqli_fetch_array($stay)) {
                              $a3weight = $row3['weighs'];
                            }

                            $moduleSize = $moduleSize + $a1weight + $a2weight + $a3weight;

                            if($moduleSize < 100) {
                              echo '<body onLoad="informUser()">';

                              $output .= '
                              <tr style="color: red">
                                <td>'.$row["module_code"].'</td>
                                <td>'.$row["module_name"].'</td>
                                <td>'.$row["description"].'</td>
                                <td>'. $moduleSize .'%</td>
                             </tr>';
                            }

                            else {
                            $output .= '
                             <tr>
                              <td>'.$row["module_code"].'</td>
                              <td>'.$row["module_name"].'</td>
                              <td>'.$row["description"].'</td>
                              <td>'.$moduleSize.'%</td>
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