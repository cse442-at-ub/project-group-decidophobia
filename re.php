<?php
header('Content-Type: text/html; charset=utf-8');

$username1  = $_POST['username'];
$userPwd1   = $_POST['userPwd'];
$reuserPwd1 = $_POST['reuserPwd'];

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

$getid = mysqli_query($conn,"SELECT MAX(`SystemID`) as now_id FROM `acc_tb`");
$id = mysqli_fetch_assoc($getid);

if ($id['now_id'] < 10){
    $next_id = 10;
}else{
    $next_id = $id['now_id'] + 1;
}


if(! $id ){
    die('Can not get system ID: ' . mysqli_error($conn));
}


$getname = mysqli_query($conn,"select * from acc_tb where `Username`='$username1'");
$row = $getname->fetch_row();

$options = ['cost' => 11,
            'salt' => random_bytes(22),
];
$hashed_pw  = password_hash($userPwd1, PASSWORD_BCRYPT, $options);
 
$sql = "INSERT INTO acc_tb ".
        "(Username,Password, SystemID, Email) ".
        "VALUES ".
        "('$username1','$hashed_pw', $next_id , ' ' )";

if ($username1 == "" or $userPwd1 == ""){
    echo '<script>alert("Account number or password cannot be left blank");history.go(-1);</script>';
}
else if (strlen($username1) < 5){
    echo '<script>alert("Short name, place change another name.");history.go(-1);</script>';
}
else if (strlen($userPwd1) < 5){
    echo '<script>alert("Short password, place change another password.");history.go(-1);</script>';
}
else if ($userPwd1 != $reuserPwd1){
    echo '<script>alert("You did not enter the same password twice.");history.go(-1);</script>'; 
}
else if ($row > 0){
    echo '<script>alert("Same name, place change another name.");history.go(-1);</script>';
}
else if (strpos($userPwd1,' ')){
    echo '<script>alert("Invaild char in password, place change another password.");history.go(-1);</script>';
}
else if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Registration Success");</script>';
    header("Refresh:0;url=Congrats.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>

