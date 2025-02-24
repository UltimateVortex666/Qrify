<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event management");

// Check connection
if ($conn->connect_error) {
    die("Error: Database connection failed - " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["event_name"])) {
    $event_name = htmlspecialchars($_POST["event_name"]);

    // Sanitize event name to match table name format
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

    // Get table structure
    $columnsQuery = "DESCRIBE `$tableName`";
    $columnsResult = $conn->query($columnsQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Event</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 50%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Select an Event to View Attendance</h2>
    <form method="POST">
        <label for="event_name">Enter Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>
        <button type="submit">Submit</button>
    </form>

    <?php if (isset($columnsResult) && $columnsResult->num_rows > 0): ?>
        <h3>Table Structure for Event: <?php echo htmlspecialchars($event_name); ?></h3>
        <table>
            <tr>
                <th>Column Name</th>
                <th>Data Type</th>
            </tr>
            <?php while ($column = $columnsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($column["Field"]); ?></td>
                    <td><?php echo htmlspecialchars($column["Type"]); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a href="viewAttendance.php?event_name=<?php echo urlencode($event_name); ?>">View Attendance Records</a>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
