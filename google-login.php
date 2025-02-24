<?php
// Start session
session_start();

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event management";  // Replace with your actual database name

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
    echo "Invalid Token! Login Failed.";
    exit();
}

// Extract User Data
$email = $userData['email'];

// Check if Email Exists in the 'users' table
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, login successfully
    $user = $result->fetch_assoc();
    
    //  Store user session
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $user['name']; // Assuming you want to store the user's name as well

    // Redirect to Event1.php after successful login
    header("Location: Event1.php");
    exit();
} else {
    echo "Access Denied! Email not registered.";
}

$conn->close();
?>
