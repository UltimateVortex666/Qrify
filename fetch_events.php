<?php
$conn = new mysqli("localhost", "root", "", "event management");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current date & time
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Fetch upcoming events
$sql = "SELECT id, event_name AS title, date AS event_date, time AS event_time, venue, description FROM events
        WHERE date > '$current_date' OR (date = '$current_date' AND time > '$current_time')
        ORDER BY date, time 
        LIMIT 3";

$result = $conn->query($sql);
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

// Return JSON response
echo json_encode($events);
$conn->close();
?>
