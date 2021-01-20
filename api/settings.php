<?php

header("Content-type: application/json");

/*===================================

This endpoint only accepts GET requests!

Examples:

Get a video's stats

GET /api/v1/stats/?id=12345


===================================*/

if(!$_SESSION["username"])
{
    header("HTTP/1.1 401 Unauthorized");
    die(json_encode(array("success" => "false", "message" => "unauthorized")));
}

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_POST["comments"])
{
    if($_POST["comments"] == "on")
    {
        $sql = "UPDATE users SET comments=? WHERE username=?";
        $stmt = $conn->prepare($sql); 
        $on = "1";
        $stmt->bind_param("ss", $on, $_SESSION["username"]);
        $stmt->execute();
    }else if($_POST["comments"] == "off")
    {
        $sql = "UPDATE users SET comments=? WHERE username=?";
        $stmt = $conn->prepare($sql); 
        $off = "0";
        $stmt->bind_param("ss", $off, $_SESSION["username"]);
        $stmt->execute();
    }
}

if($_POST["announce"])
{
    if($_POST["announce"] == "on")
    {
        $sql = "UPDATE users SET announce=? WHERE username=?";
        $stmt = $conn->prepare($sql); 
        $on = "1";
        $stmt->bind_param("ss", $on, $_SESSION["username"]);
        $stmt->execute();
    }else if($_POST["announce"] == "off")
    {
        $sql = "UPDATE users SET announce=? WHERE username=?";
        $stmt = $conn->prepare($sql); 
        $off = "0";
        $stmt->bind_param("ss", $off, $_SESSION["username"]);
        $stmt->execute();
    }
}