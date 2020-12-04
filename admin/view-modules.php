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
                           
        </form> 
    	<h1>List Of Modules</h1>
    	<hr>
      
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
                        <th><input type="text" class="form-control" placeholder="Module Leader" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Description" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Weight" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Mark Student" disabled></th>
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
                          OR module_leader LIKE '%".$search."%' 
                         ";
                        }
                        else
                        {
                         $query = "
                          SELECT DISTINCT module_code, module_name, module_leader, description, assessment1, assessment2, assessment3 FROM module
                         ";
                        }
                        $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result) > 0) {

                         while($row = mysqli_fetch_array($result))
                         {
                        $mcode = $row["module_code"];
                            
                        $sql = "SELECT assessment1, assessment2, assessment3 FROM module WHERE module_code = '$mcode'";

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

                            

                            else {
                            $output .= '
                             <tr>
                              <td>'.$row["module_code"].'</td>
                              <td>'.$row["module_name"].'</td> ';

                              $lid = $row['module_leader'];
                              $query1 = "SELECT name, surname FROM users WHERE id = '$lid'";
                              $result1 = mysqli_query($conn, $query1);

                              while ($row4 = mysqli_fetch_array($result1)) {
                                $output .= '<td>'.$row4["name"]." ".$row4["surname"].'</td>';
                              }

                              $output .= '
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