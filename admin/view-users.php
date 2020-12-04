<?php
include "../db_handler.php"; 
 
$message = "";
 
$users = '<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>name</th>
    <th>surname</th>
    <th>email</th>
    <th>username</th>
    <th>password</th>
    <th>rank</th>
    <th>level</th>
    <th>supervisor</th>
    <th>second_supervisor</th>
    <th>modules</th>
</tr>
';

$query = "SELECT * FROM users";
if (!$result = mysqli_query($conn, $query)) {
    exit(mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    $number = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $users .= '<tr>
            <td>' . $number . '</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['surname'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['username'] . '</td>
            <td>' . $row['password'] . '</td>
            <td>' . $row['rank'] . '</td>
        </tr>';
        $number++;
    }
} else {
    $users .= '<tr>
        <td colspan="4">Records not found!</td>
        </tr>';
}
$users .= '</table>';
?>

<!DOCTYPE html>
<html>
	<?php 
		include "../includes/header.php";
		include "../includes/admin-navbar.php";
	?>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/css/bootstrap-slider.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.7.2/bootstrap-slider.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <title></title>
</head>
<body  style="background-color:lightblue">
<div class="container">
    <div class="row">
        <form class="form-horizontal" style="float: right;" action="view-users.php" method="post" name="export" enctype="multipart/form-data">
          <div class="form-group">
            
          </div>                    
        </form> <br><br> <br><br>
    	<h1>List Of Users</h1>
    	<hr>
            <div class="row">
        
    </div>
        <div class="panel panel-primary filterable" style="border-color: #00bdaa;">
            <div class="panel-heading" style="background-color: #00bdaa;">
                <h3 class="panel-title">Users</h3>
                
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="First Name" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Surname" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Email" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Username" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Rank" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Edit/Delete User" disabled></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                         ";
                        }
                        else
                        {
                         $query = "SELECT * FROM users ORDER BY name asc";
                        }
                            $result = mysqli_query($conn, $query);
                        if(mysqli_num_rows($result) > 0)
                        {

                         while($row = mysqli_fetch_array($result))
                         {
                        $username = $row["username"];
                            
                          $output .= '
                           <tr>
                            <td>'.$row["name"].'</td>
                            <td>'.$row["surname"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["username"].'</td>
                            <td>'.$row["rank"].'</td>

                          <td class="text-center">
                          <a class="btn-edit btn btn-info btn-xs" href="edit-user.php?id=' . $username . '">
                          <span class=" glyphicon glyphicon-edit"></span> Edit</a>
                           <a href="remove-user.php?id=' . $username . '"class="btn-remove btn btn-danger btn-xs">
                           <span class="glyphicon glyphicon-remove"></span>Delete</a></td>
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



