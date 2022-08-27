<?php
    session_start();
    unset($_SESSION["UserID"]);
    unset($_SESSION["Cart"]);
    unset($_SESSION["ItemsInCart"]);
    echo "<script>alert('Logout Successful');</script>";
    echo "<script>window.location = 'login.php';</script>";
?>