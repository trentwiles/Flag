<?php
header("Content-type: application/json");

/*===================================

This endpoint only accepts GET requests!

Examples:

Get last 10 comments of a video

GET /api/v1/comments/?id=12345&show=10


===================================*/

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$video = $_GET["id"];
$show = $_GET["show"];

if(! $show)
{
    $show = 10;
}
if(! $video)
{
    header("HTTP/1.1 400 Bad Request");
    die(json_encode(array("success" => "false", "message" => "400 Bad Request")));
}

$comments = array();
$users = array();
$time = array();

$sql = "SELECT * FROM comments WHERE `id`=? ORDER BY epoch DESC LIMIT ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("si", $video, $show);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    array_push($users, $row["username"]);
    array_push($comments, $row["comment"]);
    array_push($time, $row["epoch"]);
}

$numbers = array();
$c = 0;
foreach($users as $user)
{
    array_push($numbers, $c);
    $c++;
}

$prep = array(
    "details" => array("username" => $users,
    "comment" => $comments,
    "timestamp" => $time)
    
);

echo json_encode($prep);