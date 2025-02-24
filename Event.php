<?php include('server.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
   	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Event.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand navbar-logo" href="#">
            <img src="images/logo.png" alt="logo" height="70px" width="200px" class="logo-1">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
               <li class="nav-item"> <a class="nav-link" href="index.php" data-scroll-nav="0">Home</a> </li>
                <li class="nav-item"><a class="nav-link" href="#" data-scroll-nav="1">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-scroll-nav="2">Clubs</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-scroll-nav="3">Demo</a></li>
            </ul>
            <div class="d-flex">
                <a href="signup.php"><button class="btn btn-primary mr-2">Sign Up</button></a>
                <a href="login.php"><button class="btn btn-outline-secondary">Login</button></a>
            </div>
        </div>
    </div>
</nav>

#Event Form
<div class="form-group">
	<div class="Event-container">
		<form method="post" action="Event.php">
            <?php include('error.php'); ?>
            <?php
            if(isset($_SESSION['message']))
            {
            	echo"<h4>".$_SESSION['message']."</h4>";
            	unset($_SESSION['message']);
            }
            ?>
            <div class="form-group">
                <label> Name</label>
                <input type="text" name="Event Name" id="Event Name" placeholder="Enter your Event Name" required>
            </div>

            <div class="form-group">
                <label>Event Date</label>
                <input type="Date" name="dateForm" id="date">
            </div>

            <div class="form-group">
            	<label>"Event Time"</label>
            	<input type="Time" name="Time" id="Time">
            </div>

            <div class ="form-group">
            	<label>Event Venue</label>
            	<input type="Text" name="Event Venue" id="Event Venue" placeholder="Enter the Event venue" required>
            </div>

            <div class="form-group">
            	<label>Event Description</label>
            	<input type="Text" name="Event Description" id="Event Description" placeholder="Enter the Event description" >
            </div>

            <form action="code.php" method="POST" enctype="multipart/form-data">
            	<input type="file" name="import_file" class="form-control"/>
            	<button class="btn btn-primary mt-3">Import</button>
            </form>

            <div class="form-group">
            	<button type="submit" class="Button" name="Button">Submit</button>
            </div>

            <div class="social-login">
                    <img src="event_banner.png" alt="event" class="social-icon">
            </div>
	</div>
</form>

</div>
</body>
</html>