<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event management");

// Check connection
if ($conn->connect_error) {
    die("Error: Database connection failed - " . $conn->connect_error);
}

// Ensure POST parameters are received
if (!isset($_POST["student_id"]) || !isset($_POST["event_name"])) {
    die("Error: Missing required parameters. student_id or event_name is not set.");
}

$student_id = htmlspecialchars($_POST["student_id"]);
$event_name = htmlspecialchars($_POST["event_name"]);

// Sanitize event name to be a valid table name
$tableName = preg_replace('/\s+/', '_', trim($event_name)); 
$tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName); 

if (empty($tableName)) {
    die("Error: Invalid event name. Table creation failed.");
}

// Ensure the event name exists in the events table
$stmt_check_event = $conn->prepare("SELECT * FROM events WHERE event_name = ?");
$stmt_check_event->bind_param("s", $event_name);
$stmt_check_event->execute();
$stmt_check_event->store_result();

if ($stmt_check_event->num_rows == 0) {
    die("Error: Event not found in database. Please check the event name.");
}

$stmt_check_event->close();

// Ensure the table exists (Create if not exists)
$createTableQuery = "CREATE TABLE IF NOT EXISTS `$tableName` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    scanned_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($createTableQuery)) {
    die("Error: Could not create table - " . $conn->error);
}

// Check if student ID already exists in the event-specific table
$checkQuery = "SELECT * FROM `$tableName` WHERE student_id='$student_id'";
$result = $conn->query($checkQuery);

if (!$result) {
    die("Error: Checking records failed - " . $conn->error);
}

if ($result->num_rows == 0) {
    // Insert scanned details into the event-specific table
    $sql = "INSERT INTO `$tableName` (student_id) VALUES ('$student_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Attendance marked successfully for event: $event_name!";
    } else {
        die("Error: Could not insert data - " . $conn->error);
    }
} else {
    echo "Attendance marked successfully for this student in $event_name.";
}

$conn->close();
?>
