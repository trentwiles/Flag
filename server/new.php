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

$sql = "SELECT * FROM videos ORDER BY v_time DESC";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
$count = 0;
while ($row = $result->fetch_assoc()) {
    $count++;
    if($count % 4 != 0)
    {
        echo '<div class="container-fluid"><div class="row">';
    }
    echo '<div class="col-sm">';
    echo "<a href='/watch/" . $row["v_id"] . "'><img src='" . $row["v_thumb"] . "' /></a>";
    echo "<br><p>" . $row["v_title"] . "</p>";
    echo "</div>";
    if($count % 4 != 0)
    {
        echo "</div></div>";
    }
}