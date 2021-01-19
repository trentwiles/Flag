<?php
header("Content-type: application/json");

/*===================================

This endpoint only accepts POST requests!

Examples:

Get a video's stats

POST /api/v1/stats
id: 12345


===================================*/

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

$sql = "SELECT * FROM videos WHERE `v_id`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $video);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $uploader = $row["v_uploader"];
    $thumb = trim($row["v_thumb"], "https://cdn.riverside.rocks/flag/");
    $url = trim($row["v_url"], "https://cdn.riverside.rocks/flag/");
}

if($uploader !== $_SESSION["username"])
{
    header("HTTP/1.1 401 Unauthorized");
    die(json_encode(array("success" => "false", "message" => "unauthorized")));
}

$sql = "DELETE FROM videos WHERE `v_id`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $video);
$stmt->execute();

die(json_encode(array("success" => "true", "message" => "success")));

/*

DRY RUN: Do not delete fie

unlink("/var/www/drive1/cdn/flag/${thumb}");
unlink("/var/www/drive1/cdn/flag/${url}");

*/