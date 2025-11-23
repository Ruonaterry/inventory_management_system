<?php
session_start();
include 'db_connect.php';

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == 'add') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $category_code = mysqli_real_escape_string($conn, $_POST['category_code']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $sql = "INSERT INTO categories (category_name, category_code, description) 
            VALUES ('$category_name', '$category_code', '$description')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Category added successfully!';
        header('Location: ../pages/categories.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/categories.php');
    }
}

elseif ($action == 'update') {
    $category_id = $_POST['category_id'];
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $category_code = mysqli_real_escape_string($conn, $_POST['category_code']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $sql = "UPDATE categories SET 
            category_name = '$category_name',
            category_code = '$category_code',
            description = '$description'
            WHERE category_id = '$category_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Category updated successfully!';
        header('Location: ../pages/categories.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/categories.php');
    }
}

elseif ($action == 'delete') {
    $category_id = $_GET['id'];
    
    $sql = "DELETE FROM categories WHERE category_id = '$category_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Category deleted successfully!';
        header('Location: ../pages/categories.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/categories.php');
    }
}

mysqli_close($conn);
?>
