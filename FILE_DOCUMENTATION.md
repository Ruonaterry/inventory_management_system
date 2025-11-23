# File Documentation - Inventory Management System

## Complete Guide to Every File in the Codebase

---

## 📁 Project Structure

```
inventory_management_system/
├── css/
│   └── style.css
├── js/
│   ├── main.js
│   ├── products.js
│   ├── categories.js
│   ├── suppliers.js
│   └── orders.js
├── includes/
│   ├── db_connect.php
│   ├── process_product.php
│   ├── process_category.php
│   ├── process_supplier.php
│   └── process_order.php
├── pages/
│   ├── products.php
│   ├── categories.php
│   ├── suppliers.php
│   ├── orders.php
│   └── reports.php
├── index.php
├── database_schema.sql
├── README.md
├── SQL_DOCUMENTATION.md
├── TESTING_CHECKLIST.md
└── FILE_DOCUMENTATION.md (this file)
```

---

## 🎨 CSS Files

### `css/style.css`

**Purpose:** Contains all the styling for the entire application

**What it does:**
- Defines the visual appearance of every element
- Sets colors, fonts, spacing, borders, and layouts
- Makes the UI look clean and professional
- Implements responsive design for mobile devices
- Styles buttons, forms, tables, cards, modals, and navigation

**Key Sections:**
1. **Global Styles** - Base styles for body, containers
2. **Header & Navigation** - Top bar and menu styling
3. **Cards** - Dashboard statistics cards
4. **Forms** - Input fields, buttons, form containers
5. **Tables** - Data table styling
6. **Modals** - Popup window styling
7. **Status Badges** - Color-coded status indicators
8. **Responsive Design** - Mobile and tablet adaptations

**Why it's needed:** Without this file, the application would have no styling and look like plain HTML.

---

## 💻 JavaScript Files

### `js/main.js`

**Purpose:** Core JavaScript functions used across all pages

**What it contains:**
- `showAlert()` - Displays success/error messages
- `resetForm()` - Clears form fields and resets buttons
- `confirmAction()` - Shows confirmation dialogs
- `viewProduct()` - Opens product details modal
- `closeProductModal()` - Closes the modal
- Search functionality - Real-time table filtering

**Why it's needed:** Provides common functionality that all pages use. Without it, alerts, search, and modals wouldn't work.

---

### `js/products.js`

**Purpose:** JavaScript specific to the Products page

**What it contains:**
- `editProduct()` - Fills the form with product data for editing
- `deleteProduct()` - Deletes a product after confirmation

**How it works:**
1. When Edit is clicked, it takes product data and populates all form fields
2. Changes the submit button from "Add Product" to "Update Product"
3. Scrolls the page to the form smoothly
4. Delete shows a confirmation dialog before deleting

**Why it's needed:** Makes the edit and delete buttons on the Products page functional.

---

### `js/categories.js`

**Purpose:** JavaScript specific to the Categories page

**What it contains:**
- `editCategory()` - Fills form with category data
- `deleteCategory()` - Deletes a category after confirmation

**How it works:** Same as products.js but for categories

**Why it's needed:** Makes edit/delete buttons work on Categories page.

---

### `js/suppliers.js`

**Purpose:** JavaScript specific to the Suppliers page

**What it contains:**
- `editSupplier()` - Fills form with supplier data
- `deleteSupplier()` - Deletes a supplier after confirmation

**Why it's needed:** Makes edit/delete buttons work on Suppliers page.

---

### `js/orders.js`

**Purpose:** JavaScript specific to the Orders page

**What it contains:**
- `openOrderModal()` - Opens the create order popup
- `closeOrderModal()` - Closes the order popup
- `viewOrderDetails()` - Views order details (can be enhanced)
- `updateOrderStatus()` - Prompts for new status and updates

**Why it's needed:** Makes the order modal and status update functionality work.

---

## 🔌 PHP Includes (Backend Processing)

### `includes/db_connect.php`

**Purpose:** Establishes connection to the MySQL database

**What it does:**
```php
- Defines database credentials (host, username, password, database name)
- Creates a connection using mysqli_connect()
- Checks if connection was successful
- Sets character encoding to UTF-8
- Creates a $conn variable used by all other PHP files
```

**Why it's needed:** Every page that needs to read or write to the database includes this file first. Without it, no data can be retrieved or saved.

