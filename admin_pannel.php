<?php
// Start session and include database connection
include 'connection.php';
session_start();

// Check if the admin is logged in, redirect if not
if (!isset($_SESSION['admin_name'])) {
    header('location:adminlogin.php');
    exit();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header('location:adminlogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Panel</title>
</head>
<body>
<?php include 'admin_header.php'; ?>

<div class="line4"></div>
<section class="dashboard">
    <div class="box-container">
        <div class="box">
            <?php 
            // Total pending orders
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'pending'") or die('Query Failed');
            while($fetch_pending = mysqli_fetch_assoc($select_pendings)){
                $total_pendings += $fetch_pending['total_price'];
            }
            ?>
            <h3>$<?php echo $total_pendings; ?>/-</h3>
            <p>Total Pendings</p>
        </div>

        <div class="box">
            <?php 
            // Total completed orders
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'completed'") or die('Query Failed');
            while($fetch_completes = mysqli_fetch_assoc($select_completes)){
                $total_completes += $fetch_completes['total_price'];
            }
            ?>
            <h3>$<?php echo $total_completes; ?>/-</h3>
            <p>Total Completes</p>
        </div>

        <div class="box">
            <?php 
            // Number of orders placed
            $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('Query Failed');
            $num_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $num_of_orders; ?></h3>
            <p>Orders Placed</p>
        </div>

        <div class="box">
            <?php 
            // Number of products added
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query Failed');
            $num_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $num_of_products; ?></h3>
            <p>Products Added</p>
        </div>

        <div class="box">
            <?php 
            // Number of normal users
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('Query Failed');
            $num_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $num_of_users; ?></h3>
            <p>Total Normal Users</p>
        </div>

        <div class="box">
            <?php 
            // Number of admins
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('Query Failed');
            $num_of_admins = mysqli_num_rows($select_admins);
            ?>
            <h3><?php echo $num_of_admins; ?></h3>
            <p>Total Admins</p>
        </div>

        <div class="box">
            <?php 
            // Total registered users
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('Query Failed');
            $num_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $num_of_users; ?></h3>
            <p>Total Registered Users</p>
        </div>

        <div class="box">
            <?php 
            // Number of messages
            $select_message = mysqli_query($conn, "SELECT * FROM `messages`") or die('Query Failed');
            $num_of_message = mysqli_num_rows($select_message);
            ?>
            <h3><?php echo $num_of_message; ?></h3>
            <p>New Messages</p>
        </div>
    </div>
</section>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
