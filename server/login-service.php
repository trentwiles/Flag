<?php

include "header.php";

if(isset($_POST["username"]) && $_POST["password"])
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
      $stmt->bind_param("s", $_POST["username"]);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
          if($row["username"] == "")
          {
              die(header("Location: /signup/"));
          }else{
            if(password_verify($_POST["password"], $row['password'])){
              $_SESSION["username"] = $row["username"];
              if(isset($_GET["to"]))
              {
                  die(header("Location: /" . $_GET["to"]));
              }else{
                die(header("Location: /account/home"));
              }
            }else{
              die(header("Location: /login/?badpassword=1"));
            }
          }
      }
  }else{
      die(header("Location: /signup/?nopasswordmatch=1"));
  }
}else{
    die(header("Location: /signup/"));
}