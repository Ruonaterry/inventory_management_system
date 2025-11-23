<?php
session_start();
include 'includes/db_connect.php';

$total_products_query = "SELECT COUNT(*) as total FROM products";
$total_products = mysqli_fetch_assoc(mysqli_query($conn, $total_products_query))['total'];

$low_stock_query = "SELECT COUNT(*) as total FROM products WHERE quantity <= reorder_level";
$low_stock = mysqli_fetch_assoc(mysqli_query($conn, $low_stock_query))['total'];

$total_categories_query = "SELECT COUNT(*) as total FROM categories";
$total_categories = mysqli_fetch_assoc(mysqli_query($conn, $total_categories_query))['total'];

$total_suppliers_query = "SELECT COUNT(*) as total FROM suppliers";
$total_suppliers = mysqli_fetch_assoc(mysqli_query($conn, $total_suppliers_query))['total'];

$recent_products_query = "SELECT p.*, c.category_name, s.supplier_name 
                          FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.category_id 
                          LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id 
                          ORDER BY p.created_at DESC LIMIT 10";
$recent_products = mysqli_query($conn, $recent_products_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System - Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="pages/products.php">Products</a></li>
                <li><a href="pages/categories.php">Categories</a></li>
                <li><a href="pages/suppliers.php">Suppliers</a></li>
                <li><a href="pages/orders.php">Orders</a></li>
                <li><a href="pages/reports.php">Reports</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2 class="page-title">Dashboard Overview</h2>

            <div class="alert success" id="alert">
                <strong>Welcome!</strong> Your inventory system is up and running.
            </div>

            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Products</h3>
                    <div class="value"><?php echo $total_products; ?></div>
                    <div class="label">Items in inventory</div>
                </div>
                <div class="card">
                    <h3>Low Stock Items</h3>
                    <div class="value"><?php echo $low_stock; ?></div>
                    <div class="label">Need reordering</div>
                </div>
                <div class="card">
                    <h3>Categories</h3>
                    <div class="value"><?php echo $total_categories; ?></div>
                    <div class="label">Product categories</div>
                </div>
                <div class="card">
                    <h3>Suppliers</h3>
                    <div class="value"><?php echo $total_suppliers; ?></div>
                    <div class="label">Active suppliers</div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>Recent Products</h3>
                    <input type="text" class="search-box" placeholder="Search products..." id="searchBox">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($recent_products)): ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['supplier_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <?php
                                if ($row['quantity'] == 0) {
                                    echo '<span class="status out-of-stock">Out of Stock</span>';
                                } elseif ($row['quantity'] <= $row['reorder_level']) {
                                    echo '<span class="status low-stock">Low Stock</span>';
                                } else {
                                    echo '<span class="status in-stock">In Stock</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <button class="action-btn view" onclick='viewProduct(<?php echo json_encode($row); ?>)'>View</button>
                                <button class="action-btn edit" onclick="window.location.href='pages/products.php'">Edit</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Product Details</h2>
                <span class="close-modal" onclick="closeProductModal()">&times;</span>
            </div>
            <div id="productDetails" style="line-height: 1.8;">
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
