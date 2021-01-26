<?php
include "header.php";

$val 

?>

<h1>Reset your password</h1>
<form action="/api/v1/reset" method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="username" class="required">Email</label>
    <input type="text" name="username" class="form-control" id="username" value='' placeholder="Username" required="required">
  </div>
  <div class="h-captcha" data-sitekey="80228737-9c23-4e37-a270-2cc47cca9fbe"></div>
  <input class="btn btn-primary btn-block" type="submit" value="Reset My Password">
</form>