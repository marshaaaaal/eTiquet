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
    <nav class="sb-topnav navbar navbar-expand" style="background:#164172">
        <a class="navbar-brand" href="../driverView/index.php">
			
			          <img src="../image/eTiquetLogoWhite.png" alt="" style="height:100px;width:auto;margin-left:30px">

			 </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars" style="color:white"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw" style="color:white"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  
                    <div class="dropdown-divider" ></div>
                    <a class="dropdown-item" href="../logout.php" >Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav" >
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>

                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Information
                        </a>
						
						<a class="nav-link" href="driverVehicle.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                            Vehicle
                        </a>
						
						<a class="nav-link" href="driverViolations.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Violation
                        </a>
						
						
                    </div>
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
                            <img class="card-img-top" src=<?php echo $rows[$ctr]['vehicleImage'];?> alt="Card image cap" style="width:100%; height:270px">
                            <div class="card-body">
                                <label class="card-text small col-12">Plate Number: <?php echo $rows[$ctr]['plateNumber'] ?> </label>
                                <label class="card-text small col-12">File Number: <?php echo $rows[$ctr]['fileNumber'] ?> </label>
                                <label class="card-text small col-12">Chassis Number: <?php echo $rows[$ctr]['chassisNumber'] ?> </label>
                                <label class="card-text small col-12">Engine Number: <?php echo $rows[$ctr]['engineNumber'] ?> </label>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=<?php echo '\'#'.$rows[$ctr]['plateNumber'].'\'';?>>
                            Show ORCR 
                            </button>
                             <!-- Modal -->
                             <div class="modal fade" id=<?php echo '\''.$rows[$ctr]['plateNumber'].'\'';?> tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ORCR</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form row">
                                        <div class="col-md-6">
                                        <img class=" " src=<?php echo $rows[$ctr]['officialReceipt'];?> alt="Card image cap" style="width:100%; height:100%">
                                        </div>
                                        <div class="col-md-6">
                                        <img class=" " src=<?php echo $rows[$ctr]['certificateRegistration'];?> alt="Card image cap" style="width:100%; height:100%">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>
                            
                        </div>
                        
                        <?php $ctr++;}?>
                    </div>
                    
                </div>
            </main>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>



</body>

</html>