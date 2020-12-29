<?php
header("Content-type: application/json");

/*===================================

This endpoint only accepts GET requests!

Examples:

Get details of a user

GET /api/v1/users/?name=RiversideRocks


===================================*/

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$request = $_GET["username"];

if(! $request)
{
    header("HTTP/1.1 400 Bad Request");
    die(json_encode(array("success" => "false", "message" => "400 Bad Request")));
}

$sql = "SELECT * FROM users WHERE `username`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $request);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    if($row["username"] == "")
    {
        die(json_encode(array("message" => "No such user")));
    }
    $details = array(
        "username" => $row["username"],
        "signup_time" => $row["signup_time"],
        "id" => $row["id"],
        "bio" => $row["bio"],
        "profile_photo" => $row["pfp"]
    );
    $final = array(
        "details" => $details
    );
    die(json_encode($final));
}