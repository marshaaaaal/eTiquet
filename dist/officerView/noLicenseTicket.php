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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Scanner </title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
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
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <form id="noLicenseTicketForm" method="post" action="saveNodriverLicense.php">
                    <div class="container-fluid">
                        <div id="box1">
                            <div class="container-fluid" style="margin-top:3%; margin-left:20%; width: 60%; background-color:rgb(235, 235, 235)" height="auto">
                                <h3>Apprehension Report</h3>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for=" "><b>Name </b> (Last Name, First Name, Middile Name)</label>
                                            <input required class="form-control  " id="txtName" name="txtName" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for=" "><b>Contact</b></label>
                                            <input required class="form-control  " id="txtContact" name="txtContact" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for=" "><b>Address </b></label>
                                            <input required class="form-control  " id="txtAddress" name="txtAddress" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for=" "><b>Place of apprehension</b></label>
                                            <input required class="form-control  " id="txtP_Apprehension" name="txtP_Apprehension" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                            <label class="small mb-1"> <input type="checkbox" id="violation1_1" name="violation1[]" value="LV1-001-01" checked onclick="return false;"> Driving without license in the Philippines</label> <br>
                                            <label class="small mb-1"> <input type="checkbox" id="violation1_2" name="violation1[]" value="LV1-002-01"> LTO penalty for not wearing seatbelt in the Philippines</label> <br>
                                            <label class="small mb-1"> <input type="checkbox" id="violation1_3" name="violation1[]" value="LV1-003-01"> Driving under the impact of alcohol/dangerous drugs</label> <br>
                                            <label class="small mb-1"> <input type="checkbox" id="violation1_4" name="violation1[]" value="LV1-004-01"> Careless driving</label> <br>
                                            <label class="small mb-1"> <input type="checkbox" id="violation1_5" name="violation1[]" value="LV1-005-01"> Other LTO violations and penalties for breaking traffic rules</label> <br>
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
                                <div class="form-group form row mt-4 mb-0">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" id="btnVehicle" data-toggle="modal" data-target="#vehicleScan" style="width:100%">Vehicle</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button disabled id="btnSubmit" type="button" class="btn btn-primary" style="width:100%" placeholder="Kindly enter a vehicle information" onclick="submitTicket()">Submit</button>
                                    </div>
                                </div>
                            </div>

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
                                                </center>
                                                <center>
                                                <!--for scanning vehicle-->
                                                <div id="vscanner" style="margin-top:3%; display:none">
                                                    <video id="preview1" class="p-1 border" style="width: 100%"></video>
                                                </div>
                                                </center>
                                                <!--for scanning vehicle-->
                                                <div id="orcr" style="display:none">
                                                    <div class="container-fluid form row">
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" id="" for="pNumber">Plate number: </label>
                                                            <b><input readonly class="form control small mb-1" type="text" id="pNumber" name="pNumber"></b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" id="" for="fNumber">File number: </label>
                                                            <b><input readonly class="form control small mb-1" type="text" id="fNumber"></b>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <label class="small mb-1" id="" for="eNumber">Engine number: </label>
                                                            <b><input readonly class="form control small mb-1" type="text" id="eNumber"></b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="small mb-1" id="" for="pNumber">Chassis number: </label>
                                                            <b><input readonly class="form control small mb-1" type="text" id="cNumber"></b>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="small mb-1" id="" for="rOwner">Registered owner: </label>
                                                            <b><input readonly class="form control small mb-1" type="text" id="rOwner"></b>
                                                        </div>
                                                    </div>
                                                </div>

                                                <center>
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

                        </div>
                    </div>
                </form>
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
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script>
        //scanner for vehicle
        var Vscanner = new Instascan.Scanner({
            video: document.getElementById('preview1'),
            scanPeriod: 5,
            mirror: false
        });
        Vscanner.addListener('scan', function(content) {
            //do something// search for the scanned qr code in tbl_vehicle
            vehicleInfo(content);
        });
        //scan vehicle
        function scanVehicle() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    Vscanner.start(cameras[0]);
                    $('[name="options"]').on('change', function() {
                        if ($(this).val() == 1) {
                            if (cameras[0] != "") {
                                Vscanner.start(cameras[0]);
                            } else {
                                alert('No Front Camera Found');
                            }
                        } else if ($(this).val() = 2) {
                            if (cameras[1] != "") {
                                Vscanner.start(cameras[1]);
                            } else {
                                alert('No Back Camera Found');
                            }
                        }
                    });
                } else {
                    alert('No Camera Found');
                }
            }).catch(function(e) {
                alert(e);
            });
            document.getElementById("vscanner").style.display = "block";
            document.getElementById("vChoose").style.display = "none";
            document.getElementById("manualInputOrcr").style.display = "block";
            document.getElementById("closeVscan").style.display = "block";
            document.getElementById("manualInputForm").style.display = "none";
        }
        //function for getting vehicle infos
        function vehicleInfo(plateNum) {
            const Http = new XMLHttpRequest();
            Http.open("GET", "../sql.php?query=select * from tbl_vehicle where plateNumber = '" + plateNum + "'");
            Http.send();
            Http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    result = JSON.parse(Http.responseText);
                    if (isEmpty(result)) {
                        alert("Plate Number Doesn't Exist");
                    } else {

                        //insert
                        document.getElementById("pNumber").value = result[0].plateNumber;
                        document.getElementById("cNumber").value = result[0].chassisNumber;
                        document.getElementById("eNumber").value = result[0].engineNumber;
                        document.getElementById("fNumber").value = result[0].fileNumber;
                        document.getElementById("rOwner").value = result[0].registeredOwner;



                        //hide and show of things.s.s.s.s........
                        document.getElementById("plateNumInput").style.display = "none";
                        document.getElementById("vscanner").style.display = "none";
                        document.getElementById("orcr").style.display = "block";
                        document.getElementById("manualInputForm").style.display = "none";
                        document.getElementById("manualInputOrcr").style.display = "none";
                        document.getElementById("startVscan").style.display = "none";
                        document.getElementById("closeVscan").style.display = "block";
                        document.getElementById("btnSubmit").disabled = false;
                    }
                }
            }
        }

        function isEmpty(obj) {
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop))
                    return false;
            }

            return true;
        }
        //rescan vehicle funtion
        function rescanVehicle() {
            scanVehicle();
            document.getElementById("orcr").style.display = "none";
            document.getElementById("startVscan").style.display = "none";
            document.getElementById("plateNumInput").style.display = "none";

        }

        //close vehicle scanner
        function scanVclose() {
            document.getElementById("vscanner").style.display = "none";
            document.getElementById("vChoose").style.display = "block";
            document.getElementById("manualInputOrcr").style.display = "none";
            document.getElementById("closeVscan").style.display = "none";
            document.getElementById("plateNumInput").style.display = "none";
            document.getElementById("orcr").style.display = "none";
            document.getElementById("startVscan").style.display = "none";
            Vscanner.stop();
        }

        //button for manual input
        function btnManualInputForm() {
            scanVclose();
            document.getElementById("startVscan").style.display = "block";
            document.getElementById("vscanner").style.display = "none";
            document.getElementById("vChoose").style.display = "none";
            document.getElementById("manualInputOrcr").style.display = "none";
            document.getElementById("manualInputForm").style.display = "block";
            document.getElementById("plateNumInput").style.display = "block";

        }
        //confirm inputted plate num
        function btnConfirmPlate() {
            var plate = document.getElementById('plateNum').value;
            console.log(plate);
            vehicleInfo(plate);

        }

        function submitTicket(){
            document.getElementById('noLicenseTicketForm').submit();
        }
    </script>
</body>

</html>