<?php
    // Delete Database and Create New One 
    $connection = mysqli_connect('localhost', 'root', '');
    $deleteDb = "DROP DATABASE Zaptos";
    if ($connection->query($deleteDb) === TRUE) {
        echo "<script>alert('Database Deleted')</script>";
    }
    $createDb = "CREATE DATABASE Zaptos";
    if ($connection->query($createDb) === TRUE) {
        echo "<script>alert('Database Created')</script>";
    }

    $connection = mysqli_connect('localhost', 'root', '', 'Zaptos');

    // Admin Create
    $create = "CREATE TABLE Admin
                (AdminID int NOT NULL PRIMARY KEY,
                Username varchar(30),
                Password varchar(30));";
    if ($connection->query($create)) {
        echo "<script>alert('Admin Table Created');</script>";
    }
    else {
        echo $connection->error;
    }

    // Admin Data Add
    $insert = "INSERT INTO Admin VALUES (1,'admin', 'admin');";
    if ($connection->query($insert)) {
        echo "<script>alert('Admin Data Inserted');</script>";
    }

    // Users Create
    $create = "CREATE TABLE Users
                (UserID varchar(30) NOT NULL PRIMARY KEY,
                Name varchar(30),
                Email varchar(30),
                Password varchar(255),
                Phone varchar(30));";
    if ($connection->query($create)) {
        echo "<script>alert('Users Table Created');</script>";
    }
    else {
        echo $connection->error;
    }

    // MembershipType Create
    $create = "CREATE TABLE MembershipTypes
                (MembershipTypeID int NOT NULL PRIMARY KEY,
                MembershipType varchar(30),
                Cost int,
                Duration varchar(30),
                DiscountPercent int,
                FreeDeliveryStatus varchar(30),
                CONSTRAINT CHK_DeliSts CHECK (FreeDeliveryStatus IN ('Free', 'Not Free')));";
    if ($connection->query($create)) {
        echo "<script>alert('MembershipTypes Table Created');</script>";
    }
    else {
        echo $connection->error;
    }

    // MembershipType Data Add
    $insert1 = "INSERT INTO MembershipTypes VALUES (1, 'Basic', 30000,'6 months', 10, 'Not Free');";
    $query1 = $connection->query($insert1);
    $insert2 = "INSERT INTO MembershipTypes VALUES (2, 'Standard', 40000, '1 year', 10, 'Free');";
    $query2 = $connection->query($insert2);
    $insert3 = "INSERT INTO MembershipTypes VALUES (3, 'Premium', 60000, '2 years', 15, 'Free');";
    $query3 = $connection->query($insert3);
    if ($query1 && $query2 && $query3) {
        echo "<script>alert('MembershipTypes Data Inserted');</script>";
    }
    else {
        echo $connection->error;
    }

    // Membership Create
    $create = "CREATE TABLE Memberships
                (MembershipID varchar(30) NOT NULL PRIMARY KEY,
                UserID varchar(30) NOT NULL,
                MembershipTypeID int NOT NULL,
                StartDate date,
                EndDate date,
                Payment text,
                MembershipStatus varchar(30),
                FOREIGN KEY (UserID) REFERENCES Users (UserID),
                FOREIGN KEY (MembershipTypeID) REFERENCES MembershipTypes (MembershipTypeID),
                CONSTRAINT MembershipSts_Chk CHECK (MembershipStatus IN ('Pending', 'Active', 'Expired')));";
    if ($connection->query($create)) {
        echo "<script>alert('Memberships Table Created');</script>";
    }   
    else {
        echo $connection->error;
    }

    // Feedback Create
    $create = "CREATE TABLE Feedbacks
                (FeedbackID varchar(30) NOT NULL PRIMARY KEY,
                UserID varchar(30) NOT NULL,
                Feedback text,
                Date date,
                FOREIGN KEY (UserID) REFERENCES Users (UserID));";
    if ($connection->query($create)) {
        echo "<script>alert('Feedbacks Table Created');</script>";
    }
    else {
        echo $connection->error;
    }

    // Services Create
    $create = "CREATE TABLE Services
                (ServiceID int NOT NULL PRIMARY KEY,
                ServiceName varchar(30),
                Cost int);";
    if ($connection->query($create)) {
        echo "<script>alert('Services Table Created');</script>";
    }   
    else {
        echo $connection->error;
    }

    // Services Data Add 
    $insert1 = "INSERT INTO Services VALUES (1, 'Basic', 5000)";
    $query1 = $connection->query($insert1);
    $insert2 = "INSERT INTO Services VALUES (2, 'Advanced', 8000)";
    $query2 = $connection->query($insert2);
    $insert3 = "INSERT INTO Services VALUES (3, 'Extended', 8000)";
    $query3 = $connection->query($insert3);
    $insert4 = "INSERT INTO Services VALUES (4, 'Premium', 10000)";
    $query4 = $connection->query($insert4);
    if ($query1 && $query2 && $query3 && $query4) {
        echo "<script>alert('Services Data Inserted');</script>";
    }   
    else {
        echo $connection->error;
    }   

    // Bookings Create
    $create = "CREATE TABLE Bookings
                (BookingID varchar(30) NOT NULL PRIMARY KEY,
                UserID varchar(30) NOT NULL,
                ServiceID int NOT NULL,
                Date date,
                Time varchar(30),
                Discount int,
                Cost int,
                BookingStatus varchar(30),
                FOREIGN KEY (UserID) REFERENCES Users (UserID),
                FOREIGN KEY (ServiceID) REFERENCES Services (ServiceID),
                CONSTRAINT BookingSts_Chk CHECK (BookingStatus IN ('Pending', 'Finished')));";
    if ($connection->query($create)) {
        echo "<script>alert('Bookings Table Created');</script>";
    }   
    else {
        echo $connection->error;
    }

    // Products Create
    $create = "CREATE TABLE Products
                (ProductID varchar(30) NOT NULL PRIMARY KEY,
                ProductName varchar(30),
                ProductDescription text,
                Price int,
                Stock int,
                ProductImage text);";
    if ($connection->query($create)) {
        echo "<script>alert('Products Table Created')</script>";
    }
    else {
        echo $connection->error;
    }

    // Orders Create
    $create = "CREATE TABLE Orders
                (OrderID varchar(30) NOT NULL PRIMARY KEY,
                UserID varchar(30) NOT NULL,
                Address text,
                Date date,
                Discount int,
                Cost int,
                OrderStatus varchar(30),
                FOREIGN KEY (UserID) REFERENCES Users (UserID),
                CONSTRAINT OrderSts_Chk CHECK (OrderStatus IN ('Order Placed', 'Shipped', 'Delivered')))";
    if ($connection->query($create)) {
        echo "<script>alert('Orders Table Created')</script>";
    }
    else {
        echo $connection->error;
    }

    // OrderProduct Create
    $create = "CREATE TABLE OrderProduct
            (OrderID varchar(30) NOT NULL,
            ProductID varchar(30) NOT NULL,
            Quantity int,
            Rating int,
            PRIMARY KEY (OrderID, ProductID),
            FOREIGN KEY (OrderID) REFERENCES Orders (OrderID),
            FOREIGN KEY (ProductID) REFERENCES Products (ProductID));";
    if ($connection->query($create)) {
        echo "<script>alert('OrderProduct Table Created');</script>";
    }
    else {
        echo $connection->error;
    }

    // Favourites Create
    $create = "CREATE TABLE Favourites
                (UserID varchar(30) NOT NULL,
                ProductID varchar(30) NOT NULL,
                PRIMARY KEY (UserID, ProductID),
                FOREIGN KEY (UserID) REFERENCES Users (UserID),
                FOREIGN KEY (ProductID) REFERENCES Products (ProductID));";
    if ($connection->query($create)) {
        echo "<script>alert('Favourites Table Created');</script>";
    }
    else {
        echo $connection->error;
    }
?>