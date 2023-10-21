<?php
header('content-type:text/html;charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// take username and password
$username = $_POST["user"];
$pwd = $_POST["pwd"];

// connect to database
$dbhost = 'oceanus'; 
$dbuser = 'yuhaolin';        
$dbpass = '50400509';        
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$con) {
    die('fail:( ' . mysqli_error($con));
}

// login page



mysqli_query($con, "set names utf8");
mysqli_select_db($con, 'cse442_2023_fall_team_y_db');

$sql = "SELECT * FROM acc_tb WHERE Username=?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$uni = mysqli_num_rows($result);
if ($uni == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($pwd, $row['Password'])) { 
            header("Location: decide_mainpage.html");
        } else {
            header("Location: React_App.html");
        }
    }
}

$con->close();
?>