<?php
  if(!isset($_SESSION)) {
    session_start();
  }
  include "db_handler.php";  
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Flat HTML5/CSS3 Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?> /">
    <link rel="stylesheet" href="css/style-mickey.css?<?php echo time(); ?> /">
  </head>
  <body style="background-color:lightblue;">
<br>
<br><br><br><br>
<br>
<br>
  <?php
    if(isset($_POST['submit'])) {

    $username = $_POST['userid'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$pass'";
    $result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

    if (!$row = $result->fetch_assoc()) {
      echo "<div class='login-form'>

          <h2>Incorrect Credentials Entered</h2>
          Username or Password is incorrect.<br><br>
          Click here to <a href='login.php'>Login</a></div>";
    }
  }
  ?>

  <div class="wrapper">
    <section>
      <div class="login-page">
        <div class="form">
          <form method="POST" class="register-form">
            <input type="text" name="email" placeholder="email address"/>
            <button type="submit">Submit</button>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
          </form>
          <form class="login-form" method="POST">
            <input type="text" name="userid" placeholder="username"/>
            <input type="password" name="password" placeholder="password"/>
            <button type="submit" name="submit">Login</button>
          </form>
        </div>
      </div>
    </section>
      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src="../js/index.js"></script>
    </div>
  </body>
</html>

<?php
  if(isset($_POST['submit'])) {

    $username = $_POST['userid'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$pass'";
    $result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

    if (!$row = $result->fetch_assoc()) {
      // ERROR MESSAGE SHOWS AT THE TOP OF THE PAGE
    } else {
      $_SESSION['id'] = $row['username'];

      if($row['rank'] == 'Admin' || $row['rank'] == 'admin' || $row['rank'] == 'Supervisor' || $row['rank'] == 'supervisor' ||$row['rank'] == 'Lecturer' || $row['rank'] == 'lecturer' || $row['rank'] == 'Student' || $row['rank'] == 'student') {

        $_SESSION['rank'] = $row['rank'];

        if(isset($_SESSION['rank'])) {
          if($_SESSION['rank'] == 'Admin' || $row['rank'] == 'admin') {
            header("Location: home/adminHome.php");
          }
          else if($_SESSION['rank'] == 'Lecturer' || $row['rank'] == 'lecturer') {
            header("Location: home/lecturerHome.php");
          }
          else if($_SESSION['rank'] == 'Student' || $row['rank'] == 'student') {
            header("Location: home/studentHome.php");
          }
		  else if($_SESSION['rank'] == 'Supervisor' || $row['rank'] == 'supervisor') {
            header("Location: home/supervisorHome.php");
          }
        }
      }
      else {
        echo "Role not found.";
      }
    }
  }
?>