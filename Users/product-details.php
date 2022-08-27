<?php
include 'connect.php';
session_start();
if (isset($_SESSION['UserID'])) {
  $redirectFile = 'profile.php';
  $redirectName = 'Profile';
  $userID = $_SESSION['UserID'];

  // add to favourite
  if (isset($_POST['btnFavourite'])) {
    $productID = $_GET['ProductID'];
    $selectFav = "SELECT * FROM Favourites WHERE UserID = '$userID' AND ProductID = '$productID'";
    $queryFav = $connection->query($selectFav);
    if ($queryFav->num_rows == 0) {
      $isFav = 'false';
    } else {
      $isFav = 'true';
    }
    if ($isFav == 'false') {
      $insert = "INSERT INTO Favourites VALUES ('$userID', '$productID')";
      $connection->query($insert);
      echo "<script>alert('Added to favourite')</script>";
      echo "<script>history.back()</script>";
    } else if ($isFav == 'true') {
      $remove = "DELETE FROM Favourites 
              WHERE UserID = '$userID' AND ProductID = '$productID'";
      $connection->query($remove);
      echo "<script>alert('Removed from favourite')</script>";
      echo "<script>history.back()</script>";
    }
  }

  // get from favourite table to check if it is already an favourite or not
  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $selectFav = "SELECT * FROM Favourites WHERE UserID = '$userID' AND ProductID = '$productID'";
    $queryFav = $connection->query($selectFav);
    if ($queryFav->num_rows == 0) {
      $isFav = 'false';
    } else {
      $isFav = 'true';
    }
    $heartColor = $isFav == 'true' ? 'red' : 'white';
  }

  // get average rating
  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $selectRating = "SELECT * FROM OrderProduct WHERE ProductID = '$productID' AND Rating > 0";
    $queryRating = $connection->query($selectRating);
    $totalRows = $queryRating->num_rows;

    $averageRating = 0;
    $totalStars = 0;
    while ($row = $queryRating->fetch_assoc()) {
      $totalStars += $row['Rating'];
    }
    if ($totalRows > 0) {
      $averageRating = round($totalStars / $totalRows);
    }
    $brightStar = $averageRating;
    $darkStar = 5 - $averageRating;
  }

  // get the information of the product by specifying an id
  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $select = "SELECT * FROM Products WHERE ProductID = '$productID'";
    $query = $connection->query($select);
    while ($row = $query->fetch_assoc()) {
      $name = $row['ProductName'];
      $description = $row['ProductDescription'];
      $price = $row['Price'];
      $stock = $row['Stock'];
      $img = $row['ProductImage'];
    }
  }
} else {
  $redirectFile = 'login.php';
  $redirectName = 'Login';
  echo "<script>alert('Please login first.');</script>";
  echo "<script>window.location = 'login.php';</script>";
}

// add to cart
if (isset($_POST['btnAddToCart'])) {
  $select = "SELECT * FROM Products WHERE ProductID = '$productID'";
  $query = $connection->query($select);
  while ($row = $query->fetch_assoc()) {
    $stock = $row['Stock'];
  }
  $itemCount = $_POST['inputItemCount'];
  //if item is not already in cart
  if (!isset($_SESSION['Cart'][$productID]['Quantity'])) {
    $_SESSION['Cart'][$productID] = array('Quantity' => 0);
    $_SESSION['Cart'][$productID]['Quantity'] += $itemCount;

    $itemLeftAfterAddingToCart = $stock - $_SESSION['Cart'][$productID]['Quantity'];
    // if item is out of stock - remove the currently added items from the cart
    if ($itemLeftAfterAddingToCart < 0) {
      $_SESSION['Cart'][$productID]['Quantity'] -= $itemCount;
      echo "<script>alert('Sorry. We only have $stock item(s) available currently.')</script>";
      echo "<script>history.back()</script>";
    } else {
      $_SESSION['ItemsInCart'] += $itemCount;
    }
  }
  //if item is already in cart
  else {
    $_SESSION['Cart'][$productID]['Quantity'] += $itemCount;

    $itemLeftAfterAddingToCart = $stock - $_SESSION['Cart'][$productID]['Quantity'];
    // if item is out of stock - remove the currently added items from the cart
    if ($itemLeftAfterAddingToCart < 0) {
      $_SESSION['Cart'][$productID]['Quantity'] -= $itemCount;
      echo "<script>alert('Sorry. We only have $stock item(s) available currently.')</script>";
      echo "<script>history.back()</script>";
    } else {
      $_SESSION['ItemsInCart'] += $itemCount;
    }
  }
  $quantity =  $_SESSION['Cart'][$productID]['Quantity'];
  echo "<script>alert('$quantity Item(s) added to a shopping cart')</script>";
  echo "<script>history.back()</script>";
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

  <!-- rating stars -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
            <li class="nav__item"><a href="shopping.php" style="background-color: #008a9a">Shopping</a></li>
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
  <div class="container">
    <div class="detail-card">
      <div class="container-fliud">
        <div class="wrapper row">
          <div class="preview col-md-6">
            <div class="preview-pic tab-content">
              <div class="tab-pane active"><img src=<?php echo $img ?> /></div>
              <div class="tab-pane" id="pic-2"><img src="http://placekitten.com/400/252" /></div>
              <div class="tab-pane" id="pic-3"><img src="http://placekitten.com/400/252" /></div>
              <div class="tab-pane" id="pic-4"><img src="http://placekitten.com/400/252" /></div>
              <div class="tab-pane" id="pic-5"><img src="http://placekitten.com/400/252" /></div>
            </div>
          </div>
          <div class="details col-md-6">
            <h3 class="product-title"><?php echo $name ?></h3>
            <div>
              <?php
              for ($i = 0; $i < $brightStar; $i++) {
                echo "<span class='fa fa-star checked'></span>";
              }
              for ($i = 0; $i < $darkStar; $i++) {
                echo "<span class='fa fa-star'></span>";
              }
              ?>
            </div>
            <p class="product-description"><?php echo $description ?></p>
            <h4 class="price">current price: <span><?php echo $price ?> MMK</span></h4>
            <p class="deli">Estimated Delivery: 1 - 2 weeks</p>
            <form action="product-details.php?ProductID=<?php echo $productID ?>" method="POST">
              <div class="action">
                <div class="number">
                  <span class="minus">-</span>
                  <input type="text" value="1" class="amountSpecify" name="inputItemCount" readonly>
                  <span class="plus">+</span>
                </div>
                <button type="submit" class="add-to-cart btn btn-default" type="button" name="btnAddToCart">add to cart</button>
                <button type="submit" class="like btn btn-default" type="button" name="btnFavourite"><span class="fa fa-heart" style="color:<?php echo $heartColor ?>;"></span></button>
              </div>
            </form>
          </div>
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