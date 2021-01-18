<?php 
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /login/?to=account/videos"));
}

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//

$sql = "SELECT * FROM videos WHERE v_id=?"; // limited to 20 for now

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $video_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if($row["v_uploader"] !== $_SESSION["username"])
    {
        die("<br><h2>Looks like you don't have access to this video or it doesn't exsist.</h2>");
    }
    $cur_title = $row["v_title"];
    $cur_desc = $row["v_desc"];
}