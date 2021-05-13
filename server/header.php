<?php
if ($_ENV["DEBUG"] == "true") {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
} else {
  ini_set('display_errors', 0);
  ini_set('display_startup_errors', 0);
}
?>
<!DOCTYPE html>
<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/frontend/resource.js"></script>
	<script type="text/javascript">
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//analytics.riverside.rocks/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
    <!--<link href="/css/lol.css" rel="stylesheet" />-->
    <!-- <script src="https://cdn.jsdelivr.net/gh/DerDer56/defresh/defresh.js"></script> -->
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
echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
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
    <nav class="nav-wrapper">
      <a href="/" class="brand-logo">Flag</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="/">Home</a></li>
        <li><a href="/top">Top</a></li>
        <li><a href="/new">New</a></li>
        <?php
        if(!isset($_SESSION["username"])) {
            echo "<li><a href='/login' class='waves-effect waves-light btn'>Login</a></li>";
        }else{
          echo
          "<li><a href='/account/home' class='nav-link'> " . $_SESSION["username"] . "</a></li>";
        }
        ?>
      </ul>
    </nav>
<?php
$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!$_SESSION["username"])
{
    echo "<!-- user is not signed in -->";
    $not_signed_in = "true";
}else{
    $sql = "SELECT * FROM bans WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        if(isset($row["reason"]))
        {
            die("<br><h1>Account Suspended</h1><br><p>" . htmlspecialchars($row["reason"]) . "</p><a href='mailto:support@riverside.rocks' class='btn btn-secondary' type='button'>Appeal</button><br /><br /><a href='/account/signout' class='btn btn-primary' type='button'>Log out</button>");
        }else{
            echo "<!-- not suspended -->";
        }
    }
}

echo "<script>";
$u = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
$pre = get_browser($u);
$h = htmlspecialchars($pre->browser);
$o = htmlspecialchars($pre->platform);
$i = htmlspecialchars($_SERVER['REMOTE_ADDR']);
$c = htmlspecialchars($_SERVER["HTTP_CF_IPCOUNTRY"]);
$t = time();
if(!isset($not_signed_in))
{
  $a = $_SESSION["username"];
}else{
  $a = '0';
}
echo "

$( document ).ready(function() {
  setInterval(send('${u}', '${h}', '${o}', '${i}', '${c}', '${t}', '${a}'), 6000);
});

<!-- @${t} -->

</script>
";
