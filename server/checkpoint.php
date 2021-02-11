<?php

/*

Service to prevent scraping/malicous traffic w/ abuseipdb

*/
?>
<html>
<head><meta http-equiv="content-type" content="text/html; charset=utf-8"><meta name="viewport" content="initial-scale=1"><title>Checkpoint</title></head>
<body style="font-family: arial, sans-serif; background-color: #fff; color: #000; padding:20px; font-size:18px;" onload="e=document.getElementById('captcha');if(e){e.focus();}">
<div style="max-width:400px;">
  <script src="https://www.hCaptcha.com/1/api.js" async defer></script>
  <div class="h-captcha" data-sitekey="80228737-9c23-4e37-a270-2cc47cca9fbe"></div>
<hr noshade size="1" style="color:#ccc; background-color:#ccc;"><br>
<div style="font-size:13px;">
Our systems have detected unusual traffic from your IP address (<?php htmlspecialchars($_SERVER['HTTP_CF_CONNECTING_IP']); ?>).  Please try your request again later. <br><br>


IP address: <?php htmlspecialchars($_SERVER['HTTP_CF_CONNECTING_IP']); ?><br>Time: <?php echo htmlspecialchars(time()); ?><br> <?php "Request Error ID: " . random_bytes(hex2bin()); ?>
</div>
</div>
</body>
</html>