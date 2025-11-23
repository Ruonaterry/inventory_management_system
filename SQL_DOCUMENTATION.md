# SQL Commands Documentation
## Complete Explanation of Database Schema

This document explains every SQL command used in the inventory management system database.

---

## 1. DATABASE CREATION

### Command:
```sql
CREATE DATABASE IF NOT EXISTS inventory_db;
```

**Explanation:**
- `CREATE DATABASE` - Creates a new database
- `IF NOT EXISTS` - Only creates if database doesn't already exist (prevents errors)
- `inventory_db` - Name of our database

### Command:
```sql
USE inventory_db;
```

**Explanation:**
- `USE` - Selects/switches to the specified database
- All subsequent commands will operate on this database

---

## 2. DROPPING TABLES (CLEANUP)

### Command:
```sql
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS suppliers;
```

**Explanation:**
- `DROP TABLE` - Completely deletes a table and all its data
- `IF EXISTS` - Only drops if table exists (prevents errors)
- **Order matters!** We must drop tables with foreign keys first
- Think of it like: delete children before parents
- `order_items` references `orders` and `products`, so it must be dropped first
- `orders` references `customers`, so drop before `customers`
- `products` references `categories` and `suppliers`, so drop before them

---

## 3. TABLE CREATION

### 3.1 Categories Table

```sql
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    category_code VARCHAR(20),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Line-by-Line Explanation:**

- `CREATE TABLE categories` - Creates a new table named "categories"
- `category_id INT AUTO_INCREMENT PRIMARY KEY`
  - `INT` - Integer data type (whole numbers)
  - `AUTO_INCREMENT` - Automatically increases by 1 for each new row (1, 2, 3...)
  - `PRIMARY KEY` - Unique identifier for each row, cannot be NULL, must be unique
- `category_name VARCHAR(100) NOT NULL`
  - `VARCHAR(100)` - Variable character string, max 100 characters
  - `NOT NULL` - This field must have a value, cannot be empty
- `category_code VARCHAR(20)`
  - Optional field (can be NULL) with max 20 characters
- `description TEXT`
  - `TEXT` - For long text content (up to 65,535 characters)
  - Can be NULL
- `created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP`
  - `TIMESTAMP` - Date and time data type
  - `DEFAULT CURRENT_TIMESTAMP` - Automatically sets to current date/time when row is created
- `updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`
  - Sets to current time when created
  - `ON UPDATE CURRENT_TIMESTAMP` - Automatically updates to current time whenever row is modified

---

### 3.2 Suppliers Table

```sql
CREATE TABLE suppliers (
    supplier_id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_name VARCHAR(150) NOT NULL,
    contact_person VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Same structure as categories, but note:**
- Multiple fields marked `NOT NULL` - supplier_name, contact_person, email, phone are required
- `address` is optional (can be NULL)

---

### 3.3 Products Table

```sql
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(200) NOT NULL,
    sku VARCHAR(50) UNIQUE NOT NULL,
    category_id INT,
    supplier_id INT,
    description TEXT,
    quantity INT DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    reorder_level INT DEFAULT 10,
    unit VARCHAR(20) DEFAULT 'pcs',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id) ON DELETE SET NULL
);
```

**New Concepts:**

- `sku VARCHAR(50) UNIQUE NOT NULL`
  - `UNIQUE` - No two products can have the same SKU
  - `NOT NULL` - SKU is required
- `category_id INT`
  - Will store ID of the category this product belongs to
  - Can be NULL (product can exist without category)
- `quantity INT DEFAULT 0`
  - `DEFAULT 0` - If no quantity specified, defaults to 0
- `price DECIMAL(10, 2) NOT NULL`
  - `DECIMAL(10, 2)` - Decimal number with max 10 digits total, 2 after decimal point
  - Example: 12345678.90
  - Perfect for money (no rounding errors like with FLOAT)
- `unit VARCHAR(20) DEFAULT 'pcs'`
  - Defaults to 'pcs' (pieces) if not specified
  
**FOREIGN KEYS:**

```sql
FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
```

**Explanation:**
- `FOREIGN KEY (category_id)` - This column is a foreign key
- `REFERENCES categories(category_id)` - Points to category_id in categories table
- **This creates a relationship:** A product belongs to a category
- `ON DELETE SET NULL` - If category is deleted, set product's category_id to NULL (don't delete product)
- **Alternative:** `ON DELETE CASCADE` would delete the product if category is deleted

---

### 3.4 Customers Table

