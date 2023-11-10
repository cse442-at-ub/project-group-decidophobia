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
$hid_pw = "**********";



if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {

    $userId = -1; 

    $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $newFileName = 'avatar'  . '_' . $userId.'.'. $fileExtension;
    $targetDir = 'avatar/';
    $targetFile = $targetDir . $newFileName;
    
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
        $SQL_avatar_in = "UPDATE acc_tb SET Avatar = '$newFileName' WHERE SystemID = -1";
        $a = $conn->query($SQL_avatar_in);

        echo '<script>alert("good upload");</script>';

    } else {
        echo '<script>alert("bad upload");</script>';
    }
} 

$c_pw   = $_POST['change_pw'];
$c_em   = $_POST['change_em'];
$c_ne   = $_POST['change_ne'];
$c_pw_od= $_POST['change_pw_od'];
// tag update
if (isset($_POST['tag'])) {
    $selectedTags = $_POST['tag'];

    // Combine selected tags into a comma-separated string
    $tagsString = implode(', ', $selectedTags);

    // Update the tags_column with the combined string
    $SQL_update_tags = "UPDATE acc_tb SET tags_column = '$tagsString' WHERE SystemID = -1";
    $conn->query($SQL_update_tags);
    echo '<script>alert("Tags updated successfully");</script>';
}

if (isset($_POST['button'])) {
    $clickedButton = $_POST['button'];

    if ($clickedButton === 'change-username') {

        $getname = mysqli_query($conn,"select * from acc_tb where `Username`='$c_ne'");
        $row = $getname->fetch_row();
        if ($row > 0 && $c_ne != '' ){
            echo '<script>alert("name is not vaild.");history.go(-1);</script>';

        } else if ($c_ne == '') {

        } else {

        $SQL_c_ne = "UPDATE `acc_tb` SET `Username`= '$c_ne' WHERE SystemID = -1";
        $result = $conn->query($SQL_c_ne);

        if ($result) {

            $c_ne = '';
            $clickedButton = '';
            echo '<script>alert("name changed");</script>';
            echo '<script>location.reload();</script>';
            
        } else {
            echo '<script>alert("not good, something wrong. ' . $conn->error . '.");</script>';

        }
    }

    } elseif ($clickedButton === 'change-email') {

        if($c_em == ''){
            echo '<script>alert("email can not be Null");</script>';
        }

        $SQL_c_em = "UPDATE `acc_tb` SET `Email`='$c_em' WHERE SystemID = -1";
        $result = $conn->query($SQL_c_em);

        if ($result) {
            echo '<script>alert("email changed");</script>';
        } else {
            echo '<script>alert("not good, something wrong. ' . $conn->error . ' .");</script>';
        }

    } elseif ($clickedButton === 'change-password') {

        if($c_pw == '' or $c_pw_od == ''){
            echo '<script>alert("password can not be Null");</script>';
        }

        $SQL_pw = "SELECT Password FROM acc_tb WHERE SystemId=-1";
        $re = $conn->query($SQL_pw);
        $res = $re->fetch_assoc();
        $pd = $res['Password'];

        if (password_verify($c_pw_od, $pd)){

            $options = ['cost' => 11,
            'salt' => random_bytes(22),];
            $hashed_pw  = password_hash($pd, PASSWORD_BCRYPT, $options);

            $SQL_c_pw = "UPDATE `acc_tb` SET `Password`='$hashed_pw' WHERE SystemID = -1";
            $result = $conn->query($SQL_c_pw);

            if ($result) {
                echo '<script>alert("password changed");</script>';
            } else {
                echo '<script>alert("not good, something wrong. ' . $conn->error . ' .");</script>';
            }
        }else{
            echo '<script>alert("wrong old password);</script>';
        }

    }

}

