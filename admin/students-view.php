<!-- CREATE 'ENTER COURSEWORK MARK' AND 'ENTER EXAM MARK' FORMS -->
<!-- 'ENTER COURSEWORK MARK' AND 'ENTER EXAM MARK' NEED TO ASK WHICH MODULE ITS FOR -->
<!-- MAKE REMOVE STUDENT A POP UP INSTEAD OF A FORM IF POSSIBLE -->

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
      <h1>Assigned Students</h1>
      <hr>      
        <div class="panel panel-primary filterable" style="border-color: #00bdaa;">
            <div class="panel-heading" style="background-color: #00bdaa;">
                <h3 class="panel-title">Students</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter Search</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Student ID" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Full Name" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Email" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Supervisor" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Second Supervisor" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Student Management" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM users"; 
                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                      
                        $output = '';
                        if(isset($_POST["query"]))
                        {
                         $search = mysqli_real_escape_string($conn, $_POST["query"]);
                         $query = "
                          SELECT * FROM users 
                          WHERE name LIKE '%".$search."%'
                          OR surname LIKE '%".$search."%' 
                          OR email LIKE '%".$search."%' 
                          OR username LIKE '%".$search."%' 
                          OR supervisor LIKE '%".$search."%' 
                          OR second supervisor LIKE '%".$search."%' 
                         ";
                        }
                        else
                        {

                          $query = "SELECT * FROM users WHERE rank='student' ORDER BY name asc";
                        }

                        $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result) > 0)
                        {

                         while($row = mysqli_fetch_array($result))
                         {
                        $username = $row["username"];
                            
                          $output .= '
                           <tr>
                            <td>'.$row["id"].'</td>
                            <td>'.$row["name"]. ' ' .$row["surname"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["supervisor"].'</td>
                            <td>'.$row["second_supervisor"].'</td>

                          <td class="text-center">
                          <div class="btn-group">
                              <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span>
                                </button>
                                
                                <ul class="dropdown-menu" role="menu">
                                  <li>
                                    <a href="add-mark.php?id=' . $username . '">Add Mark</a>
                                  </li>
                                  <li>
                                    <a href="#">Add To Module</a>
                                  </li>
                                  <li>
                                    <a href="#">Add Coursework Mark</a>
                                  </li>
                                  <li>
                                    <a href="#">Add Exam Mark</a>
                                  </li>
                                  <li>
                                    <a href="assign-supervisor.php?id=' . $username . '">Assign Supervisor</a>
                                  </li>
                                  <li>
                                    <a href="edit-student.php?id=' . $username . '">Edit Student Details</a>
                                  </li>
                                  <li>
                                    <a href="remove-student.php?id=' . $username . '">Remove Student</a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </td>
                           </tr>
                        </div>
                          ';
                         }
                         echo $output;
                        }
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