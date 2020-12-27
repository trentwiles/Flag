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
$sql = "SELECT * FROM users WHERE `username`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $useri);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {

    $use = $row["username"];
    $describe = $row["bio"];
    $photo = $row["pfp"];
}

if(!isset($use))
{
    die("<h1>404: Not Found</h1>");
}

?>
<img <?php echo "src='" . $photo ."'"; ?> class="img-fluid rounded-circle" alt="rounded circle image" width="100px" height="100px" />
<div class="content">
  <h2 class="content-title">
    <?php echo "h3>${use}</h3>"; ?>
  </h2>
  <p>
  <?php echo $describe; ?>
  </p>
</div>
<h4>Videos</h4>
<?php
$sql = "SELECT * FROM videos WHERE v_uploader=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $useri);
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