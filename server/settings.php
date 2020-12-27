<?php
include "header.php";

if(!isset($_SESSION["username"]))
{
    die(header("Location: /login"));
}

echo $_SESSION["username"] . " - Settings";

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
$userid = $_SESSION["username"];
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $describe = $row["bio"];
}

?>
<form method="post" class="w-400 mw-full">
<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" <?php echo "placeholder='" . $describe . "'"; ?> required="required"></textarea>
  </div>
  <input class="btn btn-primary" type="submit" value="Update">
</form>


<form method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="picture" class="required">Display picture</label>
    <div class="custom-file">
      <input type="file" id="picture" required="required">
      <label for="picture">Choose picture</label>
    </div>
  </div>
  <input class="btn btn-primary" type="submit" value="Update">
</form>