<?php
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: ../login.php");
}
if (strpos($_SESSION['user'], 'O01') !== false) {
    header("location: ../officerView/index.php");
} elseif (strpos($_SESSION['user'], 'S01') !== false) {
    header("location: ../officeView/index.php");
}

include('../db_connection.php');

$conn = OpenCon();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Driver Interface</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">eTiquet</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">

                <div class="input-group-append">

                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Profile
                        </a>
                        <a class="nav-link" href="driverViolations.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            List of Violations
                        </a>
                        <a class="nav-link" href="driverVehicle.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Vehicles
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['user']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid " style="background-color: white;">
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List of your vehicles</li>
                    </ol>
                    <div class="container-fluid shadow-lg p-3 mb-5 bg-white rounded form row">
                        <?php
                                $sql = 'SELECT *
                                        FROM tbl_vehicle
                                        INNER JOIN tbl_drivervehicle
                                        ON tbl_vehicle.plateNumber = tbl_drivervehicle.plateNumber where tbl_drivervehicle.licenseNumber = \''.$_SESSION['user'].'\';';
                                $result = mysqli_query($conn, $sql);
                                $rows = array();
                                $ctr = 0;
                                while ($r = mysqli_fetch_assoc($result)) {
                                    $rows[] = $r;
                        ?>
                        <div class="card col-lg-3 col-md-4 col-sm-6" style="width: 18rem;">
                            <img class="card-img-top" src="..." alt="Card image cap">
                            <div class="card-body">
                                <label class="card-text small col-12">Plate Number: <?php echo $rows[$ctr]['plateNumber'] ?> </label>
                                <label class="card-text small col-12">File Number: <?php echo $rows[$ctr]['fileNumber'] ?> </label>
                                <label class="card-text small col-12">Chassis Number: <?php echo $rows[$ctr]['chassisNumber'] ?> </label>
                                <label class="card-text small col-12">Engine Number: <?php echo $rows[$ctr]['engineNumber'] ?> </label>
                            </div>
                        </div>
                        <?php $ctr++;}?>
                    </div>
                    
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>



</body>

</html>