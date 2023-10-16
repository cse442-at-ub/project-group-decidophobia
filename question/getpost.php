
<?php

# use for main page, later
#function getAllQuestions()
#{
   #     global $conn;
    #    $sql = "SELECT * FROM `q_tb`"; 
     #   $result = mysqli_query($conn, $sql); # take all posts in database
      #  $AllQuestions = mysqli_fetch_all($result); # put to $allPosts array
       # return $AllQuestions;#returns all posts in database
#}

# function would be called when user click on a certain post
function getQuestion($post_id){
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  //connect to database
  $dbhost = 'oceanus'; 
  $dbuser = 'yuhaolin';        
  $dbpass = '50400509';        
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
  // Check the connection
  if (!$conn) {
      die('Could not connect: ' . mysqli_error());
  }
    mysqli_query($conn , "set names utf8");
    mysqli_select_db( $conn, 'cse442_2023_fall_team_y_db' );
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

    echo '<div>';
    echo '  <h1 class="question">' . $question["Question"] . '</h1>';
    echo '</div>';

    echo '<div class="answer">';
    echo '  <p class="answer-s">' . $question["an1"] . '</p>';
    echo '  <p class="answer-s">' . $question["an2"] . '</p>';
    echo '  <p class="answer-s">' . $question["an3"] . '</p>';
    echo '  <p class="answer-s">' . $question["an4"] . '</p>';
    echo '  <p class="answer-s">' . $question["an5"] . '</p>';
    echo '</div>';
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
 