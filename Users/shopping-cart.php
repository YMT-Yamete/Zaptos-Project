<?php
session_start();
include 'connect.php';
if (isset($_SESSION['UserID'])) {
  $redirectFile = 'profile.php';
  $redirectName = 'Profile';
  $userID = $_SESSION['UserID'];
} else {
  $redirectFile = 'login.php';
  $redirectName = 'Login';
  echo "<script>alert('Please login first.');</script>";
  echo "<script>window.location = 'login.php';</script>";
}

// remove item from shopping cart
if (isset($_GET['removeItem']) && isset($_GET['itemCount'])) {
  $removingItemID = $_GET['removeItem'];
  $removediItemCount = $_GET['itemCount'];
  $_SESSION['ItemsInCart'] -= $removediItemCount;
  unset($_SESSION["Cart"][$removingItemID]);
  echo "<script>window.location = 'shopping-cart.php'</script>";
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
  <link rel="stylesheet" href="shopping-cart-page-style.css">
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
            <li class="nav__item"><a href="home.php">Home</a></li>
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
  <div class="container p-3">
    <div class="row">
      <div class="col-md-12">
        <div class="page-heading clearfix">
          <br><br>
          <h1>Shopping Cart</h1>
        </div>
      </div>
    </div>
    <div class="card">
      <?php
      if ($_SESSION['ItemsInCart'] == 0) {
        $shoppingCartHideStatus = "hidden";
        $noItemsHideStatus = "";
      } else {
        $shoppingCartHideStatus = "";
        $noItemsHideStatus = "hidden";
      }
      ?>
      <div class="row">
        <h2 style="font-size: 24px; text-align:center; padding: 100px;" <?php echo $noItemsHideStatus ?>>No items added to the shopping cart</h2>
        <div class="col-md-12 cart p-5" <?php echo $shoppingCartHideStatus ?>>
          <?php
          $subTotal = 0;
          for ($i = 0; $i < count($_SESSION['Cart']); $i++) {

            // get productIDs and its related information
            $productID = array_keys($_SESSION['Cart'])[$i];
            $quantity = $_SESSION['Cart'][$productID]['Quantity'];
            $select = "SELECT * FROM Products WHERE ProductID = '$productID'";
            $query = $connection->query($select);
            while ($row = $query->fetch_assoc()) {
              $name = $row['ProductName'];
              $price = $row['Price'];
              $img = $row['ProductImage'];
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

            // calculate total price
            $subTotal += $multipliedPrice;
            $deliveryFee = ($freeDeliStatus == "Free") ? 0 : 2000;
            $total = ($subTotal + $deliveryFee) - (($subTotal + $deliveryFee) * ($discount / 100));
            echo
            "<div class='row border-top border-bottom'>
              <div class='row main align-items-center'>
                <div class='col-2 p-3'>
                  <img class='img-fluid' src=$img width='300px' height='500px'>
                </div>
                <div class='col'>
                  <div class='row text-muted'>$name</div>
                  <div class='row'>$price MMK</div>
                </div>
                <div class='col'>
                  <div class='number'>
                    <input type='text' value=$quantity class='amountSpecify' disabled>
                  </div>
                </div>
                <div class='col'>$multipliedPrice MMK 
                  <a href='shopping-cart.php?removeItem=$productID&itemCount=$quantity'><span class='close'>&#10005;</span></a>
                </div>
              </div>
            </div>";
          }
          ?>
          <div class="row border-top border-bottom">
            <div class="row main align-items-center">
              <div class="col-2 p-3">
              </div>
              <div class="col">
              </div>
              <div class="col">
                <a>&nbsp;</a><br>
                <a>&nbsp;</a><br>
                <a><span class="text-muted">Sub Total</span></a><br>
                <a>&nbsp;</a><br>
              </div>
              <div class="col"><?php echo $subTotal; ?> MMK</div>
            </div>
            <div class="row main align-items-center">
              <div class="col-2 p-3">
              </div>
              <div class="col">
              </div>
              <div class="col">
                <a>&nbsp;</a><br>
                <a><span class="text-muted">Delivery</span></a><br>
                <a>&nbsp;</a><br>
              </div>
              <div class="col"><?php echo $deliveryFee; ?> MMK</div>
            </div>
            <div class="row main align-items-center">
              <div class="col-2 p-3">
              </div>
              <div class="col">
              </div>
              <div class="col">
                <a>&nbsp;</a><br>
                <a><span class="text-muted">Discount</span></a><br>
                <a>&nbsp;</a><br>
              </div>
              <div class="col"><?php echo $discount ?>%</div>
            </div>
            <div class="row main align-items-center">
              <div class="col-2 p-3">
              </div>
              <div class="col">
              </div>
              <div class="col">
                <a>&nbsp;</a><br>
                <a><span class="text-muted">Total</span></a><br>
                <a>&nbsp;</a><br>
                <a>&nbsp;</a><br>
              </div>
              <div class="col" style="background-color: #00cfe7; padding: 10px;"><?php echo $total ?> MMK</div>
            </div>
          </div>
          <div class="back-to-shop">
            <br>
            <a href="shopping.php">
              <span class="text-muted" style="padding: 20px; float: left;">
                &nbsp; Back to shop
              </span>
            </a>
            <a href="shopping-form.php">
              <span style="float: right; background-color: #005C67; color: white; padding: 20px;">
                Proceed to Checkout &nbsp;
              </span>
            </a>
          </div>
          <br>
        </div>
      </div>
    </div>
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
            <li><a href="#">Home</a></li>
            <li><a href="#">Shopping</a></li>
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