<?php
session_start();
header("X-Powered-By: Riverside Rocks");
header("X-Server: kestral (v2.2)");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protections: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$router = new \Bramus\Router\Router();

$router->get('/', function() {
    require "server/home.php";
});

$router->get('/signup', function() {
    $title = "Create an account";
    $desc = "Sign up and start uploading videos to share";
    $thumb = "https://cdn.riverside.rocks/a/begonia-botany-skipjack.png";
    $route = "signup";
    require "server/home.php";
});

$router->get('/upload', function() {
    $title = "Upload a video";
    $desc = "Sign up and start uploading videos to share";
    $thumb = "https://cdn.riverside.rocks/a/begonia-botany-skipjack.png";
    $route = "upload";
    require "server/upload.php";
});

$router->run();