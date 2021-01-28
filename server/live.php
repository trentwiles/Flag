<?php 
include "header.php";

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!$_SESSION["username"])
{
    die(header("Location: /login"));
}

$user = $_SESSION["username"];
?>
<h1>Live Dashboard</h1>
<br>
<?php

echo "<script>const user = '${user}';</script>";

?>
<script src="/frontend/live.js"></script>
<button class="btn btn-success" type="button" onclick="live(user);">Begin Stream</button>
<br>
<p id="status"></p>
<br>
<div id="live">

</div>