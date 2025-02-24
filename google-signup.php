<?php
// Database Connection
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "event management";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Get Google Token from Frontend
$token = $_POST['credential'];

// Decode Google Token
function decodeGoogleToken($token) {
    $keys = json_decode(file_get_contents("https://www.googleapis.com/oauth2/v3/certs"), true);
    $tokenParts = explode(".", $token);
    if (count($tokenParts) !== 3) {
        return false;
    }
    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[1])), true);
    return $payload;
}

$userData = decodeGoogleToken($token);
if (!$userData) {
    echo "Invalid Token! Signup Failed.";
    exit();
}

// Extract User Data
$google_id = $userData['sub'];
$name = $userData['name'];
$email = $userData['email'];

// Check if email ends with "@vitbhopal.ac.in"
if (!preg_match("/@vitbhopal\.ac\.in$/", $email)) {
    echo "Signup failed! Only VIT Bhopal email addresses are allowed.";
    exit();
}

// Insert into Database
$sql = "INSERT INTO users (google_id, name, email) VALUES ('$google_id', '$name', '$email')
        ON DUPLICATE KEY UPDATE google_id='$google_id', name='$name'";

if ($conn->query($sql) === TRUE) {
    echo "Signup successful!"; // Return a success message to the frontend
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
