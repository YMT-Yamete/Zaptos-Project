<?php
include 'connect.php';
session_start();
if (isset($_SESSION['AdminID'])) {
    // get product information
    if (isset($_GET['ProductID'])) {
        $productID = $_GET['ProductID'];
        $selectProduct = "SELECT * FROM Products WHERE ProductID = '$productID'";
        $query = $connection->query($selectProduct);
        while ($row = $query->fetch_assoc()) {
            $name = $row['ProductName'];
            $description = $row['ProductDescription'];
            $price = $row['Price'];
            $stock = $row['Stock'];
            $productImg = $row['ProductImage'];
        }
    }
} else {
    echo "<script>window.location = 'login.php'</script>";
}

if (isset($_POST['btnSubmit'])) {
    $id = $_POST['inputID'];
    $name = $_POST['inputName'];
    $description = $_POST['inputDescription'];
    $price = $_POST['inputPrice'];
    $stock = $_POST['inputStock'];
    $chosenImg = $_FILES['inputImg']['name'];

    // echo $id;
    // echo $name;
    // echo $description;
    // echo $price;
    // echo $stock;
    // echo $chosenImg;
    if ($chosenImg == null) {
        $updateQuery = "UPDATE Products 
                        SET ProductName = '$name' 
                        , ProductDescription = '$description' 
                        , Price = '$price' 
                        , Stock = '$stock'
                        WHERE ProductID = '$id'";
        if ($connection->query($updateQuery)) {
            echo "<script>alert('Product Updated')</script>";
            echo "<script>window.location = 'stocks.php'</script>";
        } else {
            echo $connection->error;
        }
    } 
    else {
        $savedDestination = '../Imgs/Product/' . $id . '.jpg';
        $copiedImg = copy($_FILES['inputImg']['tmp_name'], $savedDestination);
        $updateQuery = $updateQuery = "UPDATE Products 
                                        SET ProductName = '$name' 
                                        , ProductDescription = '$description' 
                                        , Price = '$price' 
                                        , Stock = '$stock' 
                                        , ProductImage = '$savedDestination'
                                        WHERE ProductID = '$id'";
        if ($connection->query($updateQuery)) {
            echo "<script>alert('Product Updated')</script>";
            echo "<script>window.location = 'stocks.php'</script>";
        } else {
            echo $connection->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Zaptos Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <!-- css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- data tables -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <h1><a href="index.php" class="logo">Zaptos</a></h1>
            <ul class="list-unstyled components mb-5">
                <li>
                    <a href="#"><span class="fa fa-users mr-3"></span> Users</a>
                    <ul>
                        <li>
                            <a href="index.php">Users</a>
                        </li>
                        <li>
                            <a href="membership.php">Members</a>
                        </li>
                        <li>
                            <a href="membership-applications.php">Membership Application</a>
                        </li>
                        <li>
                            <a href="feedback.php">Feedbacks</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><span class="fa fa-sticky-note mr-3"></span> Bookings</a>
                    <ul>
                        <li>
                            <a href="bookings.php">Bookings</a>
                        </li>
                        <li>
                            <a href="booking-history.php">Booking History</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><span class="fa fa-gift mr-3"></span> Sales</a>
                    <ul>
                        <li>
                            <a href="stocks.php">Stocks</a>
                        </li>
                        <li>
                            <a href="orders.php">Orders</a>
                        </li>
                        <li>
                            <a href="shipped-orders.php">Shipped Orders</a>
                        </li>
                        <li>
                            <a href="order-history.php">Order History</a>
                        </li>
                    </ul>
                </li>
                <li style="text-align:center;">
                    <br>
                    <a href="logout.php"><button type="submit" class="btn" style="background-color: #005C67; color: white;">Logout</button></a>
                </li>
            </ul>
        </nav>

        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="container">
                <h2 class="pageHeader"> Edit Product</h2>
                <form action="edit-product.php?ProductID=<?php echo $productID; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="inputID" class="form-control" value="<?php echo $productID ?>" hidden>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="inputName" class="form-control" value="<?php echo $name ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Product Description</label><br>
                        <textarea name="inputDescription" style="width: 100%; border-color: #ced4da;" rows="5"><?php echo $description ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="inputPrice" class="form-control" value="<?php echo $price ?>">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">In stock</label>
                        <input type="number" name="inputStock" class="form-control" min="0" value="<?php echo $stock ?>">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Product Image</label>
                        <input class="form-control" name="inputImg" type="file" id="formFile" value="<?php echo $productImg ?>">
                    </div>
                    <button type="submit" name="btnSubmit" class="btn" style="background-color: #005C67; color: white;">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>