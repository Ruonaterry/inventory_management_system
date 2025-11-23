<?php
session_start();
include '../includes/db_connect.php';

$products_query = "SELECT p.*, c.category_name, s.supplier_name 
                   FROM products p 
                   LEFT JOIN categories c ON p.category_id = c.category_id 
                   LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id 
                   ORDER BY p.product_id DESC";
$products = mysqli_query($conn, $products_query);

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");

$suppliers = mysqli_query($conn, "SELECT * FROM suppliers ORDER BY supplier_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
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
                <li><a href="products.php" class="active">Products</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="suppliers.php">Suppliers</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2 class="page-title">Products Management</h2>

            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert success active" id="alert"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error active" id="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <h3 style="margin-bottom: 20px;">Add New Product</h3>
                <form id="productForm" method="POST" action="../includes/process_product.php">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Product Name *</label>
                            <input type="text" name="product_name" id="product_name" required>
                        </div>
                        <div class="form-group">
                            <label>SKU *</label>
                            <input type="text" name="sku" id="sku" required>
                        </div>
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category_id" id="category_id" required>
                                <option value="">Select Category</option>
                                <?php 
                                mysqli_data_seek($categories, 0);
                                while($cat = mysqli_fetch_assoc($categories)): 
                                ?>
                                <option value="<?php echo $cat['category_id']; ?>">
                                    <?php echo $cat['category_name']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Supplier *</label>
                            <select name="supplier_id" id="supplier_id" required>
                                <option value="">Select Supplier</option>
                                <?php 
                                mysqli_data_seek($suppliers, 0);
                                while($sup = mysqli_fetch_assoc($suppliers)): 
                                ?>
                                <option value="<?php echo $sup['supplier_id']; ?>">
                                    <?php echo $sup['supplier_name']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity *</label>
                            <input type="number" name="quantity" id="quantity" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Price *</label>
                            <input type="number" name="price" id="price" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Reorder Level *</label>
                            <input type="number" name="reorder_level" id="reorder_level" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Unit of Measure</label>
                            <input type="text" name="unit" id="unit" placeholder="e.g., pcs, kg, ltr">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description"></textarea>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" name="action" value="add">Add Product</button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>All Products</h3>
                    <input type="text" class="search-box" placeholder="Search products..." id="searchBox">
                </div>
                <table id="productsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Supplier</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($products)): ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['sku']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['supplier_name']; ?></td>
                            <td><?php echo $row['quantity']; ?> <?php echo $row['unit']; ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo $row['reorder_level']; ?></td>
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
                                <button class="action-btn edit" onclick='editProduct(<?php echo json_encode($row); ?>)'>Edit</button>
                                <button class="action-btn delete" onclick="deleteProduct(<?php echo $row['product_id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/products.js"></script>
</body>
</html>
