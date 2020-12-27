<?php 
include "header.php";

if(isset($_SESSION["username"]))
{
  die(header("Location: /account/home"));
}

?>

<form method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="username" class="required">Username</label>
    <input type="text" class="form-control" id="username" placeholder="Username" required="required">
    <div class="form-text">
      Only alphanumeric characters and numbers are allowed.
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="required">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Password" required="required">
  </div>
  <div class="form-group">
    <label for="confirm-password" class="required">Confirm password</label>
    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm password" required="required">
    <div class="form-text">
      Must match the above password exactly.
    </div>
  </div>
  <input class="btn btn-primary btn-block" type="submit" value="Sign up">
</form>