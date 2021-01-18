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


$sql = "SELECT * FROM videos WHERE v_uploader=? ORDER BY v_time DESC";

$stmt = $conn->prepare($sql);
$authed_user = $_SESSION["username"]; 
$stmt->bind_param("s", $authed_user);
$stmt->execute();
$result = $stmt->get_result();

echo '<table class="table">';
echo '  <thead><tr>';
echo '      <th>Title</th>
<th>Video ID</th><th class="text-right">Views</th></tr>';

while ($row = $result->fetch_assoc()) {
    $title = $row["v_title"];
    $vid = $row["v_id"];


    $sql = "SELECT * FROM stat WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vid);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $views = $row["views"];
    }

    echo '  <tbody>
    <tr>';
    echo "<th>${title}</th>";
    echo "<th>${vid}</th>";
    echo "<th>${views}</th>";
    echo "</tr></tbody>";
}