# Inventory Management System
**Group 1: Inventory Management System for A Store**

A complete web-based inventory management system built with PHP, MySQL, HTML, CSS, and JavaScript.

## 📋 Features

- **Dashboard**: Overview of inventory statistics with visual cards
- **Products Management**: Add, edit, delete, and search products
- **Categories Management**: Organize products into categories
- **Suppliers Management**: Manage supplier information
- **Orders Management**: Track customer orders and order items
- **Reports**: Generate low stock alerts, top-selling products, and inventory value reports
- **Responsive Design**: Works on desktop, tablet, and mobile devices

## 🛠️ Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache (XAMPP)

## 📦 Installation Instructions

### Step 1: Start XAMPP
1. Open XAMPP Control Panel
2. Start **Apache** server
3. Start **MySQL** server

### Step 2: Import Database Using MySQL Workbench

1. **Open MySQL Workbench**
2. **Connect to your MySQL server**:
   - Click on "Local instance MySQL" or create a new connection
   - Default connection: `localhost:3306`
   - Username: `root`
   - Password: (leave blank if default)

3. **Import the SQL file**:
   - Go to: **File → Open SQL Script**
   - Navigate to: `/Applications/XAMPP/xamppfiles/htdocs/inventory_management_system/`
   - Select: `database_schema.sql`
   - Click **Open**

4. **Execute the script**:
   - Click the **⚡ Execute** button (lightning bolt icon) or press `Cmd+Shift+Enter`
   - Wait for the script to complete (you should see "Database setup completed successfully!" message)

5. **Verify the database**:
   - In the left sidebar, click the **refresh** icon
   - You should see a new database named `inventory_db`
   - Expand it to see all tables: categories, suppliers, products, customers, orders, order_items

### Step 3: Access the Application

1. **Open your web browser**
2. Go to: `http://localhost/inventory_management_system/`
3. You should see the Dashboard with sample data

## 📂 Project Structure

```
inventory_management_system/
├── css/
│   └── style.css                 # Main stylesheet
├── js/
│   ├── main.js                   # Common JavaScript functions
│   ├── products.js               # Products page scripts
│   ├── categories.js             # Categories page scripts
│   ├── suppliers.js              # Suppliers page scripts
│   └── orders.js                 # Orders page scripts
├── includes/
│   └── db_connect.php            # Database connection file
├── pages/
│   ├── products.php              # Products management page
│   ├── categories.php            # Categories management page
│   ├── suppliers.php             # Suppliers management page
│   ├── orders.php                # Orders management page
│   └── reports.php               # Reports page
├── index.php                     # Dashboard (main page)
├── database_schema.sql           # Complete database schema with sample data
└── README.md                     # This file
```

## 🗄️ Database Schema

### Tables:
1. **categories** - Product categories
2. **suppliers** - Supplier information
3. **products** - Product inventory
4. **customers** - Customer information
5. **orders** - Customer orders
6. **order_items** - Items in each order

### Relationships:
- Products → Categories (Many-to-One)
- Products → Suppliers (Many-to-One)
- Orders → Customers (Many-to-One)
- Order Items → Orders (Many-to-One)
- Order Items → Products (Many-to-One)

## 🔧 Configuration

If you need to change database credentials, edit `includes/db_connect.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Change if you have a password
define('DB_NAME', 'inventory_db');
```

## 📊 Sample Data Included

The database comes pre-loaded with:
- 8 Categories
- 7 Suppliers
- 28 Products across different categories
- 8 Customers
- 8 Sample orders with order items

## 🚀 Usage Guide

### Adding a Product:
1. Go to **Products** page
2. Fill in the form: Product Name, SKU, Category, Supplier, Quantity, Price, Reorder Level
3. Click **Add Product**

### Managing Categories:
1. Go to **Categories** page
2. Add new categories or edit existing ones
3. Categories help organize your products

### Managing Suppliers:
1. Go to **Suppliers** page
2. Add supplier information including contact details
3. Link suppliers to products

### Creating Orders:
1. Go to **Orders** page
2. Click **+ Create New Order**
3. Select customer, product, quantity, and payment status
4. Submit the order

### Viewing Reports:
1. Go to **Reports** page
2. View three key reports:
   - **Low Stock Alert**: Products that need reordering
   - **Top Selling Products**: Best performing items
   - **Inventory Value by Category**: Financial overview

## 🔍 Features to Note

- **Search Functionality**: Every table has a search box to filter records
- **Stock Status**: Automatic color-coded status badges (In Stock, Low Stock, Out of Stock)
- **Responsive Tables**: All tables are mobile-friendly
- **Edit/Delete Actions**: Inline buttons for quick actions
- **Real-time Calculations**: Automatic inventory value calculations

## 📝 For Your Project Submission

### What to Include:

1. **ERD Diagram**: Create using Draw.io or MS Visio showing:
   - All entities (tables)
   - Attributes
   - Relationships with cardinality

2. **Normalization**: The database is already normalized to 3NF:
   - 1NF: All tables have atomic values
   - 2NF: No partial dependencies
   - 3NF: No transitive dependencies

3. **SQL Statements**: The `database_schema.sql` file contains:
   - CREATE TABLE statements
   - ALTER TABLE for constraints (indexes)
   - INSERT statements with sample data
   - CREATE VIEW statements
   - CREATE PROCEDURE statements

4. **Application Screenshots**: Take screenshots of:
   - Dashboard
   - Products management
   - Categories management
   - Suppliers management
   - Orders management
   - Reports pages

5. **Queries Documentation**: Document the queries used in reports.php

## 🐛 Troubleshooting

### Database Connection Error:
- Make sure MySQL is running in XAMPP
- Check credentials in `db_connect.php`
- Verify database name is correct

### Page Not Found (404):
- Ensure files are in the correct XAMPP htdocs directory
- Check file permissions
- Verify Apache is running

### Blank Page:
- Check PHP error logs in XAMPP
- Enable error reporting by adding to php.ini:
  ```
  display_errors = On
  error_reporting = E_ALL
  ```

## 📧 Support

For issues or questions, refer to:
- XAMPP Documentation: https://www.apachefriends.org/
- MySQL Documentation: https://dev.mysql.com/doc/
- PHP Documentation: https://www.php.net/docs.php

## ✅ Project Checklist

- [x] Business Information Requirements captured
- [x] ERD with proper relationships
- [x] Normalized database schema
- [x] Database implementation with constraints
- [x] Sample data for testing
- [x] Web application with forms
- [x] Reports for business operations
- [x] Documentation

---

**Created for Group 1 - Inventory Management System for A Store**
**Academic Project - Database Systems Course**
