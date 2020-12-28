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

if(isset($_POST["comment"]) && isset($_SESSION["username"]) && isset($_POST["video"]))
{
    $sql = "INSERT INTO `comments` (username, commment, epoch, id, comment_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql); 
    $comment = htmlspecialchars($_POST["comment"]);
    $epoch = time();
    $comment_id = rand();
    $stmt->bind_param("ssiss", $_SESSION["username"], $comment, $epoch, $video, $comment_id);
    $stmt->execute();
    die(json_encode(array("success" => "true", "comment" => $comment), true));
}