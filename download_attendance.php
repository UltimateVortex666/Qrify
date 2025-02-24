<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event management");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Ensure event name is received
if (!isset($_GET["event_name"])) {
    die("Error: Missing event name parameter.");
}

$event_name = htmlspecialchars($_GET["event_name"]);

// Sanitize event name
$tableName = preg_replace('/\s+/', '_', trim($event_name));
$tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);

if (empty($tableName)) {
    die("Error: Invalid event name.");
}

// Check if table exists
$checkTableQuery = "SHOW TABLES LIKE '$tableName'";
$tableExists = $conn->query($checkTableQuery);

if ($tableExists->num_rows == 0) {
    die("Error: No attendance records found for event: $event_name.");
}

// Fetch data from the table
$sql = "SELECT id, student_id, DATE_FORMAT(scanned_time, '%Y-%m-%d %H:%i:%s') as scanned_time FROM `$tableName`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Set CSV file name based on event name
    $fileName = str_replace(' ', '_', $event_name) . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');

    $output = fopen("php://output", "w");

    // Fetch column names dynamically
    $columns = array();
    while ($field = $result->fetch_field()) {
        $columns[] = $field->name;
    }

    // Write column headers dynamically
    fputcsv($output, $columns);

    // Write rows from the database
    while ($row = $result->fetch_assoc()) {
        // Force scanned_time to be a text value by adding quotes
        $row["scanned_time"] = '"' . $row["scanned_time"] . '"';  
        fputcsv($output, $row);  // This will ensure scanned_time is treated as text in Excel
    }

    fclose($output);
} else {
    echo "No attendance records found.";
}

$conn->close();
?>
