<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event management");

// Check connection
if ($conn->connect_error) {
    die("Error: Database connection failed - " . $conn->connect_error);
}

// Ensure GET parameter is received
if (!isset($_GET["event_name"])) {
    die("Error: Missing event name parameter.");
}

$event_name = htmlspecialchars($_GET["event_name"]);

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

// Fetch attendance records
$sql = "SELECT student_id, scanned_time FROM `$tableName` ORDER BY scanned_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance for <?php echo htmlspecialchars($event_name); ?></title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 50%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Attendance for <?php echo htmlspecialchars($event_name); ?></h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Scanned Time</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["student_id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["scanned_time"]); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No attendance records found for this event.</p>
    <?php endif; ?>

    <br>
    <a href="Event1.php">Back to Home</a>
</body>
</html>

<?php
$conn->close();
?>
