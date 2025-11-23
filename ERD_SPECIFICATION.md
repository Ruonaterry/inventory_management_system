# ENTITY-RELATIONSHIP DIAGRAM (ERD) SPECIFICATION
## Inventory Management System - Oracle Notation

**Project:** Database Systems - Group 1  
**Topic:** Inventory Management System  
**Date:** November 2024

---

## OVERVIEW

This document provides complete specifications for creating the Entity-Relationship Diagram (ERD) using Oracle notation (crow's foot notation). This ERD is based on the Business Information Requirements document and represents the conceptual data model of the Inventory Management System.

---

## ENTITIES AND ATTRIBUTES

### Entity 1: CATEGORIES
**Description:** Product categories for organizing inventory items

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| category_id | Integer | PK | Yes | Unique identifier for category |
| category_name | String(100) | - | Yes | Name of the category |
| description | String(255) | - | No | Description of category |

### Entity 2: SUPPLIERS
**Description:** Companies that supply products to the store

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| supplier_id | Integer | PK | Yes | Unique identifier for supplier |
| supplier_name | String(150) | - | Yes | Company name of supplier |
| contact_person | String(100) | - | Yes | Name of contact person |
| email | String(100) | - | Yes | Email address |
| phone | String(20) | - | Yes | Phone number |
| address | String(255) | - | No | Physical address |

### Entity 3: PRODUCTS
**Description:** Items available in inventory

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| product_id | Integer | PK | Yes | Unique identifier for product |
| product_name | String(200) | - | Yes | Name of the product |
| category_id | Integer | FK | No | Reference to category |
| supplier_id | Integer | FK | No | Reference to supplier |
| quantity | Integer | - | Yes | Current stock quantity |
| price | Decimal(10,2) | - | Yes | Selling price |

### Entity 4: CUSTOMERS
**Description:** Store customers who place orders

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| customer_id | Integer | PK | Yes | Unique identifier for customer |
| customer_name | String(150) | - | Yes | Full name of customer |
| email | String(100) | - | No | Email address |
| phone | String(20) | - | No | Phone number |
| address | String(255) | - | No | Delivery/billing address |

### Entity 5: ORDERS
**Description:** Customer purchase orders

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| order_id | Integer | PK | Yes | Unique identifier for order |
| customer_id | Integer | FK | No | Reference to customer |
| order_date | Date | - | Yes | Date order was placed |
| total_amount | Decimal(10,2) | - | Yes | Total order amount |
| status | String(50) | - | Yes | Order status |

### Entity 6: ORDER_ITEMS
**Description:** Individual line items within an order

| Attribute Name | Data Type | Key Type | Mandatory | Description |
|---------------|-----------|----------|-----------|-------------|
| order_item_id | Integer | PK | Yes | Unique identifier for order item |
| order_id | Integer | FK | Yes | Reference to order |
| product_id | Integer | FK | No | Reference to product |
| quantity | Integer | - | Yes | Quantity ordered |
| unit_price | Decimal(10,2) | - | Yes | Price per unit at time of order |
| subtotal | Decimal(10,2) | - | Yes | Line item total |

---

## RELATIONSHIPS

### Relationship 1: CATEGORIES to PRODUCTS
- **Name:** "contains" / "belongs to"
- **Entities:** CATEGORIES (1) ——< PRODUCTS (Many)
- **Type:** One-to-Many
- **Cardinality:** 
  - One category can contain zero or many products (0..*)
  - Each product belongs to zero or one category (0..1)
- **Oracle Notation:** 
  - CATEGORIES side: Single line (one)
  - PRODUCTS side: Crow's foot (many)
- **Participation:**
  - CATEGORIES: Optional (a category can exist without products)
  - PRODUCTS: Optional (a product can exist without a category)
- **Foreign Key:** category_id in PRODUCTS references category_id in CATEGORIES

### Relationship 2: SUPPLIERS to PRODUCTS
- **Name:** "supplies" / "supplied by"
- **Entities:** SUPPLIERS (1) ——< PRODUCTS (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One supplier can supply zero or many products (0..*)
  - Each product is supplied by zero or one supplier (0..1)
- **Oracle Notation:**
  - SUPPLIERS side: Single line (one)
  - PRODUCTS side: Crow's foot (many)
- **Participation:**
  - SUPPLIERS: Optional (a supplier can exist without products)
  - PRODUCTS: Optional (a product can exist without a supplier)
- **Foreign Key:** supplier_id in PRODUCTS references supplier_id in SUPPLIERS

### Relationship 3: CUSTOMERS to ORDERS
- **Name:** "places" / "placed by"
- **Entities:** CUSTOMERS (1) ——< ORDERS (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One customer can place zero or many orders (0..*)
  - Each order is placed by zero or one customer (0..1)
- **Oracle Notation:**
  - CUSTOMERS side: Single line (one)
  - ORDERS side: Crow's foot (many)
- **Participation:**
  - CUSTOMERS: Optional (a customer can exist without orders)
  - ORDERS: Optional (an order can exist without a customer reference)
- **Foreign Key:** customer_id in ORDERS references customer_id in CUSTOMERS

### Relationship 4: ORDERS to ORDER_ITEMS
- **Name:** "contains" / "belongs to"
- **Entities:** ORDERS (1) ——< ORDER_ITEMS (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One order can contain one or many order items (1..*)
  - Each order item belongs to exactly one order (1..1)
- **Oracle Notation:**
  - ORDERS side: Single line with mandatory mark (one and mandatory)
  - ORDER_ITEMS side: Crow's foot with mandatory mark (many and mandatory)
- **Participation:**
  - ORDERS: Mandatory (an order must have at least one order item)
  - ORDER_ITEMS: Mandatory (an order item must belong to an order)
- **Foreign Key:** order_id in ORDER_ITEMS references order_id in ORDERS

### Relationship 5: PRODUCTS to ORDER_ITEMS
- **Name:** "appears in" / "contains"
- **Entities:** PRODUCTS (1) ——< ORDER_ITEMS (Many)
- **Type:** One-to-Many
- **Cardinality:**
  - One product can appear in zero or many order items (0..*)
  - Each order item references zero or one product (0..1)
- **Oracle Notation:**
  - PRODUCTS side: Single line (one)
  - ORDER_ITEMS side: Crow's foot (many)
- **Participation:**
  - PRODUCTS: Optional (a product can exist without being ordered)
  - ORDER_ITEMS: Optional (an order item can exist without product reference if product is deleted)
- **Foreign Key:** product_id in ORDER_ITEMS references product_id in PRODUCTS

---

## ERD LAYOUT INSTRUCTIONS FOR DRAW.IO

### Step-by-Step Guide:

#### 1. Open Draw.io
- Go to https://app.diagrams.net/
- Select "Create New Diagram"
- Choose "Blank Diagram"

#### 2. Enable Entity-Relationship Shapes
- Click on "More Shapes" at the bottom of the left panel
- Check "Entity Relation" or "ER Diagram"
- Click "Apply"

#### 3. Create Entities (Rectangles)
Create six entity boxes with the following layout suggestion:

```
Top Row:
[CATEGORIES]        [SUPPLIERS]

Middle Row:
            [PRODUCTS]

Bottom Row:
[CUSTOMERS]         [ORDERS]         [ORDER_ITEMS]
```

#### 4. Add Attributes to Each Entity
For each entity, list all attributes inside the box:
- **Bold** or underline Primary Keys (PK)
- Mark Foreign Keys with (FK)
- Use format: attribute_name : data_type

Example for PRODUCTS entity:
```
┌─────────────────────────┐
│      PRODUCTS           │
├─────────────────────────┤
│ PK: product_id         │
│     product_name       │
│ FK: category_id        │
│ FK: supplier_id        │
│     quantity           │
│     price              │
└─────────────────────────┘
```

#### 5. Draw Relationships
Use the connector tool with crow's foot notation:

**Notation Symbols:**
- **One (mandatory):** Single line with perpendicular line |—
- **One (optional):** Single line with circle ○—
- **Many (mandatory):** Crow's foot with perpendicular line |<
- **Many (optional):** Crow's foot with circle ○<

**Draw these connections:**

1. **CATEGORIES to PRODUCTS**
   - From CATEGORIES: ○— (optional one)
   - To PRODUCTS: ○< (optional many)

2. **SUPPLIERS to PRODUCTS**
   - From SUPPLIERS: ○— (optional one)
   - To PRODUCTS: ○< (optional many)

3. **CUSTOMERS to ORDERS**
   - From CUSTOMERS: ○— (optional one)
   - To ORDERS: ○< (optional many)

4. **ORDERS to ORDER_ITEMS**
   - From ORDERS: |— (mandatory one)
   - To ORDER_ITEMS: |< (mandatory many)

5. **PRODUCTS to ORDER_ITEMS**
   - From PRODUCTS: ○— (optional one)
   - To ORDER_ITEMS: ○< (optional many)

#### 6. Label Relationships
Add text labels above/below each relationship line:
- CATEGORIES ——< PRODUCTS: "contains" or "classifies"
- SUPPLIERS ——< PRODUCTS: "supplies"
- CUSTOMERS ——< ORDERS: "places"
- ORDERS ——< ORDER_ITEMS: "contains"
- PRODUCTS ——< ORDER_ITEMS: "ordered as"

#### 7. Add Title and Legend
- Add a title box at the top: "Inventory Management System - ERD"
- Add your group information
- Add a legend explaining:
  - PK = Primary Key
  - FK = Foreign Key
  - Crow's foot notation symbols

#### 8. Formatting Tips
- Use consistent colors (e.g., light blue for entity headers)
- Align entities neatly
- Keep relationship lines clean and not crossing unnecessarily
- Use 12-14pt font for readability
- Export as PNG or PDF for submission

---

## CARDINALITY SUMMARY TABLE

| Relationship | Parent Entity | Child Entity | Parent Cardinality | Child Cardinality |
|-------------|---------------|--------------|-------------------|-------------------|
| Contains/Belongs to | CATEGORIES | PRODUCTS | 0..* (optional many) | 0..1 (optional one) |
| Supplies/Supplied by | SUPPLIERS | PRODUCTS | 0..* (optional many) | 0..1 (optional one) |
| Places/Placed by | CUSTOMERS | ORDERS | 0..* (optional many) | 0..1 (optional one) |
| Contains/Belongs to | ORDERS | ORDER_ITEMS | 1..* (mandatory many) | 1..1 (mandatory one) |
| Ordered as/Appears in | PRODUCTS | ORDER_ITEMS | 0..* (optional many) | 0..1 (optional one) |

---

## BUSINESS RULES REFLECTED IN ERD

1. **Product Classification:** Products are organized by categories, but a product can exist without category assignment (optional relationship)

2. **Supplier Management:** Each product is linked to a supplier, but products can exist without supplier assignment (optional relationship)

3. **Customer Orders:** Customers place orders, but customers can exist in the system without placing orders, and orders can exist without customer reference (optional relationship)

4. **Order Composition:** Every order must contain at least one order item, and every order item must belong to an order (mandatory relationship on both sides)

5. **Product Ordering:** Products can be ordered multiple times, and order items reference products, but order items can exist even if the product is later deleted (optional relationship)

---

## NORMALIZATION VERIFICATION

The ERD represents a database in **Third Normal Form (3NF)**:

### First Normal Form (1NF)
✓ All attributes contain atomic values  
✓ No repeating groups  
✓ Each table has a primary key

### Second Normal Form (2NF)
✓ In 1NF  
✓ No partial dependencies (all non-key attributes depend on the entire primary key)

### Third Normal Form (3NF)
✓ In 2NF  
✓ No transitive dependencies (non-key attributes depend only on the primary key)

---

## ADDITIONAL NOTES

### Foreign Key Constraints
All foreign keys in the ERD have optional participation (NULL allowed) except:
- order_id in ORDER_ITEMS (mandatory - an order item must belong to an order)

This design allows:
- Products to exist before category assignment
- Products to exist before supplier assignment
- Orders to exist without customer reference (walk-in customers)
- Order items to reference deleted products (historical data preservation)

### Data Integrity
The ERD ensures:
- Referential integrity through foreign key relationships
- Entity integrity through primary keys
- Domain integrity through appropriate data types

---

**Document Prepared By:** Group 1 - Inventory Management System  
**Academic Institution:** Database Systems Course  
**Date:** November 2024

---

## SUBMISSION CHECKLIST

- [ ] ERD created in Draw.io or MS Visio
- [ ] All 6 entities included with complete attributes
- [ ] Primary keys clearly marked
- [ ] Foreign keys clearly marked
- [ ] All 5 relationships drawn with correct cardinality
- [ ] Crow's foot notation used correctly
- [ ] Relationship names added
- [ ] Mandatory/optional participation indicated
- [ ] Title and legend included
- [ ] Exported as high-resolution image or PDF
- [ ] ERD matches Business Information Requirements document
