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

?>

<h1>Custom Thumbnail</h1>

<form method="post" class="w-400 mw-full" enctype="multipart/form-data">
<div class="form-group">
    <label for="picture" class="required">Custom Thumbnail</label>
    <div class="custom-file">
      <input type="file" id="foo" name="foo" required="required">
      <label for="foo">Choose picture</label>
    </div>
  </div>
  <input class="btn btn-primary" type="submit" value="Submit">
</form>

<?php

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
}else if(isset($_POST)){
    $storage = new \Upload\Storage\FileSystem('/var/www/drive1/cdn/flag/');
    $file = new \Upload\File('foo', $storage);

    $names = json_decode(file_get_contents("https://friendlywords.eddiestech.co.uk/.netlify/functions/words/objects"), true);


    $new_filename = $names[0] . "-" . $names[1] . "-" . $names[2];
    $file->setName($new_filename);

    $file->addValidations(array(

    new \Upload\Validation\Mimetype(array('image/png', 'image/jpg', 'image/jpeg')),

    new \Upload\Validation\Size('5M')
        ));

        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        // Try to upload file
        try {
            $file->upload();
            $sql = "UPDATE `videos` SET `v_thumb`=? WHERE v_id=?";
            $stmt = $conn->prepare($sql); 
            $new_photo = "https://cdn.riverside.rocks/flag/" . $file->getNameWithExtension();
            $stmt->bind_param("ss", $new_photo, $video_id);
            $stmt->execute();
            die(header("Location: /watch/${video_id}"));
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
        }
}

echo "<br><button class='btn btn-danger' type='button' onclick='areYouSure(${video_id});'>Delete Video</button>";