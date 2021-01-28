<?php 
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /"));
}

echo "<br><h1>Welcome back, " . $_SESSION["username"] . "!</h1>";
echo '<br><a href="/upload" class="btn btn-primary" type="button">Upload</a> <a href="/account/settings" class="btn btn-primary" type="button">Settings</a> <a href="/account/videos" class="btn btn-primary" type="button">Edit Videos</a> <a href="/account/live" class="btn btn-primary" type="button">Live Control Panel</a>';
