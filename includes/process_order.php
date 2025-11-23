<?php
session_start();
include 'db_connect.php';

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == 'add') {
    $customer_id = $_POST['customer_id'];
    $order_date = $_POST['order_date'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $payment_status = $_POST['payment_status'];
    
    $product_query = mysqli_query($conn, "SELECT price FROM products WHERE product_id = '$product_id'");
    $product = mysqli_fetch_assoc($product_query);
    $unit_price = $product['price'];
    $subtotal = $unit_price * $quantity;
    
    mysqli_begin_transaction($conn);
    
    try {
        $order_sql = "INSERT INTO orders (customer_id, order_date, total_amount, status, payment_status) 
                      VALUES ('$customer_id', '$order_date', '$subtotal', 'Pending', '$payment_status')";
        mysqli_query($conn, $order_sql);
        $order_id = mysqli_insert_id($conn);
        
        $order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal) 
                           VALUES ('$order_id', '$product_id', '$quantity', '$unit_price', '$subtotal')";
        mysqli_query($conn, $order_item_sql);
        
        $update_stock = "UPDATE products SET quantity = quantity - $quantity WHERE product_id = '$product_id'";
        mysqli_query($conn, $update_stock);
        
        mysqli_commit($conn);
        $_SESSION['message'] = 'Order created successfully!';
        header('Location: ../pages/orders.php');
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['error'] = 'Error: ' . $e->getMessage();
        header('Location: ../pages/orders.php');
    }
}

elseif ($action == 'update_status') {
    $order_id = $_GET['id'];
    $status = $_GET['status'];
    
    $sql = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Order status updated successfully!';
        header('Location: ../pages/orders.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/orders.php');
    }
}

mysqli_close($conn);
?>
