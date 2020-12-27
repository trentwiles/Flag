<?php
include "header.php";



if(isset($_SESSION["username"]))
{
    $data = array(
    'secret' => $_ENV["CAPTCHA"],
    'response' => $_POST['h-captcha-response']
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $responseData = json_decode($response, true);
    if($responseData["success"]) {
        $storage = new \Upload\Storage\FileSystem('/var/www/drive1/cdn/flag/');
        $file = new \Upload\File('foo', $storage);

        $names = json_decode(file_get_contents("https://friendlywords.eddiestech.co.uk/.netlify/functions/words/objects"), true);


        $new_filename = $names[0] . "-" . $names[1] . "-" . $names[2];
        $file->setName($new_filename);

        $file->addValidations(array(

            new \Upload\Validation\Mimetype(array('video/mp4')),

            new \Upload\Validation\Size('15M')
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
                    $v_title = htmlspecialchars($_POST["title"]);
                    if(! $_POST["description"])
                    {
                        $_POST["description"] = "A neat video.";
                    }
                    $v_desc = htmlspecialchars($_POST["description"]);
                    $v_size = $file->getSize();
                    $v_id = rand();
                    $v_url = "https://cdn.riverside.rocks/flag/" . $file->getNameWithExtension();
                    $v_len = 0;
                    $v_uploader = htmlspecialchars($_SESSION["username"]);
                    $v_thumb = "https://cdn.riverside.rocks/a/printer-turnip-shoemaker.png";
                    $v_time = time();
                    // Success!
                    $file->upload();
                    $servername = $_ENV['MYSQL_SERVER'];
                    $username = $_ENV["MYSQL_USERNAME"];
                    $password = $_ENV["MYSQL_PASSWORD"];
                    $dbname = $_ENV["MYSQL_DATABASE"];

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "INSERT INTO videos (v_title, v_desc, v_size, v_url, v_id, v_len, v_uploader, v_thumb, v_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("ssississi", $v_title, $v_desc, $v_size, $v_url, $v_id, $v_len, $v_uploader, $v_thumb, $v_time);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $sql = "INSERT INTO stat (id, views, likes, dislikes, commments) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql); 
                    $stmt->bind_param("siiis", $v_id, 0, 0, 0, "{}");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    die(header("Location: /watch/${v_id}"));
                } catch (\Exception $e) {
                    // Fail!
                    $errors = $file->getErrors();
                }
            }
}