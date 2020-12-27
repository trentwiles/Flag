<?php 
include "header.php";

if(isset($_SESSION["username"]))
{
  die(header("Location: /account/home"));
}

$val = htmlspecialchars($_GET["username"]);

?>
<script src="/frontend/username.js"></script>
<script src="https://www.hCaptcha.com/1/api.js" async defer></script>
<h1>Create an account</h1>
<br>
<form method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="username" class="required">Username</label>
    <input type="text" name="username" class="form-control" id="username" <?php echo "value='${val}'"; ?> placeholder="Username" required="required">
    <div class="form-text">
      Only alphanumeric characters and numbers are allowed.
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="required">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="required">
  </div>
  <div class="form-group">
    <label for="confirm-password" class="required">Confirm password</label>
    <input type="password" name="password_conf" class="form-control" id="confirm-password" placeholder="Confirm password" required="required">
    <div class="form-text">
      Must match the above password exactly.
    </div>
  </div>
  <div class="h-captcha" data-sitekey="80228737-9c23-4e37-a270-2cc47cca9fbe"></div>
  <input class="btn btn-primary btn-block" type="submit" value="Sign up">
</form>

<?php

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
}

?>