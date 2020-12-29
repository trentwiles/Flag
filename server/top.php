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

$sql = "SELECT * FROM stat ORDER BY views DESC LIMIT 15";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();

$top = array();

while ($row = $result->fetch_assoc()) {
    array_push($top, $row["id"]);
}

foreach($top as $video)
{
    $sql = "SELECT * FROM videos WHERE v_id=?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $video);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = 0;

    echo '<br><div class="container-fluid"><div class="row">';

    while ($row = $result->fetch_assoc()) {
        $count++;
        if($count == 4 || $count == 8 || $count == 12)
        {
            echo '<div class="container-fluid"><div class="row">';
        }
        echo '<div class="col-sm">';
        echo "<a href='/watch/" . $row["v_id"] . "'><img src='" . $row["v_thumb"] . "' height='144px' width='360'/></a>";
        echo "<br><p>" . $row["v_title"] . "</p>";
        echo "</div>";
        if($count == 4 || $count == 8 || $count == 12)
        {
            echo "</div></div>";
        }
    }
    echo "</div></div>";

}
include "seo.php";
