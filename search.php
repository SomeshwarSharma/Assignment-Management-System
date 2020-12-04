<?php
  $conn = mysqli_connect('localhost', 'root', '', 'project');

  if (!$conn) {
    die("Connection failed: ".mysqli_connect_err());
  }

  $output = '';
  if(isset($_POST["query"]))
  {
   $search = mysqli_real_escape_string($conn, $_POST["query"]);
   $query = "
    SELECT * FROM users 
    WHERE Name LIKE '%".$search."%'
    OR Surname LIKE '%".$search."%' 
    OR Email LIKE '%".$search."%' 
    OR Username LIKE '%".$search."%'
    OR Rank LIKE '%".$search."%' 
   ";
  }
  else
  {
   $query = "
    SELECT * FROM users ORDER BY Name asc
   ";
  }
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0)
  {
   $output .= '
   <div class=""wrapper>
     <div class="col-md-10 custyle">
      <table class="table table-striped custab">
      <thead>
          <tr>
              <th>First name</th>
              <th>Last name</th>
              <th>Email address</th>
              <th>Username</th>
              <th>Rank</th>
              <th class="text-center">Action</th>
          </tr>
      </thead>
   ';
   while($row = mysqli_fetch_array($result))
   {
    $output .= '
     <tr>
      <td>'.$row["Name"].'</td>
      <td>'.$row["Surname"].'</td>
      <td>'.$row["Email"].'</td>
      <td>'.$row["Username"].'</td>
      <td>'.$row["Rank"].'</td>

    <td class="text-center">
    <a class="btn-edit btn btn-info btn-xs" href="#">
    <span class=" glyphicon glyphicon-edit "></span> Edit</a>
     <a href="#" class="btn-remove btn btn-danger btn-xs">
     <span class="glyphicon glyphicon-remove"></span> Del</a></td>

     </tr>
  </div>
    ';
   }
   echo $output;
  }
?>