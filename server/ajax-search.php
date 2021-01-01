<?php
header("Content-type: application/json");

$servername = $_ENV['MYSQL_SERVER'];
$username = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$dbname = $_ENV["MYSQL_DATABASE"];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$q = $_GET["q"];

if(! $q)
{
    $q = "the";
}


$sql = "SELECT v_title, v_id FROM videos WHERE v_title LIKE ?%";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $q);
$stmt->execute();
$result = $stmt->get_result();
$res = array();
$ids = array();
while ($row = $result->fetch_assoc()) {
    $fi = htmlspecialchars($row["v_title"]);
    $ida = htmlspecialchars($row["v_id"]);
    array_push($res, $fi);
    array_push($ids, $ida);
}

$final = array(
    "results" => $res,
    "ids" => $ids
);

echo json_encode($final, true);