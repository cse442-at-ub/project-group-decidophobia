<?php
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

if (isset($_GET['selectedTag'])) {
    $selectedTag = $_GET['selectedTag'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM `q_tb` WHERE tag = ? ORDER BY QuestID DESC LIMIT 8";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $selectedTag);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        // Log the SQL error
        error_log("Error in query: " . mysqli_error($conn));
        die('Error in query');
    }

    // Fetch the results into an associative array
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Return the data as JSON
    if (count($questions) === 0) {
        echo json_encode(['message' => 'No matching records found']);
    } else {
        echo json_encode($questions);
    }
} else {
    // Return an error message if 'selectedTag' is not set
    echo json_encode(['error' => 'selectedTag parameter is missing']);
}

mysqli_close($conn);
?>