<?php include('server1.php') ?>
<?php 
session_start(); // Start the session to fetch user details

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

// Fetch user details from the session
$user_name = $_SESSION['user_name'];  // Assuming the user's name is stored in the session
$user_email = $_SESSION['user_email'];  // Assuming the user's email is stored in the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="Event.css"/>
    <title>Event Manager</title>
</head>
<body>
    <!--NavBar-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <button id="sidebarToggle" class="sidebar-toggle">☰</button>
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="logo" height="70px" width="200px" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index1.php" data-scroll-nav="0">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index1.php" data-scroll-nav="1">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index1.php" data-scroll-nav="2">Clubs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index1.php" data-scroll-nav="3">Demo</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="index1.php" data-scroll-nav="4">Feedback</a> </li>
                </ul>

                <div class="d-flex align-items-center ms-auto">
                    <!-- Profile Dropdown -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg text-black"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="px-4 py-3">
                                    <h6 class="text-muted mb-0">Logged in as</h6>
                                    <p class="mb-0"><?= htmlspecialchars($user_name) ?></p> <!-- Display user name -->
                                    <p class="text-muted small"><?= htmlspecialchars($user_email) ?></p> <!-- Display user email -->
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav> 

    <aside id="sidebar" class="sidebar">
        <h4><center>MENU</center></h4>
        <button class="btn sidebar-btn" onclick="toggleEventForm()">＋ Create Event</button>
        <button class="btn sidebar-btn" onclick="window.location.href='selectevent.php';">
    Attendance Details
            </button>
            <button class="btn sidebar-btn" onclick="window.location.href='qr.php';">
                Generate QR
            </button>
            <button class="btn sidebar-btn" onclick="window.location.href='event_selection.php';">
                Download Attendance
            </button>
    </aside>

    <!--Main Content-->
    <div class="banner-overlay">
        <img src="images/img.jpg" /> 
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Scheduled Events</h1>
        </div>

        <form id="eventForm" method="POST" enctype="multipart/form-data">
            <h2>Create New Event</h2>
            <div class="form-group">
                <label for="eventName">Event Name</label>
                <input type="text" name="eventName" id="eventName" required>
            </div>

            <div class="form-group">
                <label for="eventDate">Date</label>
                <input type="date" name="eventDate" id="eventDate" required>
            </div>

            <div class="form-group">
                <label for="eventTime">Time</label>
                <input type="time" name="eventTime" id="eventTime" required>
            </div>

            <div class="form-group">
                <label for="eventVenue">Venue</label>
                <input type="text" name="eventVenue" id="eventVenue" required>
            </div>

            <div class="form-group">
                <label for="eventDescription">Description</label>
                <textarea name="eventDescription" id="eventDescription" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="eventFile">Upload File</label>
                <input type="file" name="eventFile" id="eventFile" class="form-control" accept=".csv, .xls">
                <small class="form-text text-muted">Upload the registered student file (.csv, .xls only)</small>
            </div>

            
            <label>Random Code:</label>
        <span id="generated_code"></span><br>

        <input type="hidden" id="random_code" name="random_code">

        <label>Enter Code:</label>
        <input type="text" name="entered_code" class="entered_code" id="entered_code" required><br>
        <div class="form-group">
                <button type="submit" class="btn">Create</button>
                <button type="button" class="btn btn-danger" onclick="toggleEventForm()">Close</button>
            </div>

        </form>

        <div class="events-list" id="eventsList"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    // Toggle Sidebar
    function generateCode() {
        var code = Math.floor(10000000 + Math.random() * 90000000); // Random 8-digit number
        document.getElementById("generated_code").textContent = code;
        document.getElementById("random_code").value = code;
    }
    window.onload = generateCode;
    document.getElementById('sidebarToggle').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('active');
    });

    function toggleEventForm() {
        const eventForm = document.getElementById('eventForm');
        eventForm.style.display = eventForm.style.display === 'none' ? 'block' : 'none';
    }

    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this); // Capture form data

        fetch('server1.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Event created successfully!");
                window.location.reload(); // Refresh the page to clear form and show updates
            } else {
                alert("Error creating event.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while creating the event.");
        });
    });
</script>
</body>
</html>
