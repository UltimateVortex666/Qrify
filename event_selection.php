<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["event_name"])) {
    $event_name = htmlspecialchars($_POST["event_name"]);

    // Sanitize event name to match table format
    $tableName = preg_replace('/\s+/', '_', trim($event_name));
    $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);

    if (!empty($tableName)) {
        header("Location: download_attendance.php?event_name=" . urlencode($tableName));
        exit();
    } else {
        echo "<script>alert('Invalid event name. Please enter a valid name.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Event</title>
</head>
<body>
    <h2>Select an Event to Download Attendance</h2>
    <form method="POST">
        <label for="event_name">Enter Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>
        <button type="submit">Proceed</button>
    </form>
</body>
</html>
