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
    <div>
        <!-- Add the description above the tag filtering section -->
        <p>Please select the tag(s) you wish to see:</p>
        
        <form action="backend_script.php" method="POST" id="tagForm">
        <!-- Tag filtering checkboxes -->
        <input type="checkbox" name="tag[]" class="tag-filter" value="Music"> Music
        <input type="checkbox" name="tag[]" class="tag-filter" value="School"> School
        <input type="checkbox" name="tag[]" class="tag-filter" value="Food"> Food
        <input type="checkbox" name="tag[]" class="tag-filter" value="Life"> Life
        <input type="checkbox" name="tag[]" class="tag-filter" value="Game"> Game
        <br>
        <input type="submit" value="Update Tags">
    </form>
    
    <div id="selectedTags" style="display:none;">
        <p>Selected tags:</p>
    </div>
</div>

<script>
    const form = document.getElementById('tagForm');
    const selectedTagsDiv = document.getElementById('selectedTags');
    
    form.addEventListener('change', function() {
        // Clear the selected tags display
        selectedTagsDiv.innerHTML = '<p>Selected tags:</p>';
        
        // Find all checked checkboxes
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        const selectedTags = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                // Add the selected tags to an array
                selectedTags.push(checkbox.value);
            }
        });

        // Display the selected tags with spaces in between
        selectedTagsDiv.innerHTML += selectedTags.join(', ');
        
        // Show the selected tags
        selectedTagsDiv.style.display = 'block';
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
            position: ;
            top: 0%;
            left:5%;
        }

.upload-form {
    top: 32%;
    left: 1%;
    position: ;
    margin-top: 20px; 
}

button {
    padding: 5px 10px; /* 设置按钮的上下和左右内边距，控制大小 */
    font-size: 24px;
    margin-left: 10px;
    margin: 10px;
    
}

.tag-filter {
  opacity: 0.5; /* Adjust the opacity as needed (0 is fully transparent, 1 is fully opaque) */
}

input[type="submit"] {
  font-size: 14px; /* Adjust the font size as needed */
  padding: 5px 10px; /* Adjust the padding to control the button size */
}

#tagForm {
    background: transparent; /* Adjust the alpha value (0.8) for transparency */
  padding: 10px; /* Add some padding to create a visible background */
}

#tagForm p {
  font-size: 14px;
}

/* Reduce the size of the checkboxes and label text */
.tag-filter {
  font-size: 12px; /* Adjust the font size as needed */
  margin-right: 5px; /* Adjust the spacing between checkboxes */
}

/* Reduce the size of the Update Tags button */
input[type="submit"] {
  font-size: 12px; /* Adjust the font size as needed */
  padding: 5px 10px; /* Adjust the padding to control the button size */
}

/* Reduce the spacing between the selected tags */
#selectedTags p {
  font-size: 12px; /* Adjust the font size as needed */
}
</style>
