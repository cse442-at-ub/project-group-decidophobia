<?php
$dbhost = 'oceanus'; 
$dbuser = 'jiehanke';        
$dbpass = '50358791';        
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('fail: ' . mysqli_error($conn));
}
echo 'Connection success<br />';


mysqli_query($conn , "set names utf8");
 

$Username = 'test';
$Password = 'test';
$SystemID = '-1';
$Email    = 'abc@cde.com';

$sql = "INSERT INTO test ".
        "(Username, Password, SystemID, Email) ".
        "VALUES ".
        "('$Username','$Password','$SystemID','$Email')";
 
 
 
mysqli_select_db( $conn, 'cse442_2023_fall_team_y_db' );
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('Unable to insert data: ' . mysqli_error($conn));
}
echo "Data insertion success, do not keep reflash this page, it will add to much infor to SQL\n";
mysqli_close($conn);
?>