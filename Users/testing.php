<?php
session_start();

echo $_SESSION['ItemsInCart'];
echo "</br>";

for($i = 0; $i< count($_SESSION['Cart']); $i++) {
    print_r(array_keys($_SESSION['Cart'])[$i]);
    echo "</br>";
}
