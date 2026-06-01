-- E-Commerce System Database
-- Task 4: DDL script for table creation

DROP TABLE shipment CASCADE CONSTRAINTS;
DROP TABLE payment CASCADE CONSTRAINTS;
DROP TABLE order_item CASCADE CONSTRAINTS;
DROP TABLE sales_order CASCADE CONSTRAINTS;
DROP TABLE product CASCADE CONSTRAINTS;
DROP TABLE category CASCADE CONSTRAINTS;
DROP TABLE customer CASCADE CONSTRAINTS;
DROP TABLE admin CASCADE CONSTRAINTS;

CREATE TABLE admin (
  adminID       NUMBER(4) NOT NULL,
  adminName     VARCHAR2(50) NOT NULL,
  adminEmail    VARCHAR2(60) NOT NULL,
  adminContact  VARCHAR2(15) NOT NULL,
  adminPassword VARCHAR2(30) NOT NULL,
  CONSTRAINT admin_adminID_PK PRIMARY KEY (adminID),
  CONSTRAINT admin_adminEmail_UK UNIQUE (adminEmail)
);

CREATE TABLE customer (
  customerID       NUMBER(4) NOT NULL,
  customerName     VARCHAR2(60) NOT NULL,
  customerEmail    VARCHAR2(60) NOT NULL,
  customerPhone    VARCHAR2(15) NOT NULL,
  customerAddress  VARCHAR2(120) NOT NULL,
  customerPassword VARCHAR2(30) NOT NULL,
  joinDate         DATE DEFAULT SYSDATE NOT NULL,
  CONSTRAINT customer_customerID_PK PRIMARY KEY (customerID),
  CONSTRAINT customer_email_UK UNIQUE (customerEmail)
);

CREATE TABLE category (
  categoryID          NUMBER(3) NOT NULL,
  categoryName        VARCHAR2(40) NOT NULL,
  categoryDescription VARCHAR2(120),
  CONSTRAINT category_categoryID_PK PRIMARY KEY (categoryID),
  CONSTRAINT category_name_UK UNIQUE (categoryName)
);

CREATE TABLE product (
  productID     NUMBER(4) NOT NULL,
  categoryID    NUMBER(3) NOT NULL,
  adminID       NUMBER(4) NOT NULL,
  productName   VARCHAR2(60) NOT NULL,
  productBrand  VARCHAR2(40),
  unitPrice     NUMBER(8,2) NOT NULL,
  stockQty      NUMBER(5) NOT NULL,
  productStatus VARCHAR2(20) NOT NULL,
  createdDate   DATE DEFAULT SYSDATE NOT NULL,
  CONSTRAINT product_productID_PK PRIMARY KEY (productID),
  CONSTRAINT product_categoryID_FK FOREIGN KEY (categoryID)
    REFERENCES category (categoryID),
  CONSTRAINT product_adminID_FK FOREIGN KEY (adminID)
    REFERENCES admin (adminID),
  CONSTRAINT product_price_CK CHECK (unitPrice >= 0),
  CONSTRAINT product_stock_CK CHECK (stockQty >= 0),
  CONSTRAINT product_status_CK CHECK (productStatus IN ('AVAILABLE', 'LOW STOCK', 'OUT OF STOCK', 'DISCONTINUED'))
);

CREATE TABLE sales_order (
  orderID      NUMBER(5) NOT NULL,
  customerID   NUMBER(4) NOT NULL,
  adminID      NUMBER(4) NOT NULL,
  orderDate    DATE NOT NULL,
  orderStatus  VARCHAR2(20) NOT NULL,
  subtotal     NUMBER(10,2) NOT NULL,
  deliveryFee  NUMBER(6,2) DEFAULT 0 NOT NULL,
  totalAmount  NUMBER(10,2) NOT NULL,
  CONSTRAINT sales_order_orderID_PK PRIMARY KEY (orderID),
  CONSTRAINT sales_order_customerID_FK FOREIGN KEY (customerID)
    REFERENCES customer (customerID),
  CONSTRAINT sales_order_adminID_FK FOREIGN KEY (adminID)
    REFERENCES admin (adminID),
  CONSTRAINT sales_order_status_CK CHECK (orderStatus IN ('PENDING', 'PROCESSING', 'SHIPPED', 'DELIVERED', 'CANCELLED')),
  CONSTRAINT sales_order_amount_CK CHECK (subtotal >= 0 AND deliveryFee >= 0 AND totalAmount >= 0)
);

CREATE TABLE order_item (
  orderItemID NUMBER(5) NOT NULL,
  orderID     NUMBER(5) NOT NULL,
  productID   NUMBER(4) NOT NULL,
  quantity    NUMBER(4) NOT NULL,
  unitPrice   NUMBER(8,2) NOT NULL,
  lineTotal   NUMBER(10,2) NOT NULL,
  CONSTRAINT order_item_itemID_PK PRIMARY KEY (orderItemID),
  CONSTRAINT order_item_orderID_FK FOREIGN KEY (orderID)
    REFERENCES sales_order (orderID),
  CONSTRAINT order_item_productID_FK FOREIGN KEY (productID)
    REFERENCES product (productID),
  CONSTRAINT order_item_order_product_UK UNIQUE (orderID, productID),
  CONSTRAINT order_item_qty_CK CHECK (quantity > 0),
  CONSTRAINT order_item_amount_CK CHECK (unitPrice >= 0 AND lineTotal >= 0)
);

CREATE TABLE payment (
  paymentID     NUMBER(5) NOT NULL,
  orderID       NUMBER(5) NOT NULL,
  customerID    NUMBER(4) NOT NULL,
  paymentDate   DATE NOT NULL,
  paymentMethod VARCHAR2(20) NOT NULL,
  paymentStatus VARCHAR2(20) NOT NULL,
  paymentAmount NUMBER(10,2) NOT NULL,
  CONSTRAINT payment_paymentID_PK PRIMARY KEY (paymentID),
  CONSTRAINT payment_orderID_UK UNIQUE (orderID),
  CONSTRAINT payment_orderID_FK FOREIGN KEY (orderID)
    REFERENCES sales_order (orderID),
  CONSTRAINT payment_customerID_FK FOREIGN KEY (customerID)
    REFERENCES customer (customerID),
  CONSTRAINT payment_method_CK CHECK (paymentMethod IN ('CARD', 'ONLINE BANKING', 'EWALLET', 'CASH')),
  CONSTRAINT payment_status_CK CHECK (paymentStatus IN ('PAID', 'PENDING', 'FAILED', 'REFUNDED')),
  CONSTRAINT payment_amount_CK CHECK (paymentAmount >= 0)
);

CREATE TABLE shipment (
  shipmentID      NUMBER(5) NOT NULL,
  orderID         NUMBER(5) NOT NULL,
  courierName     VARCHAR2(40) NOT NULL,
  trackingNo      VARCHAR2(30),
  shippingAddress VARCHAR2(120) NOT NULL,
  shippedDate     DATE,
  deliveredDate   DATE,
  shipmentStatus  VARCHAR2(20) NOT NULL,
  CONSTRAINT shipment_shipmentID_PK PRIMARY KEY (shipmentID),
  CONSTRAINT shipment_orderID_UK UNIQUE (orderID),
  CONSTRAINT shipment_orderID_FK FOREIGN KEY (orderID)
    REFERENCES sales_order (orderID),
  CONSTRAINT shipment_status_CK CHECK (shipmentStatus IN ('PACKING', 'SHIPPED', 'DELIVERED', 'RETURNED', 'CANCELLED'))
);

