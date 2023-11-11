
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
      echo '<div class="bubble">';
      echo '</div>';
      echo '<div class="qt">';
      echo '<h1 class="question">' . $question["Question"] . '</h1>';
      echo '</div>';
  
      echo '<div class="answer">';
      echo '<form method="post">';
      echo '<input type="submit" name="an1" class="answer-s" value="' . htmlspecialchars($question["an1"]) . '" />';
      echo '<br>';
      echo '<br>';
      echo '<input type="submit" name="an2" class="answer-s" value="' . htmlspecialchars($question["an2"]) . '" />';
      echo '<br>';
      echo '<br>';
      echo '<input type="submit" name="an3" class="answer-s" value="' . htmlspecialchars($question["an3"]) . '" />';
      echo '<br>';
      echo '<br>';
      echo '<input type="submit" name="an4" class="answer-s" value="' . htmlspecialchars($question["an4"]) . '" />';
      echo '<br>';
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

<?php
session_start();
 
//读取服务器端的session_id，如果没有的话赋值为-1
$session_id = empty($_SESSION['session_id']) ? -1 : $_SESSION['session_id'];
 
//读取客户端的post_id,如果没有的话赋值为-2
$post_id = empty($_POST['post_id']) ? -2 : $_POST['post_id'];
 
//判断两个id是否相同，相同则说明已经处理过一次，不同则进行处理
if($session_id == $post_id){
    
    //echo "<script>alert('已经处理过了，不管了');</script>'";
    
}else{
    
    //如果页面还没有提交过表单，则显示表单，否则处理post过来的数据
    if($post_id == -2){        
?>

<input type="text" hidden="hidden" name="post_id" id="" value="<?php echo rand(1, 999999); ?>" >

<?php

}else{
        
  //echo "<script>alert('正在处理');</script>'";
  
  //处理过后吧post_id存入session，方便下次比较
  $_SESSION['session_id'] = $post_id;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dbhost = 'oceanus'; 
    $dbuser = 'jiehanke';          
    $dbpass = '50358791';       
  
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
        die('fail of connection: ' . mysqli_error($conn));
    }
  
    mysqli_query($conn , "set names utf8");
    mysqli_select_db( $conn, 'cse442_2023_fall_team_y_db' );
  
    $datetime = date_create()->format('Y-m-d H:i:s');
  
    $getid = mysqli_query($conn,"SELECT MAX(`C_id`) as C_id FROM `q_c_tb`");
    $id = mysqli_fetch_assoc($getid);
  
    $next_id = $id['C_id'] + 1;
  
    $comment = $_POST['comm'];
    $sql = "INSERT INTO `q_c_tb`(`QuestID`, `Content`, `SystemID`, `Creator`, `Time`, `C_id`) 
                         VALUES (12,'$comment',-1,'test_name','$datetime',$next_id)";
  
    if (mysqli_query($conn, $sql)) {
      echo '<script>alert("Comment posted successfully.");</script>';
    } else {
      echo '<script>alert("Error: ' . $sql . '\n' . mysqli_error($conn) . '");</script>';
    }
  
    $conn->close();
  
  }
  
}

}

?>

<div class='c'>
<div class='comment-container'>
<div class="comment">
<form action="getpost2.php" method="post" enctype="multipart/form-data" class="form1">
<input type="text" name="comm" placeholder="enter your comment here"  required>
<input type="text" hidden="hidden" name="post_id" id="" value="<?php echo rand(1, 999999); ?>" >

<input type="submit" value="Post Your comment">
</form>
</div>
</div>

<?php
$dbhost = 'oceanus'; 
$dbuser = 'jiehanke';          
$dbpass = '50358791';       

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('fail of connection: ' . mysqli_error($conn));
}

mysqli_query($conn , "set names utf8");
mysqli_select_db( $conn, 'cse442_2023_fall_team_y_db' );

$SQL_qc = "SELECT * FROM `q_c_tb` WHERE `QuestID` = 12";
$qc = $conn->query($SQL_qc);

while($row = mysqli_fetch_assoc($qc))
{
  echo "<div class='comment-container'>";
  echo '<div class="comment">';
  echo '<div class="comment-header">'.$row['Creator'].'</div>';
  echo '<div class="comment-time">'.$row['Time'].'</div>';
  echo '<div class="comment-content">'.$row['Content'].'</div>';
  echo '</div>';
  echo '</div>';
}

echo  "</div>";



$conn->close();
?>



<script src="src/index.jsx"></script>
</body>
</html>
  
<style>

.form1 input[type="text"] {
  width: 60%; /* 设置输入框的高度为 100px，根据需要调整 */
}

.comment_in{
  position: relative;
  left: 50%;
  bottom: 10%;
  width: 100%;
}


.comment-container {
  display: flex;
  padding: 1px;
  bottom: 1%; /* 将底部设置为 0 */
  right: 1%; /* 可选，根据需要调整 */
  width: 100%; /* 将宽度设置为 100% */
  }

.c{
  position: absolute;
  left: 2%;
  top: 80%;
  width: 100%;
}

  /* 样式化单个评论 */
  .comment {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #fff;
    width: 90%;
  }

  /* 样式化评论头部 */
  .comment-header {
    font-weight: bold;
  }

  .comment-time {
  font-style: italic; /* 设置时间为斜体 */
  font-size: 14px;
}

  /* 样式化评论内容 */
  .comment-content {
    margin-top: 5px;
  }

.bubble {
  background-color: rgba(255, 255, 255, 0.5);
  border-radius: 50%;
  padding: 50%;
  width: 200px; /* 设置气泡的宽度 */
  border-width: 30px;
  border-style: solid;
  border-color: rgba(255, 255, 255, 0.5);
  text-align: center;
  position: relative;
  z-index: 0;
  top: -50%;
  left: -20%;
  font-size: 24px; /* 设置字体大小为 24像素，根据需要调整 */
}

.qt {
  position: absolute;
  left: 5%;
  top: 5%;
  z-index: 1; /* 确保 .qt 在 .bubble 之上 */
}


.answer{
  position: relative;
  left: -20%;
  top: -30%;
  z-index: 0;
}

.navbar {
    display: flex;
    flex-direction: row; /* 确保是水平布局 */
    background-color: #181A30;
    width: 100%;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 2;
    font-family: 'YourFontFamily', Kalam; /* 设置导航栏的字体 *
    /* 其他样式规则 */
  }
  
  .navbar a {
    font-weight: bold; /* 设置导航项的字体粗细 */
    font-size: 25px; /* 设置导航项的字体大小 */
    color: rgb(255, 255, 255);
  }

</style>