<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT image FROM clubs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imageData);

if ($stmt->fetch()) {
    header("Content-Type: image/jpeg");
    echo $imageData;
}

$stmt->close();
$conn->close();
?>