**Database credentials:**
- Host: `localhost`
- User: `root`
- Password: (empty)
- Database: `inventory_db`

---

### `includes/process_product.php`

**Purpose:** Handles all backend operations for products (Add, Update, Delete)

**What it does:**

**1. Add Product:**
- Receives form data from products.php
- Sanitizes input using `mysqli_real_escape_string()`
- Inserts new product into database
- Redirects back to products page with success message

**2. Update Product:**
- Receives product ID and updated data
- Updates the product record in database
- Redirects with success message

**3. Delete Product:**
- Receives product ID from URL
- Deletes product from database
- Redirects with success message

**Why it's needed:** Without this file, the Add/Update/Delete buttons on Products page wouldn't do anything. This file is the bridge between the user interface and the database.

---

### `includes/process_category.php`

**Purpose:** Handles Add, Update, Delete operations for categories

**What it does:**
- Same as process_product.php but for categories table
- Handles: category_name, category_code, description

**Why it's needed:** Makes category management functional.

---

### `includes/process_supplier.php`

**Purpose:** Handles Add, Update, Delete operations for suppliers

**What it does:**
- Same structure as above but for suppliers table
- Handles: supplier_name, contact_person, email, phone, address

**Why it's needed:** Makes supplier management functional.

---

### `includes/process_order.php`

**Purpose:** Handles order creation and status updates

**What it does:**

**1. Create Order:**
- Receives customer, product, quantity, payment status
- Fetches product price from database
- Calculates subtotal (price × quantity)
- Uses database transaction to:
  - Create order record
  - Create order item record
  - Reduce product stock quantity
- All or nothing (if one fails, all rollback)

**2. Update Order Status:**
- Receives order ID and new status
- Updates order status in database

**Why it's needed:** Makes order creation and management functional. The transaction ensures data integrity.

---

## 📄 PHP Pages (User Interface)

### `index.php` (Dashboard)

**Purpose:** Main landing page showing system overview

**What it displays:**
1. **Statistics Cards:**
   - Total Products count
   - Low Stock Items count
   - Total Categories count
   - Total Suppliers count

2. **Recent Products Table:**
   - 10 most recently added products
   - Product details with status badges
   - View and Edit buttons

**Database queries:**
- Counts products, categories, suppliers
- Counts low stock items
- Fetches 10 recent products with JOIN to categories and suppliers

**Why it's needed:** Gives users a quick overview of the inventory system. First page users see.

---

### `pages/products.php`

**Purpose:** Complete product management interface

**What it displays:**

**1. Add Product Form:**
- Input fields for all product information
- Dropdowns for category and supplier (populated from database)
- Add Product button
- Reset button

**2. Products Table:**
- All products from database
- Shows: ID, Name, SKU, Category, Supplier, Quantity, Price, Reorder Level, Status
- Edit and Delete buttons for each product

**Database queries:**
- Fetches all products with JOINs to categories and suppliers
- Fetches all categories for dropdown
- Fetches all suppliers for dropdown

**Why it's needed:** Central place to manage all products. Most important page in the system.

---

### `pages/categories.php`

**Purpose:** Manage product categories

**What it displays:**

**1. Add Category Form:**
- Category name (required)
- Category code (optional)
- Description (optional)

**2. Categories Table:**
- All categories
- Edit and Delete buttons

**Why it's needed:** Categories organize products. Need to manage them separately.

---

### `pages/suppliers.php`

**Purpose:** Manage suppliers

**What it displays:**

**1. Add Supplier Form:**
- Supplier name, contact person, email, phone (required)
- Address (optional)

**2. Suppliers Table:**
- All suppliers with contact information
- Edit and Delete buttons

**Why it's needed:** Track who supplies each product. Important for reordering and business records.

---

### `pages/orders.php`

**Purpose:** Manage customer orders

**What it displays:**

**1. Create Order Button:**
- Opens modal for new orders

**2. Order Modal:**
- Customer dropdown
- Product dropdown
- Quantity input
- Order date
- Payment status

**3. Orders Table:**
- All orders with customer name, date, amount, status
- View and Update buttons

**Database queries:**
- Fetches all orders with customer details
- Fetches all customers for dropdown
- Fetches all products for dropdown

**Why it's needed:** Orders are the core business transaction. This tracks sales and reduces inventory.

