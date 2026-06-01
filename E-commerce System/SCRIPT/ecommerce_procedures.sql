-- E-Commerce System Database
-- Task 7: Procedures

SET SERVEROUTPUT ON
SET VERIFY OFF

-- 7.1.1 Allow admin to add a new product.
CREATE OR REPLACE PROCEDURE add_product (
  p_productID     IN product.productID%TYPE,
  p_categoryID    IN product.categoryID%TYPE,
  p_adminID       IN product.adminID%TYPE,
  p_productName   IN product.productName%TYPE,
  p_productBrand  IN product.productBrand%TYPE,
  p_unitPrice     IN product.unitPrice%TYPE,
  p_stockQty      IN product.stockQty%TYPE,
  p_productStatus IN product.productStatus%TYPE
) IS
BEGIN
  INSERT INTO product (
    productID,
    categoryID,
    adminID,
    productName,
    productBrand,
    unitPrice,
    stockQty,
    productStatus,
    createdDate
  )
  VALUES (
    p_productID,
    p_categoryID,
    p_adminID,
    p_productName,
    p_productBrand,
    p_unitPrice,
    p_stockQty,
    p_productStatus,
    SYSDATE
  );

  DBMS_OUTPUT.PUT_LINE('Product ' || p_productName || ' has been added successfully.');
EXCEPTION
  WHEN DUP_VAL_ON_INDEX THEN
    DBMS_OUTPUT.PUT_LINE('Product ID already exists.');
  WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Error while adding product: ' || SQLERRM);
END add_product;
/

-- Anonymous block example for add_product.
BEGIN
  add_product(3014, 201, 1001, 'Bluetooth Speaker', 'SoundMax', 89.90, 50, 'AVAILABLE');
END;
/

-- 7.1.2 Retrieve all orders for a selected customer using a cursor.
CREATE OR REPLACE PROCEDURE list_customer_orders (
  p_customerID IN customer.customerID%TYPE
) IS
  v_customerName customer.customerName%TYPE;

  CURSOR order_cur IS
    SELECT so.orderID,
           so.orderDate,
           so.orderStatus,
           so.totalAmount,
           p.paymentStatus
    FROM sales_order so
    JOIN payment p ON so.orderID = p.orderID
    WHERE so.customerID = p_customerID
    ORDER BY so.orderDate;
BEGIN
  SELECT customerName
  INTO v_customerName
  FROM customer
  WHERE customerID = p_customerID;

  DBMS_OUTPUT.PUT_LINE('Orders for customer: ' || v_customerName);

  FOR order_rec IN order_cur LOOP
    DBMS_OUTPUT.PUT_LINE(
      'Order ID: ' || order_rec.orderID ||
      ' | Date: ' || TO_CHAR(order_rec.orderDate, 'DD-MON-YYYY') ||
      ' | Order Status: ' || order_rec.orderStatus ||
      ' | Payment Status: ' || order_rec.paymentStatus ||
      ' | Total: RM ' || order_rec.totalAmount
    );
  END LOOP;
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    DBMS_OUTPUT.PUT_LINE('Customer ID was not found.');
  WHEN OTHERS THEN
    DBMS_OUTPUT.PUT_LINE('Error while retrieving customer orders: ' || SQLERRM);
END list_customer_orders;
/

-- Anonymous block example for list_customer_orders.
BEGIN
  list_customer_orders(2001);
END;
/

