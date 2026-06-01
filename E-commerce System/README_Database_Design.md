# E-Commerce System Database Design

## Project Scenario

The E-Commerce System is designed for an online store that sells products from multiple categories such as electronics, fashion, home appliances, books, toys and groceries. Customers can browse products, place orders, make payments and receive shipments. Admin users manage product records, process orders and monitor customer purchases.

This database is needed because an e-commerce platform handles many connected records: customer profiles, product inventories, order details, payment status and delivery tracking. A structured database helps the business reduce duplicate data, track stock levels, calculate sales, update order progress and retrieve reports accurately.

## Main Entities

The database contains 8 main entities:

1. `admin`
2. `customer`
3. `category`
4. `product`
5. `sales_order`
6. `order_item`
7. `payment`
8. `shipment`

## Relationship Summary

| Relationship | Type | Explanation |
| --- | --- | --- |
| `admin` to `product` | One-to-many | One admin can manage many products. |
| `admin` to `sales_order` | One-to-many | One admin can handle many orders. |
| `customer` to `sales_order` | One-to-many | One customer can place many orders. |
| `category` to `product` | One-to-many | One category can contain many products. |
| `sales_order` to `order_item` | One-to-many | One order can contain many items. |
| `product` to `order_item` | One-to-many | One product can appear in many order items. |
| `sales_order` to `payment` | One-to-one | One order has one payment record. |
| `sales_order` to `shipment` | One-to-one | One order has one shipment record. |

## Data Dictionary

### ADMIN

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| adminID | NUMBER | 4 | NO (PK) |
| adminName | VARCHAR2 | 50 | NO |
| adminEmail | VARCHAR2 | 60 | NO (UK) |
| adminContact | VARCHAR2 | 15 | NO |
| adminPassword | VARCHAR2 | 30 | NO |

### CUSTOMER

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| customerID | NUMBER | 4 | NO (PK) |
| customerName | VARCHAR2 | 60 | NO |
| customerEmail | VARCHAR2 | 60 | NO (UK) |
| customerPhone | VARCHAR2 | 15 | NO |
| customerAddress | VARCHAR2 | 120 | NO |
| customerPassword | VARCHAR2 | 30 | NO |
| joinDate | DATE | - | NO |

### CATEGORY

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| categoryID | NUMBER | 3 | NO (PK) |
| categoryName | VARCHAR2 | 40 | NO (UK) |
| categoryDescription | VARCHAR2 | 120 | YES |

### PRODUCT

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| productID | NUMBER | 4 | NO (PK) |
| categoryID | NUMBER | 3 | NO (FK) |
| adminID | NUMBER | 4 | NO (FK) |
| productName | VARCHAR2 | 60 | NO |
| productBrand | VARCHAR2 | 40 | YES |
| unitPrice | NUMBER | 8,2 | NO |
| stockQty | NUMBER | 5 | NO |
| productStatus | VARCHAR2 | 20 | NO |
| createdDate | DATE | - | NO |

### SALES_ORDER

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| orderID | NUMBER | 5 | NO (PK) |
| customerID | NUMBER | 4 | NO (FK) |
| adminID | NUMBER | 4 | NO (FK) |
| orderDate | DATE | - | NO |
| orderStatus | VARCHAR2 | 20 | NO |
| subtotal | NUMBER | 10,2 | NO |
| deliveryFee | NUMBER | 6,2 | NO |
| totalAmount | NUMBER | 10,2 | NO |

### ORDER_ITEM

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| orderItemID | NUMBER | 5 | NO (PK) |
| orderID | NUMBER | 5 | NO (FK) |
| productID | NUMBER | 4 | NO (FK) |
| quantity | NUMBER | 4 | NO |
| unitPrice | NUMBER | 8,2 | NO |
| lineTotal | NUMBER | 10,2 | NO |

### PAYMENT

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| paymentID | NUMBER | 5 | NO (PK) |
| orderID | NUMBER | 5 | NO (FK, UK) |
| customerID | NUMBER | 4 | NO (FK) |
| paymentDate | DATE | - | NO |
| paymentMethod | VARCHAR2 | 20 | NO |
| paymentStatus | VARCHAR2 | 20 | NO |
| paymentAmount | NUMBER | 10,2 | NO |

### SHIPMENT

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| shipmentID | NUMBER | 5 | NO (PK) |
| orderID | NUMBER | 5 | NO (FK, UK) |
| courierName | VARCHAR2 | 40 | NO |
| trackingNo | VARCHAR2 | 30 | YES |
| shippingAddress | VARCHAR2 | 120 | NO |
| shippedDate | DATE | - | YES |
| deliveredDate | DATE | - | YES |
| shipmentStatus | VARCHAR2 | 20 | NO |

## Script Files

| File | Purpose |
| --- | --- |
| `SCRIPT/ecommerce_table.sql` | Creates all tables, primary keys, foreign keys, unique constraints and check constraints. |
| `SCRIPT/ecommerce_data.sql` | Inserts sample records into all tables. |
| `SCRIPT/ecommerce_queries.sql` | Contains SELECT, INSERT, UPDATE and DELETE examples. |
| `SCRIPT/ecommerce_procedures.sql` | Contains two procedures and anonymous block examples. |
| `SCRIPT/ecommerce_functions.sql` | Contains two functions and anonymous block examples. |
| `ERD.mmd` | Mermaid ER diagram source. |

## Suggested Report Sections

1. Project Scenario
2. ER Diagram
3. Data Dictionary
4. Create Table Command
5. Insert Command
6. SQL Statements
7. Procedures and Functions
8. Web Application
9. Members' Contribution

