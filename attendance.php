<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event management");

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get event_name from URL and trim extra spaces
$event_name_from_url = isset($_GET['event_name']) ? urldecode(trim($_GET['event_name'])) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $emp_id = htmlspecialchars($_POST["emp_id"]);
    $event_name_typed = htmlspecialchars(trim($_POST["event_name"])); // Trim event name input
    $entered_code = trim($_POST["entered_code"]);  // Trim entered code

    // Debugging: Print both values to compare
    echo "<p>Debug: Event name from URL: " . htmlspecialchars($event_name_from_url) . "</p>";
    echo "<p>Debug: Event name typed: " . htmlspecialchars($event_name_typed) . "</p>";

    // Ensure typed event_name matches the one in the URL (case-insensitive)
    if (strcasecmp($event_name_typed, $event_name_from_url) !== 0) {
        echo "<h3 style='color:red;'>Error: Event name does not match. Access denied.</h3>";
        exit();
    }

    // Debugging: Checking event name in DB
    echo "<p>Debug: Checking event name in DB - " . htmlspecialchars($event_name_from_url) . "</p>";

    // Correct SQL Query - Ensure column name matches your database
    $stmt = $conn->prepare("SELECT entered_code FROM events WHERE TRIM(event_name) = ?");
    $stmt->bind_param("s", $event_name_from_url);
    $stmt->execute();
    $stmt->store_result();

    // Debugging: Check if the query returns any rows
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_code);
        $stmt->fetch();

        // Remove any extra spaces from stored code for better comparison
        $stored_code = trim($stored_code);

        echo "<p>Debug: Retrieved code from DB - " . htmlspecialchars($stored_code) . "</p>";

        // Compare entered code with stored code (case-insensitive)
        if (strcasecmp($entered_code, $stored_code) === 0) {
            // Insert attendance record
            $insert_stmt = $conn->prepare("INSERT INTO attendance (name, emp_id, event_name, code) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $name, $emp_id, $event_name_typed, $entered_code);

            if ($insert_stmt->execute()) {
                $event_name = htmlspecialchars($_POST["event_name"]);  // Get the event name from POST

                    // Redirect to qr_scanner.html with event_name as a query parameter
                    header("Location: qr scanner.html?event_name=" . urlencode($event_name));
                    exit(); 
            } else {
                echo "<h3>Error: " . $conn->error . "</h3>";
            }
            $insert_stmt->close();
        } else {
            echo "<h3 style='color:red;'>Error: Incorrect code entered. Access denied.</h3>";
        }
    } else {
        echo "<h3 style='color:red;'>Error: Event not found in database. Access denied.</h3>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Attendance Details</title>
</head>
<body>
    <h2>Mark Attendance for <span style="color:blue;"><?php echo htmlspecialchars($event_name_from_url); ?></span></h2>
    
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Employee ID:</label>
        <input type="text" name="emp_id" required><br>

        <label>Event Name:</label>
        <input type="text" name="event_name" required><br>

        <label>Enter Code:</label>
        <input type="text" name="entered_code" required><br>

        <button type="submit">Mark Attendance</button>
    </form>
</body>
</html>
