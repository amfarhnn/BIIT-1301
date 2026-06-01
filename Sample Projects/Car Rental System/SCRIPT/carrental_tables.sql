DROP TABLE CLIENT cascade constraints;

CREATE TABLE client (
clientID number(3) NOT NULL,
clientName varchar2(50) NOT NULL,
clientContact varchar2(15) NOT NULL,
clientAdr varchar2(50) NOT NULL,
clientPswrd varchar2(20) NOT NULL,
CONSTRAINT client_clientID_PK PRIMARY KEY(clientID)
);


DROP TABLE ADMIN cascade constraints;
CREATE TABLE admin (
adminID number(3) NOT NULL,
adminName varchar2(50) NOT NULL,
adminContact varchar2(15) NOT NULL,
adminPswrd varchar2(20) NOT NULL,
CONSTRAINT Admin_adminID_PK PRIMARY KEY(adminID)
);

DROP TABLE CAR cascade constraints;
CREATE TABLE car (
carID number(3) NOT NULL,
adminID number(3) NOT NULL,
carName varchar2(30) NOT NULL,
carBrand varchar2(30) NOT NULL,
carType varchar2(30) NOT NULL,
carCapacity number(4) NOT NULL,
carColour varchar2(30) NOT NULL,
carPlate varchar2(10) NOT NULL,
carYear number(4) NOT NULL,
carPrice number(8,2) NOT NULL,
carStatus varchar2(30) NOT NULL,
carNotes varchar2(255) NOT NULL,
CONSTRAINT car_carID_PK PRIMARY KEY (carID),
CONSTRAINT car_adminID_FK FOREIGN KEY (adminID) REFERENCES admin
);

DROP TABLE BOOKING cascade constraints;
CREATE TABLE booking (
bookingID number(3) NOT NULL,
carID number(3) NOT NULL,
clientID number(3) NOT NULL,
adminID number(3) NOT NULL,
paymentID number(3) NOT NULL,
returnDate date NOT NULL,
returnTime timestamp NOT NULL,
bookingDate date NOT NULL,
bookingStatus varchar(30) NOT NULL,
CONSTRAINT booking_bookingID_PK PRIMARY KEY (bookingID),
CONSTRAINT booking_adminID_FK FOREIGN KEY (adminID) REFERENCES admin,
CONSTRAINT booking_clientID_FK FOREIGN KEY (clientID) REFERENCES client,
CONSTRAINT booking_carID_FK FOREIGN KEY (carID) REFERENCES car
);

DROP TABLE PAYMENT cascade constraints;
CREATE TABLE payment (
paymentID number(3) NOT NULL,
bookingID number(3) NOT NULL,
clientID number(3) NOT NULL,
paymentType varchar(20) NOT NULL,
timeStamp timestamp,
totalPayment number(8,2) NOT NULL,
CONSTRAINT payment_paymentID_PK PRIMARY KEY (paymentID),
CONSTRAINT payment_bookingID_FK FOREIGN KEY(bookingID) REFERENCES
booking,
CONSTRAINT payment_clientID_FK FOREIGN KEY(clientID) REFERENCES client
) ;