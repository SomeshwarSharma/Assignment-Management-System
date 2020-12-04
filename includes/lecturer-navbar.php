<!-- FIX LOGOUT - SESSION DOESNT STOP RUNNING -->

<?php session_start(); ?>

  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img src="../ams.png" alt="ams" name="ams" style="width: 200px; height: 75px; margin-top: -10px; float: left; margin-left: -10px;">
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php
            // Define each name associated with an URL
            $urls = array(
                'Home' => '../home/lecturerHome.php', 
                'Logout' => '../logout.php',
            );

            foreach ($urls as $name => $url) {
                echo '<li> <a href="'.$url.'">'.$name.'</a></li>';
            }
        ?>
</ul>

<ul class="nav navbar-nav navbar-right">
    
        <?php
        if(isset($_SESSION['id'])) {
          echo '<li><a href="#">Welcome, '. $_SESSION["id"] . '</a></li>';
          echo '<li><a href="../logout.php">Log Out</a></li>';
        } else {
            echo '<li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
        }
        ?>
    </div>
  </div>
</nav>

<style type="text/css">
    .navbar-inverse .navbar-nav>li>a {
        color: #9d9d9d;
        border: none!important;
        font-size: 12px;
        text-transform: uppercase;
        color: #ececec;
        font-family: "Raleway","Helvetica Neue","Helvetica","Roboto","Arial",sans-serif;
        font-feature-settings: "lnum";
        font-variant-numeric: lining-nums;
    }

    div {
        display: block;
    }

    .navbar-inverse {
        background-color: #363636;
        border-color: #080808;
        height: 75px;
    }

    .container-fluid {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
        margin-top: 10px;
    }

    #container1 {
      margin-top: -65px;
      margin-bottom: 50px;
      margin-left: 255px
    }

    .nav ul {
        list-style: none;
        background-color: black;
        text-align: center;
        padding: 0;
        margin: auto;
        z-index: 1000;
        align-items: center;
    }

    ul, menu, dir {
        display: block;
        list-style-type: disc;
        -webkit-margin-before: 1em;
        -webkit-margin-after: 1em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
        -webkit-padding-start: 40px;
    }

    .nav ul {
      list-style: none;
      background-color: #99CCCC;
      text-align: center;
      padding: 0;
      margin: auto;
      z-index: 1000;
      background-color: #363636;
      }

    .nav li {
      font-family: 'Gabriola', sans-serif;
      font-size: 1.2em;
      line-height: 40px;
      text-align: left;
      background-color: #363636;
      }

    .nav a {
      text-decoration: none;
      color: #FFFFFF;
      display: block;
      padding-left: 15px;
      border-bottom: 1px solid #888;
      transition: .3s background-color;
      }

    .nav a:hover {
      background-color: #005f5f;
    }

    .nav a:active {
      background-color: #aaa;
      color: #444;
      cursor: default;
    }    
</style>