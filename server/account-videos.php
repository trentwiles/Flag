<?php
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /login/?to=account/videos"));
}

?>

<script src="/frontend/stats.js"></script>

<?php

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_GET["sort"] == "new")
{
    $sql = "SELECT * FROM videos WHERE v_uploader=? ORDER BY v_time DESC LIMIT 20"; // limited to 20 for now
}else if($_GET["sort"] == "old"){
    $sql = "SELECT * FROM videos WHERE v_uploader=? ORDER BY v_time ASC LIMIT 20"; // limited to 20 for now
}else{
    $sql = "SELECT * FROM videos WHERE v_uploader=? ORDER BY v_time DESC LIMIT 20"; // limited to 20 for now
}

$stmt = $conn->prepare($sql);
$authed_user = $_SESSION["username"];
$stmt->bind_param("s", $authed_user);
$stmt->execute();
$result = $stmt->get_result();

?>
<div class="container">
  <br>
  <div class="btn-group" role="group" aria-label="Change">
    <a href="?sort=new"><button class="btn" type="button">Sort by new</button></a>
    <a href="?sort=old"><button class="btn" type="button">Sort by old</button></a>
  </div>
  <br>
  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Video ID</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = $result->fetch_assoc()) {
          $title = $row["v_title"];
          $vid = $row["v_id"];
      ?>
        <tr>
          <th><?php echo $title; ?></th>
          <th><?php echo $vid ?></th>
          <th><a href="/account/edit/<?php echo $vid ?>" class="btn">Edit</a></th>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<br>
<?php
include 'footer.php';
?>
