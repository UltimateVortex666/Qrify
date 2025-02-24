<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'event management';  // Adjust the database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['eventName'];
    $date = $_POST['eventDate'];
    $time = $_POST['eventTime'];
    $venue = $_POST['eventVenue'];
    $description = $_POST['eventDescription'];
    $entered_code = $_POST['entered_code'];
    
    // Check if the event name already exists
    $stmt_check = $conn->prepare("SELECT COUNT(*) FROM events WHERE event_name = ?");
    $stmt_check->bind_param("s", $name);
    $stmt_check->execute();
    $stmt_check->bind_result($event_count);
    $stmt_check->fetch();
    
    if ($event_count > 0) {
        // If the event already exists, return an error
        echo json_encode(["success" => false, "message" => "Event name already exists. Please choose another name."]);
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();
    
    // Proceed with inserting the event into the database
    $file = $_FILES['eventFile'] ?? null;
    $fileData = null;
    $fileName = null;
    
    if ($file && in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['csv', 'xls'])) {
        $fileData = file_get_contents($file['tmp_name']);
        $fileName = $file['name'];
    }
    
    $stmt = $conn->prepare("INSERT INTO events (event_name, date, time, venue, description, file, fileName, entered_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $date, $time, $venue, $description, $fileData, $fileName, $entered_code);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
    
    $stmt->close();
}

$conn->close();
?>
