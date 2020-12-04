<?php
require_once('config.php');

$conn = mysqli_connect(db_host, db_username, db_password, db_name);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
