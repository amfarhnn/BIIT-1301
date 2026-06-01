# Data Dictionary

## ADMIN

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| adminID | NUMBER | 4 | NO (PK) |
| adminName | VARCHAR2 | 50 | NO |
| adminEmail | VARCHAR2 | 60 | NO (UK) |
| adminContact | VARCHAR2 | 15 | NO |
| adminPassword | VARCHAR2 | 30 | NO |

## CUSTOMER

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| customerID | NUMBER | 4 | NO (PK) |
| customerName | VARCHAR2 | 60 | NO |
| customerEmail | VARCHAR2 | 60 | NO (UK) |
| customerPhone | VARCHAR2 | 15 | NO |
| customerAddress | VARCHAR2 | 120 | NO |
| customerPassword | VARCHAR2 | 30 | NO |
| joinDate | DATE | - | NO |

## CATEGORY

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| categoryID | NUMBER | 3 | NO (PK) |
| categoryName | VARCHAR2 | 40 | NO (UK) |
| categoryDescription | VARCHAR2 | 120 | YES |

## PRODUCT

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

## SALES_ORDER

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

## ORDER_ITEM

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| orderItemID | NUMBER | 5 | NO (PK) |
| orderID | NUMBER | 5 | NO (FK) |
| productID | NUMBER | 4 | NO (FK) |
| quantity | NUMBER | 4 | NO |
| unitPrice | NUMBER | 8,2 | NO |
| lineTotal | NUMBER | 10,2 | NO |

## PAYMENT

| Attribute Name | Data Type | Size | Null |
| --- | --- | --- | --- |
| paymentID | NUMBER | 5 | NO (PK) |
| orderID | NUMBER | 5 | NO (FK, UK) |
| customerID | NUMBER | 4 | NO (FK) |
| paymentDate | DATE | - | NO |
| paymentMethod | VARCHAR2 | 20 | NO |
| paymentStatus | VARCHAR2 | 20 | NO |
| paymentAmount | NUMBER | 10,2 | NO |

## SHIPMENT

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

