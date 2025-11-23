<?php
session_start();
include '../includes/db_connect.php';

$orders_query = "SELECT o.*, c.customer_name, c.email 
                 FROM orders o 
                 LEFT JOIN customers c ON o.customer_id = c.customer_id 
                 ORDER BY o.order_date DESC";
$orders = mysqli_query($conn, $orders_query);

$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_name");

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY product_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management</title>
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
                <li><a href="orders.php" class="active">Orders</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2 class="page-title">Orders Management</h2>

            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert success active" id="alert"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error active" id="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div style="margin-bottom: 20px;">
                <button class="btn btn-primary" onclick="openOrderModal()">+ Create New Order</button>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>All Orders</h3>
                    <input type="text" class="search-box" placeholder="Search orders..." id="searchBox">
                </div>
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['order_date'])); ?></td>
                            <td>$<?php echo number_format($row['total_amount'], 2); ?></td>
                            <td>
                                <?php
                                $status_class = '';
                                switch($row['status']) {
                                    case 'Completed':
                                        $status_class = 'in-stock';
                                        break;
                                    case 'Pending':
                                        $status_class = 'low-stock';
                                        break;
                                    case 'Cancelled':
                                        $status_class = 'out-of-stock';
                                        break;
                                }
                                ?>
                                <span class="status <?php echo $status_class; ?>"><?php echo $row['status']; ?></span>
                            </td>
                            <td><?php echo $row['payment_status']; ?></td>
                            <td>
                                <button class="action-btn view" onclick="viewOrderDetails(<?php echo $row['order_id']; ?>)">View</button>
                                <button class="action-btn edit" onclick="updateOrderStatus(<?php echo $row['order_id']; ?>)">Update</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create New Order</h2>
                <span class="close-modal" onclick="closeOrderModal()">&times;</span>
            </div>
            <form id="orderForm" method="POST" action="../includes/process_order.php">
                <div class="form-group">
                    <label>Customer *</label>
                    <select name="customer_id" id="customer_id" required>
                        <option value="">Select Customer</option>
                        <?php 
                        mysqli_data_seek($customers, 0);
                        while($cust = mysqli_fetch_assoc($customers)): 
                        ?>
                        <option value="<?php echo $cust['customer_id']; ?>">
                            <?php echo $cust['customer_name']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Order Date *</label>
                    <input type="date" name="order_date" id="order_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label>Product *</label>
                    <select name="product_id" id="product_id" required>
                        <option value="">Select Product</option>
                        <?php 
                        mysqli_data_seek($products, 0);
                        while($prod = mysqli_fetch_assoc($products)): 
                        ?>
                        <option value="<?php echo $prod['product_id']; ?>" data-price="<?php echo $prod['price']; ?>">
                            <?php echo $prod['product_name']; ?> - $<?php echo $prod['price']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity" id="order_quantity" min="1" required>
                </div>
                <div class="form-group">
                    <label>Payment Status</label>
                    <select name="payment_status" id="payment_status">
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                        <option value="Partial">Partial</option>
                    </select>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary" name="action" value="add">Create Order</button>
                    <button type="button" class="btn btn-secondary" onclick="closeOrderModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/orders.js"></script>
</body>
</html>
