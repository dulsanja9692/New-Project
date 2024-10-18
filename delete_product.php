<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product image from the server
    $select_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$product_id'") or die('Query Failed');
    $fetch_image = mysqli_fetch_assoc($select_image);
    $image_path = 'product_images/' . $fetch_image['image'];
    unlink($image_path);  // Delete the image file

    // Delete the product from the database
    $delete_product = mysqli_query($conn, "DELETE FROM `products` WHERE id = '$product_id'") or die('Query Failed');

    if ($delete_product) {
        echo "<script>alert('Product deleted successfully'); window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Failed to delete product'); window.location.href = 'admin.php';</script>";
    }
}
?>