---

### `pages/reports.php`

**Purpose:** Generate business reports

**What it displays:**

**1. Low Stock Alert Report:**
- Products at or below reorder level
- Sorted by quantity (lowest first)
- Shows which products need reordering

**2. Top Selling Products Report:**
- Top 10 best-selling products
- Shows units sold and revenue
- Helps identify popular products

**3. Inventory Value by Category:**
- Total value of inventory per category
- Calculated as: quantity × price
- Shows where money is tied up

**Database queries:**
- Complex queries with JOINs and aggregations (SUM, COUNT, GROUP BY)

**Why it's needed:** Business insights. Helps make decisions about restocking, pricing, and inventory management.

---

## 🗄️ Database Files

### `database_schema.sql`

**Purpose:** Complete database structure with sample data

**What it contains:**

**1. Database Creation:**
```sql
CREATE DATABASE inventory_db;
USE inventory_db;
```

**2. Table Definitions:**
- categories (8 sample records)
- suppliers (7 sample records)
- products (28 sample records)
- customers (8 sample records)
- orders (8 sample records)
- order_items (order details)

**3. Relationships:**
- Foreign keys connecting tables
- Cascading delete rules
- Set NULL rules

**4. Indexes:**
- Speed up searches on frequently used columns

**5. Stored Procedures:**
- `update_product_stock()` - Reduce stock when order placed
- `get_low_stock_products()` - Get products needing reorder

**6. Views:**
- `vw_product_inventory` - Product details with calculated fields
- `vw_order_summary` - Order summaries with item counts

**Why it's needed:** This file creates the entire database structure. Run it once in MySQL to set up everything.

**How to use:**
1. Open MySQL Workbench
2. File → Open SQL Script → Select this file
3. Execute (⚡ button)
4. Database is ready!

---

## 📚 Documentation Files

### `README.md`

**Purpose:** Main project documentation

**What it contains:**
- Project overview and features
- Installation instructions
- Usage guide
- Technology stack
- Project structure
- Configuration details
- Troubleshooting tips

**Why it's needed:** First file people read to understand the project.

---

### `SQL_DOCUMENTATION.md`

**Purpose:** Complete explanation of every SQL command

**What it contains:**
- Explanation of CREATE DATABASE
- Explanation of CREATE TABLE
- Data types explained (INT, VARCHAR, DECIMAL, etc.)
- Constraints explained (PRIMARY KEY, FOREIGN KEY, NOT NULL, etc.)
- INSERT statements explained
- JOIN operations explained
- Stored procedures explained
- Views explained
- Real examples and use cases

**Why it's needed:** Helps understand the database structure. Educational resource for learning SQL.

---

### `TESTING_CHECKLIST.md`

**Purpose:** Verification that all features work

**What it contains:**
- Complete list of all features
- Testing results for each feature
- Button functionality tests
- Database integrity checks
- UI/UX verification

**Why it's needed:** Quality assurance. Proves everything works correctly.

---

### `FILE_DOCUMENTATION.md`

**Purpose:** This file! Explains what every file does

**Why it's needed:** Helps understand the codebase structure.

---

## 🔄 How Files Work Together

### 1. User Opens Dashboard

```
Browser → index.php
         ↓
    db_connect.php (connects to database)
         ↓
    Queries database for stats and products
         ↓
    Generates HTML with data
         ↓
    Loads style.css (makes it pretty)
         ↓
    Loads main.js (adds interactivity)
         ↓
    User sees dashboard
```

---

### 2. User Adds a Product

```
User fills form in products.php
         ↓
User clicks "Add Product"
         ↓
Form submits to process_product.php
         ↓
process_product.php:
    - Includes db_connect.php
    - Sanitizes input
    - INSERT INTO products...
    - Sets success message in session
         ↓
Redirects back to products.php
         ↓
products.php shows success message
         ↓
Table refreshes with new product
```

---

### 3. User Edits a Product

```
User clicks "Edit" button
         ↓
products.js editProduct() function runs
         ↓
JavaScript fills form with product data
         ↓
Button changes to "Update Product"
         ↓
User modifies data and submits
         ↓
Form submits to process_product.php (action=update)
         ↓
process_product.php:
    - UPDATE products SET...
    - Sets success message
         ↓
Redirects back to products.php
         ↓
Shows updated product
```

---

