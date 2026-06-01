-- E-Commerce System Database
-- Task 6: SQL statements for query, insert, update and delete operations

-- 6.1.1 Display customers with the highest total spending.
SELECT c.customerID,
       c.customerName,
       SUM(p.paymentAmount) AS totalSpent
FROM customer c
JOIN payment p ON c.customerID = p.customerID
WHERE p.paymentStatus = 'PAID'
GROUP BY c.customerID, c.customerName
HAVING SUM(p.paymentAmount) = (
  SELECT MAX(customerTotal)
  FROM (
    SELECT SUM(paymentAmount) AS customerTotal
    FROM payment
    WHERE paymentStatus = 'PAID'
    GROUP BY customerID
  )
);

-- 6.1.2 Display all available products with category names.
SELECT p.productID,
       p.productName,
       c.categoryName,
       p.unitPrice,
       p.stockQty,
       p.productStatus
FROM product p
JOIN category c ON p.categoryID = c.categoryID
WHERE p.productStatus IN ('AVAILABLE', 'LOW STOCK')
ORDER BY c.categoryName, p.productName;

-- 6.1.3 Display all orders made by customer 2001.
SELECT so.orderID,
       c.customerName,
       so.orderDate,
       so.orderStatus,
       so.totalAmount
FROM sales_order so
JOIN customer c ON so.customerID = c.customerID
WHERE so.customerID = 2001
ORDER BY so.orderDate;

-- 6.1.4 Display order item details for order 4001.
SELECT so.orderID,
       p.productName,
       oi.quantity,
       oi.unitPrice,
       oi.lineTotal
FROM sales_order so
JOIN order_item oi ON so.orderID = oi.orderID
JOIN product p ON oi.productID = p.productID
WHERE so.orderID = 4001;

-- 6.1.5 Display products that need restocking.
SELECT productID,
       productName,
       stockQty,
       productStatus
FROM product
WHERE stockQty < 10
ORDER BY stockQty ASC;

-- 6.1.6 Display monthly sales total for paid payments.
SELECT TO_CHAR(paymentDate, 'YYYY-MM') AS salesMonth,
       COUNT(paymentID) AS totalPayments,
       SUM(paymentAmount) AS totalSales
FROM payment
WHERE paymentStatus = 'PAID'
GROUP BY TO_CHAR(paymentDate, 'YYYY-MM')
ORDER BY salesMonth;

-- 6.2 Insert statement: allow admin to add a new product.
INSERT INTO product
VALUES (3013, 208, 1009, 'SQL Practice Workbook', 'LearnPro', 55.00, 35, 'AVAILABLE', SYSDATE);

-- 6.3 Update statement: modify product stock after a restock.
UPDATE product
SET stockQty = stockQty + 25,
    productStatus = 'AVAILABLE'
WHERE productID = 3008;

-- 6.4 Update statement: update an order status.
UPDATE sales_order
SET orderStatus = 'SHIPPED'
WHERE orderID = 4005;

-- 6.5 Delete statement: remove the newly inserted product.
DELETE FROM product
WHERE productID = 3013;

-- Use COMMIT after checking results, or ROLLBACK during testing.
-- COMMIT;

