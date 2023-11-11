<?php
header('Content-Type: text/html; charset=utf-8');

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

$SQL_info = "SELECT * FROM `acc_tb` WHERE `SystemID` = -1 LIMIT 1";
$info_s = $conn->query($SQL_info);
$info = $info_s->fetch_assoc();

$name = $info['Username'];
$eml  = $info['Email'];
$pas  = $info['Password'];

echo '<div class="output">';
echo '<div class="name-value">' . $name . '</div>';
echo '<div class="email-value">' . $eml . '</div>';
echo '</div>';
echo '<br>';

//echo '<div class="questions">';

$SQL_q = "SELECT * FROM `q_tb` WHERE `Creator_ID` = -1";
$q = $conn->query($SQL_q);


echo '<div class=tb>';
echo '<table border="1">';
while($row = mysqli_fetch_assoc($q))
{
  echo '<tr>';
  echo '<td colspan="10">' . $row['Question'] . '</td>';
  echo '<td >' . "colour" . '</td>';
  echo '<td >' . "anony" . '</td>';
  echo '<tr>';
  echo 
  "<td>{$row['an1']} </td> ".
  "<td>{$row['vote1']} votes</td> ".
  "<td>{$row['an2']} </td> ".
  "<td>{$row['vote2']} votes </td> ".
  "<td>{$row['an3']} </td> ".
  "<td>{$row['vote3']} votes </td> ".
  "<td>{$row['an4']} </td> ".
  "<td>{$row['vote4']} votes </td> ".
  "<td>{$row['an5']} </td> ".
  "<td>{$row['vote5']} votes </td> ".
  "<td>{$row['colour']} </td> ".
  "<td>{$row['anony']} </td> ".
  "</tr>";
}

echo '</table>';
echo '</div>';



$conn->close();
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
    <link rel="stylesheet" href="src/profile.css">
  </head>
  <body>

    <script src="src/index.jsx"></script>

    <div class="info">
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

    $SQL_av = "SELECT Avatar FROM `acc_tb` WHERE `SystemID` = -1 LIMIT 1";
    $result = $conn->query($SQL_av);
    if ($result) {
        $row = $result->fetch_assoc();
        $avatarFilePath = 'avatar/' .$row['Avatar'];
    } else {
        $avatarFilePath = 'avatar/default.png';
    }


    if (file_exists($avatarFilePath)) {
        echo '<div class="avatar_dis"><img src="' . $avatarFilePath . '" alt="avatar" width="300" height="300">';
    } else {
        echo '<div class="avatar_dis"><img src="' . $default_avtar . '" alt="avatar" width="300" height="300">';
    }

    ?>

    </div>

  </body>
</html>



<style>

.info {
    position: absolute;
    top: 10%;
    left: 1%;
    z-index: -1; 
}


.output {
    position: absolute;
    top: 50%;
    left: 1%;
    font-size: 40px; /* 设置字体大小为 24像素 */
}

.name-value {
    font-size: 60px; /* 设置字体大小为 24像素 */
    font-weight: bold; /* 加粗文本 */
  
}

.avatar_dis {
            width: 300px;
            height: 300px;
            border-radius: 50%; 
            overflow: hidden; 
            top: 0%;
            left:5%;
            z-index: 0; 
}

.tb {
    position: absolute;
    /* 在这里添加您想要的样式规则，例如调整位置 */
    top: 70%; /* 顶部外边距为20像素 */
    left: 1%; /* 左边外边距为10像素 */
}

table {
    border-collapse: collapse;
  }

  table {
    border-collapse: collapse;
    border: 2px solid black; /* 外边框样式和颜色，可以根据需要自定义 */
    font-size: 18px; /* 指定表格单元格字体大小 */
  }

  th, td {
    border-top: 2px solid black; /* 设置横向边框的样式和颜色 */
    padding: 10px; /* 添加一些内边距来让内容与横向边框有一些间距 */
  }
</style>

