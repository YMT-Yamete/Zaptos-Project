<?php
    session_start();
    unset($_SESSION["AdminID"]);
    echo "<script>alert('Logout Successful');</script>";
    echo "<script>window.location = 'login.php';</script>";
?>