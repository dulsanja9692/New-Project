<?php
include 'connection.php';
session_start();

$message = []; // Initialize as an empty array

if (isset($_POST['Submit-btn'])) {
  

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    
    $select_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('query failed');
    

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);
        if($row['user_type']== 'admin'){
             $_SESSION['admin_name'] = $row['name'];
             $_SESSION['admin_email'] = $row['email'];
             $_SESSION['admin_id'] = $row['id'];
             header('location:admin_pannel.php');
             
        }else {
            $message[] = 'incorrect email or password';
        }
        {
            mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$password')") or die('query failed');
            $message[] = 'Registered successfully';
            header('location:index.php');
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
    <link rel="stylesheet" href="adminlogincss.css">
    <title>Login</title>
</head>
<body>
<div class="login-container">
    <h1>Admin Login</h1>
    <?php if (isset($error_message)) echo "<p style='color: red;'>$error_message</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Enter username" required>
        <input type="password" name="password" placeholder="Enter password" required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>