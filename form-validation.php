<?php 
  $name_error = $email_error = $choice_error = "";
  $name = $email = $message = $success = $choice = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $name_error = "Name is required";
    } else {
      $name = test_input($_POST["name"]);

      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $name_error = "Only letters and white space allowed"; 
      }
    }

    if (empty($_POST["email"])) {
      $email_error = "Email is required";
    } else {
      $email = test_input($_POST["email"]);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format"; 
      }
    }

    $errors = array($name_error, $email_error); 
      if (isset($_POST['Submit'])) {
         if(!$errors){
            header("view-users.php");
         }
         else {
            echo "Unable to process form. Please try again";
         }
      }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  }
?>