# BUSINESS INFORMATION REQUIREMENTS
## Inventory Management System for A Store

**Project:** Database Systems - Group 1  
**Topic:** Inventory Management System  
**Date:** November 2024

---

## 1. BUSINESS OVERVIEW

### 1.1 System Purpose
The Inventory Management System is designed to help a retail store manage its products, track inventory levels, maintain supplier relationships, handle customer orders, and monitor stock status. The system enables efficient inventory control by tracking product quantities, generating alerts for low stock items, and maintaining records of all business transactions.

### 1.2 Business Objectives
- Track all products and their current stock levels
- Manage supplier information and product sources
- Organize products into categories for easy classification
- Process customer orders efficiently
- Monitor inventory status and generate alerts for restocking
- Maintain accurate records of all transactions

---

## 2. INFORMATION REQUIREMENTS

### 2.1 Product Information
The system must capture and manage the following product details:
- **Product Identification:** Unique product ID and SKU (Stock Keeping Unit)
- **Product Details:** Product name and description
- **Classification:** Category assignment for grouping similar items
- **Supplier Information:** Which supplier provides the product
- **Inventory Data:** Current quantity in stock
- **Pricing Information:** Selling price per unit
- **Stock Control:** Reorder level to trigger restocking alerts
- **Unit of Measure:** How the product is measured (pieces, kilograms, liters, etc.)

### 2.2 Category Information
To organize products effectively, the system must track:
- **Category Identification:** Unique category ID
- **Category Name:** Name of the product category (e.g., Electronics, Clothing, Food)
- **Description:** Brief explanation of what products belong in this category

### 2.3 Supplier Information
For managing relationships with product suppliers, the system must maintain:
- **Supplier Identification:** Unique supplier ID
- **Company Details:** Supplier company name
- **Contact Information:** 
  - Contact person name
  - Email address
  - Phone number
  - Physical address

### 2.4 Customer Information
To process orders, the system must store customer details:
- **Customer Identification:** Unique customer ID
- **Personal Information:** Customer full name
- **Contact Details:**
  - Email address
  - Phone number
  - Delivery/billing address

### 2.5 Order Information
For tracking customer purchases, the system must capture:
- **Order Identification:** Unique order ID
- **Customer Reference:** Which customer placed the order
- **Order Date:** When the order was placed
- **Financial Information:** Total amount of the order
- **Order Status:** Current state of the order (Pending, Processing, Completed, Cancelled)
- **Payment Status:** Payment state (Pending, Paid, Partial)

### 2.6 Order Items Information
For detailed order tracking, each order must contain:
- **Order Item Identification:** Unique order item ID
- **Order Reference:** Which order this item belongs to
- **Product Reference:** Which product was ordered
- **Quantity Information:** How many units were ordered
- **Pricing Data:**
  - Unit price at the time of order
  - Subtotal for this line item (quantity × unit price)

---

## 3. BUSINESS RULES AND RELATIONSHIPS

### 3.1 Product Management Rules
- Each product must belong to exactly one category
- Each product must be supplied by exactly one supplier
- Products have a reorder level; when quantity falls to or below this level, restocking is needed
- Product stock status is determined by:
  - **Out of Stock:** Quantity = 0
  - **Low Stock:** Quantity ≤ Reorder Level
  - **In Stock:** Quantity > Reorder Level

### 3.2 Supplier-Product Relationship
- One supplier can provide multiple products
- Each product is supplied by one supplier only
- Supplier information is crucial for restocking purposes

### 3.3 Category-Product Relationship
- One category can contain multiple products
- Each product belongs to only one category
- Categories help organize inventory and generate reports

### 3.4 Customer-Order Relationship
- One customer can place multiple orders over time
- Each order is associated with exactly one customer
- Customer information is necessary for order processing and delivery

### 3.5 Order-Order Items Relationship
- One order can contain multiple order items (different products)
- Each order item belongs to exactly one order
- Order items record what products were purchased and in what quantities

### 3.6 Product-Order Items Relationship
- One product can appear in multiple order items across different orders
- Each order item references one product
- Order items capture the product price at the time of purchase (historical pricing)

### 3.7 Pricing and Calculation Rules
- Order item subtotal is calculated as: Quantity × Unit Price
- Order total amount is the sum of all order item subtotals
- Prices are stored with 2 decimal places for currency accuracy

---

## 4. OPERATIONAL REQUIREMENTS

### 4.1 Stock Management
- The system must track current inventory levels for all products
- When products are sold, quantities must be adjusted
- Low stock alerts should be generated when quantity reaches reorder level
- System must prevent negative stock quantities

### 4.2 Order Processing
- Orders must capture the current price of products at the time of sale
- Each order must calculate and store the total amount
- Order status must be tracked throughout the fulfillment process
- Payment status must be recorded separately from order status

### 4.3 Reporting Needs
- Identify products that need restocking (low stock items)
- Track best-selling products
- Calculate total inventory value
- Monitor order completion rates
- Track payment collection status

### 4.4 Data Integrity Requirements
- Product SKUs must be unique to avoid confusion
- All financial amounts must be stored with proper decimal precision
- Dates must be recorded for all orders for historical tracking
- Customer and supplier contact information must be complete for communication

---

## 5. USER INFORMATION NEEDS

### 5.1 Inventory Manager Needs
- View all products with current stock levels
- Add new products to inventory
- Update product information (prices, quantities, suppliers)
- Remove discontinued products
- Identify low stock items requiring reorder

### 5.2 Sales Staff Needs
- Access customer information
- Create new orders for customers
- View order history
- Update order and payment status
- Check product availability before selling

### 5.3 Management Needs
- Overview of total inventory value
- Sales performance reports
- Supplier performance analysis
- Stock turnover rates
- Low stock alerts for purchasing decisions

---

## 6. SYSTEM CONSTRAINTS

### 6.1 Data Volume
- System must handle multiple product categories (currently 7 categories)
- Support for multiple suppliers (currently 5 suppliers)
- Track numerous products across categories (currently 10 products)
- Manage customer base and order history (currently 5 customers, 5 orders)

### 6.2 Data Accuracy
- All monetary values must maintain 2 decimal place precision
- Dates must be stored in standard format (YYYY-MM-DD)
- Stock quantities must be whole numbers (integers)
- All required fields must be completed before saving records

---

## 7. FUTURE CONSIDERATIONS

### 7.1 Potential Enhancements
- Add user authentication and role-based access
- Implement barcode scanning for faster product lookup
- Include product images
- Add purchase order management for supplier ordering
- Implement automated reorder triggers
- Add inventory adjustment logs for tracking changes
- Include sales analytics and forecasting

### 7.2 Scalability Needs
- System should accommodate growing product catalog
- Support for multiple store locations
- Handle increasing transaction volumes
- Maintain performance with larger datasets

---

## 8. SUMMARY

This Inventory Management System captures essential business information needed to operate a retail store efficiently. The system tracks six main entities (Categories, Suppliers, Products, Customers, Orders, and Order Items) with clear relationships between them. The information requirements support core business operations including inventory tracking, supplier management, order processing, and stock control. The system provides the foundation for efficient inventory management while maintaining data integrity and supporting business decision-making through accurate information capture and storage.

---

**Document Prepared By:** Group 1 - Inventory Management System  
**Academic Institution:** Database Systems Course  
**Instructor Approval:** _______________  
**Date:** November 2024
