<?php
include "header.php";

if(isset($_SESSION["username"]))
{
?>
<script src="https://www.hCaptcha.com/1/api.js" async defer></script>

<form class="container" method="post" enctype="multipart/form-data">
  <h1>Upload Video</h1>
  <br>
  <div>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" placeholder="A neat video..." required>
  </div>
  <div>
    <label for="title">Description</label>
    <textarea class="materialize-textarea" id="description" name="description" placeholder="Very cool video i made!"></textarea>
  </div>
  <div class="file-field input-field">
    <div class="btn">
      <span>Video</span>
      <input type="file" id="foo" name="foo">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text">
    </div>
  </div>
  <div>
    <label>
      <input type="checkbox" id="agree-to-terms" name="agree-to-terms">
      <span>I agree to our <a href="/legal.php/privacy">primacy policy</a> and our <a href="/legal/tos">terms and conditions</a></span>
    </label>
  </div>
  <div class="h-captcha" data-sitekey="80228737-9c23-4e37-a270-2cc47cca9fbe"></div>
  <button type="submit" name="button" class="waves-effect waves-light btn">Upload</button>
</form>

<?php
}else{
?>

<h1>Sign in to upload videos and comment.</h1>

<?php
}

include "footer.php";
