<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'event management';  // Adjust the database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date and time
$current_date = date('Y-m-d');
$current_time = date('H:i:s');

// Fetch upcoming events from the 'events' table
$sql = "SELECT * FROM events 
        WHERE date > '$current_date' OR (date = '$current_date' AND time > '$current_time') 
        ORDER BY date, time 
        LIMIT 3";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Build the event data array
        $event = [
            'id' => $row['id'],
            'name' => $row['name'],
            'date' => $row['date'],
            'time' => $row['time'],
            'venue' => $row['venue'],
            'description' => $row['description'],
            'fileName' => $row['fileName'],
            'fileUrl' => $row['file'] ? "download_file.php?id=" . $row['id'] : null  // Generate download URL
        ];
        $events[] = $event;
    }
}

// Return events as JSON
header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>
