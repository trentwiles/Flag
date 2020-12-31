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

if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function base64_rand($amm)
{   
    $base = "A";
    for ($amm1 = 0; $amm1 <= $amm; $amm1++) {
        $number1 = rand(1,62);
        $number2 = $number1 - 1;
        $chars = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM_-";
        $letter = substr($chars, $number2, $number1);
        $base .= $letter[0];
    }
    return $base;
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
    require "server/signup.php";
});

$router->get('/login', function() {
    $title = "Sign in";
    $desc = "Sign in and start uploading videos to share";
    $thumb = "https://cdn.riverside.rocks/a/begonia-botany-skipjack.png";
    $route = "login";
    require "server/login.php";
});

$router->get('/upload', function() {
    $title = "Upload a video";
    $desc = "Upload a short video for the world to enjoy";
    $thumb = "https://cdn.riverside.rocks/a/begonia-botany-skipjack.png";
    $route = "upload";
    require "server/upload.php";
});

$router->get('/sitemap', function() {
    require "server/sitemap.php";
});

$router->post('/login', function() {
    require "server/login-service.php";
});

$router->post('/signup', function() {
    require "server/signup-service.php";
});

$router->get('/upload', function() {
    $title = "Upload a video";
    $desc = "Sign up and start uploading videos to share";
    $thumb = "https://cdn.riverside.rocks/a/begonia-botany-skipjack.png";
    $route = "upload";
    require "server/upload.php";
});

$router->get('/watch/(\w+)', function($req){
    require "server/player.php";
});

$router->post('/watch/(\w+)', function($vic){
    require "server/comment.php";
});

$router->get('/user/(\w+)', function($useri){
    require "server/user.php";
});

$router->post('/upload', function() {
    require "server/upload-service.php";
});

$router->post('/action', function() {
    require "server/action-service.php";
});

$router->get('/new', function() {
    require "server/new.php";
});

$router->get('/top', function() {
    require "server/top.php";
});

$router->mount('/account', function () use ($router) {
    $router->get('/', function () {
        die(header("Location: /account/home"));
    });
    $router->get('/home', function() {
        require "server/account.php";
    });
    $router->get('/settings', function() {
        require "server/settings.php";
    });
    $router->post('/settings', function() {
        require "server/settings-backend.php";
    });
    $router->get('/signout', function() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
        die();
    });
});

$router->mount('/api/v1', function () use ($router) {
    $router->get('/comments', function () {
        require "api/comment.php";
    });
    $router->get('/users', function () {
        require "api/user.php";
    });
    $router->get('/videos', function () {
        require "api/video.php";
    });
});


$router->set404(function() {
    require "server/404.php";
});

$router->run();