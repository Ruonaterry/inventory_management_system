<?php
session_start();
include '../includes/db_connect.php';

$low_stock_query = "SELECT p.*, c.category_name, s.supplier_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.category_id 
                    LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id 
                    WHERE p.quantity <= p.reorder_level 
                    ORDER BY p.quantity ASC";
$low_stock_products = mysqli_query($conn, $low_stock_query);

$top_selling_query = "SELECT p.product_name, SUM(oi.quantity) as total_sold, SUM(oi.subtotal) as total_revenue
                      FROM order_items oi
                      JOIN products p ON oi.product_id = p.product_id
                      GROUP BY oi.product_id
                      ORDER BY total_sold DESC
                      LIMIT 10";
$top_selling = mysqli_query($conn, $top_selling_query);

$inventory_value_query = "SELECT c.category_name, COUNT(p.product_id) as product_count, 
                          SUM(p.quantity * p.price) as total_value
                          FROM products p
                          JOIN categories c ON p.category_id = c.category_id
                          GROUP BY p.category_id";
$inventory_value = mysqli_query($conn, $inventory_value_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
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
                <li><a href="suppliers.php">Suppliers</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="reports.php" class="active">Reports</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2 class="page-title">Reports & Analytics</h2>

            <div class="table-container" style="margin-bottom: 30px;">
                <div class="table-header">
                    <h3>🔴 Low Stock Alert Report</h3>
                    <button class="btn btn-primary" onclick="window.print()">Print Report</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Current Quantity</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($low_stock_products)): ?>
                        <tr>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['sku']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['supplier_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['reorder_level']; ?></td>
                            <td>
                                <?php
                                if ($row['quantity'] == 0) {
                                    echo '<span class="status out-of-stock">Out of Stock</span>';
                                } else {
                                    echo '<span class="status low-stock">Low Stock</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-container" style="margin-bottom: 30px;">
                <div class="table-header">
                    <h3>📊 Top Selling Products Report</h3>
                    <button class="btn btn-primary" onclick="window.print()">Print Report</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Product Name</th>
                            <th>Total Units Sold</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        while($row = mysqli_fetch_assoc($top_selling)): 
                        ?>
                        <tr>
                            <td><?php echo $rank++; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['total_sold']; ?></td>
                            <td>$<?php echo number_format($row['total_revenue'], 2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>💰 Inventory Value by Category Report</h3>
                    <button class="btn btn-primary" onclick="window.print()">Print Report</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Number of Products</th>
                            <th>Total Inventory Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_value = 0;
                        while($row = mysqli_fetch_assoc($inventory_value)): 
                            $total_value += $row['total_value'];
                        ?>
                        <tr>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['product_count']; ?></td>
                            <td>$<?php echo number_format($row['total_value'], 2); ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <tr style="font-weight: bold; background: #f8f9fa;">
                            <td colspan="2">TOTAL INVENTORY VALUE</td>
                            <td>$<?php echo number_format($total_value, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>
