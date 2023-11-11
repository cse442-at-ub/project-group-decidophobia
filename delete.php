<?php

//connect to database
$dbhost = 'oceanus'; 
$dbuser = 'yuhaolin';        
$dbpass = '50400509';        
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $con )
{
    die('fail:( ' . mysqli_error($con));
}
echo 'it wroks!!!!<br />';

mysqli_query($con, "set names utf8");

$sql = "DELETE FROM test WHERE SystemID = -1";

mysqli_select_db( $con, 'cse442_2023_fall_team_y_db' );
$ret = mysqli_query( $con, $sql );
if(! $ret )
{
  die('Unable to delete data: ' . mysqli_error($conn));
}
mysqli_close($con);

?>