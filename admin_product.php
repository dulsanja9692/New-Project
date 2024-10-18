<?php

include 'connection.php';
session_start();
$admin_id =$_SESSION['admin_name'];



if (!isset($_SESSION['admin_id'])) {
    header('location:Login.php');
    
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:Login.php');
    
}
//adding products to database
if(isset($_POST['add_product'])){
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $image = $_FILES['image']['name'];
    $image_size= $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder ='image/'.$image;

    $select_product_name =mysqli_query($conn, "SELECT name FROM products WHERE name ='$product_name'") or die('query failed');

    if(mysqli_num_rows($select_product_name)>0){
        $message[] = 'product name already exist';

    }else{
        $insert_product = mysqli_query($conn, "INSERT INTO products(name, price, product_detail, image)
VALUES('$product_name','$product_price','$product_detail', '$image')") or die ('query failed');
        if($insert_product){
            if($image_size > 2000000){
                $message[] = 'image size is too large';
            }else{
                move_iploaded_file($image_tmp_name,$image_folder);
                $message[]= 'product added successfully';
            }
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
    <title>Admin Panel</title>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <?php
    if(isset($message)){

        foreach($message as $message){
echo '
<div class= "message">
<span> '.$message.'</span>
<i class ="bi bi-x-circle" onclick ="this.parentElement.remove()"></i>
        </div>
        
        ';
        }
    }
    ?>
    <div class = "line2"></div>
    <section class = "add-products form-container">
        <form method = "POST" action = "" enctype = "multipart/form-data">
            <div class = "input field">
                <label>Product name</label>
                <input type = "text" name= "name" required>
</div>
<div class = "input field">
                <label>Product price</label>
                <input type = "text" name= "price" required>
</div>
<div class = "input field">
                <label>Product detail</label>
                
                <textarea name = "detail" required></textarea>
</div>
<div class = "input field">
                <label>Product image</label>
                <input type = "file" name= "image" accept= "image/jpg, image jpeg, image/png, image/webp" required>
</div>
<input type = "submit" name ="add_product" value= "add product" class = "btn">
</form>
</section>
<div class = "line3"></div>
<div class = "line4"></div>
<section class = "show-products">
    <div class = "box-container">
    <?php
            $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="box">
                        <img src="image/<?php echo $fetch_products['image']; ?>" alt="Product Image">
                        <p>Price: <?php echo $fetch_products['price']; ?></p>
                        <h4><?php echo $fetch_products['name']; ?></h4>
                        <details><?php echo $fetch_products['product_detail']; ?></details>
                        <a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">Edit</a>
                        <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="
                        return confirm('Want to Delete this product?')">Delete</a>
                    </div>
            <?php
                }
            } else {
                echo '<div class="empty">No products available</div>';
            }
            ?>
        </div>
    </section>
    <script type = "text/javascript" src = "script.js"></script>
</body>
</html>