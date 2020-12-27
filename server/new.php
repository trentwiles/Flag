<?php

include "head.php";

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