<?php
include "header.php";

if(!isset($_SESSION["username"]))
{
    die(header("Location: /login?to=account/settings/email"));
}

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<div class="container">
  <h2>Email settings</h2>
  <div class="switch">
    <h5>Site Announcements</h5>
    <label>
      Off
      <input type="checkbox" id="ann">
      <span class="lever"></span>
      On
    </label>
  </div>
  <div class="switch">
    <h5>Comments (On your videos)</h5>
    <label>
      Off
      <input type="checkbox" id="comments">
      <span class="lever"></span>
      On
    </label>
  </div>
  <br>
  <p>Please note that you will always get emails about moderation action on your account.</p>
  <br>
  <a href="/account/settings" class="waves-effect waves-light btn">Back</a>
</div>
<script src="/frontend/settings.js"></script>
<?php
include "footer.php";
?>
