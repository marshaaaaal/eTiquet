<?php
session_start();
if(!isset($_SESSION['user'])){
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: ../login.php");

}
if(strpos($_SESSION['user'], 'E01') !== false){
    header("location: ../driverView/index.php");
}
elseif(strpos($_SESSION['user'], 'O01') !== false){
    header("location: ../officerView/index.php");
}
include '../db_connection.php';

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
        <title>Tables - SB Admin</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand" style="background:#164172" >
            <a class="navbar-brand" href="../officeView/dashboard.php">
				<img src="../image/eTiquetLogoWhite.png" alt="" style="height:100px;width:auto;margin-left:30px"></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars" style="color:white"></i></button>
           <!-- Navbar Search-->
           <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                     
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw" style="color:white	"></i></a>
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
                            <div class="sb-sidenav-menu-heading">Core</div>
                           
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-copy"></i></div>
                                Application Form
                            </a>
                            <a class="nav-link" href="driverTable.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Drivers' List
                            </a>
                            <a class="nav-link" href="payQueue.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                                Payment Queue
                            </a>
                            <a class="nav-link" href="violationRec.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-circle"></i></div>
                                Violation Records
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php
                        echo $_SESSION['user'];
                        ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
<br>
						<ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Driver's List</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Records
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead  style="background:#164172;color:white">
                                            <tr>
                                            <th>License Number</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>License Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>License Number</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>License Status</th>
                                            <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
											<?php
$sql = "select * from tbl_drivers INNER JOIN tbl_documents ON tbl_drivers.licenseNumber = tbl_documents.licenseNumber";
$result = mysqli_query($conn, $sql);
$rows = array();
$ctr = 0;
$violationNum = "";
while ($r = mysqli_fetch_assoc($result)) {
$rows[] = $r;

?>
<tr>
<th scope="row"><?php echo $rows[$ctr]["licenseNumber"]; ?>
</th>
<td><?php echo $rows[$ctr]["lastName"].", ". $rows[$ctr]["firstName"].", ".$rows[$ctr]["firstName"]; ?></td>
<td><?php echo $rows[$ctr]["address"]; ?></td>
<td><?php echo $rows[$ctr]["status"]; ?></td>

<td>
<button id=' ' value='' data-toggle="modal" data-target=<?php echo '\'#' . $rows[$ctr]["licenseNumber"] . '\''; ?> type='button' class="btn btn-primary">View Details</button>
<!-- Modal for view detalis -->
<div class="modal fade" id=<?php echo '\'' . $rows[$ctr]["licenseNumber"] . '\''; ?> tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel"><b> <?php echo $rows[$ctr]["licenseNumber"]; ?></b></h5>
</div>
<div class="modal-body">
<div class="for row form-group">
<div class="col-md-6">
<label class="small mb-1">Name of driver:<b> <?php echo $rows[$ctr]["lastName"].", ". $rows[$ctr]["firstName"].", ".$rows[$ctr]["firstName"];?></b></label>
</div>
<div class="col-md-6">
<label class="small mb-1">Type of License: <b><?php echo $rows[$ctr]['licenseType']; ?></b></label>
</div>
<div class="col-md-3">
<label class="small mb-1">Restrictions: <b><?php echo $rows[$ctr]['restrictions']; ?></b></label>
</div>
<div class="col-md-3">
<label class="small mb-1">Condition: <b><?php echo $rows[$ctr]['driverCondition']; ?></b></label>
</div>
<div class="col-md-6">
<label class="small mb-1">Address: <b><?php echo $rows[$ctr]['address']; ?></b></label>
</div>
<div class="col-md-4">
<label class="small mb-1"> Contact Number:  <b><?php echo $rows[$ctr]['contactNumber']; ?></b></label>
</div>
<div class="col-md-2">
<label class="small mb-1">TIN: <b><?php echo $rows[$ctr]['tinNumber']; ?></b></label>
</div>
<div class="col-md-3">
<label class="small mb-1">Nationality: <b><?php echo $rows[$ctr]['nationality']; ?></b></label>
</div>
<div class="col-md-3">
<label class="small mb-1">Gender: <b><?php echo $rows[$ctr]['gender']; ?></b></label>
</div>
<div class="col-md-4">
<label class="small mb-1">Birthdate: <b><?php echo $rows[$ctr]['birthDate']; ?></b></label>
</div>
<div class="col-md-2">
<label class="small mb-1">Height: <b><?php echo $rows[$ctr]['height']; ?></b></label>
</div> 
<div class="col-md-3">
<label class="small mb-1">Weight: <b><?php echo $rows[$ctr]['weight']; ?></b></label>
</div>
<div class="col-md-3">
<label class="small mb-1">Blood Type: <b><?php echo $rows[$ctr]['bloodType']; ?></b></label>
</div>
<div class="col-md-5">
<label class="small mb-1">Will donate Organ? <b><?php echo $rows[$ctr]['organDonor']; ?></b></label>
</div>

<div class="col-md-12">
<div class="form row">
<div class="col-md-6">
<label class="small mb-1">License Issued Date: <b><?php echo $rows[$ctr]['licenseIssued'] ?></b></label>
</div>
<div class="col-md-6">
<label class="small mb-1">License Expiration Date: <b><?php echo $rows[$ctr]['licenseExpiration'] ?></b></label>
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<?php

?>
</td>
</tr>
<?php
$ctr++;
}
?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
				<div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                <h1 class="mt-4">Unregistered Drivers</h1>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead  style="background:#164172;color:white">
                                            <tr>
                                            <th scope="col">Temporary License Number</th>
<th scope="col">Name</th>
<th scope="col">Address </th>
<th scope="col">Contact Number </th>
<th scope="col">Issued Date</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th scope="col">Temporary License Number</th>
<th scope="col">Name</th>
<th scope="col">Address </th>
<th scope="col">Contact Number </th>
<th scope="col">Issued Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
									<?php
$sql = "select * from tbl_nodriverlicense ";
$result = mysqli_query($conn, $sql);
$rows = array();
$ctr = 0;
$violationNum = "";
while ($r = mysqli_fetch_assoc($result)) {
$rows[] = $r;

?>
<tr>
<th scope="row"><?php echo $rows[$ctr]["noDriverLicenseNumber"]; ?>
</th>
<td><?php echo $rows[$ctr]["lastName"].", ". $rows[$ctr]["firstName"].", ".$rows[$ctr]["firstName"]; ?></td>
<td><?php echo $rows[$ctr]["address"]; ?></td>
<td><?php echo $rows[$ctr]["contactNumber"]; ?></td>
<td><?php echo $rows[$ctr]["issuedDate"]; ?></td>
</tr>
<?php
$ctr++;
}
?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					
                </main>
                
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../assets/demo/datatables-demo.js"></script>
    </body>
</html>
