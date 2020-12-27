<?php
include "header.php";

if(isset($_SESSION["username"]))
{
?>

<form method="post" class="w-400 mw-full">
  <div class="form-group">
    <label for="full-name" class="required">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="A neat video..." required="required">
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description" placeholder="Write a short description about yourself."></textarea>
  </div>
  <div class="form-group">
    <label for="vid" class="required">Pick Video (only mp4s supported, must be less than 15mb)</label>
    <div class="custom-file">
      <input type="file" id="foo" name="foo" required="required">
      <label for="foo">Choose video</label>
    </div>
  </div>
  <div class="form-group">
    <div class="custom-checkbox">
      <input type="checkbox" id="agree-to-terms" required="required">
      <label for="agree-to-terms">I agree to the <a href="https://riverside.rocks/legal" class="hyperlink">terms of service</a></label>
    </div>
  </div>

  <input class="btn btn-primary" type="submit" value="Upload">
</form>

<?php
}else{
?>

<h1>Sign in to upload videos and comment.</h1>

<?php
}