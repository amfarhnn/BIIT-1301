# E-Commerce System Setup Guide

## SQL Developer Setup

Run the SQL files in this order:

1. `SCRIPT/ecommerce_table.sql`
2. `SCRIPT/ecommerce_data.sql`
3. `SCRIPT/ecommerce_procedures.sql`
4. `SCRIPT/ecommerce_functions.sql`
5. `SCRIPT/ecommerce_queries.sql`

You may also run `SCRIPT/run_all.sql` from inside the `SCRIPT` folder to execute the main setup files in order.

## Web Application Setup

1. Place the `WEB` folder in your PHP server directory.
2. Open `WEB/config.php`.
3. Change the Oracle username, password and service name.
4. Make sure PHP OCI8 is enabled.
5. Open the dashboard page:

```text
http://localhost/WEB/index.php
```

## Docker Web Application Setup

Docker runs Apache, PHP, and OCI8 in an isolated container while connecting to
the Oracle XE database running on Windows.

1. Copy `.env.example` to `.env` and enter the Oracle account password.
2. From the `E-commerce System` folder, run:

```powershell
docker compose up --build
```

3. Open:

```text
http://localhost:8081
```

The Docker app connects to Oracle XE using `host.docker.internal:1521/XE`.

## Suggested Demo Flow

1. Show the dashboard.
2. Open Products and add a new product.
3. Update the product price or stock.
4. Delete a test product.
5. Open Orders and update an order status.
6. Open Procedures and run `list_customer_orders`.
7. Open Functions and run `customer_discount` and `order_total`.

## Report Completion Notes

Before submitting, add screenshots of:

1. Tables created in SQL Developer
2. Sample data result sets
3. Query result sets
4. Procedure outputs
5. Function outputs
6. Web app dashboard
7. Web app insert/update/delete pages
