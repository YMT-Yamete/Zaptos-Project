<?php
include 'connect.php';
session_start();
if (isset($_SESSION['UserID'])) {
    $redirectFile = 'profile.php';
    $redirectName = 'Profile';

    if(isset($_GET['ProductID']) && isset($_GET['OrderID'])) {
        $productID = $_GET['ProductID'];
        $orderID = $_GET['OrderID'];
        $select = "SELECT * FROM Products WHERE ProductID = '$productID'";
        $query = $connection->query($select);
        while ($row = $query->fetch_assoc()) {
            $img = $row['ProductImage'];
            $productName = $row['ProductName'];
        }
    }
} else {
    $redirectFile = 'login.php';
    $redirectName = 'Login';
    echo "<script>alert('Please login first.');</script>";
    echo "<script>window.location = 'login.php';</script>";
}

if (isset($_POST['btnSubmit'])) {
    if (isset($_POST['rate'])) {
        $rate = $_POST['rate'];
        $update = "UPDATE OrderProduct SET Rating = '$rate' WHERE ProductID = '$productID' AND OrderID = '$orderID'";
        if($connection->query($update)) {
            echo "<script>alert('Thank you for your rating');</script>";
            echo "<script>window.location = 'shopping-history.php';</script>";
        }
        else {
            echo $connection->error;
        }
    }
    else {
        echo "<script>alert('Please rate from 1 to 5 stars')</script>";
        echo "<script>history.back()</script>";
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
    <link rel="stylesheet" href="styles/rating-stars.css" />

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
                    <span class="badge"><?php echo isset($_SESSION['ItemsInCart'])?$_SESSION['ItemsInCart']:"";?></span>
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
                    <h1>Product Rating</h1><br>
                    <h2><?php echo $productName?></h2><br>
                    <form action="rate-product.php?ProductID=<?php echo $productID;?>&OrderID=<?php echo $orderID?>" method="POST">
                    <table class="center">
                        <tr>
                            <td>
                                <img src='<?php echo $img?>' class='img-fluid' width='300px' height='500px'>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="display: flex;">
                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5"/>
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4"/>
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3"/>
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2"/>
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1"/>
                                    <label for="star1" title="text">1 star</label>
                                </div><br><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <button type="submit" name="btnSubmit" class="btn btn-link">Submit</button>
                            </td>
                        </tr>
                    </table>
                    </form>
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