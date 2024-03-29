<?php
include 'connect.php';
session_start();
if (isset($_SESSION['UserID'])) {
  $redirectFile = 'profile.php';
  $redirectName = 'Profile';
  $userID = $_SESSION['UserID'];

  // get order information
  if (isset($_GET['OrderID']))
    $orderID = $_GET['OrderID'];
  $select = "SELECT * FROM Orders o, Users u, Products p, OrderProduct op
                WHERE o.OrderID = op.OrderID
                AND p.ProductID = op.ProductID
                AND o.UserID = u.UserID
                AND o.OrderID = '$orderID'";
  $query = $connection->query($select);

  // get delivery fee
  $freeDeliStatus = "";
  $selectDeli = "SELECT * FROM Memberships m, MembershipTypes mt 
    WHERE m.MembershipTypeID = mt.MembershipTypeID
    AND m.UserID = '$userID'
    AND m.MembershipStatus = 'Active'";
  $queryDeli = $connection->query($selectDeli);
  if ($queryDeli->num_rows > 0) {
    while ($row = $queryDeli->fetch_assoc()) {
      $freeDeliStatus = $row['FreeDeliveryStatus'];
    }
  }
  $deliFee = $freeDeliStatus == "Free" ? 0 : 2000;
} else {
  $redirectFile = 'login.php';
  $redirectName = 'Login';
  echo "<script>alert('Please login first.');</script>";
  echo "<script>window.location = 'login.php';</script>";
}


// cancel order
if (isset($_POST['btnCancel'])) {
  $delete1 = "DELETE FROM OrderProduct WHERE OrderID = '$orderID'";
  $delete2 = "DELETE FROM Orders WHERE OrderID = '$orderID'";
  if ($connection->query($delete1) && $connection->query($delete2)) {
    echo "<script>alert('Order Cancelled');</script>";
    echo "<script>window.location = 'shopping-history.php';</script>";
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
          <h1>Shopping Receipt</h1>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="row">
        <div class="col-md-12 cart p-5">
          <p><?php echo $orderID ?></p>
          <?php
          while ($row = $query->fetch_assoc()) {
            $discount = $row['Discount'];
            $total = $row['Cost'];
            $multiploedPrice = $row['Price'] * $row['Quantity'];
            $orderStatus = $row['OrderStatus'];
            $ratingHiddenStatus = ($orderStatus == 'Delivered') ? '' : 'hidden';
            echo
            "<div class='row border-top border-bottom'>
                <div class='row main align-items-center'>
                  <div class='col-2 p-3'>
                    <img class='img-fluid' src='$row[ProductImage]' width='300px' height='500px'>
                  </div>
                  <div class='col'>
                    <div class='row text-muted'>$row[ProductName]</div>
                    <div class='row'>$row[Price] MMK</div>
                  </div>
                  <div class='col'>$row[Quantity]</div>
                  <div class='col'>$multiploedPrice MMK</div>
                  <div class='col' $ratingHiddenStatus>
                    <a href='rate-product.php?ProductID=$row[ProductID]&OrderID=$row[OrderID]'><button type='button' class='btn btn-link'>Rate this product</button></a>
                  </div>
                </div>
              </div>";
          }
          ?>
          <div class='row main align-items-center'>
            <div class='col-2 p-3'>
            </div>
            <div class='col'>
            </div>
            <div class='col'>
              <a>&nbsp;</a><br>
              <a><span class='text-muted'>Delivery</span></a><br>
              <a>&nbsp;</a><br>
            </div>
            <div class='col'><?php echo $deliFee ?> MMK</div>
          </div>
          <div class='row main align-items-center'>
            <div class='col-2 p-3'>
            </div>
            <div class='col'>
            </div>
            <div class='col'>
              <a>&nbsp;</a><br>
              <a><span class='text-muted'>Discount</span></a><br>
              <a>&nbsp;</a><br>
            </div>
            <div class='col'><?php echo $discount ?>%</div>
          </div>
          <div class='row main align-items-center'>
            <div class='col-2 p-3'>
            </div>
            <div class='col'>
            </div>
            <div class='col'>
              <a>&nbsp;</a><br>
              <a><span class='text-muted'>Total Cost</span></a><br>
              <a>&nbsp;</a><br>
              <a>&nbsp;</a><br>
            </div>
            <div class='col' style='background-color: #00cfe7; padding: 10px;'><?php echo $total ?></div>
          </div>
        </div>
        <?php $cancelHiddenStatus = ($orderStatus == 'Order Placed') ? '' : 'hidden' ?>
        <form action="shopping-receipt.php?OrderID=<?php echo $orderID ?>" method="POST">
          <div class="back-to-shop">
            <br>
            <a>
              <span style="float: right; background-color: red; color: white; padding: 20px; margin: 20px;" <?php echo $cancelHiddenStatus ?>>
                <button style="background-color: transparent;color:white;border:none;" type="submit" name="btnCancel">
                  Cancel Order &nbsp;
                </button>
              </span>
              <p style="margin: 50px; color: red;">You cannot cancel the order once the order is shipped.</p>
            </a>
          </div>
        </form>
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