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
    <link href="../css/styles2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
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
                <div class="container-fluid">
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Driver's Profile</li>
                    </ol>


                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="row">
                            <?php

                            $documentsTable = array();
                            $licenseNumber = $_SESSION['user'];
                            $sql = "SELECT * FROM tbl_documents where licenseNumber = '$licenseNumber'";
                            $result = mysqli_query($conn, $sql) or die($conn->error);

                            if ($result) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $documentsTable[] = $row;
                                }
                            }


                            $driversTable = array();
                            $driverNumber = $documentsTable[0]['licenseNumber'];
                            $sql = "SELECT * FROM tbl_drivers where licenseNumber  = '$driverNumber'";
                            $result = mysqli_query($conn, $sql) or die($conn->error);

                            if ($result) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $driversTable[] = $row;
                                }
                            }



                            //virtual license needed fields
                            //echo $driversTable[0]['driverImage']."<br>";
                            //echo $driversTable[0]['lastName']."<br>";
                            //echo $driversTable[0]['firstName']."<br>";
                            //echo $driversTable[0]['middleName']."<br>";
                            //echo $driversTable[0]['nationality']."<br>";
                            //echo $driversTable[0]['gender']."<br>";
                            //echo $driversTable[0]['birthdate']."<br>";
                            //echo $driversTable[0]['weight']."<br>";
                            //echo $driversTable[0]['height']."<br>";
                            //echo $driversTable[0]['address']."<br>";
                            //echo $documentsTable[0]['licenseNumber']."<br>";
                            //echo $documentsTable[0]['licenseIssued']."<br>";
                            // echo $documentsTable[0]['licenseExpiration']."<br>";
                            //echo $driversTable[0]['bloodType']."<br>";
                            //echo $driversTable[0]['eyesColor']."<br>";
                            // echo $documentsTable[0]['restrictions']."<br>";
                            // echo $documentsTable[0]['driverConditions']."<br><br><br><br><br><br>";




                            //other personal information fields sa lower part na ni kang virtual license
                            //echo $driversTable[0]['contactNumber']."<br>";
                            //echo $driversTable[0]['tinNumber']."<br>";
                            //echo $driversTable[0]['DSA']."<br>";//DRIVING SKILL ACQUIRED
                            //echo $driversTable[0]['EA']."<br>";//EDUCATION ATTAINMENT
                            //echo $driversTable[0]['organDonor']."<br>";
                            //echo $driversTable[0]['civilStatus']."<br>";
                            //echo $driversTable[0]['hairColor']."<br>";
                            //echo $driversTable[0]['bodyBuilt']."<br>";
                            //echo $driversTable[0]['complexion']."<br>";
                            //echo $driversTable[0]['birthplace']."<br>";
                            //echo $driversTable[0]['fatherName']."<br>";
                            //echo $driversTable[0]['spouseName']."<br>";
                            //echo $driversTable[0]['employerName']."<br>";
                            //echo $driversTable[0]['employerNumber']."<br>";
                            // echo $driversTable[0]['employerAddress']."<br>";

                            //ORC FILE
                            //echo $documentsTable[0]['orc']."<br>";

                            ?>
                            <div class="col-5 col-md-3">
                                <div class="form row">
                                    <div class="col-md-12 mb-4">
                                        <center> <img src=<?php echo "'" . $driversTable[0]['driverImage'] . "'"; ?> style="width:70%" height=auto></center>
                                    </div>
                                    <div class=" container-fluid col-md-12">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generateQR" style="width:100%" onclick="makeCode()">
                                            Generate QR CODE
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="generateQR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Your QR Code</h5>

                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="col">
                                                            <div class="item">
                                                                <center>
                                                                    <p class="item-name">Kindly save this QR Code</p><br>
                                                                    <div id="qrCode">

                                                                    </div>
                                                                </center>
                                                                <br>
                                                                <p class="item-name">How to save this QR Code?</p> 
                                                                <p class="item-name"><b>Method number 1:</b> Long press the QR Code and click/tap the "download image" or "save image"</p> 
                                                                <p class="item-name"><b>Method number 2:</b> Screenshot this QR Code using your device</p>
                                                                <br>
                                                                <hr>
                                                                <p class="item-name"> <b>IMPORTANT:</b> Please do not share this QR code to anyone, thank you.</p><br>
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
                                </div>

                            </div>
                            <div class="col-13 col-md-9">
                                <form>
                                    <div class="row">
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['lastName']; ?></p>
                                                <p class="item-description">Last Name</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['firstName']; ?></p>
                                                <p class="item-description">First Name</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['middleName']; ?></p>
                                                <p class="item-description">Middle Name</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $documentsTable[0]['licenseNumber']; ?></p>
                                                <input hidden id="licenseNum" value=<?php echo $documentsTable[0]['licenseNumber']; ?>>
                                                <p class="item-description">License Number</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form>
                                    <div class="row">
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['nationality']; ?></p>
                                                <p class="item-description">Nationality</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['gender']; ?></p>
                                                <p class="item-description">Gender</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['birthDate']; ?></p>
                                                <p class="item-description">Date of Birth</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['contactNumber']; ?></p>
                                                <p class="item-description">Tel No. / CP No.</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['tinNumber']; ?></p>
                                                <p class="item-description">TIN </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['birthPlace']; ?></p>
                                                <p class="item-description">Place of Birth </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form>
                                    <div class="row">
                                        <div class="col">
                                            <div class="item">
                                                <p class="item-name"><?php echo $driversTable[0]['address']; ?></p>
                                                <p class="item-description">Present Address</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr>

                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['height']; ?> cm</p>
                                        <p class="item-description">Height</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['weight']; ?> kg</p>
                                        <p class="item-description">Weight</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['bloodType']; ?></p>
                                        <p class="item-description">Blood type</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['civilStatus']; ?></p>
                                        <p class="item-description">Civil Status</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['EA']; ?></p>
                                        <p class="item-description">Educational Attainment</p>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['organDonor']; ?></p>
                                        <p class="item-description">Organ Donor</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['DSA']; ?></p>
                                        <p class="item-description">Driving Skill Acquired</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['hairColor']; ?></p>
                                        <p class="item-description">Hair </p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['eyesColor']; ?></p>
                                        <p class="item-description">Eyes</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['bodyBuilt']; ?></p>
                                        <p class="item-description">Built</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['complexion']; ?></p>
                                        <p class="item-description">Complexion</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['fatherName']; ?></p>
                                        <p class="item-description">Father's Name</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['motherName']; ?></p>
                                        <p class="item-description">Mother's Name</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['spouseName']; ?></p>
                                        <p class="item-description">Spouse's Name</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['employerName']; ?></p>
                                        <p class="item-description">Employer's Business Name</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['employerNumber']; ?></p>
                                        <p class="item-description">Contact Number</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $driversTable[0]['employerAddress']; ?></p>
                                        <p class="item-description">Employer's Business Address</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <h3>License Information</h3>
                        <br>
                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $documentsTable[0]['status']; ?></p>
                                        <p class="item-description">License Status</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $documentsTable[0]['licenseType']; ?></p>
                                        <p class="item-description">Type of License</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $documentsTable[0]['restrictions']; ?></p>
                                        <p class="item-description">Restriction</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $documentsTable[0]['licenseIssued']; ?></p>
                                        <p class="item-description">IssuedDate</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name"><?php echo $documentsTable[0]['licenseExpiration']; ?></p>
                                        <p class="item-description">ExpirationDate</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name">Official Receipt</p>
                                        <img src="/LTO/try.png" alt="..." class="img-thumbnail" style="height:227px;width:227px">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="item">
                                        <p class="item-name">Certificate of Registration</p>
                                        <img src="/LTO/try.png" alt="..." class="img-thumbnail" style="height:227px;width:227px">
                                    </div>
                                </div>
                            </div>
                        </form>
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

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script type="text/javascript">
        var qrcode = new QRCode('qrCode');

        function makeCode() {
            var input = document.getElementById('licenseNum');
            qrcode.makeCode(input.value);
        }
    </script>

</body>

</html>