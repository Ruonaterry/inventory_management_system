CREATE DATABASE inventory_db;
USE inventory_db;

-- CREATE TABLE statements without constraints
CREATE TABLE categories (
    category_id INT,
    category_name VARCHAR(100),
    description VARCHAR(255)
);

CREATE TABLE suppliers (
    supplier_id INT,
    supplier_name VARCHAR(150),
    contact_person VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255)
);

CREATE TABLE products (
    product_id INT,
    product_name VARCHAR(200),
    category_id INT,
    supplier_id INT,
    quantity INT,
    price DECIMAL(10, 2)
);

CREATE TABLE customers (
    customer_id INT,
    customer_name VARCHAR(150),
    email VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255)
);

CREATE TABLE orders (
    order_id INT,
    customer_id INT,
    order_date DATE,
    total_amount DECIMAL(10, 2),
    status VARCHAR(50)
);

CREATE TABLE order_items (
    order_item_id INT,
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DECIMAL(10, 2),
    subtotal DECIMAL(10, 2)
);

-- ALTER TABLE statements to add PRIMARY KEY constraints
ALTER TABLE categories
ADD PRIMARY KEY (category_id);

ALTER TABLE suppliers
ADD PRIMARY KEY (supplier_id);

ALTER TABLE products
ADD PRIMARY KEY (product_id);

ALTER TABLE customers
ADD PRIMARY KEY (customer_id);

ALTER TABLE orders
ADD PRIMARY KEY (order_id);

ALTER TABLE order_items
ADD PRIMARY KEY (order_item_id);

-- ALTER TABLE statements to add FOREIGN KEY constraints
ALTER TABLE products
ADD FOREIGN KEY (category_id) REFERENCES categories(category_id);

ALTER TABLE products
ADD FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id);

ALTER TABLE orders
ADD FOREIGN KEY (customer_id) REFERENCES customers(customer_id);

ALTER TABLE order_items
ADD FOREIGN KEY (order_id) REFERENCES orders(order_id);

ALTER TABLE order_items
ADD FOREIGN KEY (product_id) REFERENCES products(product_id);
INSERT INTO categories VALUES (1, 'Electronics', 'Electronic devices');
INSERT INTO categories VALUES (2, 'Clothing', 'Clothes and fashion');
INSERT INTO categories VALUES (3, 'Food', 'Food and drinks');
INSERT INTO categories VALUES (4, 'Home & Kitchen', 'Home items');
INSERT INTO categories VALUES (5, 'Books', 'Books and stationery');
INSERT INTO categories VALUES (6, 'Sports', 'Sports items');
INSERT INTO categories VALUES (7, 'Beauty', 'Beauty products');
INSERT INTO suppliers VALUES (1, 'TechSupply Co.', 'John Smith', 'john@techsupply.com', '555-0101', '123 Tech Street');
INSERT INTO suppliers VALUES (2, 'Fashion Wholesale', 'Sarah Johnson', 'sarah@fashion.com', '555-0102', '456 Fashion Ave');
INSERT INTO suppliers VALUES (3, 'Global Foods', 'Michael Chen', 'michael@foods.com', '555-0103', '789 Food Plaza');
INSERT INTO suppliers VALUES (4, 'HomeGoods', 'Emily Davis', 'emily@homegoods.com', '555-0104', '321 Home Blvd');
INSERT INTO suppliers VALUES (5, 'Book World', 'David Wilson', 'david@bookworld.com', '555-0105', '654 Book Lane');
INSERT INTO products VALUES (1, 'Wireless Mouse', 1, 1, 50, 25.99);
INSERT INTO products VALUES (2, 'USB Cable', 1, 1, 100, 12.50);
INSERT INTO products VALUES (3, 'Headphones', 1, 1, 30, 79.99);
INSERT INTO products VALUES (4, 'T-Shirt', 2, 2, 120, 15.99);
INSERT INTO products VALUES (5, 'Jeans', 2, 2, 60, 45.00);
INSERT INTO products VALUES (6, 'Coffee Beans', 3, 3, 70, 18.99);
INSERT INTO products VALUES (7, 'Green Tea', 3, 3, 55, 8.50);
INSERT INTO products VALUES (8, 'Knife Set', 4, 4, 35, 89.99);
INSERT INTO products VALUES (9, 'Frying Pan', 4, 4, 50, 32.50);
INSERT INTO products VALUES (10, 'Notebook', 5, 5, 150, 12.99);
INSERT INTO customers VALUES (1, 'Alice Williams', 'alice@email.com', '555-1001', '100 Maple Street');
INSERT INTO customers VALUES (2, 'Bob Thompson', 'bob@email.com', '555-1002', '200 Oak Avenue');
INSERT INTO customers VALUES (3, 'Carol Martinez', 'carol@email.com', '555-1003', '300 Pine Road');
INSERT INTO customers VALUES (4, 'David Brown', 'david@email.com', '555-1004', '400 Cedar Lane');
INSERT INTO customers VALUES (5, 'Emma Garcia', 'emma@email.com', '555-1005', '500 Birch Street');
INSERT INTO orders VALUES (1, 1, '2024-01-15', 105.98, 'Completed');
INSERT INTO orders VALUES (2, 2, '2024-01-18', 89.99, 'Completed');
INSERT INTO orders VALUES (3, 3, '2024-01-20', 156.47, 'Processing');
INSERT INTO orders VALUES (4, 4, '2024-01-22', 67.50, 'Pending');
INSERT INTO orders VALUES (5, 5, '2024-01-25', 234.95, 'Completed');
INSERT INTO order_items VALUES (1, 1, 1, 2, 25.99, 51.98);
INSERT INTO order_items VALUES (2, 2, 3, 1, 79.99, 79.99);
INSERT INTO order_items VALUES (3, 3, 8, 1, 89.99, 89.99);
INSERT INTO order_items VALUES (4, 4, 6, 2, 15.99, 31.98);
INSERT INTO order_items VALUES (5, 5, 5, 2, 45.00, 90.00);
