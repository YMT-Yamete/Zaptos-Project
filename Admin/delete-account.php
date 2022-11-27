<?php
    include 'connect.php';
    $id = $_GET['UserID'];

    $select = "SELECT * FROM Orders WHERE UserID = '$id'";
    $selectQuery = $connection->query($select);
    while ($row = $selectQuery->fetch_assoc()) {
      $orderID = $row['OrderID'];
      $deleteOrders = "DELETE FROM OrderProduct WHERE OrderID = '$orderID'";
      $deleteOrdersQuery = $connection->query($deleteOrders);
    }

    $delete1 = "DELETE FROM Users WHERE UserID = '$id'";
    $query1 = $connection->query($delete1);

    $delete2 = "DELETE FROM Memberships WHERE UserID = '$id'";
    $query2 = $connection->query($delete2);

    $delete3 = "DELETE FROM Feedbacks WHERE UserID = '$id'";
    $query3 = $connection->query($delete3);

    $delete4 = "DELETE FROM Bookings WHERE UserID = '$id'";
    $query4 = $connection->query($delete4);

    $delete5 = "DELETE FROM Favourites WHERE UserID = '$id'";
    $query5 = $connection->query($delete5);

    $delete6 = "DELETE FROM Orders WHERE UserID = '$id'";
    $query6 = $connection->query($delete6);

    if ($query6 and $query5 and $query4 and $query3 and $query2 and $query1) {
        echo "<script>alert('Account Deleted')</script>";
        echo "<script>window.location = 'index.php';</script>";
    }
    else {
        echo $connection->error;
    }
