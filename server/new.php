<?php

include "header.php";

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}?>
  <div class="container">
    <h2>Recently Uploaded Videos</h2>
    <div class="row">
      <?php
      $sql = "SELECT * FROM videos ORDER BY v_time DESC";
      $stmt = $conn->prepare($sql);
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
              <p class="grey-text">By <a href="/user/<?php echo $row["v_uploader"] ?>" class="grey-text"><?php echo $row["v_uploader"] ?></a></p>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

<?php
include "footer.php";
