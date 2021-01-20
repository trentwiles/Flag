<?php
session_start();

require "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable("/var/www/flag/");
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SESSION["username"] !== $_ENV["ADMIN"]){ die("bad request"); };

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
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql); 
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $mail->addBCC($_ENV["email"]);
    }
    
    $mail->isHTML(true);                                  // Set email format to HTML
    $prejson = fopen("email.json", "r") or die("Unable to open email config!");
    $decode = fread($prejson,filesize("email.json"));
    $content = json_decode($decode, true);
    $mail->Subject = $content["subject"] . " - Flag";
    $mail->Body    = $content["bodyHTML"];
    $mail->AltBody = $content["bodyTXT"];

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
