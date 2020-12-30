<!DOCTYPE html>
<head>
    
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon-variables.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/js/halfmoon.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/281a5c53f1.js"></script>
</head>
<?php
if(isset($req))
{
  $api = json_decode(file_get_contents("https://flag.riverside.rocks/api/v1/videos?id=${req}"), true);
  $title = $api["details"]["title"];
  $desc = $api["details"]["description"];
  $thumb = $api["details"]["thumbnail"];
  $route = "watch/${req}";
}
echo "<title>";
    if(isset($title))
    {
        echo $title . " - Flag";
    }else{
        echo "Flag - Bite Size Videos";
    }
echo "    </title>";
if(isset($title) && isset($desc) && isset($thumb) && isset($route))
{
    echo "<meta name='title' content='${title} - Flag'>";
    echo "<meta name='description' content='${desc}'>";
    echo "<meta name='og:description' content='${desc}'>";
    echo "<meta name='og:title' content='${title}'>";
    echo "<meta name='twitter:title' content='${title}'>";
    echo "<meta name='twitter:description' content='${desc}'>";
    echo "<meta name='twitter:image' content='${thumb}'>";
    echo "<meta name='og:image' content='${thumb}'>";
    echo "<meta name='og:url' content='https://flag.riverside.rocks/${route}'>";
    echo "<meta name='twitter:url' content='https://flag.riverside.rocks/${route}'>";
}else{
    echo "<meta name='title' content='Flag'>";
    echo "<meta name='description' content='Bite size videos for the masses'>";
    echo "<meta name='og:description' content='Bite size videos for the masses'>";
    echo "<meta name='og:title' content='flag'>";
    echo "<meta name='twitter:title' content='flag'>";
    echo "<meta name='twitter:description' content='Bite size videos for the masses'>";
    echo "<meta name='twitter:image' content='https://cdn.riverside.rocks/a/begonia-botany-skipjack.png'>";
    echo "<meta name='og:image' content='https://cdn.riverside.rocks/a/begonia-botany-skipjack.png'>";
    echo "<meta name='og:url' content='https://flag.riverside.rocks'>";
    echo "<meta name='twitter:url' content='https://flag.riverside.rocks'>";
}
?>
<meta property="og:type" content="website">
<meta property="twitter:card" content="summary_large_image">

<body onload="halfmoon.toggleDarkMode()">
  <div class="page-wrapper with-navbar">
    <nav class="navbar">
      <div class="navbar-content">
          <!--

        <button class="btn btn-action" type="button">
          <i class="fa fa-bars" aria-hidden="true"></i>
          <span class="sr-only">Menu</span>
          
          -->

        </button>
      </div>
      <a href="/" class="navbar-brand">
        Flag
      </a>
      <span class="navbar-text text-monospace">Beta</span>
      <ul class="navbar-nav d-none d-md-flex">
        <li class="nav-item active">
          <a href="/top" class="nav-link">Top</a>
        </li>
        <li class="nav-item">
          <a href="/new" class="nav-link">New</a>
        </li>
      </ul>
      <?php
      if(!isset($_SESSION["username"]))
      {
          echo "<form class='form-inline d-none d-md-flex ml-auto' action='/signup' method='get'>";
          echo '<input type="text" name="username" class="form-control" placeholder="Create a username" required="required">';
          echo '<button class="btn btn-primary" type="submit">Sign up</button>';
          echo '</form>';
      }else{
        echo 
        "
        <li class='nav-item'>
          <a href='/account/home' class='nav-link'> " . $_SESSION["username"] . "</a>
        </li>
        ";
      }
      ?>
        
      <div class="navbar-content d-md-none ml-auto"> <!-- d-md-none = display: none on medium screens and up (width > 768px), ml-auto = margin-left: auto -->
        <div class="dropdown with-arrow">
          <button class="btn" data-toggle="dropdown" type="button" id="navbar-dropdown-toggle-btn-1">
            Menu
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right w-200" aria-labelledby="navbar-dropdown-toggle-btn-1"> <!-- w-200 = width: 20rem (200px) -->
            <a href="/top" class="dropdown-item">Top</a>
            <a href="/new" class="dropdown-item">New</a>
            <div class="dropdown-divider"></div>
            <div class="dropdown-content">
            <?php
            if(!isset($_SESSION["username"]))
            {
                echo "<form action='/signup' method='get'>";
                echo '<div class="form-group"><input type="text" class="form-control" placeholder="Create a username" required="required"></div>';
                echo '<button class="btn btn-primary btn-block" type="submit">Sign up</button>';
                echo '</form>';
            }else{
                echo 
                "
                <li class='nav-item'>
                <a href='/account/home' class='dropdown-item'> " . $_SESSION["username"] . "</a>
                </li>
                ";
            }
            ?>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="content-wrapper">
    <center>