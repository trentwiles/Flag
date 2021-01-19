<?php 
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /login/?to=account/videos"));
}

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<script src="/frontend/delete.js"></script>

<?php
//

$sql = "SELECT * FROM videos WHERE v_id=?"; // limited to 20 for now

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $video_id);
$stmt->execute();
$result = $stmt->get_result();

echo '<form method="post" class="w-400 mw-full">';

while ($row = $result->fetch_assoc()) {

    $uploader = $row["v_uploader"];
    $cur_title = $row["v_title"];
    $cur_desc = $row["v_desc"];
    echo "<h1>Edit your video</h1>";
    echo '<div class="form-group">';
    echo "<label for='title' class='required'>Title</label>";
    echo "<input type='text' class='form-control' name='title' id='title' placeholder='${cur_title}' required='required'>";
    echo "</div>";
    echo '<div class="form-group">';
    echo '<label for="description">Description</label>';
    echo "<textarea class='form-control' id='description' name='description' placeholder='${cur_desc}' required='required'></textarea>";
    echo "</div>";
    echo '<input class="btn btn-primary" type="submit" value="Update"></form>';
    break;
}

if($uploader !== $_SESSION["username"])
{
    die("<br><h2>Looks like you don't have access to this video or it doesn't exsist.</h2>");
}

if(isset($_POST["title"]) && isset($_POST["description"]))
{
    $sql = "SELECT * FROM videos WHERE v_id=?"; // limited to 20 for now

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<form method="post" class="w-400 mw-full">';

    while ($row = $result->fetch_assoc()) {
        if($row["v_uploader"] !== $_SESSION["username"])
        {
            die("<br><h2>Looks like you don't have access to this video or it doesn't exsist.</h2>");
        }
    }
    
    $new_title = htmlspecialchars($_POST["title"]);
    $new_description = htmlspecialchars($_POST["description"]);

    $sql = "UPDATE videos SET v_title=?, v_desc=? WHERE v_id=?"; // limited to 20 for now

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $new_title, $new_description, $video_id);
    $stmt->execute();
    die(header("Location: /account/dashboard"));
}else if($_POST){
    echo "Something went wrong with your request.";
}else{
    echo "<!-- no delete requested -->";
}

echo "<br><button class='btn btn-danger' type='button' onclick='areYouSure(${video_id});'>Delete Video</button>";