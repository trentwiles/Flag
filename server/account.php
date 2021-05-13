<?php
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /"));
}
?>
  <div class="container">
    <h1>Welcome back, <?php echo $_SESSION["username"] ?>!</h1>
    <a href="/upload" class="waves-effect waves-light btn">Upload Videos</a> <a href="/account/settings" class="waves-effect waves-light btn">Settings</a> <a href="/account/videos" class="waves-effect waves-light btn">Edit Videos</a> <a href="/account/live" class="waves-effect waves-light btn">Live Control Panel</a> <a href="/account/signout" class="waves-effect waves-light btn">Log Out</a>
  </div>

<?php
include "footer.php";
