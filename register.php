<?php
include 'connection.php';
session_start();

$message = []; // Initialize as an empty array

if (isset($_POST['Submit-btn'])) {
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
    $cpassword = mysqli_real_escape_string($conn, $filter_cpassword);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'User already exists';
    } else {
        if ($password != $cpassword) {
            $message[] = 'Passwords do not match';
        } else {
            mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$password')") or die('query failed');
            $message[] = 'Registered successfully';
            header('location:Login.php');
            exit(); // Ensure no further code is executed after the header redirect
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Register Page</title>
</head>
<body>
    <?php 
    if (isset($message) && is_array($message)) {
        foreach ($message as $msg) {
            echo '
                <div class="message">
                    <span>' . htmlspecialchars($msg) . '</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
            ';
        }
    }
    ?>
    <section class="form-container">
        <form method="post">
            <h1>Register Now</h1>
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="password" name="cpassword" placeholder="Confirm your password" required>
            <input type="submit" name="Submit-btn" value="Register now" class="btn">
            <p>Already have an account? <a href="userlogin.php">Login now</a></p>
            <p>Admin Login only  <a href="Login.php">  Admin Login now</a></p>
        </form>
    </section>
</body>
</html>
