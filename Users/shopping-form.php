<?php
include 'connect.php';
include 'auto-id.php';
include 'email-notification.php';
session_start();
if (isset($_SESSION['UserID'])) {
  $redirectFile = 'profile.php';
  $redirectName = 'Profile';

  if ($_SESSION['ItemsInCart'] == 0) {
    echo "<script>alert('Please add item to your shopping cart first.')</script>";
    echo "<script>window.location = 'shopping.php'</script>";
  }

  $userID = $_SESSION['UserID'];
  $select = "SELECT * FROM Users WHERE UserID = '$userID'";
  $query = $connection->query($select);
  while ($row = $query->fetch_assoc()) {
    $name = $row['Name'];
    $email = $row['Email'];
  }
} else {
  $redirectFile = 'login.php';
  $redirectName = 'Login';
  echo "<script>alert('Please login first.');</script>";
  echo "<script>window.location = 'login.php';</script>";
}

// submit shopping form
if (isset($_POST['btnSubmit'])) {
  // get form data
  $orderID = AutoID('O', 6, 'Orders', 'OrderID');
  $userID = $_SESSION['UserID'];
  $name = $_POST['inputName'];
  $email = $_POST['inputEmail'];
  $address = $_POST['inputAddress'];
  $date = $date = date("Y-m-d");
  $discount = null;
  $cost = null;
  $orderStatus = 'Order Placed';

  // declar required var and arrays
  $subTotal = 0;
  $orderProductInsertArray = array();
  $stockUpdateArray = array();

  // loop all the items in the cart
  for ($i = 0; $i < count($_SESSION['Cart']); $i++) {

    // get productIDs and its related information
    $productID = array_keys($_SESSION['Cart'])[$i];
    $quantity = $_SESSION['Cart'][$productID]['Quantity'];
    $select = "SELECT * FROM Products WHERE ProductID = '$productID'";
    $query = $connection->query($select);
    while ($row = $query->fetch_assoc()) {
      $productName = $row['ProductName'];
      $price = $row['Price'];
      $img = $row['ProductImage'];
      $stock = $row['Stock'];
    }
    $multipliedPrice = $price * $quantity;

    // get discount percent
    $select = "SELECT * FROM Memberships m, MembershipTypes mt 
    WHERE m.MembershipTypeID = mt.MembershipTypeID
    AND m.UserID = '$userID'
    AND m.MembershipStatus = 'Active'";
    $query = $connection->query($select);
    if ($query->num_rows > 0) {
      while ($row = $query->fetch_assoc()) {
        $discount = $row['DiscountPercent'];
        $freeDeliStatus = $row['FreeDeliveryStatus'];
      }
    } else {
      $discount = 0;
      $freeDeliStatus = "";
    }

    $stockRemaining = $stock - $quantity;

    // put OrderProduct insert queries into array + update stock
    $orderProductInsertArray[$i] = "INSERT INTO OrderProduct (OrderID, ProductID, Quantity) VALUES ('$orderID', '$productID', '$quantity')";
    $stockUpdateArray[$i] = "UPDATE Products SET Stock = '$stockRemaining' WHERE ProductID = '$productID'";

    // calculate total price
    $subTotal += $multipliedPrice;
    $deliveryFee = ($freeDeliStatus == "Free") ? 0 : 2000;
    $total = ($subTotal + $deliveryFee) - (($subTotal + $deliveryFee) * ($discount / 100));
  }

  //insert Orders
  $orderInsert = "INSERT INTO Orders VALUES ('$orderID', '$userID','$address', '$date', '$discount', '$total', '$orderStatus')";
  $orderQuery = $connection->query($orderInsert);
  if ($orderQuery) {
    EmailNotification(
      $email,
      "Zaptos Booking",
      "Dear $name, <br>

          Thank you for your order. <br>

          Order ID - $orderID, <br>
          Date - $date, <br>
          Cost - $total, <br>
          Address - $address <br>
          
          If you ordered by mistake, you can cancel your order before it is shipped."
    );
    for ($j = 0; $j < count($orderProductInsertArray); $j++) {
      $connection->query($orderProductInsertArray[$j]);
      $connection->query($stockUpdateArray[$j]);
    }
    $_SESSION['ItemsInCart'] = 0;
    unset($_SESSION["Cart"]);
    echo "<script>alert('Order Placed')</script>";
    echo "<script>window.location = 'shopping.php'</script>";
  } else {
    echo $connection->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Zaptos</title>

  <!-- boostrap 4 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <!-- boostrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

  <!-- css -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="styles/reset.min.css" />
  <link rel="stylesheet" href="styles/style.css" />
  <link rel="stylesheet" href="styles/header-7.css" />

  <!-- font awesome icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css
    ">

  <script src="js/add-to-cart-number.js"></script>

</head>

<body>
  <!-- Header Start -->
  <header class="site-header">
    <div class="wrapper site-header__wrapper">
      <div class="site-header__start">
        <a href="home.php" class="brand" style="text-decoration: none; color: white;">Zaptos</a>
      </div>
      <div class="site-header__middle">
        <nav class="nav">
          <button class="nav__toggle" aria-expanded="false" type="button">
            menu
          </button>
          <ul class="nav__wrapper">
            <li class="nav__item"><a href="home.php" style="background-color: #008a9a">Home</a></li>
            <li class="nav__item"><a href="shopping.php">Shopping</a></li>
            <li class="nav__item"><a href="membership.php">Membership</a></li>
            <li class="nav__item"><a href="feedback.php">Feedback</a></li>
            <li class="nav__item"><a href="faq.php">FAQ</a></li>
          </ul>
        </nav>
      </div>
      <div style="word-spacing: 10px;">
        <a href="favourite.php" style="text-decoration: none;">
          <i class="fa fa-heart fa-lg" style="color: white;"></i>
        </a>
        <a href="shopping-cart.php" class="notification">
          <i class="fa fa-shopping-cart fa-lg" style="color: white;"></i>
          <span class="badge"><?php echo isset($_SESSION['ItemsInCart']) ? $_SESSION['ItemsInCart'] : ""; ?></span>
        </a>
        <a href="booking-history.php">
          <i class="fa fa-file-text-o fa-lg" style="color: white;"></i>
        </a>
      </div>
      <div class="site-header__end">
        <a href=<?php echo $redirectFile; ?> style="color: white;"><?php echo $redirectName; ?></a>
      </div>
    </div>
  </header>
  <!-- Header End -->
  <div class="container p-5">
    <div class="row">
      <div class="col-md-12">
        <div class="page-heading clearfix">
          <h1>Shopping form</h1>
        </div>
      </div>
    </div>
    <form action="shopping-form.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="inputName" value='<?php echo $name ?>' readonly>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="inputEmail" value='<?php echo $email ?>' readonly>
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">Shipping Address</label>
        <div class="form-group">
          <textarea class="form-control" rows="3" name="inputAddress"></textarea>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="btnSubmit" style="background-color: #005C67;">Submit</button>
    </form>
  </div>
  <!-- Site footer -->
  <br><br><br><br><br><br><br>
  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <h6>Location</h6>
          <p class="text-justify">No.199, Zagawar Street, Dagon Township, Yangon</p><br>
          <h6>Contact</h6>
          <a>+95969837234</a><br>
          <a>zaptos.cars@gmail.com</a>
        </div>

        <div class="col-xs-6 col-md-3">
          <h6>Opening Hours</h6>
          <ul class="footer-links">
            <li><a>Sunday: 9am - 5pm</a></li>
            <li><a>Monday: 9am - 5pm</a></li>
            <li><a>Tuesday: 9am - 5pm</a></li>
            <li><a>Wednesday: 9am - 5pm</a></li>
            <li><a>Thursday: 9am - 5pm</a></li>
            <li><a>Friday: 9am - 5pm</a></li>
            <li><a>Saturday: 9am - 5pm</a></li>
          </ul>
        </div>

        <div class="col-xs-6 col-md-3">
          <h6>Quick Links</h6>
          <ul class="footer-links">
            <li><a href="#">Shop</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Membership</a></li>
            <li><a href="#">Feedback</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>
      </div>
      <hr>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-sm-6 col-xs-12">
          <p class="copyright-text">Copyright &copy; 2022 All Rights Reserved by
            <a href="#">Zaptos</a>.
          </p>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <ul class="social-icons">
            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <script src="js/header-7.js"></script>
</body>

</html>