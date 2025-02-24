<?php
session_start();

// Initialize variables
$emp_id = "";
$username = "";
$email = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'event management'); // Adjust as needed

// REGISTER USER
if (isset($_POST['signup-button'])) {
    // Receive all input values from the form
    $emp_id = mysqli_real_escape_string($db, $_POST['emp_id']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);

    // Form validation
    if (empty($emp_id)) { array_push($errors, "Employee ID is required"); }
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { 
        array_push($errors, "Email is required"); 
    } elseif (!str_ends_with($email, '@vitbhopal.ac.in')) {
        array_push($errors, "Only emails ending with @vitbhopal.ac.in are allowed");
    }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $confirm_password) { 
        array_push($errors, "The two passwords do not match");
    }

    // Check if the email or username already exists
    $user_check_query = "SELECT * FROM registration WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // If user exists
        if ($user['username'] === $username) { array_push($errors, "Username already exists"); }
        if ($user['email'] === $email) { array_push($errors, "Email already exists"); }
    }

    // Register user if no errors
    if (count($errors) == 0) {
        // Encrypt password before saving
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        // Insert user into the registration table
        $query = "INSERT INTO registration (emp_id, username, email, password) 
                  VALUES('$emp_id', '$username', '$email', '$password')";
        mysqli_query($db, $query);

        // Store user data in session and redirect
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: login.php');
    }
}

// LOGIN USER
if (isset($_POST['login-button'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Form validation
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password)) { array_push($errors, "Password is required"); }

    // Check if no errors, then proceed with authentication
    if (count($errors) == 0) {
        // Query to check if email exists in the registration table
        $query = "SELECT * FROM registration WHERE email='$email' LIMIT 1";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user details in session
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $user['username']; // Assuming username is stored in the registration table
                $_SESSION['success'] = "You are now logged in";

                // Check if the user already exists in the login table
                $query2 = "SELECT * FROM login WHERE email='$email'";
                $results1 = mysqli_query($db, $query2);

                if (mysqli_num_rows($results1) == 1) {
                    // User exists in the login table, redirect to Event1.php
                    header('location: Event1.php');
                } else {
                    // Insert user into the login table
                    $query1 = "INSERT INTO login (email, password) 
                               VALUES('$email', '$password')";
                    mysqli_query($db, $query1);
                    header('location: Event1.php');
                }
            } else {
                // Incorrect password
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            // Email not found
            array_push($errors, "User not found");
        }
    }
}

?>
