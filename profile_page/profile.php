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

echo '<div class="output">';
echo '<div class="label-value">Name: ' . $name . '</div>';
echo '<div class="label-value">Email: ' . $eml . '</div>';
echo '<div class="label-value">Password: ' . $hid_pw . '</div>';
echo '<div class="label-value2">Enter your old password here</div>';
echo '</div>';
echo '<br>';

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


if (isset($_POST['button'])) {
    $clickedButton = $_POST['button'];

    if ($clickedButton === 'change-username') {

        if($c_ne == ''){

            echo '<script>alert("name can not be Null");</script>';

        }

        $SQL_c_ne = "UPDATE `acc_tb` SET `Username`= '$c_ne' WHERE SystemID = -1";
        $result = $conn->query($SQL_c_ne);

        if ($result) {
            
            echo '<script>alert("name changed");</script>';

            
        } else {
            echo '<script>alert("not good, something wrong. ' . $conn->error . '.");</script>';

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
    <link rel="stylesheet" href="src/style.css">
  </head>
  <body>

    <script src="src/index.jsx"></script>

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
    <div class="space">
    <input type="text" name="change_ne">
    <input type="text" name="change_em">
    <input type="text" name="change_pw">
    <input type="text" name="change_pw_od">
    </div>
    
    <div class="bu">
    <button id="change-password" name="button" value="change-username">Change Username</button>
    <button id="change-email"    name="button" value="change-email"   >Change Email</button>
    <button id="change-name"     name="button" value="change-password">Change Password</button>
    </div>
    </form>



  </body>
</html>



<style>

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
    position: absolute;
    top: 50%;
    left:5%;
}

.space{
    position: absolute;
    top: 50%;
    left:25%;
}


.bu{
    position: absolute;
    top: 49.5%;
    left:75%;
}

.avatar_dis {
            width: 300px;
            height: 300px;
            border-radius: 50%; 
            overflow: hidden; 
            position: absolute;
            top: 10%;
            left:5%;
        }

.upload-form {
    top: 32%;
    left:1%;
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

