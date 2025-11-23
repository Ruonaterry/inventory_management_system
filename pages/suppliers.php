<?php
session_start();
include '../includes/db_connect.php';

$suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY supplier_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Inventory Management System</h1>
            <div class="header-info">
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <span>Admin User</span>
                </div>
            </div>
        </div>

        <nav class="nav">
            <ul>
                <li><a href="../index.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="suppliers.php" class="active">Suppliers</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2 class="page-title">Suppliers Management</h2>

            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert success active" id="alert"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error active" id="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <h3 style="margin-bottom: 20px;">Add New Supplier</h3>
                <form id="supplierForm" method="POST" action="../includes/process_supplier.php">
                    <input type="hidden" name="supplier_id" id="supplier_id">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Supplier Name *</label>
                            <input type="text" name="supplier_name" id="supplier_name" required>
                        </div>
                        <div class="form-group">
                            <label>Contact Person *</label>
                            <input type="text" name="contact_person" id="contact_person" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="tel" name="phone" id="phone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" id="address"></textarea>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" name="action" value="add">Add Supplier</button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>All Suppliers</h3>
                    <input type="text" class="search-box" placeholder="Search suppliers..." id="searchBox">
                </div>
                <table id="suppliersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($suppliers)): ?>
                        <tr>
                            <td><?php echo $row['supplier_id']; ?></td>
                            <td><?php echo $row['supplier_name']; ?></td>
                            <td><?php echo $row['contact_person']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td>
                                <button class="action-btn edit" onclick='editSupplier(<?php echo json_encode($row); ?>)'>Edit</button>
                                <button class="action-btn delete" onclick="deleteSupplier(<?php echo $row['supplier_id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/suppliers.js"></script>
</body>
</html>
