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

$action = $_POST["action"];

$valid_actions = array("Like", "Dislike");

if(!in_array($action, $valid_actions))
{
    header("HTTP/1.1 400 Bad Request");
    die(json_encode(array("success" => "false", "message" => "400 Bad Request")));
}

if(!$_SESSION["username"])
{
    header("HTTP/1.1 401 Unauthorized");
    die(json_encode(array("success" => "false", "message" => "unauthorized")));
}

$sql = "SELECT * FROM actions WHERE `username`=? AND id=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $_SESSION["username"], $video);
$stmt->execute();
$result = $stmt->get_result();
$c = 0;
while ($row = $result->fetch_assoc()) {
    if($row["action"])
    {
        //header("HTTP/1.1 400 Bad Request"); https://support.glitch.com/t/37491/
        die(json_encode(array("success" => "false", "message" => "You can't vote twice")));
    }
}


$sql = "INSERT INTO actions (username, `action`, id, epoch) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql); 
$stamp = time();
$stmt->bind_param("sssi", $_SESSION["username"], $action, $video, $stamp);
$stmt->execute();


$sql = "SELECT * FROM actions WHERE `id`=? AND `action`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $video, $action);
$stmt->execute();
$result = $stmt->get_result();
$c = 0;
while ($row = $result->fetch_assoc()) {
    $c++;
}
die(json_encode(array("success" => "true", "count" => "${c}", "type" => $action)));