```sql
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(150) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Simple structure:** Only customer_name is required, rest is optional

---

### 3.5 Orders Table

```sql
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_date DATE NOT NULL,
    total_amount DECIMAL(10, 2) DEFAULT 0.00,
    status ENUM('Pending', 'Processing', 'Completed', 'Cancelled') DEFAULT 'Pending',
    payment_status ENUM('Pending', 'Paid', 'Partial') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL
);
```

**New Concepts:**

- `order_date DATE NOT NULL`
  - `DATE` - Stores only date (YYYY-MM-DD), not time
- `status ENUM('Pending', 'Processing', 'Completed', 'Cancelled') DEFAULT 'Pending'`
  - `ENUM` - Enumeration, can only be one of the specified values
  - Restricts status to only these 4 options
  - Defaults to 'Pending'
  - **Benefits:** Data validation, saves space, prevents typos
- Similar ENUM for payment_status

---

### 3.6 Order Items Table

```sql
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE SET NULL
);
```

**Important Difference:**

```sql
FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
```

- `ON DELETE CASCADE` - If an order is deleted, automatically delete all its order items
- **Why?** Order items don't make sense without an order
- **Contrast with product:** `ON DELETE SET NULL` - If product is deleted, keep the order item (for history) but set product_id to NULL

---

## 4. INDEXES

### Commands:
```sql
CREATE INDEX idx_product_sku ON products(sku);
CREATE INDEX idx_product_category ON products(category_id);
CREATE INDEX idx_product_supplier ON products(supplier_id);
CREATE INDEX idx_order_customer ON orders(customer_id);
CREATE INDEX idx_order_date ON orders(order_date);
CREATE INDEX idx_order_status ON orders(status);
```

**Explanation:**
- `CREATE INDEX` - Creates an index (like a book index)
- `idx_product_sku` - Name of the index
- `ON products(sku)` - On which table and column
- **Purpose:** Makes searches faster
  - Without index: Database scans every row
  - With index: Database jumps directly to matching rows
- **Use on:** Columns frequently used in WHERE, JOIN, ORDER BY
- **Primary keys automatically have indexes**

---

## 5. INSERT STATEMENTS

### Categories Insert:
```sql
INSERT INTO categories (category_name, category_code, description) VALUES
('Electronics', 'ELEC', 'Electronic devices and accessories'),
('Clothing', 'CLTH', 'Apparel and fashion items');
```

**Explanation:**
- `INSERT INTO categories` - Insert data into categories table
- `(category_name, category_code, description)` - Columns we're inserting into
- `VALUES` - The actual data to insert
- `('Electronics', 'ELEC', 'Electronic devices...')` - First row of data
- Notice: We don't specify `category_id` (AUTO_INCREMENT handles it)
- We don't specify `created_at` or `updated_at` (DEFAULT handles it)
- Can insert multiple rows at once (comma-separated)

---

### Products Insert:
```sql
INSERT INTO products (product_name, sku, category_id, supplier_id, description, quantity, price, reorder_level, unit) VALUES
('Wireless Mouse', 'ELEC-001', 1, 1, 'Ergonomic wireless mouse with USB receiver', 50, 25.99, 10, 'pcs');
```

**Note the numbers:**
- `category_id` is `1` - References the first category (Electronics)
- `supplier_id` is `1` - References the first supplier
- **This is how relationships work:** We store the ID, not the name

---

## 6. STORED PROCEDURES

### Procedure 1: Update Product Stock

```sql
DELIMITER //
CREATE PROCEDURE update_product_stock(
    IN p_product_id INT,
    IN p_quantity INT
)
BEGIN
    UPDATE products 
    SET quantity = quantity - p_quantity 
    WHERE product_id = p_product_id;
END //
DELIMITER ;
```

**Line-by-Line:**

- `DELIMITER //` - Changes command delimiter from `;` to `//`
  - **Why?** Procedure contains multiple `;` inside, would confuse MySQL
- `CREATE PROCEDURE update_product_stock` - Creates a stored procedure (reusable SQL code)
- `IN p_product_id INT` - Input parameter, integer
- `IN p_quantity INT` - Another input parameter
- `BEGIN` - Start of procedure code
- `UPDATE products` - Modifies products table
- `SET quantity = quantity - p_quantity` - Subtracts sold quantity from stock
- `WHERE product_id = p_product_id` - Only for this specific product
- `END //` - End of procedure
- `DELIMITER ;` - Restore normal delimiter

**How to use it:**
```sql
CALL update_product_stock(1, 5);
```
This subtracts 5 from product ID 1's quantity.

---

### Procedure 2: Get Low Stock Products

```sql
DELIMITER //
CREATE PROCEDURE get_low_stock_products()
BEGIN
    SELECT p.*, c.category_name, s.supplier_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id
    WHERE p.quantity <= p.reorder_level
    ORDER BY p.quantity ASC;
END //
DELIMITER ;
```

**Explanation:**
- No input parameters `()`
- `SELECT p.*` - Select all columns from products (aliased as `p`)
- `LEFT JOIN categories c` - Join categories table (aliased as `c`)
  - **LEFT JOIN:** Keep all products even if they don't have a category
- `ON p.category_id = c.category_id` - Join condition (how tables connect)
- `WHERE p.quantity <= p.reorder_level` - Only products at or below reorder level
- `ORDER BY p.quantity ASC` - Sort by quantity ascending (lowest first)

**How to use it:**
```sql
CALL get_low_stock_products();
```

---

## 7. VIEWS

### View 1: Product Inventory

