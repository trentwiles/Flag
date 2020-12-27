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
              $sign_time = time();
              $sign_ip = $_SERVER['REMOTE_ADDR'];
              $new_id = base64_rand(24);
              $secure_pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
              $stmt = $conn->prepare("INSERT INTO users (username, `password`, signup_time, id, ip) VALUES (?, ?, ?, ?, ?)");
              $stmt->bind_param("ssiss", $prep_name, $secure_pass, $sign_time, $new_id, $sign_ip);
              $stmt->execute();
              $stmt->close();
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