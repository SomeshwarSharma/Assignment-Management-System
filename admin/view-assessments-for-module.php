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
    	<h1>List Of Assessments For 
        <?php 
            $module = mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "SELECT * FROM module WHERE module_code = '$module'"; 
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
          
                while($row = mysqli_fetch_array($result)) { 
                  $mcode = $row['module_code'];
                  $mname = $row['module_name'];
            }

            echo $mcode . " - " . $mname; 
        ?> 
      </h1>
    	<hr>
      <div class="alert alert-warning" role="alert">
        <strong>ALERT: </strong> To mark a student with a marking scheme for the selected module, select the assessment you wish to mark first.
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
                        <th><input type="text" class="form-control" placeholder="Assessment Name" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Description" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Deadline" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Sub Assessment" disabled></th>
                        <th><input type="text" class="form-control" placeholder="SA Weight" disabled></th>
                        <th><input type="text" class="form-control" placeholder="SA Deadline" disabled></th>
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
                          SELECT * FROM assessment 
                          WHERE name LIKE '%".$search."%'
                          OR description LIKE '%".$search."%' 
                          OR sub_assessment LIKE '%".$search."%' 
                         ";
                        }
                        else
                        {

                          $mcode = mysqli_real_escape_string($conn, $_GET['id']);
                          $sql = "SELECT * FROM assessment WHERE module_code = '$mcode'"; 

                          $res = mysqli_query($conn, $sql);

                        }

                        while($row = mysqli_fetch_array($res)) {
                          $assessment = $row["assessment_code"];
                              
                            $output .= '
                             <tr>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["description"].'</td>
                              <td>'.$row["deadline"].'</td>
                              <td>'.$row["sub_assessment"].'</td>
                              <td>'.$row["sub_assessment_weight"].'</td>
                              <td>'.$row["sub_assessment_deadline"].'</td>

                                <td class="text-center">
                                  <button type="button" class="btn btn-success"><a href="marking-scheme-form.php?id=' . $assessment . '">Mark Student</a></button>
                                </td>
                              </tr>
                              </div>
                            ';
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
    button {
      margin-left: -80px;
    }
    a {
      color: white;
    }
</style>

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