<?php
include "header.php";

if(!isset($_SESSION["username"]))
{
    die(header("Location: /login"));
}

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["bio"]))
{
    $sql = "UPDATE `users` SET `bio`=? WHERE username=?";
    $stmt = $conn->prepare($sql); 
    $new_bio = htmlspecialchars($_POST["bio"]);
    $stmt->bind_param("ss", $new_bio, $_SESSION["username"]);
    $stmt->execute();
}