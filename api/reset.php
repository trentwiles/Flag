<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header("Content-type: application/json");

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!$_POST["email"])
{
    $errors = array("message" => "Missing email param", "success" => "false");
    die(json_encode($errors, true));
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors = array("message" => "Invalid email", "success" => "false");
    die(json_encode($errors, true));
}

$sql = "INSERT INTO resets (`token`, `email`) VALUES (?, ?)";
$stmt = $conn->prepare($sql); 
$token = bin2hex(random_bytes(35));
$email = htmlspecialchars($_POST["email"]);
$stmt->bind_param("ss", $token, $email);
$stmt->execute();


$mail = new PHPMailer(true);



try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $_ENV["EMAIL_USERNAME"];                     // SMTP username
    $mail->Password   = $_ENV["EMAIL_PASSWORD"];                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    $mail->setFrom($_ENV["EMAIL_USERNAME"], $_ENV["NAME"]);
    $mail->addBCC($_POST["email"]);
    
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "Password Reset - Flag";
    $mail->Body    = "Hello, your password on <a href='https://flag.riverside.rocks'>Flag</a> was reset. Click <a href='https://flag.riverside.rocks/login/reset?token=${token}'>this link</a> to reset your password. If you didn't request this reset, you can safley ignore this email.";
    $mail->AltBody = "Hello, your password was reset on Flag. Click the link below to reset it. If you didn't request this reset, you can safley ignore this email. https://flag.riverside.rocks/login/reset?token=${token}";

    $mail->send();
} catch (Exception $e) {
    $errors = array(
        "success" => "false",
        "debug" => $mail->ErrorInfo,
        "message" => "Something went wrong when sending the email, please see the debug info.",
        "email_san" => $email
    );
    die(json_encode($errors, true));
    echo "Message could not be sent. Mailer Error: {}";
}

$errors = array(
    "success" => "true",
    "email_san" => $email
);
die(json_encode($errors, true));