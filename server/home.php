<?php 
include "header.php";

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM videos";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
$x = 0;
while ($row = $result->fetch_assoc()) {

    $x++;
}

$sql = "SELECT * FROM stat ORDER BY views DESC LIMIT 20";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
$a = 0;
while ($row = $result->fetch_assoc()) {
    $a++;
}

$sql = "SELECT * FROM stat ORDER BY views DESC LIMIT 20";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
$top = array();
while ($row = $result->fetch_assoc()) {
    array_push($top, $row["id"]);
}
echo "<script>";
echo "const videos = [";
$nu = 0;
foreach($top as $vi)
{
    $nu++;
    if($nu == $a)
    {
        echo "'${vi}'";
        break;
    }
    echo "'${vi}', ";
}
echo "];";
echo "</script>";
echo "<h1>Flag - Bite Sized Videos</h1>";
echo "<script src='/frontend/top.js'></script>";