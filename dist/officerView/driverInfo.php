<?php
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: ../login.php");
}
if (strpos($_SESSION['user'], 'E01') !== false) {
    header("location: ../driverView/index.php");
} elseif (strpos($_SESSION['user'], 'S01') !== false) {
    header("location: ../officeView/index.php");
}

include('../db_connection.php');
$conn = OpenCon();


if (!empty($_GET)) {
    $_SESSION['got'] = $_GET;
    header("location: driverinfo.php");
    die;
} else {
    if (!empty($_SESSION['got'])) {
        $_GET = $_SESSION['got'];
        unset($_SESSION['got']);
    }

    //use the $_GET var here..
    if (isset($_GET['LN'])) {
        $LicenseNumber = base64_decode($_GET['LN']);
        $checkedOrNot = 0;
        if (strpos($LicenseNumber, 'x') !== false) {
            $LicenseNumber = substr($LicenseNumber, 1);
            $checkedOrNot = 1;
        }
        $resultDoc = $conn->query("SELECT * FROM `tbl_documents` WHERE licenseNumber= '$LicenseNumber'") or die($conn->error);
        $resultDriver = $conn->query("SELECT * FROM `tbl_drivers` WHERE licenseNumber='$LicenseNumber'") or die($conn->error);
    } else header("location: index.php");
    if (mysqli_num_rows($resultDoc) == 1) $rowDoc = $resultDoc->fetch_array();
    if (mysqli_num_rows($resultDriver) == 1) $rowDri = $resultDriver->fetch_array();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Scanner</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/styles2.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">eTiquet</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
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
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Scanner
                        </a>
                        <a class="nav-link" href="record.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Records
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php
                    echo $_SESSION['user'];
                    ?>
                    <input type="hidden" id="user" value=<?php echo "\'" . $_SESSION['user'] . "\'"; ?>>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid" style="background-color: white; display: block;" id="divImage">
                    <center>
                        <img id="driverImage" height="auto" style="width:60%;margin-top:2%" src=<?php echo "\"" . $rowDri['driverImage'] . "\""; ?>></img>
                        <div class="form-group">
                            <a href="index.php"><button class="btn btn-secondary" id="close" type="button">Close</button></a>
                            <button class="btn btn-primary" id="confirm" type="button" onclick="confirmDriver()">Confirm</button>
                        </div>
                    </center>
                </div>
                <div class="container-fluid" style="background-color: white; display: none;margin-top:2%" id="driverInfo">
                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                        <div class="form-group form-row">
                            <!--for image and buttons-->
                            <div class="col-md-2">
                                <div class="form row">
                                    <!-- for driver pic-->
                                    <div class="col-md-12 mb-3">
                                        <img id="driverImage" height="auto" style="width:100%" src=<?php echo "\"" . $rowDri['driverImage'] . "\""; ?>></img>
                                    </div>
                                    <!-- for add violation-->
                                    <div class="col-md-12 mb-3">
                                        <button type="button" class="btn btn-danger" style="width:100%" onclick="addViolation()">Add Violations</button>
                                    </div>
                                    <!-- for done-->
                                    <div class="col-md-12 mb-3">
                                        <a href="index.php"> <button type="button" class="btn btn-secondary" style="width:100%">Done</button></a>
                                    </div>
                                </div>
                            </div>
                            <!--for license info-->
                            <div class="col-md-10">
                                <div class="form row">
                                    <!--for name and licence number-->
                                    <div class="col-md-12">
                                        <div class="form row">
                                            <!--name-->
                                            <div class="col-md-2">
                                                <div class="col-md-12">
                                                    <label class="large"><b> <?php echo strtoupper($rowDri['lastName']); ?></b> </label>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="small" style=" margin-top: -10px">Last Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="col-md-12">
                                                    <label class="large"><b> <?php echo strtoupper($rowDri['firstName']); ?></b> </label>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="small" style=" margin-top: -10px">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="col-md-12">
                                                    <label class="large"><b> <?php echo strtoupper($rowDri['middleName']); ?></b> </label>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="small" style=" margin-top: -10px">Middle Name</label>
                                                </div>
                                            </div>
                                            <!--license numb-->
                                            <div class="col-md-6">
                                                <label class="large"><b> License Number: <?php echo strtoupper($rowDri['licenseNumber']); ?></b> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!--for licence other info-->
                                    <div class="col-md-12">
                                        <div class="container-fluid">
                                            <div class="form row">
                                                <!--for licence status-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <?php
                                                        $color = "";
                                                        if (strcmp($rowDoc['status'], "Active") == 0) {
                                                            $color = "large text-success";
                                                        } else {
                                                            $color = "large text-danger";
                                                        }
                                                        ?>
                                                        <label class=<?php echo '\'' . $color . '\''; ?>><b> <?php echo $rowDoc['status']; ?></b> </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">License Status</label>
                                                    </div>
                                                </div>
                                                <!--for licence restriction-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDoc['restrictions']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">License Restrictions</label>
                                                    </div>
                                                </div>
                                                <!--for licence type-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDoc['licenseType']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">License Type</label>
                                                    </div>
                                                </div>
                                                <!--for licence exp date-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDoc['licenseExpiration']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">License Expiration</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form row">
                                                <!--for  nationality-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b> <?php echo $rowDri['nationality']; ?></b> </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Nationality</label>
                                                    </div>
                                                </div>
                                                <!--for  birthdate-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDri['birthDate']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Date of Birth</label>
                                                    </div>
                                                </div>
                                                <!--for agency code-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo substr($rowDri['licenseNumber'], 0, 3); ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Agency Code</label>
                                                    </div>
                                                </div>
                                                <!--for cohntact num-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDri['contactNumber']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Tel No./ CP No.</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--for addresss-->
                                            <div class="form row">
                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDri['address']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Address</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form row">
                                                <!--for  gender-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b> <?php echo $rowDri['gender']; ?></b> </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Gender</label>
                                                    </div>
                                                </div>
                                                <!--for  condition-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDoc['driverCondition']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Conditions</label>
                                                    </div>
                                                </div>
                                                <!--for blood type-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo substr($rowDri['bloodType'], 0, 3); ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Blood Type</label>
                                                    </div>
                                                </div>
                                                <!--for eyes color-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDri['eyesColor']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Eyes Color</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form row">
                                                <!--for  weight-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b> <?php echo $rowDri['weight']; ?></b> </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Weight (kg)</label>
                                                    </div>
                                                </div>
                                                <!--for  height-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <label class="large"><b><?php echo $rowDri['height']; ?></b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small" style=" margin-top: -10px">Height (cm)</label>
                                                    </div>
                                                </div>
                                                <!--for organ donor-->
                                                <div class="col-md-3">
                                                    <div class="col-md-12">
                                                        <?php
                                                        $OD = "";
                                                        if (strcmp($rowDri['organDonor'], "Yes") == 0) $OD = "I will donate any organ";
                                                        else $OD = "I will not donate any organ";
                                                        ?>
                                                        <label class="large" style="margin-top:10px"><b><?php echo $OD; ?></b></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="col-md-12 ">
                                                        <label class="large">Father: <b><?php echo ucfirst($rowDri['fatherName']); ?> - <?php echo ucfirst($rowDri['fatherContact']); ?> </b></label>
                                                    </div>
                                                    <div class="col-md-12">
                                                    <label class="large">Mother:<b> <?php echo ucfirst($rowDri['motherName']); ?> - <?php echo ucfirst($rowDri['motherContact']); ?> </b></label>

                                                    </div>
                                                    <div class="col-md-12">
                                                    <label class="large">Spouse:<b><?php echo ucfirst($rowDri['spouseName']); ?> - <?php echo ucfirst($rowDri['spouseContact']); ?> </b></label>

                                                    </div>
                                                    <div class="col-md-12">
                                                    <label class="small" style=" margin-top: -10px">Incase of emergency contacts</label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--for table-->
                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                        <div class="form row">

                            <div class="col-md-12">
                                <div class="form-group table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table" id="dataTable" width="100%" cellspacing="0"><br><br>
                                        <h3>List of <?php echo $rowDri['lastName']; ?>'s Violations</h3>
                                        <thead class="thead">
                                            <tr>
                                                <th scope="col">Violation Number</th>
                                                <th scope="col">Issued Date</th>
                                                <th scope="col">Status/Remarks</th>
                                                <th scope="col"></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "select * from tbl_driverviolation where licenseNumber = '$LicenseNumber';";
                                            $result = mysqli_query($conn, $sql);
                                            $rows = array();
                                            $ctr = 0;
                                            $violationNum = "";
                                            while ($r = mysqli_fetch_assoc($result)) {
                                                $rows[] = $r;
                                                if (!(strcmp($violationNum, $rows[$ctr]["violationNumber"]) == 0)) {
                                            ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $rows[$ctr]["violationNumber"]; ?>
                                                        </th>
                                                        <td><?php echo $rows[$ctr]["issuedDate"]; ?></td>
                                                        <?php
                                                        $colorPaid = "";
                                                        if (strcmp($rows[$ctr]["remarks"], "Paid") == 0)
                                                            $colorPaid = "text-success";
                                                        else
                                                            $colorPaid = "text-danger";
                                                        ?>
                                                        <td class=<?php echo $colorPaid ?>><?php echo $rows[$ctr]["remarks"]; ?></td>
                                                        <td>
                                                            <button id=' ' value='' data-toggle="modal" data-target=<?php echo '\'#' . $rows[$ctr]["violationNumber"] . '\''; ?> type='button' class="btn btn-primary">View Details</button>
                                                            <!-- Modal for view detalis -->
                                                            <div class="modal fade" id=<?php echo '\'' . $rows[$ctr]["violationNumber"] . '\''; ?> tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><b> <?php echo $rows[$ctr]["violationNumber"]; ?></b></h5>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="for row form-group">
                                                                                <div class="col-md-12">
                                                                                    <label class="small mb-1">Place of apprehension:<b> <?php echo $rows[$ctr]['apprehensionPlace']; ?></b></label>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <label class="small mb-1">Confiscated Items: <b><?php echo $rows[$ctr]['confiscatedItem']; ?></b></label>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <label class="small mb-1"> While Driving Motorcycle, vehicle described as follows:</label>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label class="small mb-1">Plate Number: <b><?php echo $rows[$ctr]['plateNumber']; ?></b></label>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <?php
                                                                                    $sql1 = 'select * from tbl_vehicle where plateNumber = \'' . $rows[$ctr]['plateNumber'] . '\';';
                                                                                    $rowVehicle = array();
                                                                                    $rowVehicle = mysqli_fetch_assoc(mysqli_query($conn, $sql1)); ?>
                                                                                    <label class="small mb-1">File Number:<b> <?php echo $rowVehicle['fileNumber']; ?></b></label>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label class="small mb-1">Engine Number:<b> <?php echo $rowVehicle['engineNumber']; ?></b></label>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <label class="small mb-1">Chassis Number:<b> <?php echo $rowVehicle['chassisNumber']; ?></b></label>
                                                                                </div>

                                                                                <label class="small mb-1">Registered Owner:<b>
                                                                                        <?php
                                                                                        $regOwn = explode(" ", $rowVehicle['registeredOwner']);
                                                                                        echo ucfirst($regOwn[count($regOwn) - 1]) . ', ' . ucfirst(substr($regOwn[0], 0, 1)) . '.';
                                                                                        ?></b>
                                                                                </label>

                                                                                <div class="col-md-12">
                                                                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                                                                        <table id=<?php echo '\'tbl' . $rows[$ctr]['violationNumber'] . '\''; ?> class="table table-bordered table-striped mb-0">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th scope="col">Violation ID</th>
                                                                                                    <th scope="col">Description</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td><?php echo $rows[$ctr]['violationID'] ?></td>
                                                                                                    <td><?php $sql2 = 'select name from list_violation where violationID = \'' . $rows[$ctr]['violationID'] . '\';';
                                                                                                        $rowVio = mysqli_fetch_assoc(mysqli_query($conn, $sql2));
                                                                                                        echo $rowVio['name']; ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <label class="small mb-1">Apprehended by Officer ID: <b><?php echo $rows[$ctr]['staffID'] ?></b></label>
                                                                                    <br>
                                                                                    <label class="small mb-1">Officer name: <b><?php
                                                                                                                                $sqlo = 'select lastName, firstName from tbl_staff where staffID = \'' . $rows[$ctr]['staffID'] . '\';';
                                                                                                                                $rowoffcr = mysqli_fetch_assoc(mysqli_query($conn, $sqlo));
                                                                                                                                echo ucfirst($rowoffcr['lastName']) . ', ' . substr(ucfirst($rowoffcr['firstName']), 0, 1) . '.';
                                                                                                                                ?></b>
                                                                                    </label>
                                                                                    <br>
                                                                                    <label class="small mb-1">Issued date: <b><?php echo $rows[$ctr]['issuedDate'] ?></b></label>
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
                                                    } //end of not equal violation
                                                    else { //modifly violation modal to add more violations of the same violation number but different violation ID
                                                        echo "<script>
                                                    var table = document.getElementById('tbl" . $rows[$ctr]['violationNumber'] . "');
                                                    var row = table.insertRow(-1);
                                                    var cell1 = row.insertCell(0);
                                                    var cell2 = row.insertCell(1);
                                                    cell1.innerHTML = '" . $rows[$ctr]['violationID'] . "';";
                                                        $sql2 = 'select name from list_violation where violationID = \'' . $rows[$ctr]['violationID'] . '\';';
                                                        $rowVio = mysqli_fetch_assoc(mysqli_query($conn, $sql2));
                                                        echo "cell2.innerHTML = '" . $rowVio['name'] . "';
                                                </script>";
                                                    }
                                                        ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                $violationNum = $rows[$ctr]["violationNumber"];
                                                $ctr++;
                                            }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--for adding violation-->
                <div id="apprehensionReport" style="display:none">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                <div class="container-fluid" style="background-color: white;">
                                    <h3>Apprehension Report</h3>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="small mb-1" for=" "><b>Place of apprehension</b></label>
                                                <input class="form-control  " id="txtP_Apprehension" name="txtP_Apprehension" type="text" />
                                                <input class="form-control  " id="txtlicense" name="txtlicense" type="text" hidden value=<?php echo '\'' . $LicenseNumber . '\'';  ?> />

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="small mb-1" for=" "><b>Confiscated item/s</b></label>
                                                <input class="form-control " id="txtC_items" name="txtC_items" type="text" />
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <h3>List of Violations</h3>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <b>I. LTO Violations fee relative to Licensing </b>
                                            <div class="form-check"><br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation1_1" name="violation1[]" value="LV1-001-01"> Driving without license in the Philippines</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation1_2" name="violation1[]" value="LV1-002-01"> LTO penalty for not wearing seatbelt in the Philippines</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation1_3" name="violation1[]" value="LV1-003-01"> Driving under the impact of alcohol/dangerous drugs</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation1_4" name="violation1[]" value="LV1-004-01"> Careless driving</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation1_5" name="violation1[]" value="LV1-005-01"> Other LTO violations and penalties for breaking traffic rules</label> <br>
                                                <?php
                                                if ($checkedOrNot == 1) {
                                                    echo "<script>document.getElementById('violation1_1').checked=true;</script>";
                                                    echo "<script>document.getElementById('violation1_1').onclick= function (){return false;};</script>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <b>II. LTO Fines and Penalties connected with car registration/renewal </b>
                                            <div class="form-check"><br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation2_1" name="violation2[]" value="LV2-001-01"> Driving without valid vehicle registration</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation2_2" name="violation2[]" value="LV2-002-01"> Driving an illegally modified car </label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation2_3" name="violation2[]" value="LV2-003-01"> Running a right hand car</label> <br>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <b>III. LTO Fines and Penalties cin connection with vehicles accessories, equipment, parts</b>
                                            <div class="form-check"><br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation3_1" name="violation3[]" value="LV3-001-01"> Driving a car without proper/authorized devices, equipment, accessories or car part</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation3_2" name="violation3[]" value="LV3-002-02"> Operating a car with an improper attachment/unauthorized of motor vehicle license plate </label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation3_3" name="violation3[]" value="LV3-003-03"> Smoke Belching</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="violation3_4" name="violation3[]" value="LV4-001-01"> Other related LTO violations</label> <br>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="form-group form row mt-4 mb-0">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" id="btnVehicle" data-toggle="modal" data-target="#vehicleScan" style="width:100%">Vehicle</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button disabled type="button" id="btnmodalConfirm" class="btn btn-primary" data-toggle="modal" data-target="#confirmModalSubmit" name="" style="width:100%" onclick="modalConfirm()">Done</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </main>

            <!--modals-->
            <!--vehicle scan modals-->
            <div class="modal fade" id="vehicleScan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="VScanTitle">Scan Vehicle</h5>

                        </div>
                        <div class="modal-body">
                            <div id="box1">
                                <center>
                                    <div id="vChoose" style="margin-top:3%; display:block">
                                        <div class="form row">
                                            <div class="col-md-6">
                                                <button id="" type="button" class="btn btn-primary" style="display:block" onclick="scanVehicle()">Scan Vehicle QR Code</button>
                                            </div>
                                            <div class="col-md-6">
                                                <button id="" type="button" class="btn btn-primary" style="display:block" onclick="btnManualInputForm()">Manually Input Plate Number</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!--for scanning vehicle-->
                                    <div id="vscanner" style="margin-top:3%; display:none">
                                        <video id="preview1" class="p-1 border" style="width: 100%"></video>
                                    </div>

                                    <!--for scanning vehicle-->
                                    <div id="orcr" style="display:none">
                                        <div class="form row">
                                            <div class="col-md-6">
                                                <label id="lblor" for="or">Official Receipt</label>
                                                <img id="or" src="" heigh="auto" style="width:70%"></img>
                                            </div>
                                            <div class="col-md-6">
                                                <label id="lblcr" for="cr"> Certificate Of Registration</label>
                                                <img id="cr" src="" heigh="auto" style="width:70%"></img>
                                            </div>
                                        </div>
                                    </div>

                                    <!--for manual input of ORCR form-->
                                    <div id="manualInputForm" style="display:none;">
                                        <div class="form-group form row">
                                            <div class="col-md-12">
                                                <label class="small mb-1" id="lblplatenum" for="plateNum">Plate Number</label>
                                                <input class="form control" type="text" id="plateNum" />
                                            </div>
                                        </div>
                                    </div>

                                </center>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeVscan" class="btn btn-secondary" data-dismiss="modal" style="display:none" onclick="scanVclose()">Close</button>
                            <button type="button" id="startVscan" class="btn btn-primary" style="display:none" onclick="rescanVehicle()">Scan QR</button>
                            <button type="button" id="manualInputOrcr" class="btn btn-primary" style="display:none" onclick="btnManualInputForm()">Manual input</button>
                            <button type="button" id="plateNumInput" class="btn btn-primary" style="display:none" onclick="btnConfirmPlate()">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--modal for summary of violation confirmation-->
            <form id="confirmationForm" method="post" action="../SaveRecords/saveViolation.php">
                <div class="modal modal-fade" id="confirmModalSubmit">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="modalSummary" style="display:block">
                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                <h3>Apprehension Report Summary</h3>
                                <div class="container-fluid" style="background-color: white;">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" for=" "><b>Place of apprehension</b></label>
                                                <input required class="form-control  " readonly id="txtmP_Apprehension" name="txtP_Apprehension" type="text" />
                                                <input class="form-control  " id="txtmlicense" name="txtlicense" type="text" hidden value=<?php echo '\'' . $LicenseNumber . '\'';  ?> />

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" for=" "><b>Confiscated item/s</b></label>
                                                <input readonly class="form-control " id="txtmC_items" name="txtC_items" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="small mb-1" for=" "><b>Name of Driver</b></label>
                                                <input readonly class="form-control " id="txtN_driver" name="txtN_driver" type="text" value=<?php echo '\'' . $rowDri['lastName'] . ', ' . $rowDri['firstName'] . ', ' . $rowDri['middleName'] . '\'';  ?> />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="small mb-1" for=" "><b>Address of Driver</b></label>
                                                <input readonly class="form-control " id="txtAddress" name="txtAddress" type="text" value=<?php echo '\'' . $rowDri['address'] . '\''; ?> />
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                </div>

                                <div class="container-fluid" style="background-color: white;" id="confirmationViolation" style="display:block">
                                    <h3>List of Violations</h3>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <b>I. LTO Violations fee relative to Licensing </b>
                                            <div class="form-check"><br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation1_1" name="violation1[]" value="LV1-001-01" onclick="return false;"> Driving without license in the Philippines</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation1_2" name="violation1[]" value="LV1-002-01" onclick="return false;"> LTO penalty for not wearing seatbelt in the Philippines</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation1_3" name="violation1[]" value="LV1-003-01" onclick="return false;"> Driving under the impact of alcohol/dangerous drugs</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation1_4" name="violation1[]" value="LV1-004-01" onclick="return false;"> Careless driving</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation1_5" name="violation1[]" value="LV1-005-01" onclick="return false;"> Other LTO violations and penalties for breaking traffic rules</label> <br>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <b>II. LTO Fines and Penalties connected with car registration/renewal </b>
                                            <div class="form-check"><br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation2_1" name="violation2[]" value="LV2-001-01" onclick="return false;"> Driving without valid vehicle registration</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation2_2" name="violation2[]" value="LV2-002-01" onclick="return false;"> Driving an illegally modified car </label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation2_3" name="violation2[]" value="LV2-003-01" onclick="return false;"> Running a right hand car</label> <br>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <b>III. LTO Fines and Penalties cin connection with vehicles accessories, equipment, parts</b>
                                            <div class="form-check"><br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation3_1" name="violation3[]" value="LV3-001-01" onclick="return false;"> Driving a car without proper/authorized devices, equipment, accessories or car part</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation3_2" name="violation3[]" value="LV3-003-02" onclick="return false;"> Operating a car with an improper attachment/unauthorized of motor vehicle license plate </label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation3_3" name="violation3[]" value="LV3-003-03" onclick="return false;"> Smoke Belching</label> <br>
                                                <label class="small mb-1"> <input type="checkbox" id="mviolation3_4" name="violation3[]" value="LV4-001-01" onclick="return false;"> Other related LTO violations</label> <br>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <label class="large"><b>Vehicle Information</b></label>
                                            <div class="form row ">

                                                <div class="col-md-6">
                                                    <!--for plate number-->
                                                    <div class="col-md-12">
                                                        <label class="small">Plate Number</label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input readonly class="form-control input-sm" id="txtPlateNumber" name="txtPlateNumber" type="text" />
                                                    </div>

                                                    <!-- for engine number-->
                                                    <div class="col-md-12">
                                                        <label class="small">Engine Number</label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input readonly class="form-control input-sm" id="txtEngineNumber" type="text" />
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <!-- for chassis number-->
                                                    <div class="col-md-12">
                                                        <label class="small">Chassis Number</label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input readonly class="form-control input-sm" id="txtChassisNumber" type="text" />
                                                    </div>


                                                    <!-- for file number-->
                                                    <div class="col-md-12">
                                                        <label class="small">File Number</label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input readonly class="form-control input-sm" id="txtFileNumber" type="text" />
                                                    </div>

                                                </div>


                                                <!-- for registered Owner-->
                                                <div class="col-md-12">
                                                    <label class="small">Registered Owner</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <input readonly class="form-control input-sm" id="txtRegisteredOwner" type="text" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id="btnVehicle" data-dismiss="modal" style="width:100%">Close</button>
                                    <button type="button" class="btn btn-primary" style="width:100%" onclick="confirmViolation()">Confirm</button>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!--confrmation to submit scan modal-->
                    <div id="confirmationQR" style="display:none">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Scan QR of driver to Confirm</h5>
                                </div>
                                <div class="modal-body">
                                    <div id="box2">
                                        <center>
                                            <div id="dcscanner" style="margin-top:3%;">
                                                <video id="preview2" class="p-1 border" style="width: 100%"></video>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closedcScan()">Close</button>
                                    <button type="button" class="btn btn-primary" type="button" onclick="enterPassword()">Enter Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--confrmation to submit password modal-->
                    <div id="confirmationPass" style="display:none">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Scan QR of driver to Confirm</h5>

                                </div>
                                <div id="loginalert">
                                </div>
                                <div class="modal-body">
                                    <div id="box1">
                                        <center>
                                            <div id=" " style="margin-top:3%;">
                                                <input type="password" id="txtpassw" />
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closedcScan()">Close</button>
                                    <button id="submitRep" class="btn btn-primary" type="button" onclick="submitReport()" placeholder="Kindly Input a vehicle information">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    <script src="driverinfroscript.js"></script>

</body>
<?php unset($_GET['LN']); ?>

</html>