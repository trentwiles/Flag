<?php 
include "header.php";

$sql = "SELECT * FROM videos";
$stmt = $conn->prepare($sql); 
$stmt->execute();
$result = $stmt->get_result();
$x = 0;
while ($row = $result->fetch_assoc()) {

    $x++;
}

echo "<h1>Enjoy ${x} short videos</h1>";