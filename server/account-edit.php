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

//

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
    $cur_title = $row["v_title"];
    $cur_desc = $row["v_desc"];
    echo '<div class="form-group">';
    echo "<label for='title' class='required'>Title</label>";
    echo "<input type='text' class='form-control' id='title' placeholder='${cur_title}' required='required'>";
    echo "</div>";
    echo '<div class="form-group">';
    echo '<label for="description">Description</label>';
    echo "<textarea class='form-control' id='description' placeholder='${cur_desc}' required='required'>";
    echo "</div>";
    echo '<input class="btn btn-primary" type="submit" value="Submit"></form>';
    break;
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

    $sql = "SELECT * FROM videos WHERE v_id=?"; // limited to 20 for now

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $video_id);
    $stmt->execute();
}