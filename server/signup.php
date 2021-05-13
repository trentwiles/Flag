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
  <div class="container">
    <h2>Create an account</h2>
    <br>
    <form method="post">
      <div>
        <label for="username" class="required">Username</label>
        <input type="text" name="username" class="form-control" id="username" <?php echo "value='${val}'"; ?> required="required">
        <div class="form-text">
          Only alphanumeric characters and numbers are allowed.
        </div>
        <div class="form-text" id="taken">
        </div>
      </div>
      <div>
        <label for="email" class="required">Email</label>
        <input type="text" name="email" id="email" required="required">
      </div>
      <div>
        <label for="password" class="required">Password</label>
        <input type="password" name="password" id="password" required="required">
      </div>
      <div>
        <label for="confirm-password" class="required">Confirm password</label>
        <input type="password" name="password_conf" id="confirm-password" required="required">
      </div>
      <div class="h-captcha" data-sitekey="<?php echo $_ENV["CAPTCHA"] ?>"></div>
      <p>By creating an account you will accept our <a href="/legal.php/privacy">primacy policy</a> and our <a href="/legal/tos">terms and conditions</a></p>
      <button type="submit" name="button" class="waves-effect waves-light btn">Sign Up!</button>
    </form>
  </div>
<script src="/frontend/username.js"></script>
<script>
$( document ).ready(function() {
    check();
});
</script>
<?php
include "footer.php";
?>
