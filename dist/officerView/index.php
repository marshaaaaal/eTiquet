<?php
session_start();
if(!isset($_SESSION['user'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: ../login.php");
}
if(strpos($_SESSION['user'], 'E01') !== false){
    header("location: ../driverView/index.php");
}
elseif(strpos($_SESSION['user'], 'S01') !== false){
    header("location: ../officeView/index.php");
}

include ('../db_connection.php');

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
    <link href="../driverView/styles2.css" rel="stylesheet" />        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand" style="background:#164172" >
            <a class="navbar-brand" href="../officeView/index.php">
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
                                <div class="sb-nav-link-icon"><i class="fas fa-qrcode"></i></div>
                                Scanner
                            </a>
                            <a class="nav-link" href="record.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
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
                    <div class="container-fluid">
						<br>
						<section id="form-layout" class="form-layout">
					
      <div class="container">

        <div class="row">
          
			
          <div class="col-xl-12 col-lg-12 d-flex">
            <div class="icon-boxes d-flex flex-column">
              <div class="row">
                <div class="col-xl-8 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                  <div class="icon-box mt-4 mt-xl-0">
					                      <i class="bx bx-fingerprint"></i>

					  <h4>Scan</h4>
					  <video id="preview" class="p-1 border" style="width: 100%; margin-top:3%" height="auto"> </video>
					  <center><p>Kindly align the QR code to the Camera</p> </center>
                    
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-scan"></i>
                    <h4>Optional</h4>
					  <br>
					  <br>
					  <center> 
					  <button class="btn btn-primary btn-more" style="width: 70%; " data-toggle="modal" data-target="#logInModal" data-backdrop="static" data-keyboard="false" onclick="btnLoginModal()">Log-in Driver</button>
                    <p  >For those who have an existing license but doesn't have the QR Code</p>
					  <br>
					  <a href="noLicenseTicket.php"><button class="btn btn-primary btn-more"  style="width: 70%; ">Issue a ticket</button></a>
					  <p>Only for those who doesn't have an existing license</p>
						  </center>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<br>
      </div>
					
    </section>
						<!--log in driver modal-->
                        <div class="modal fade" id="logInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Log-in Driver's Info</h5>
                                    </div>
                                    <div id="loginAlert"></div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="txtLicenseNum">Username (License number)</label>
                                                <input type="text" class="form-control" id="txtLicenseNum" aria-describedby="emailHelp" placeholder="Enter License Number">
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your ID with anyone else.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtPass">Password</label>
                                                <input type="password" class="form-control" id="txtPass" placeholder="Password">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="btnCloseLoginModal()">Close</button>
                                        <button type="button" id="logInDriver" class="btn btn-info" onclick="btnLoginDriver()">Log-in</button>
                                    </div>
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
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <script type="text/javascript">

           var scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });
        scanner.addListener('scan', function(content) {
            const Http = new XMLHttpRequest();
            Http.open("GET", "../sql.php?query=select * from tbl_userdriver where licenseNumber = '" + content + "'");
            Http.send();
            Http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    result = JSON.parse(Http.responseText);
                    if (isEmpty(result)) {
                        alert("invalid QR Code");
                    } else {
                        //encrypting user content license
                        window.location.href = "driverInfo.php?LN=" + btoa(content);
                    }
                }
            }
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
                $('[name="options"]').on('change', function() {
                    if ($(this).val() == 1) {
                        if (cameras[0] != "") {
                            scanner.start(cameras[0]);
                        } else {
                            alert('No Front Camera Found');
                        }
                    } else if ($(this).val() = 2) {
                        if (cameras[1] != "") {
                            scanner.start(cameras[1]);
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


        function btnLoginModal() {
            scanner.stop();
        }

        function btnCloseLoginModal() {
            scanner.start();
        }

        function btnLoginDriver() {
            var licnum = document.getElementById("txtLicenseNum").value;
            var pass = document.getElementById("txtPass").value;
            const Http = new XMLHttpRequest();
            Http.open("GET", "../sql.php?query=select * from tbl_userdriver where licenseNumber = '" + licnum + "'");
            Http.send();
            Http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    result = JSON.parse(Http.responseText);
                    if (isEmpty(result)) {
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <div class="alert alert-danger" role="alert">
                            Incorrect Username or Password!
                            </div>`;
                        document.getElementById('loginAlert').appendChild(div);

                        setTimeout(function() {
                            $(".alert").alert('close');
                        }, 2000);
                    } else {
                        window.location.href = "driverInfo.php?LN=" + btoa("x"+licnum);
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

        </script>
    </body>
</html>
