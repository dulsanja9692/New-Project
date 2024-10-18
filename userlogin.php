<?php
include 'connection.php'; // Make sure this file connects to your database
session_start();

$message = []; // Initialize message array for feedback

// User Login
if (isset($_POST['login-btn'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    // Query to select the user
    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];

            // Redirect to user index page
            header('Location: Index.php'); // Make sure Index.php exists
            exit(); // Ensure no further code is executed after redirect
        } else {
            $message[] = 'Incorrect email or password'; // Add message if password is wrong
        }
    } else {
        $message[] = 'User not found'; // Add message if user is not found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="userlogincss.css">
    <title>User Login</title>
</head>
<body>
<div class="login-container">
    <h1>User Login</h1>
    <?php if (!empty($message)) {
        foreach ($message as $msg) {
            echo "<p style='color: red;'>$msg</p>"; // Display any messages
        }
    } ?>
    <form method="post" action="">
        <input type="text" name="email" placeholder="Enter email" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <button type="submit" name="login-btn">Login</button>
    </form>
</div>
</body>
</html>
