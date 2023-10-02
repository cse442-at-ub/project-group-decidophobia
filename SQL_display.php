<?php
$dbhost = 'oceanus';  // mysql服务器主机地址
$dbuser = 'jiehanke';            // mysql用户名
$dbpass = '50358791';          // mysql用户名密码

$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('fail: ' . mysqli_error($conn));
}
// 设置编码，防止中文乱码
mysqli_query($conn , "set names utf8");
 
$sql = 'SELECT Username, Password, SystemID, Email FROM test';
 
mysqli_select_db( $conn, 'cse442_2023_fall_team_y_db' );
$retval = mysqli_query( $conn, $sql );

if(! $retval )
{
    die('unable to read data: ' . mysqli_error($conn));
}

echo '<h2>Decidophobia Test</h2>';
echo '<table border="1"><tr><td>Username ID</td><td>Password</td><td>SystemID</td><td>Email</td></tr>';
while($row = mysqli_fetch_assoc($retval))
{
    echo "<tr><td> {$row['Username']}</td> ".
         "<td>{$row['Password']} </td> ".
         "<td>{$row['SystemID']} </td> ".
         "<td>{$row['Email']} </td> ".
         "</tr>";
}
echo '</table>';
mysqli_close($conn);
?>