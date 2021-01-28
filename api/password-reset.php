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

if(!$_POST["token"])
{
    die(json_encode(array("success" => "false", "message" => "Missing valid auth token")));
}

$sql = "SELECT * FROM resets WHERE `token`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $_POST["token"]);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $email = $row["email"];
}

if(!$email)
{
    die(json_encode(array("success" => "false", "message" => "Invalid auth token")));
}

$sql = "SELECT * FROM users WHERE `email`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $user = $row["username"];
}

if(!$user)
{
    die(json_encode(array("success" => "false", "message" => "Invalid auth token (bad email)")));
}

$len = strlen($_POST["password"]);

if($len < 4)
{
    die(json_encode(array("success" => "false", "message" => "Your new password is too short")));
}

$secure_pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE users SET `password`=? WHERE email=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $secure_pass, $email);
$stmt->execute();

$sql = "DELETE FROM tokens WHERE token=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $_POST["token"]);
$stmt->execute();

//die(json_encode(array("success" => "true", "message" => "OK")));
header("Location: /login/");
die();