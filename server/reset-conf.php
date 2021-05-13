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

$sql = "SELECT * FROM resets WHERE `token`=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_GET["token"]);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $email = $row["email"];
}

if(!$email)
{
    echo "<br><h1>Sorry, but this reset link is either invalid or expired.</h1>";
}

$sql = "SELECT * FROM users WHERE `email`=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $user = $row["username"];
}

if(!$user)
{
    echo "<br><h1>No user exsists with that email.</h1>";
}

$token = htmlspecialchars($_GET["token"]);

?>
  <div class="container">
    <h2><h2>Reseting password for <?php echo $user ?></h2></h2>
    <form action="/api/v1/password" method="post" class="w-400 mw-full">
      <div class="form-group">
        <label for="password" class="required">New Password</label>
        <input type="password" name="password" class="form-control" id="password" value='' placeholder="" required="required">
      </div>
      <div>
        <input type="hidden" name="token" id="token" value='<?php echo $token; ?>' placeholder="" required="required">
      </div>
      <input class="btn btn-primary" type="submit" value="Submit">
    </form>
  </div>
  <script>
    /* dynamic js @ <?php echo time() ?> */
    const email = "<?php echo $email ?>";
    const tokem = "<?php echo $token ?>";
  </script>
<?php
include "footer.php";
