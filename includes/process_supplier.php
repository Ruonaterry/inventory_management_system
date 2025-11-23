<?php
session_start();
include 'db_connect.php';

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == 'add') {
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $contact_person = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $sql = "INSERT INTO suppliers (supplier_name, contact_person, email, phone, address) 
            VALUES ('$supplier_name', '$contact_person', '$email', '$phone', '$address')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Supplier added successfully!';
        header('Location: ../pages/suppliers.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/suppliers.php');
    }
}

elseif ($action == 'update') {
    $supplier_id = $_POST['supplier_id'];
    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $contact_person = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $sql = "UPDATE suppliers SET 
            supplier_name = '$supplier_name',
            contact_person = '$contact_person',
            email = '$email',
            phone = '$phone',
            address = '$address'
            WHERE supplier_id = '$supplier_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Supplier updated successfully!';
        header('Location: ../pages/suppliers.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/suppliers.php');
    }
}

elseif ($action == 'delete') {
    $supplier_id = $_GET['id'];
    
    $sql = "DELETE FROM suppliers WHERE supplier_id = '$supplier_id'";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = 'Supplier deleted successfully!';
        header('Location: ../pages/suppliers.php');
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: ../pages/suppliers.php');
    }
}

mysqli_close($conn);
?>
