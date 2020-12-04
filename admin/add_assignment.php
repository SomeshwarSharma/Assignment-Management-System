<?php
include "../db_handler.php";

// fetch files
?>
<?php
//check if form is submitted
if (isset($_POST['submit']))
{
    $filename = $_FILES['file1']['name'];
    $aid= $_POST['aid'];
    $aname= $_POST['aname'];
    $adiscription= $_POST['adiscription'];
    $enddate= $_POST['enddate'];
    
    

    //upload file
    if($filename != '')
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg',  'gif'];
    
        //check if file type is valid
        if (in_array($ext, $allowed))
        {
            // get last record id
            $sql = 'select max(aid) as aid from assignment';
            $result = mysqli_query($con, $sql);
            if (count($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                $filename = ($row['aid']+1) . '-' . $filename;
            }
            else
                $filename = '1' . '-' . $filename;

            //set target directory
            $path = 'uploads/';
                
            $created = @date('Y-m-d');
            move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
            
            // insert file details into database
            $sql = "INSERT INTO assignment(aid,aname,created,enddate,adiscription,filename) VALUES('$aid','$aname','$created','$enddate','$adiscription','$filename' )";
            mysqli_query($con, $sql);
            header("Location: add_assignment.php?st=success");
        }
        else
        {
            header("Location: add_assignment.php?st=error");
        }
    }
    else
        header("Location: add_assignment.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
</head>
<body>
<br/>
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 well">
        <form method="post" enctype="multipart/form-data">
        <div class="form-group">
		  <label class="col-lg-3 control-label">Assignment ID:</label>
		<div class="col-lg-8">
		 <input class="form-control" type="text" id="aid" name="aid" value="<?php if (isset($_GET['aid'])) { print $aid; }?>" >
			 </div>
		   </div>
          <div class="form-group">
				<label class="col-md-3 control-label" for="aname">Assignment Name:</label>
				    <div class="col-md-8">
	                  <input class="form-control" type="text" id="aname" name="aname">
                    </div>			
                  </div>
                  <div class="form-group">
                  
                              <div class="form-group">
					 <label class="col-lg-3 control-label">Assessment lastdate</label>
				    <div class="col-lg-8">
			      <input class="form-control" type="date" id="enddate" name="enddate" required>
				    </div>
                              </div>
                       
                              <div class="form-group">
					            <label class="col-lg-3 control-label">Assessment Description:</label>
					            <div class="col-lg-8">
					              <textarea class="form-control" onkeyup="textCounter(this,'counter',250);" type="text" id="adiscription" name="adiscription" rows="5" required></textarea>
					              <input disabled maxlength="3" size="3" value="250" id="counter">
						      		<small>Characters remaining.</small>
						      		<script>
										function textCounter(field,field2,maxlimit)
										{
										 	var countfield = document.getElementById(field2);
										 	if ( field.value.length > maxlimit ) {
										  		field.value = field.value.substring( 0, maxlimit );
										  		return false;
										 	} else {
										  		countfield.value = maxlimit - field.value.length;
										 	}
										}
							  		</script>
				            	</div>
					          </div>

            <legend>Select File to Upload:</legend>
            <div class="form-group">
                <input type="file" name="file1" />
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Upload" class="btn btn-info"/>
            </div>
            <?php if(isset($_GET['st'])) { ?>
                <div class="alert alert-danger text-center">
                <?php if ($_GET['st'] == 'success') {
                        echo "File Uploaded Successfully!";
                    }
                    else
                    {
                        echo 'Invalid File Extension!';
                    } ?>
                </div>
            <?php } ?>
        </form>
        </div>
    </div>

</div>
<script type="text/javascript">
	function SetDate()
	{
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();

		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;

		var today = year + "-" + month + "-" + day;
		document.getElementById('enddate').value = today;
		document.getElementById('enddate').value = today;
		var today1 = new Date().toISOString().split('T')[0];
    	document.getElementsByName("enddate")[0].setAttribute('min', today1);
    	document.getElementsByName("enddate[]")[0].setAttribute('min', today1);

	}
</script>
</body>
</html>