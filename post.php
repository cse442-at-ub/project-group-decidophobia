<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$question  = $_POST['ques'];
$an1       = $_POST['an1'];
$an2       = $_POST['an2'];
$an3       = $_POST['an3'];
$an4       = $_POST['an4'];
$an5       = $_POST['an5'];

// Validate the selected tag
$allowedTags = array("Random", "School", "Food", "Music", "Life", "Game");
$tag = $_POST['tag'];

if (!in_array($tag, $allowedTags)) {
    echo '<script>alert("Invalid tag selection");history.go(-1);</script>';
    exit; // Stop script execution
}

if(isset($_POST['selected_color'])) {
    $colour = $_POST['selected_color'];

    if ($colour == 'red') {
        $colour = '255,0,0'; // RGB for red
    } elseif ($colour == 'green') {
        $colour = '0,128,0'; // RGB for green
    } elseif ($colour == 'blue') {
        $colour = '0,0,255'; // RGB for blue
    } elseif ($colour == 'yellow') {
        $colour = '255,255,0'; // RGB for yellow
    } elseif ($colour == 'orange') {
        $colour = '255,165,0'; // RGB for orange
    } elseif ($colour == 'purple') {
        $colour = '128,0,128'; // RGB for purple
    } else {
        $colour = 'unknown'; // or handle this case as needed
    }
  
}else{
    $colour = "24,26,48";
}

if (strlen($question) >= 50){
    echo '<script>alert("Question is too long, should be less than 50 characters");history.go(-1);</script>';
}else if(strlen($an1) >= 20 || strlen($an2) >= 20 || strlen($an3) >= 20 || strlen($an4) >= 20 || strlen($an5) >= 20  ){
    echo '<script>alert("Answer is too long, should be less than 20 characters");history.go(-1);</script>';
}else{


    
if (isset($_POST['submit_button'])) {
        
    if (isset($_POST["anony"])) {
        $anony = 1;
    } else {
        $anony = 0;
    }



    $dbhost = 'oceanus'; 
    $dbuser = 'jiehanke';          
    $dbpass = '50358791';       

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
        die('fail: ' . mysqli_error($conn));
    }

    mysqli_query($conn , "set names utf8");
    mysqli_select_db( $conn, 'cse442_2023_fall_team_y_db' );



    $getid = mysqli_query($conn,"SELECT MAX(`QuestID`) as now_id FROM `q_tb`");
    $id = mysqli_fetch_assoc($getid);

    if ($id['now_id'] < 10){
        $QID = 10;
    }else{
        $QID = $id['now_id'] + 1;
    }
    
    $datetime = date_create()->format('Y-m-d H:i:s');
    $testname = "test_name";
    $testID = -1;
    $votes = 0;

    if($an3 == ""){
        $an3 == " ";
    }
    if($an4 == ""){
        $an4 == " ";
    }
    if($an5 == ""){
        $an5 == " ";
    } 
    

    $sql = "INSERT INTO `q_tb`
    (`Question`,`QuestID`, `anony`, `Colour`,  `an1`, `vote1`, `an2`, `vote2`, `an3`, `vote3`, `an4`, `vote4`, `an5`, `vote5`, `Creator`, `Creator_ID`, `Time`,`tag`)
    VALUES 
    ('$question', $QID,$anony,'$colour','$an1',$votes,'$an2',$votes,'$an3',$votes,'$an4',$votes,'$an5',$votes,'$testname',$testID,'$datetime','$tag')";

    if ($question == "" or $an1 == "" or $an2 == "" or $tag==""){
        echo '<script>alert("Question or answer or tag cannot be left blank");history.go(-1);</script>';
    }else if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Good to go!");</script>';
        header("Refresh:0;url=TEST.HTML");
    }else if ($conn->query($sql) === FALSE) {
        echo '<script>alert("Something wrong with SQL: '.$conn->error.'");</script>';
    }else{
        echo '<script>alert("Something wrong");</script>';
    }

    $conn->close();
  }else{

  }

}

?>

