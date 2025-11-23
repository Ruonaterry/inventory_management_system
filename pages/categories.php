<?php
session_start();
include '../includes/db_connect.php';

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management</title>
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
                <li><a href="categories.php" class="active">Categories</a></li>
                <li><a href="suppliers.php">Suppliers</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <h2 class="page-title">Categories Management</h2>

            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert success active" id="alert"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert error active" id="alert"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="form-container">
                <h3 style="margin-bottom: 20px;">Add New Category</h3>
                <form id="categoryForm" method="POST" action="../includes/process_category.php">
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Category Name *</label>
                            <input type="text" name="category_name" id="category_name" required>
                        </div>
                        <div class="form-group">
                            <label>Category Code</label>
                            <input type="text" name="category_code" id="category_code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description"></textarea>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary" name="action" value="add">Add Category</button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>All Categories</h3>
                    <input type="text" class="search-box" placeholder="Search categories..." id="searchBox">
                </div>
                <table id="categoriesTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Category Code</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($categories)): ?>
                        <tr>
                            <td><?php echo $row['category_id']; ?></td>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['category_code']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <button class="action-btn edit" onclick='editCategory(<?php echo json_encode($row); ?>)'>Edit</button>
                                <button class="action-btn delete" onclick="deleteCategory(<?php echo $row['category_id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/categories.js"></script>
</body>
</html>
