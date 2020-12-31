<?php
use Tackk\Cartographer\Sitemap;
use Tackk\Cartographer\ChangeFrequency;

$sitemap = new Tackk\Cartographer\Sitemap();
$time = date("Y-m-d", time());
$sitemap->add('https://flag.riverside.rocks', $time, ChangeFrequency::WEEKLY, 1.0);
$sitemap->add('https://flag.riverside.rocks/top', $time, ChangeFrequency::WEEKLY, 1.0);
$sitemap->add('https://flag.riverside.rocks/new', $time, ChangeFrequency::WEEKLY, 1.0);


$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $user = $row["username"];
    $sitemap->add('https://flag.riverside.rocks/user/' . $user, $time);
}

$sql = "SELECT * FROM videos";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $user = $row["v_id"];
    $sitemap->add('https://flag.riverside.rocks/watch/' . $user, $time);
}


header ('Content-Type:text/xml');
echo $sitemap->toString();