<?php 
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /"));
}

echo "<br><h1>Welcome back, " . $_SESSION["username"] . "!</h1>";
echo '<br><a href="/upload"><button class="btn btn-primary" type="button">Upload</button></a><a href="/account/settings"><button class="btn btn-primary" type="button">Settings</button></a>';