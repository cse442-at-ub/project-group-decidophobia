<?php
// Allow requests from any origin
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$dbhost = 'oceanus';
$dbuser = 'yuhaolin';
$dbpass = '50400509';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if (!$conn) {
    die('fail: ' . mysqli_error($conn));
}

mysqli_query($conn, "set names utf8");
mysqli_select_db($conn, 'cse442_2023_fall_team_y_db');

// Fetch data from the q_tb table
$query = "SELECT * FROM `q_tb` ORDER BY QuestID DESC LIMIT 8";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($conn));
}

// Fetch the results into an associative array
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);

// Return the data as JSON
echo json_encode($questions);
?>
