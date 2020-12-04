<?php
include "db_handler.php";
?>

<!DOCTYPE html>
<html>
	<?php 
		include "header.php";
		include "lecturer-navbar.php";
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
	<style>
.dropbtn {
  background-color: darkblue;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: grey;}
</style>
</head>
<body style="background-color:lightblue;">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-0">
		
		<?php
				
		$fileList = glob('*.txt');
		foreach($fileList as $filename){
		   echo $filename, '<br>'; 
}
		?>
			<form method="post">
			File name : <input type ="text" name="fname"/>
			<input type ="submit" name ="submit"/>
			</form>
			<?php
			if(isset($_POST['submit']))
			{
			$filename= $_POST['fname'];
			//$filename = "cheat sheet 2.jpg";
			$file= fopen($filename,"r");
			if($file==false)
			{
			echo"error<br>";
			}
			$fsize=filesize($filename);
			$filetxt= fread($file,$fsize);
			echo $filetxt."<br>";
			}
			?>
        </div>
    </div>
</div>
</body>
</html>