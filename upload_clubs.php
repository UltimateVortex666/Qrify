<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event management";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $category = $_POST["category"];

    // Handling the uploaded file
    $image = file_get_contents($_FILES['image']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO clubs (name, description, image, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssb", $name, $description, $image, $category);

    if ($stmt->execute()) {
        echo "Club added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
