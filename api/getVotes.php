<?php
header("Content-type: application/json");

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$video = $_POST["id"];

if(! $video)
{
    header("HTTP/1.1 400 Bad Request");
    die(json_encode(array("success" => "false", "message" => "400 Bad Request")));
}


$sql = "SELECT * FROM actions WHERE `id`=? AND `action`=?";
$stmt = $conn->prepare($sql); 
$likes = "Like";
$stmt->bind_param("ss", $video, $likes);
$stmt->execute();
$result = $stmt->get_result();
$c = 0;
while ($row = $result->fetch_assoc()) {
    $c++;
}

$sql = "SELECT * FROM actions WHERE `id`=? AND `action`=?";
$stmt = $conn->prepare($sql); 
$likes = "Dislike";
$stmt->bind_param("ss", $video, $likes);
$stmt->execute();
$result = $stmt->get_result();
$d = 0;
while ($row = $result->fetch_assoc()) {
    $d++;
}
die(json_encode(array("success" => "true", "Likes" => "${c}", "Dislikes" => "${d}", "type" => $action)));