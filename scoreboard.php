<?php
// 数据库连接设置
$dbHost     = 'oceanus'; // 通常是 'localhost'
$dbUsername = 'jiehanke';
$dbPassword = '50358791';
$dbName     = 'cse442_2023_fall_team_y_db';

// 创建数据库连接
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 查询数据库，获取排名和头像数据
$query = "SELECT p.Username, p.SystemID, p.point, a.Avatar
          FROM point_tb AS p
          JOIN acc_tb AS a ON p.SystemID = a.SystemID
          ORDER BY p.point DESC";
$result = $conn->query($query);

// 存储数据到数组
$rankings = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rankings[] = $row;
    }
}

// 关闭数据库连接
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
<title>Scoreboard</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div id="leaderboard">
    <h1>Top 5</h1>
    <table>
        <tr>
            <th>Rank</th>
            <th>Avatar</th>
            <th>Username</th>
            <th>Points</th>
        </tr>
        <?php foreach ($rankings as $index => $person): ?>
        <tr>
            <td data-label="Rank"><?php echo $index + 1; ?></td>
            <td data-label="Avatar">

                <img src="avatar/<?php echo htmlspecialchars($person['Avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="avatar-img">

            </td>
            <td data-label="Username"><?php echo htmlspecialchars($person['Username'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td data-label="Points"><?php echo $person['point']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<script src="script.js"></script>

</body>
</html>


<style>
body {
  background: linear-gradient(125deg, #FFFFFF 1%,#5CAED1 30%, #06192B); /* Make it white if you need */
  padding: 0 24px;
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  font-size: 18px; /* 调整为期望的字体大小 */
}

#scoreboard {
    text-align: center;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#scores {
    display: flex;
    justify-content: space-around;
    margin: 20px 0;
}

.team {
    margin: 0 15px;
}

.score {
    font-size: 3em;
    margin: 10px 0;
}

button {
    background: #0084ff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
}

table img {
    width: 50px; /* Or the size you prefer */
    height: 50px; /* Maintain the aspect ratio */
    border-radius: 50%; /* Makes the image circular */
    object-fit: cover; /* Ensures the image covers the area without stretching */
}

button:hover {
    background: #0056b3;
}

.navbar {
  display: flex;
  flex-direction: row; /* 确保是水平布局 */
  background-color: #181A30;
  width: 100%;
  position: fixed;
  left: 0;
  top: 0;
  font-family: 'YourFontFamily', Kalam; /* 设置导航栏的字体 *
  /* 其他样式规则 */
}

.navbar a {
  font-weight: bold; /* 设置导航项的字体粗细 */
  font-size: 25px; /* 设置导航项的字体大小 */
  color: rgb(255, 255, 255);
}

#leaderboard {
    max-width: 800px;
    margin: 20px auto;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#leaderboard h1 {
    text-align: center; /* This centers the text inside the h1 element */
    background-color: #007bff;
    color: #fff;
    padding: 20px;
    margin: 0;
    text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.1);
    font-size: 32px; /* 增大标题字体 */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    background: #fafafa;
    
}

table tr {
    border-bottom: 1px solid #eaeaea;
}

table th, table td {
    padding: 12px 15px;
    text-align: left;
}

table th {
    background-color: #20c997;
    color: #ffffff;
    font-weight: bold;
}

table th, table td {
  padding: 20px; /* 增加间距 */
  font-size: 20px; /* 增大表格中的文本大小 */
}

table td {
    color: #333333;
}

table tbody tr {
    transition: background-color 0.2s ease;
}

table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

table tbody tr:last-of-type {
    border-bottom: 2px solid #20c997;
}

table tbody tr:hover {
    background-color: #e2f4ea;
}

/* Responsive table */
@media screen and (max-width: 600px) {
    table {
        border: 0;
    }

    table thead {
        display: none;
    }

    table tr {
        margin-bottom: 10px;
        display: block;
        border-bottom: 2px solid #ddd;
    }

    table td {
        display: block;
        text-align: right;
        font-size: 13px;
        border-bottom: 1px dotted #ccc;
    }

    table td:last-child {
        border-bottom: 0;
    }

    table td:before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }
}
</style>