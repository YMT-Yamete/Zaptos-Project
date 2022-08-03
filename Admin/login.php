<?php
include 'connect.php';
session_start();
if (isset($_SESSION['AdminID'])) {
    echo "<script>window.location = 'index.php'</script>";
}
if (isset($_POST['btnSubmit'])) {
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];
    $select = "SELECT * FROM Admin 
              WHERE Username = '$username'
              AND Password = '$password'";
    $query = $connection->query($select);
    $count = $query->num_rows;
    if ($count > 0) {
        $adminArray = $query->fetch_array();
        $_SESSION['AdminID'] = $adminArray['AdminID'];
        echo "<script>alert('Login Successful');</script>";
        echo "<script>window.location = 'index.php'</script>";
    } else {
        echo "<script>alert('Username or Password Incorrect');</script>";
        echo "<script>window.location = 'login.php'</script>";
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
    <!-- custom css -->
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
                    <a href="#"><span class="fa fa-sign-in mr-3"></span> Login</a>
                </li>
            </ul>
        </nav>
        <table width="60%" style="margin-left: auto; margin-right: auto;" class="loginTable">
            <tr>
                <td>
                    <div id="content" class="p-4 p-md-5 pt-5">
                        <div class="container" style="border-style: groove; padding: 50px;">
                            <h2 class="pageHeader">Admin Login</h2><br>
                            <form action="login.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="inputUsername" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="inputPassword" class="form-control" required>
                                </div>
                                <button type="submit" class="btn" name="btnSubmit" style="background-color: #005C67; color: white;">Login</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
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