<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event management";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Fetch user data based on the email address (common for both Google and normal logins)
    $user_email = $_SESSION['email'];

    // Check if the email exists in the 'users' table (Google login)
    $sql = "SELECT name, email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Google sign-in user found
        $user = $result->fetch_assoc();
        $user_name = $user['name'];
        $user = $user['email'];
    } else {
        // If not found in 'users' table, check in the 'registration' table (normal login)
        $sql = "SELECT username, email FROM registration WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Normal user found
            $user = $result->fetch_assoc();
            $user_name = $user['username'];
            $user_email = $user['email'];
        } else {
            // If the email is not found in both tables, redirect to login page
            header('Location: login.php');
            exit();
        }
    }
} else {
    // If no user is logged in, redirect to login page
    header('Location: login.php');
    exit();
}

$conn->close();
?>

<!-- Profile Dropdown HTML -->
<ul class="dropdown-menu dropdown-menu-end">
    <li>
        <div class="px-4 py-3">
            <h6 class="text-muted mb-0">Logged in as</h6>
            <p class="mb-0"><?= htmlspecialchars($user_name) ?></p>
            <p class="text-muted small"><?= htmlspecialchars($user_email) ?></p>
        </div>
    </li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
</ul>