```sql
CREATE VIEW vw_product_inventory AS
SELECT 
    p.product_id,
    p.product_name,
    p.sku,
    c.category_name,
    s.supplier_name,
    p.quantity,
    p.price,
    p.reorder_level,
    (p.quantity * p.price) AS inventory_value,
    CASE 
        WHEN p.quantity = 0 THEN 'Out of Stock'
        WHEN p.quantity <= p.reorder_level THEN 'Low Stock'
        ELSE 'In Stock'
    END AS stock_status
FROM products p
LEFT JOIN categories c ON p.category_id = c.category_id
LEFT JOIN suppliers s ON p.supplier_id = s.supplier_id;
```

**What is a VIEW?**
- A VIEW is a saved query that acts like a virtual table
- **Benefits:**
  - Simplifies complex queries
  - Reusable
  - Provides data security (can hide columns)

**New Concepts:**

- `(p.quantity * p.price) AS inventory_value`
  - Calculates total value (quantity × price)
  - `AS inventory_value` - Names this calculated column
  
- `CASE` statement (like if-else):
```sql
CASE 
    WHEN p.quantity = 0 THEN 'Out of Stock'
    WHEN p.quantity <= p.reorder_level THEN 'Low Stock'
    ELSE 'In Stock'
END AS stock_status
```
  - If quantity is 0, return "Out of Stock"
  - Else if quantity is at or below reorder level, return "Low Stock"
  - Else return "In Stock"

**How to use:**
```sql
SELECT * FROM vw_product_inventory;
```
Treat it like a regular table!

---

### View 2: Order Summary

```sql
CREATE VIEW vw_order_summary AS
SELECT 
    o.order_id,
    o.order_date,
    c.customer_name,
    c.email,
    o.total_amount,
    o.status,
    o.payment_status,
    COUNT(oi.order_item_id) AS total_items
FROM orders o
LEFT JOIN customers c ON o.customer_id = c.customer_id
LEFT JOIN order_items oi ON o.order_id = oi.order_id
GROUP BY o.order_id;
```

**New Concepts:**

- `COUNT(oi.order_item_id) AS total_items`
  - `COUNT()` - Aggregate function, counts rows
  - Counts how many items are in each order
  
- `GROUP BY o.order_id`
  - Groups results by order_id
  - **Required when using aggregate functions** (COUNT, SUM, AVG, etc.)
  - One row per order, with item count calculated

---

## 8. COMMON SQL OPERATIONS

### SELECT (Read/Query)
```sql
SELECT column1, column2 FROM table_name WHERE condition;
```

### INSERT (Create)
```sql
INSERT INTO table_name (col1, col2) VALUES (val1, val2);
```

### UPDATE (Modify)
```sql
UPDATE table_name SET col1 = val1 WHERE condition;
```

### DELETE (Remove)
```sql
DELETE FROM table_name WHERE condition;
```

---

## 9. DATA TYPES SUMMARY

| Type | Description | Example |
|------|-------------|---------|
| `INT` | Whole numbers | 42, -10, 0 |
| `VARCHAR(n)` | Variable-length string | 'Hello' |
| `TEXT` | Long text | Articles, descriptions |
| `DECIMAL(m,d)` | Fixed-point decimal | 99.99 |
| `DATE` | Date only | 2024-01-15 |
| `TIMESTAMP` | Date and time | 2024-01-15 14:30:00 |
| `ENUM` | One of specified values | 'Pending', 'Completed' |

---

## 10. CONSTRAINTS SUMMARY

| Constraint | Purpose |
|------------|---------|
| `PRIMARY KEY` | Unique identifier for each row |
| `FOREIGN KEY` | Links to another table |
| `UNIQUE` | No duplicate values allowed |
| `NOT NULL` | Value is required |
| `DEFAULT` | Default value if none provided |
| `AUTO_INCREMENT` | Automatically increases |

---

## 11. RELATIONSHIPS EXPLAINED

### One-to-Many
- One category can have many products
- One supplier can supply many products
- One customer can have many orders
- One order can have many order items

**Implemented with FOREIGN KEY in the "many" table**

### Example:
```
categories (one)
    └── products (many) [has category_id foreign key]
```

---

## 12. JOINS EXPLAINED

### INNER JOIN
- Returns only rows that have matches in both tables
```sql
SELECT * FROM products 
INNER JOIN categories ON products.category_id = categories.category_id;
```

### LEFT JOIN
- Returns all rows from left table, matched rows from right (or NULL)
```sql
SELECT * FROM products 
LEFT JOIN categories ON products.category_id = categories.category_id;
```
Products without categories are still included.

### RIGHT JOIN
- Opposite of LEFT JOIN

### FULL JOIN
- Returns all rows from both tables

---

## 13. KEY SQL KEYWORDS

- `CREATE` - Create new database/table/view
- `DROP` - Delete database/table
- `ALTER` - Modify table structure
- `INSERT` - Add new data
- `SELECT` - Query/retrieve data
- `UPDATE` - Modify existing data
- `DELETE` - Remove data
- `WHERE` - Filter condition
- `ORDER BY` - Sort results
- `GROUP BY` - Group rows
- `JOIN` - Combine tables
- `DISTINCT` - Remove duplicates
- `COUNT`, `SUM`, `AVG`, `MAX`, `MIN` - Aggregate functions

---

This documentation explains every SQL concept used in the inventory management system database schema.
