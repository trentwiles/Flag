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

$sql = "SELECT views FROM stat WHERE `id`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $req);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $pre_view = $row["views"];
}

$new_views = $pre_view + 1;

$sql = "UPDATE `stat` SET `views`=? WHERE id=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss", $new_views, $req);
$stmt->execute();

$sql = "SELECT * FROM videos WHERE `v_id`=?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $req);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    if($row["v_title"] == "")
    {
        die("<h1>404: Video not found. Was it removed?</h1>");
    }
    $title = $row["v_title"];
    $url = $row["v_url"];
    $thumb = $row["v_thumb"];
    $desc = $row["v_desc"];
    $user = $row["v_uploader"];
}

?>
<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js/dist/video.min.js"></script>
<br>
<video
    id="watch"
    class="video-js"
    controls
    preload="auto"
    <?php echo "poster='" . $thumb . "'"; ?>
    data-setup='{}'
    width="720"
    height="480"
    >
  <source <?php echo "src='" . $url . "'"; ?> type="video/mp4"></source>
  <p class="vjs-no-js">
    To view this video please enable JavaScript, and consider upgrading to a
    web browser that
    <a href="https://videojs.com/html5-video-support/" target="_blank">
      supports HTML5 video
    </a>
  </p>
</video>
<?php echo "<br><h2>" . $title . "</h2>"; ?>
<?php echo "<p>" . $new_views . " views</p>"; ?>
<hr>
<div class="desc" width="60%">
    <?php echo $desc; ?>
</div>
<?php echo "<p><a href='/user/${user}'>${user}</a></p>"; ?>