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
      if (!preg_match('/[^A-Za-z0-9]/', $_POST["username"])){
        if(strlen($_POST["username"]) > 20)
        {
          die(header("Location: /signup/?longusername=1"));
        }else{
          $prep_name = htmlspecialchars($_POST["username"]);
          if(strlen($_POST["password"]) > 80)
          {
            die(header("Location: /signup/?longpassword=1"));
          }else{
            if($_POST["password"] == $_POST["password_conf"])
            {
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
                        die(header("Location: /signup/?username_taken=1"));
                    }
                }
              $sign_time = time();
              $sign_ip = $_SERVER['REMOTE_ADDR'];
              $new_id = rand();
              $san_email = htmlspecialchars($_POST["email"]);
              $secure_pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
              $stmt = $conn->prepare("INSERT INTO users (username, `password`, email, signup_time, id, ip, bio) VALUES (?, ?, ?, ?, ?, ?)");
              $cbio = "A fine user!";
              $stmt->bind_param("sssisss", $prep_name, $secure_pass, $san_email, $sign_time, $new_id, $sign_ip, $cbio);
              $stmt->execute();
              $stmt->close();
              $_SESSION["username"] = $prep_name;
              if(isset($_GET["to"]))
              {
                  die(header("Location: /" . $_GET["to"]));
              }else{
                die(header("Location: /account/home"));
              }
              die();
            }else{
                die(header("Location: /signup/?nopasswordmatch=1"));
            }
          }
        }
      }else{
        die(header("Location: /signup/?badusername=1"));
      }
    } 
    else {
        // Signup fails
    }
}else{
    die(header("Location: /signup/"));
}