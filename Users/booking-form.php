<?php
session_start();
if (isset($_SESSION['UserID'])) {
  $redirectFile = 'profile.php';
  $redirectName = 'Profile';
} else {
  $redirectFile = 'login.php';
  $redirectName = 'Login';
  echo "<script>alert('Please login first.');</script>";
  echo "<script>window.location = 'login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Zaptos</title>

  <!-- boostrap 4 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <!-- boostrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
    crossorigin="anonymous"></script>

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
          <span class="badge">3</span>
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
          <h1>Booking form</h1>
        </div>
      </div>
    </div>
    <form>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="service type" class="form-label">Service Type</label>
        <input type="text" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="time" class="form-label">Time</label>
        <select class="form-select" aria-label="Default select example" required>
          <option selected>Select time</option>
          <option value="9:00 am">9:00 am</option>
          <option value="9:30 am">9:30 am</option>
          <option value="10:00 am">10:00 am</option>
          <option value="10:30 am">10:30 am</option>
          <option value="11:00 am">11:00 am</option>
          <option value="11:30 am">11:30 am</option>
          <option value="12:00 pm">12:00 pm</option>
          <option value="12:30 pm">12:30 pm</option>
          <option value="1:00 pm">1:00 pm</option>
          <option value="1:30 pm">1:30 pm</option>
          <option value="2:00 pm">2:00 pm</option>
          <option value="2:30 pm">2:30 pm</option>
          <option value="3:00 pm">3:00 pm</option>
          <option value="3:30 pm">3:30 pm</option>
          <option value="4:00 pm">4:00 pm</option>
          <option value="4:30 pm">4:30 pm</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="background-color: #005C67;">Submit</button>
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