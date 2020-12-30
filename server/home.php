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

echo "<!--";
print_r($top);
echo "-->";

echo "<h1>Flag - Bite Sized Videos</h1>";
echo "<script src='/frontend/top.js'></script>";

foreach($top as $vias)
{
    $sql = "SELECT * FROM videos WHERE v_id=?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $vias);
    $stmt->execute();
    $result = $stmt->get_result();
    $top = array();
    while ($row = $result->fetch_assoc()) {
        $thumb = $row["v_thumb"];
        $title = $row["v_title"];
    }
    echo '<div class="w-300 mw-full">';
    echo '<div class="card p-0">';
    echo "<a href='/watch/${vias}'><img src='${thumb}' class='img-fluid rounded-top' alt='thumbnail'></a>";
    echo "<div class='content'><h2 class='content-title'>${title}</h2></div></div></div>";
}