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

$polr_base_url = "https://rocks.pog.rs";

if(!$_GET["id"])
{
    die(json_encode(array("success" => "false", "message" => "Missing id param")));
}

$headers = array('User-agent' => 'FlagVideo ' . version);
$request = Requests::get('https://rocks.pog.rs/api/v2/action/shorten?key=' . $_ENV["POLR_API"] . "&url=https://flag.riverside.rocks/watch/" . $_GET["id"] . "&is_secret=false", $headers);

$api = json_decode($request->body, true);
die(json_encode(array("success" => "true", "url" => $api["result"])));