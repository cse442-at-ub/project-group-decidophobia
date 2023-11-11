
<?php

function getQuestion($post_id) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Connect to the database
    $dbhost = 'oceanus'; 
    $dbuser = 'yuhaolin';        
    $dbpass = '50400509';        
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

    // Check the connection
    if (!$conn) {
        die('Could not connect: ' . mysqli_error());
    }

    mysqli_query($conn, "set names utf8");
    mysqli_select_db($conn, 'cse442_2023_fall_team_y_db');
    $sql = "SELECT * FROM `q_tb` WHERE QuestID=$post_id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error in the query: ' . mysqli_error($conn));
    }

    $question = mysqli_fetch_assoc($result);

    if (!$question) {
        // No results found for the given post_id
        echo 'Question not found.';
        return;
    }
    if ($question) {
      // Now you can use $question outside the function
      echo '<div>';
      echo '<h1 class="question">' . $question["Question"] . '</h1>';
      echo '</div>';
  
      echo '<div class="answer">';
      echo '<form method="post">';
      echo '<input type="submit" name="an1" class="answer-s" value="' . htmlspecialchars($question["an1"]) . '" />';
      echo '<br>';
      echo '<input type="submit" name="an2" class="answer-s" value="' . htmlspecialchars($question["an2"]) . '" />';
      echo '<br>';
      echo '<input type="submit" name="an3" class="answer-s" value="' . htmlspecialchars($question["an3"]) . '" />';
      echo '<br>';
      echo '<input type="submit" name="an4" class="answer-s" value="' . htmlspecialchars($question["an4"]) . '" />';
      echo '<br>';
      echo '<input type="submit" name="an5" class="answer-s" value="' . htmlspecialchars($question["an5"]) . '" />';
      echo '</form>';
      echo '</div>';
  }
    // Handle the answers
    if (isset($_POST['an1'])) {
        an1($conn, $question);
    } elseif (isset($_POST['an2'])) {
        an2($conn, $question);
    } elseif (isset($_POST['an3'])) {
        an3($conn, $question);
    } elseif (isset($_POST['an4'])) {
        an4($conn, $question);
    } elseif (isset($_POST['an5'])) {
        an5($conn, $question);
    }
}

function an1($conn, $question) {
  $newVote = $question['vote1'] + 1;
  $sql = "UPDATE `q_tb` SET vote1 = $newVote WHERE QuestID = " . $question['QuestID'];
  mysqli_query($conn, $sql);
}

function an2($conn, $question) {
  $newVote = $question['vote2'] + 1;
  $sql = "UPDATE `q_tb` SET vote2=$newVote WHERE QuestID=" . $question['QuestID'];
  mysqli_query($conn, $sql);
}
function an3($conn, $question) {
  $newVote = $question['vote3'] + 1;
  $sql = "UPDATE `q_tb` SET vote3=$newVote WHERE QuestID=" . $question['QuestID'];
  mysqli_query($conn, $sql);
}
function an4($conn, $question) {
  $newVote = $question['vote4'] + 1;
  $sql = "UPDATE `q_tb` SET vote4=$newVote WHERE QuestID=" . $question['QuestID'];
  mysqli_query($conn, $sql);
}
function an5($conn, $question) {
  $newVote = $question['vote5'] + 1;
  $sql = "UPDATE `q_tb` SET vote5$newVote WHERE QuestID=" . $question['QuestID'];
  mysqli_query($conn, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <nav class="navbar">
      <ul>
        <a href="#">Help We decide</a>

      </ul>
    </nav>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
  </head>
<body>

<?php
$post_id = 12;
getQuestion($post_id);
?>

<script src="src/index.jsx"></script>
</body>
</html>
  