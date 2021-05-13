<?php
include "header.php";

if(!isset($_SESSION["username"]))
{
    die(header("Location: /login?to=accounts/settings"));
}

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
  <br>
  <h3 class="container">Settings</h3>
  <form method="post" class="container">
    <div class="form-group">
        <h5>Description</h5>
        <textarea class="materialize-textarea" id="description" name="bio" required="required"><?php echo $describe ?></textarea>
    </div>
    <button type="submit" name="button" class="waves-effect waves-light btn">Save Changes</button>
  </form>
  <br>
  <form method="post" class="container" enctype="multipart/form-data">
    <h5>Profile Picture</h5>
    <div class="file-field input-field">
      <div class="btn">
        <span>File</span>
        <input type="file" id="foo" name="foo">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
    <button type="submit" name="button" class="waves-effect waves-light btn">Save Changes</button>
  </form>
<br>
<center><a href="/account/settings/email/" class="waves-effect waves-light btn">Email Settings</a> <a href="/account/" class="waves-effect waves-light btn">Account Home</a></center>
<?php
include "footer.php";
?>
