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
    if(!isset($row["v_id"]))
    {
        header("HTTP/1.1 404 Not Found");
        die("<h1>404: Video not found. Was it removed?</h1>");
    }
    $title = $row["v_title"];
    $url = $row["v_url"];
    $thumb = $row["v_thumb"];
    $desc = $row["v_desc"];
    $user = $row["v_uploader"];
    $pretime = $row["v_time"];
}


$ago = time() - $pretime;

$mins = round($ago/60);
$hours = round($ago/3600);
$days = round($ago/86400);
$months = round($ago/2629800);
$years = round($ago/31557600);

if($mins > 60)
{
  if($hours > 24)
  {
    if($days > 7)
    {
      if($months > 12)
      {
        $final = $years . " years ago";
      }else{
        $final = $months . " months ago";
      }
    }else{
      $final = $days . " days ago";
    }
  }else{
    $final = $hours . " hours ago";
  }
}else{
  $final = $mins . " minutes ago";
}

$sql = "SELECT * FROM users WHERE `username`=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $pfp = $row["pfp"];
}

?>
<script>
<?php
$video = htmlspecialchars($req);
echo "const video = '${video}';"
?>
</script>
<script src="/frontend/vote.js"></script>
<script src="/frontend/comment.js"></script>
<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js/dist/video.min.js"></script>
 <div class="container">
   <video
       id="watch"
       class="video-js vjs-fluid"
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
   <h2><?php echo $title ?></h2>
   <p><?php echo $new_views ?> views · Uploaded <?php echo $final ?>&nbsp; &nbsp; &nbsp; <button type="button" class="waves-effect waves-light btn" id="like"><i class="material-icons left">thumb_up</i><span id="like_count">?</span></button> <button type="button" class="waves-effect waves-light btn" id="dislike"><i class="material-icons left">thumb_down</i><span id="dislike_count">?</span></button></p>
   <hr>
   <a href="/user/<?php echo $user ?>"><h5><img src="<?php echo $pfp ?>" width="75px" height="75px"><?php echo $user ?></h5></a>
   <div class="desc">
     <h6 class="grey-text"><?php echo $desc; ?></h6>
   </div>
   <hr>
   <h5>Comments</h5>
   <form method="post">
     <textarea id="comment" name="comment" placeholder="What a great video!"  class="materialize-textarea"></textarea>
     <button type="submit" name="button" class="waves-effect waves-light btn">Comment</button>
   </form>
   <br>
   <?php
   $limit = $_GET["show"];
   if(! $limit)
   {
     $limit = 10;
   }
   $sql = "SELECT * FROM comments WHERE `id`=? ORDER BY epoch DESC LIMIT ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("si", $req, $limit);
   $stmt->execute();
   $result = $stmt->get_result();
   $c = 0;
   while ($row = $result->fetch_assoc()) { $c++; ?>
     <div class="card">
       <div class="card-content">
         <span class="card-title"><a href="/users/<?php echo $row["username"] ?>"></a><?php echo $row["username"] ?></span>
         <p><?php echo htmlspecialchars($row["comment"]) ?></p>
       </div>
     </div>
     <br>
    <?php
   }
   $next = $limit + 5;
   if($c == $limit || $c > $limit) { ?>
     <center><a href="/video/<?php echo $req ?>/?show=<?php echo $next ?>" class="waves-effect waves-light btn">Show More</a></center>
    <?php
   }
   ?>
 </div>

<script>

if (!$(window).width() < 1270) {
   $("#video").removeAttr("class");
}
</script>
<script src="/frontend/404.js"></script>
<?php
include "footer.php";
