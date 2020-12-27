<?php
include "header.php";

if(!isset($_SESSION["username"]))
{
    die(header("Location: /login"));
}

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["bio"]))
{
    $sql = "UPDATE `users` SET `bio`=? WHERE username=?";
    $stmt = $conn->prepare($sql); 
    $new_bio = htmlspecialchars($_POST["bio"]);
    $stmt->bind_param("ss", $new_bio, $_SESSION["username"]);
    $stmt->execute();
    die(header("Location: /account/"));
}


$storage = new \Upload\Storage\FileSystem('/var/www/drive1/cdn/profiles/');
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
            $sql = "UPDATE `users` SET `pfp`=? WHERE username=?";
            $stmt = $conn->prepare($sql); 
            $new_photo = "https://cdn.riverside.rocks/profiles/" . $file->getNameWithExtension();
            $stmt->bind_param("ss", $new_photo, $_SESSION["username"]);
            $stmt->execute();
            die(header("Location: /account/"));
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
        }
            
