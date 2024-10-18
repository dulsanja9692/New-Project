<?php
include 'connection.php';
session_start();

$message = []; // Initialize as an empty array

// Admin user setup (for example purpose, should run once or be handled separately)
$admin_email = 'admin@example.com';
$admin_password = 'password123'; // This is the plain text password
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

// Check if the admin user already exists
$check_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$admin_email'") or die('query failed');

if (mysqli_num_rows($check_admin) == 0) {
    // If not, insert the admin user into the database
    mysqli_query($conn, "INSERT INTO `users` (`name`, `email`, `password`, `user_type`) VALUES ('Admin Name', '$admin_email', '$hashed_password', 'admin')") or die('query failed');
}

// Register User (Only for demonstration; ideally should be a separate page)
if (isset($_POST['register-btn'])) {
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    // Check if user already exists
    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'Email already exists!';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`, `user_type`) VALUES ('$name','$email','$hashed_password', 'user')") or die('query failed');
        $message[] = 'Registered successfully';
        header('location:Login.php'); // Redirect to login after registration
        exit(); // Ensure no further code is executed after the header redirect
    }
}

// Admin Login
if (isset($_POST['login-btn'])) {
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_pannel.php'); // Redirect to admin panel
                exit();
            } else if ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php'); // Redirect to user index page
                exit();
            }
        } else {
            $message[] = 'Incorrect email or password';
        }
    } else {
        $message[] = 'User not found';
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
    <title>Login / Register Page</title>
</head>
<body>
    <section class="form-container">
        <form method="post">
            <h1>Login Now</h1>
            <div class="input-field">
                <label>Your Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-field">
                <label>Your Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <input type="submit" name="login-btn" value="Login Now" class="btn">
            
        </form>

        

        <?php 
        // Display messages
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
    </section>
</body>
</html>
