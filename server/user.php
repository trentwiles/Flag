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
}

if(!isset($use))
{
    die("<h1>404: Not Found</h1>");
}

?>

<div class="content">
  <h2 class="content-title">
    <?php echo $use; ?>
  </h2>
  <p>
  <?php echo $describe; ?>
  </p>
</div>