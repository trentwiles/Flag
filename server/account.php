<?php 
include "header.php";

if(! $_SESSION["username"])
{
    die(header("Location: /"));
}

echo "<br<h1>Welcome back, " . $_SESSION["username"] . "</h1>";