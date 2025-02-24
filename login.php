<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager - Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="login.css"/>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container"> <a class="navbar-brand navbar-logo" href="#"> <img src="images/logo.png" alt="logo" height="70px" width="200px" class="logo-1"> </a>
     
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item"> <a class="nav-link" href="index.php" data-scroll-nav="0">Home</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="1">About</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="2">Clubs</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#" data-scroll-nav="3">Demo</a> </li>
        </ul>
  
        <div class="d-flex" > <!-- d-flex makes it flexbox-->
          <a href="signup.php"><button class="btn btn-primary mr-2" >Sign Up</button></a>
          <a href="login.php"><button class="btn btn-outline-secondary" >Login</button></a>
        </div>
      </div>
      
    </div>
  </nav>
  <!-- End Navbar --> 
<!--Login form-->
<div class="login-bg">
  <div class="background"></div>
<div name="login-container"class="login-container">
    <h2>Login</h2>
    <form method="post" action="login.php">
      <?php include('error.php'); ?>
        <div class="input-group">
            <label >Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>
        
        <a class="forgot" href="#">Forgot Password?</a>
        <div class="input-group">
        <button type="submit" class="login-button" name="login-button">Sign In</button>
        </div>
        <div><br>
         <div class="continue"><center>Or Continue With</center></div>
          <div class="social-login">
            
          <script src="https://accounts.google.com/gsi/client" async defer></script>
    <div id="g_id_onload"
         data-client_id="767280440286-ngnkfttp5i2oddujomgefedcpld6smrr.apps.googleusercontent.com"
         data-callback="handleCredentialResponse">
    </div>
    <div class="g_id_signin" data-type="standard"></div>

    <script>
    function handleCredentialResponse(response) {
        fetch("google-login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "credential=" + response.credential
        })
        .then(() => {
            window.location.href = "Event1.php"; // Redirect to QR page after login
        });
    }
</script>

            
          </div>
          
        </div>
        
    </form>
    <div class="form-footer">
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
  </div>

</div>
</body>
</html>