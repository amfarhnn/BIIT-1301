-- E-Commerce System Database
-- Task 8: Functions

SET SERVEROUTPUT ON
SET VERIFY OFF

-- 8.1.1 Calculate discount percentage based on a customer's paid spending.
CREATE OR REPLACE FUNCTION customer_discount (
  p_customerID IN customer.customerID%TYPE
) RETURN NUMBER IS
  v_totalSpent NUMBER(10,2);
  v_discount   NUMBER(4,2);
BEGIN
  SELECT NVL(SUM(paymentAmount), 0)
  INTO v_totalSpent
  FROM payment
  WHERE customerID = p_customerID
    AND paymentStatus = 'PAID';

  IF v_totalSpent >= 500 THEN
    v_discount := 0.10;
  ELSIF v_totalSpent >= 250 THEN
    v_discount := 0.05;
  ELSE
    v_discount := 0.02;
  END IF;

  RETURN v_discount;
END customer_discount;
/

-- Anonymous block example for customer_discount.
DECLARE
  v_customerID  customer.customerID%TYPE := 2001;
  v_customer    customer.customerName%TYPE;
  v_discount    NUMBER(4,2);
BEGIN
  SELECT customerName
  INTO v_customer
  FROM customer
  WHERE customerID = v_customerID;

  v_discount := customer_discount(v_customerID);

  DBMS_OUTPUT.PUT_LINE('Customer Name: ' || v_customer);
  DBMS_OUTPUT.PUT_LINE('Discount Rate: ' || (v_discount * 100) || '%');
END;
/

-- 8.1.2 Calculate the current total amount of an order from its order items.
CREATE OR REPLACE FUNCTION order_total (
  p_orderID IN sales_order.orderID%TYPE
) RETURN NUMBER IS
  v_itemTotal   NUMBER(10,2);
  v_deliveryFee sales_order.deliveryFee%TYPE;
  v_total       NUMBER(10,2);
BEGIN
  SELECT NVL(SUM(lineTotal), 0)
  INTO v_itemTotal
  FROM order_item
  WHERE orderID = p_orderID;

  SELECT deliveryFee
  INTO v_deliveryFee
  FROM sales_order
  WHERE orderID = p_orderID;

  v_total := v_itemTotal + v_deliveryFee;
  RETURN v_total;
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    RETURN 0;
END order_total;
/

-- Anonymous block example for order_total.
DECLARE
  v_orderID sales_order.orderID%TYPE := 4001;
  v_total   NUMBER(10,2);
BEGIN
  v_total := order_total(v_orderID);
  DBMS_OUTPUT.PUT_LINE('Order ID: ' || v_orderID);
  DBMS_OUTPUT.PUT_LINE('Calculated Total: RM ' || v_total);
END;
/

