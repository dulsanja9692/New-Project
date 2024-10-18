<?php
session_start();
include 'connection.php'; // Your database connection file

// Check if the admin is logged in
if (!isset($_SESSION['admin_name'])) {
    header('location:Login.php'); // Redirect to login if not logged in
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('location:Login.php'); // Redirect to login after logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icon@1.9.1/font/bootstrap-icons.css">
    <title>Admin Dashboard</title>
</head>
<body>

<!-- Menu Bar -->
<div class="menu-bar">
    <button onclick="window.location.href='index.php'">Home</button>
    <button onclick="window.location.href='Products.php'">Products</button>
    <button onclick="window.location.href='aboutus.php'">About Us</button>
    <button onclick="window.location.href='MyOrders.php'">My Orders</button>
    <button onclick="window.location.href=''">Messages</button>
</div>

<header class="header"> 

    <div class="flex">
        <a href="admin_dashboard.php" class="logo"><img src="9.png" alt="Logo"></a>
        <nav class="navbar">
            <a href="admin_pannel.php">Home</a>
            <a href="admin_product.php">Products</a>
            <a href="aboutus.php">Orders</a>
            <a href="MyOrders.php">Users</a>
            <a href="admin_message.php">Messages</a>
        </nav>
        <div class = "icons">
            <i class = "bi bi-person" id= "user-btn"></i>
            <i class = "bi bi-list" id= "menu-btn"></i>
</div>
        <div class="user-box">
            <p>Username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>Email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
            
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">Log Out</button>
            </form>
        </div>
    </div>
</header>

<div class="banner">
    <div class = "detail">
    <h1>Admin Dashboard</h1>
    <p>Welcome to the Clothing Shop Admin Panel! Here, you can manage products, track orders, and handle customer accounts.</p>
</div>
</div>

<div class="line"></div>

</body>
</html>
