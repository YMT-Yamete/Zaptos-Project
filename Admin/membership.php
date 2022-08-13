<?php
include 'connect.php';
session_start();
if (isset($_SESSION['AdminID'])) {
    // select members
    $select = "SELECT * FROM Memberships m, Users u, MembershipTypes mt
                WHERE m.UserID = u.UserID
                AND m.MembershipTypeID = mt.MembershipTypeID
                AND m.MembershipStatus != 'Pending'";
    $query = $connection->query($select);
} else {
    echo "<script>window.location = 'login.php'</script>";
}

// remove members
if (isset($_POST['btnRemove'])) {
    $membershipID = $_POST['inputMembershipID'];
    $delete = "DELETE FROM Memberships WHERE MembershipID = '$membershipID'";
    if ($connection->query($delete)) {
        echo "<script>alert('Member Removed');</script>";
        echo "<script>window.location = 'membership.php'</script>";
    } else {
        echo $connection->error;
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
                        <li class="active">
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
                    <a href="logout.php"><button type="submit" class="btn" name="btnSubmit" style="background-color: #005C67; color: white;">Logout</button></a>
                </li>
            </ul>
        </nav>

        <div id="content" class="p-4 p-md-5 pt-5">
            <div class="container">
                <h2 class="pageHeader">Members</h2>
                <form action="membership.php" method="POST">
                    <table id="tableID" class="table table-bordered table-striped table-responsive-stack">
                        <thead class="tableHeaders">
                            <tr>
                                <th>MemberID</th>
                                <th>UserID</th>
                                <th>Name</th>
                                <th>Membership Plan</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $query->fetch_assoc())
                                echo
                                "
                                <input type='text' name='inputMembershipID' value='$row[MembershipID]' hidden> 
                                <tr>
                                    <td>$row[MembershipID]</td>
                                    <td>$row[UserID]</td>
                                    <td>$row[Name]</td>
                                    <td>$row[MembershipType]</td>
                                    <td>$row[StartDate]</td>
                                    <td>$row[EndDate]</td>
                                    <td>$row[MembershipStatus]</td>
                                    <td><input type='submit' name='btnRemove' value='Remove Member' style='color:red; border:none;'></td>
                                </tr>";
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tableID').DataTable();
        });
    </script>
</body>

</html>