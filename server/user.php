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
  <br>
  <div class="container">
    <center>
      <img src="<?php echo $photo; ?>" alt="<?php echo $use ?>'s profile picture" width="75px" height="75px">
      <h3><?php echo $use ?></h3>
      <h6><?php echo htmlspecialchars($describe) ?></h6>
      <br>
      <strong id="views">0 views</strong>
    </center>
    <br>
    <h4>Videos</h4>
    <div class="row">
      <?php

      $videos = array();

      $sql = "SELECT * FROM videos WHERE v_uploader=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $useri);
      $stmt->execute();
      $result = $stmt->get_result();
      $count = 0;

      while ($row = $result->fetch_assoc()) { ?>
        <div class="col s12 m7">
          <div class="card">
            <div class="card-image">
              <img src="<?php echo $row["v_thumb"] ?>" height="144px" width="360" loading="lazy">
              <a href="/watch/<?php echo $row["v_id"] ?>" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons"><span class="material-icons-round">play_arrow</span></i></a>
            </div>
            <div class="card-content">
              <span class="card-title"><?php echo $row["v_title"] ?></span>
              <p class="grey-text"><?php echo $row["v_desc"] ?></p>
            </div>
          </div>
        </div>
      <?php
          array_push($videos, $row["v_id"]);
      }
      echo "</div></div>";

      $cont = 0;


      foreach($videos as $video)
      {
          $sql = "SELECT * FROM stat WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $video);
          $stmt->execute();
          $result = $stmt->get_result();

          while ($row = $result->fetch_assoc()) {
              $cont = $cont + (int)($row["views"]);
          }
      }

      echo "<script>document.getElementById('views').innerHTML = ${cont}+' views';</script>";
      ?>
    </div>
  </div>
<?php

echo "<script>document.getElementById('views').innerHTML = ${cont}+' views';</script>";

include "footer.php";
