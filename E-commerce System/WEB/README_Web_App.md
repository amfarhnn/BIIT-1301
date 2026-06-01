# E-Commerce System Web Application

## Requirement Covered

This PHP web application covers Task 9:

- Connect to the database
- Insert product records
- Update product and order records
- Delete product records
- Execute the `add_product` and `list_customer_orders` procedures
- Execute the `customer_discount` and `order_total` functions

## Files

| File | Purpose |
| --- | --- |
| `config.php` | Oracle username, password and connection string. |
| `lib.php` | Database connection, query helpers, layout helpers and DBMS_OUTPUT capture. |
| `index.php` | Dashboard summary and recent orders. |
| `products.php` | Product insert, update and delete. |
| `orders.php` | Order list and order status update. |
| `customers.php` | Customer list with total orders and total spending. |
| `procedures.php` | Runs stored procedures. |
| `functions_demo.php` | Runs stored functions. |
| `assets/style.css` | Web application styling. |

## Setup

1. Run `SCRIPT/ecommerce_table.sql` in Oracle SQL Developer.
2. Run `SCRIPT/ecommerce_data.sql`.
3. Run `SCRIPT/ecommerce_procedures.sql`.
4. Run `SCRIPT/ecommerce_functions.sql`.
5. Copy the `WEB` folder into your local PHP server folder, such as XAMPP `htdocs`.
6. Open `WEB/config.php` and update the Oracle account:

```php
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
define('DB_CONNECTION_STRING', 'localhost/XEPDB1');
```

7. Make sure PHP OCI8 is enabled.
8. Open the app in a browser, for example:

```text
http://localhost/WEB/index.php
```

## Notes

If your Oracle service name is different, change `DB_CONNECTION_STRING`. Common values are `localhost/XEPDB1`, `localhost/XE`, or a full connection descriptor from Oracle SQL Developer.