//echo '<div class="output">';
//echo '<div class="label-value">Name: ' . $name . '</div>';
//echo '<div class="label-value">Email: ' . $eml . '</div>';
//echo '<div class="label-value">Password: ' . $hid_pw . '</div>';
//echo '<div class="label-value2">Enter your old password here</div>';
//echo '</div>';
//echo '<br>';


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


    <div class = "tag">
        <p>Please select the tags you wish to update:</p>

        <form action="profile.php" method="POST" id="tagForm">
            <input type="checkbox" name="tag[]" class="tag-filter" value="Music"> Music
            <input type="checkbox" name="tag[]" class="tag-filter" value="School"> School
            <input type="checkbox" name="tag[]" class="tag-filter" value="Food"> Food
            <input type="checkbox" name="tag[]" class="tag-filter" value="Life"> Life
            <input type="checkbox" name="tag[]" class="tag-filter" value="Game"> Game
            <br>
            <input type="submit" value="Update Tags">
        </form>
    </div>

    <script>

const form = document.getElementById('tagForm');
const updateButton = document.getElementById('updateTagsButton');

updateButton.addEventListener('click', function () {
    form.submit();
});

updateButton.addEventListener('click', function () {
    form.submit();
});
    </script>


    <div>
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

    <div  class="upload-form">
    <form action="profile.php" method="post" enctype="multipart/form-data" >
        <label for="avatar">select your avtar:</label>
        <input type="file" name="avatar" id="avatar" accept="image/*" required>
        <input type="submit" value="upload">
    </form>
    </div>


        <form action="profile.php" method="post" enctype="multipart/form-data" class="form1">

        <div class = all>
        <?php
            echo '<div class="label-value">Name: ' . $name . '</div>';
        ?>
        <input type="text" name="change_ne">
        <button id="change-password" name="button" value="change-username">Change Username</button>

        <?php
            echo '<div class="label-value">Email: ' . $eml . '</div>';
            ?>
        <input type="text" name="change_em">
        <button id="change-email"    name="button" value="change-email"   >Change Email</button>

        <?php
            echo '<div class="label-value">Password: ' . $hid_pw . '</div>';
            ?>
        <input type="text" name="change_pw">


        <?php
            echo '<div class="label-value2">Enter your old password here</div>';
        ?>
        <input type="text" name="change_pw_od">
        <button id="change-name"     name="button" value="change-password">Change Password</button>
        </div>

    </form>

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
          
          $SQL_ftb = "SELECT q_tb.* FROM f_q_tb INNER JOIN q_tb ON f_q_tb.QuestID = q_tb.QuestID WHERE f_q_tb.SystemID = -1";
          $ftb_s = $conn->query($SQL_ftb);
          
          echo '<div class=tb>';
          echo '<table border="1">';
          while($row = mysqli_fetch_assoc($ftb_s))
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


          echo '<br>';
          echo '<br>';
          echo '<br>';
          


        
    ?>



  </body>
</html>



<style>

.tb{
    position: absolute;
    top: 110%;
    left: 1%;
}
table {
    border-collapse: collapse;
    border: 2px solid black; /* 外边框样式和颜色，可以根据需要自定义 */
    font-size: 20px; /* 指定表格单元格字体大小 */
  }

.space input {
    margin-right: 1%; /* 设置输入框之间的右外边距为 10px */
    padding: 10px; /* 设置输入框内部的内边距为 5px，可以根据需要调整 */
}

.form1 {
    background: transparent;
    border: none;
    padding: 10px;
}

.label-value {
    margin-bottom: 10px;
    font-size: 30px;
}

.label-value2 {
    margin-bottom: 10px;
    font-size: 20px;
}


.output {
    display: inline-block;
    position: relative;
    top: 24%;
    right: 0;
}

.space{
    display: inline-block;
    position: relative;
    top: 10%;
    left:0%;
}


.bu{
    display: inline-block; /* 将输入框放在同一行 */
    position: relative;
    top: 0%;
    right: 8%;
}

.avatar_dis {
            width: 300px;
            height: 300px;
            border-radius: 50%; 
            overflow: hidden; 
            position: absolute;
            top: 7%;
            left:5%;
            z-index: -1; 
        }

.tag{
    top: 38%;
    left: 1%;
    position: absolute;
    width :50%;
}

.all{
    top: 50%;
    left: 1%;
    position: absolute;
    width :90%;
}

.upload-form {
    top: 32%;
    left: 1%;
    position: absolute;
    margin-top: 20px; 
}

button {
    padding: 5px 10px; /* 设置按钮的上下和左右内边距，控制大小 */
    font-size: 24px;
    margin-left: 10px;
    margin: 10px;
    
}

</style>

