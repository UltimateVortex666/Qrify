<?php
$servername = "localhost";  // Example: "localhost"
$username = "root";
$password = "";
$database = "event management";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
