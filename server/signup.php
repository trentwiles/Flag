<?php 
include "header.php";

if(isset($_SESSION["username"]))
{
  die(header("Location: /account/home"));
}

$val = htmlspecialchars($_GET["username"]);

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
$stmt->bind_param("s", $val);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    if($row["username"] !== "")
    {
        die(header("Location: /login/?username=${val}"));
    }
}

?>
<script src="https://www.hCaptcha.com/1/api.js" async defer></script>
<h1>Create an account</h1>
<br>
<form method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="username" class="required">Username</label>
    <input type="text" name="username" class="form-control" id="username" <?php echo "value='${val}'"; ?> placeholder="Username" required="required">
    <div class="form-text">
      Only alphanumeric characters and numbers are allowed.
    </div>
    <div class="form-text" id="taken">
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="required">Email</label>
    <input type="text" name="email" class="form-control" id="email" placeholder="Email" required="required">
  </div>
  <div class="form-group">
    <label for="password" class="required">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="required">
  </div>
  <div class="form-group">
    <label for="confirm-password" class="required">Confirm password</label>
    <input type="password" name="password_conf" class="form-control" id="confirm-password" placeholder="Confirm password" required="required">
    <div class="form-text">
      Must match the above password exactly.
    </div>
  </div>
  <div class="h-captcha" data-sitekey="80228737-9c23-4e37-a270-2cc47cca9fbe"></div>
  <input class="btn btn-primary btn-block" type="submit" value="Sign up">
</form>
<script src="/frontend/username.js"></script>
