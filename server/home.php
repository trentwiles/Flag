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

$sql = "SELECT * FROM videos";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$x = 0;
while ($row = $result->fetch_assoc()) {

    $x++;
}

$sql = "SELECT * FROM stat ORDER BY views DESC LIMIT 20";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$a = 0;
while ($row = $result->fetch_assoc()) {
    $a++;
}

$sql = "SELECT * FROM stat ORDER BY views DESC LIMIT 20";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$top = array();
$views = array();
while ($row = $result->fetch_assoc()) {
    array_push($top, $row["id"]);
    array_push($views, $row["views"]);
}

$sql = "SELECT * FROM stat";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$viewer = 0;
while ($row = $result->fetch_assoc()) {
    $viewer = $viewer + (int)($row["views"]);
}

echo "<!--";
print_r($top);
echo "-->";
?>
  <div class="container">
    <h2>Flag</h2>
    <h4>Bite Sized Videos</h4>
    <br>
    <div class="row videos">
      <?php
        foreach ($top as $vias) {
          $cur_views = $count - 1;
          $viw = $views[$cur_views];
          $sql = "SELECT * FROM videos WHERE v_id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $vias);
          $stmt->execute();
          $result = $stmt->get_result();
          $top = array();
          while ($row = $result->fetch_assoc()) {
      ?>
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
      <?php
          }
        }
      ?>
    </div>
  </div>
<?php
include "footer.php";