### 4. User Creates an Order

```
User clicks "+ Create New Order"
         ↓
orders.js openOrderModal() runs
         ↓
Modal appears with form
         ↓
User fills: customer, product, quantity
         ↓
Submits form to process_order.php
         ↓
process_order.php:
    - START TRANSACTION
    - INSERT INTO orders...
    - INSERT INTO order_items...
    - UPDATE products SET quantity = quantity - X
    - COMMIT TRANSACTION
         ↓
Redirects to orders.php with success
         ↓
New order appears in table
```

---

## 🎯 Key Concepts

### Why Multiple Files?

**Separation of Concerns:**
- **CSS files** = Appearance only
- **JavaScript files** = Client-side behavior
- **PHP files** = Server-side logic and database
- **Includes** = Reusable backend code
- **Pages** = User interface

**Benefits:**
1. **Easier to maintain** - Change one thing without breaking others
2. **Reusability** - db_connect.php used by all pages
3. **Organization** - Know exactly where to look for issues
4. **Team work** - Multiple people can work on different files
5. **Performance** - Browser caches CSS/JS files

---

### Why PHP and JavaScript?

**PHP (Server-Side):**
- Runs on the server
- Can access database
- Generates HTML dynamically
- Processes forms
- Keeps business logic secure

**JavaScript (Client-Side):**
- Runs in user's browser
- Makes UI interactive
- No page reload needed for simple actions
- Instant feedback (form validation, search)
- Cannot access database directly (security)

**They work together:**
- PHP generates the page with data
- JavaScript makes it interactive
- PHP processes changes
- PHP refreshes with updated data

---

### Why Include Files?

**Problem:** Every page needs database connection

**Bad Solution:** Copy-paste connection code in every file
- If password changes, update 10 files
- Easy to make mistakes
- Duplicate code

**Good Solution:** One db_connect.php file
- Include it in every page: `include 'db_connect.php';`
- Change password once, works everywhere
- DRY principle (Don't Repeat Yourself)

---

## 🎓 Learning Path

**If you're new to this:**

1. **Start with HTML** (structure)
   - Look at index.php HTML sections
   - Understand tables, forms, buttons

2. **Learn CSS** (styling)
   - Open style.css
   - See how classes affect appearance
   - Try changing colors

3. **Basic JavaScript** (interactivity)
   - Look at main.js
   - Understand functions
   - See how buttons trigger actions

4. **PHP Basics** (server-side)
   - Look at index.php PHP sections
   - Understand variables ($conn, $row)
   - See how PHP generates HTML

5. **Database** (data storage)
   - Read SQL_DOCUMENTATION.md
   - Understand tables and relationships
   - Learn SELECT, INSERT, UPDATE, DELETE

6. **Integration** (putting it together)
   - Follow the "How Files Work Together" section
   - Trace a complete user action
   - Understand the flow

---

## 🔍 Quick Reference

**Need to change:**

| What | File to Edit |
|------|-------------|
| Colors/styling | css/style.css |
| Button behavior | js/*.js files |
| Database connection | includes/db_connect.php |
| Form processing | includes/process_*.php |
| Page layout | pages/*.php or index.php |
| Database structure | database_schema.sql |

**Need to debug:**

| Issue | Check |
|-------|-------|
| Button not working | Browser console (F12) for JavaScript errors |
| Data not saving | includes/process_*.php for PHP errors |
| Wrong data displayed | Check SQL query in page file |
| Styling broken | css/style.css, check class names |
| Page not loading | Check db_connect.php, ensure MySQL running |

---

## 📋 File Checklist

**All 20 files explained:**

✅ 1 CSS file (style.css)  
✅ 5 JavaScript files (main.js, products.js, categories.js, suppliers.js, orders.js)  
✅ 5 PHP includes (db_connect.php, process_product.php, process_category.php, process_supplier.php, process_order.php)  
✅ 6 PHP pages (index.php, products.php, categories.php, suppliers.php, orders.php, reports.php)  
✅ 1 SQL file (database_schema.sql)  
✅ 4 Documentation files (README.md, SQL_DOCUMENTATION.md, TESTING_CHECKLIST.md, FILE_DOCUMENTATION.md)  

**Total: 22 files - Every file documented!**

---

**This documentation explains the purpose, functionality, and relationships of every file in the Inventory Management System.**
