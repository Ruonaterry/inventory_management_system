<?php
session_start();
include 'db_connect.php';

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == 'add') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $reorder_level = $_POST['reorder_level'];
    $unit = mysqli_real_escape_string($conn, $_POST['unit']);
    
    $sql = "INSERT INTO products (product_name, sku, category_id, supplier_id, description, quantity, price, reorder_level, unit) 
            VALUES ('$product_name', '$sku', '$category_id', '$supplier_id', '$description', '$quantity', '$price', '$reorder_level', '$unit')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Product added successfully!';
        header('Location: ../pages/products.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/products.php');
    }
}

elseif ($action == 'update') {
    $product_id = $_POST['product_id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $reorder_level = $_POST['reorder_level'];
    $unit = mysqli_real_escape_string($conn, $_POST['unit']);
    
    $sql = "UPDATE products SET 
            product_name = '$product_name',
            sku = '$sku',
            category_id = '$category_id',
            supplier_id = '$supplier_id',
            description = '$description',
            quantity = '$quantity',
            price = '$price',
            reorder_level = '$reorder_level',
            unit = '$unit'
            WHERE product_id = '$product_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Product updated successfully!';
        header('Location: ../pages/products.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/products.php');
    }
}

elseif ($action == 'delete') {
    $product_id = $_GET['id'];
    
    $sql = "DELETE FROM products WHERE product_id = '$product_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Product deleted successfully!';
        header('Location: ../pages/products.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/products.php');
    }
}

mysqli_close($conn);
?>
