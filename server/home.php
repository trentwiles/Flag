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

echo "<h1>Enjoy ${x} short videos</h1>";