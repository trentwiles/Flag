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
    if(!$row["username"])
    {
        die(header("Location: /signup/?username=${val}"));
    }
}

?>
<script src="https://www.hCaptcha.com/1/api.js" async defer></script>
<div class="container">
  <h1>Log In</h1>
  <br>
  <?php if($_GET["badpassword"]) { ?>
    <div class="card red" role="alert">
      <div class="card-content">
        <h6>Invalid username or password!</h6>
      </div>
    </div>
  <?php } ?>
  <?php if($_GET["captcha"]) { ?>
    <div class="card red" role="alert">
      <div class="card-content">
        <h6>Please complete the captcha verification first!</h6>
      </div>
    </div>
  <?php } ?>
  <form method="post">
    <div>
      <label for="username" class="required">Username</label>
      <input type="text" name="username" class="form-control" id="username" <?php echo "value='${val}'"; ?> required="required">
    </div>
    <div>
      <label for="password" class="required">Password</label>
      <input type="password" name="password" class="form-control" id="password" required="required">
    </div>
    <div class="h-captcha" data-sitekey="<?php echo $_ENV["CAPTCHA"] ?>"></div>
    <button type="submit" name="button" class="waves-effect waves-light btn">Log In</button>
  </form>
  <br>
  <a href="/reset/">Forgot your password?</a>
  <br>
  <a href="/signup/">Need an account?</a>
</div>
<?php
include "footer.php";
?>
