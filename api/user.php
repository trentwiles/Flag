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

