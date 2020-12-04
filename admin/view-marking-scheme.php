<!DOCTYPE html>
<html>
    <?php 
        include "../includes/header.php";
        include "../includes/student-navbar.php";
        include "../db_handler.php";
    ?>
    <?php 
        if (isset($_GET['id'])) {
            $acode = mysqli_real_escape_string($conn, $_GET['id']);

            $sql = "SELECT * FROM marking_scheme_marks WHERE assessment_code = '$acode'"; 
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
            while($row = mysqli_fetch_array($result)) { 
                $mc = $row['module_code'];
                $si = $row['student_id'];
                $ac = $row['assessment_code'];
                $nom = $row['marker'];
                $mg = $row['mark_given'];
                $msc = $row['total_marks'];
                $md = $row['feedback'];
            }

            $query = "SELECT name, sub_assessment FROM assessment WHERE assessment_code = '$acode'";

            $res = mysqli_query($conn, $query); // SAVES 'sql' QUERY RESULT
            $test = mysqli_fetch_array($res); // FETCHES THE DATA FROM THAT RESULT

            $acn = $test['name'];
            $acsb = $test['sub_assessment']; // SAVES THE ARRAY AS A STRING

            $get = "SELECT module_name FROM module WHERE module_code = '$mc'";

            $got = mysqli_query($conn, $get);
            $gotten = mysqli_fetch_array($got);

            $mn = $gotten['module_name'];

            $query1 = "SELECT name, surname FROM users WHERE id = '$nom'";

            $res1 = mysqli_query($conn, $query1);
            $testing = mysqli_fetch_array($res1);

            $nomn = $testing['name'];
            $noml = $testing['surname'];

            $query2 = "SELECT name, surname FROM users WHERE id = '$si'";

            $res2 = mysqli_query($conn, $query2);
            $testing1 = mysqli_fetch_array($res2);

            $sidn = $testing1['name'];
            $sidl = $testing1['surname'];
            
        }
    ?>
<head>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />
    <title></title>
</head>
<body  style="background-color:lightblue">
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="container">
                    <h2 class="test">Marking Scheme For <?php echo $mc . " " . $mn . ": " . $acn; if($acsb != " "){echo " - " . $acsb ;}?></h2>
                    <hr>
                <form class="form-horizontal" role="form" method="post">
                    <div class="form-group">
                    <label class="col-lg-3 control-label">Student ID & Name:</label> 
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="student" style="width: 35%;" value="<?php echo $si . " - " . $sidn . " " . $sidl ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Marker ID & Name:</label> 
                        <div class="col-lg-8">
                            <input class="form-control" type="text" name="marker" style="width: 35%;" value="<?php echo $nomn . " " . $noml?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label">Marking Table:</label> 
                        <div class="col-lg-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>Criteria</th>
                                <th>Description</th>
                                <th>Marks Avaliable</th>
                                <th>Mark Given</th>
                            </tr>                   
                                <?php
                                    $sql = "SELECT * FROM marking_scheme WHERE assessment_code = '$acode'"; 
                                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                                    $sql1 = "SELECT * FROM marking_scheme_marks WHERE student_id = '$si' AND assessment_code = '$acode'"; 
                                    $res1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));

                                    $output = '';

                                     while($row = mysqli_fetch_array($result)) {
                                        $output .= '
                                        <tr>
                                            <td>'.$row["criteria"].'</td>
                                            <td>'.$row["description"].'</td>         
                                            <td style="text-align: center;">'.$row["marks_range"].'</td> ';

                                        while($row1 = mysqli_fetch_array($res1)) {
                                            $output .= '
                                                <td style="text-align: center;">'.$row1["mark_given"].'</td>
                                        ';
                                        }

                                        $output .= '</tr>';
                                    }
                                 echo $output;
                                ?>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: center; font-weight: bold; color: red;">Total:</td>
                                <td>
                                    <input type="text" name="totalmarks" placeholder="Total Marks" id="totalmarks" value="<?php echo $msc ?>" readonly style="border-style: groove; border-color: black; text-align: center;">
                                </td>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label">Feedback:</label>
                        <div class="col-lg-8">
                            <textarea class="form-control" onkeyup="textCounter(this,'counter',250);" type="text" id="feedback" name="feedback" rows="5" placeholder="Enter feedback/comments" readonly><?php echo $md ?></textarea>
                        </div>
                    </div>
                <div class="form-group">
                <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                      <input type="reset" class="btn btn-success" value="Finish" id="button2" onclick="goBack()">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<style type="text/css">
    input {
        width: 100%;
        height: 30px;
        resize: none;
        margin: 4px;
    }
    th {
        text-align: center;
    }
    textarea {
        resize: none;
        width: 100%;
        height: 150px;
    }
    #place { 
        text-align: center;
    }
    #button1, #button2 {
        width: auto;
        height: auto;
    }
    #counter {
        padding: 2px;
        border: 1px solid #eee;
        font: 1em 'Trebuchet MS',verdana,sans-serif;
        color: black;
        border: none;
        height: auto;
        width: auto;
    }
</style>

<script type="text/javascript">
    function goBack() {
        window.location.href = '../home/studentHome.php';
    }
</script>