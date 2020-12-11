<?php
include('db_connection.php');
session_start();
if (isset($_SESSION['user'])) {
    if (strpos($_SESSION['user'], 'E01') !== false) {
        header("location: driverView/index.php");
    } elseif (strpos($_SESSION['user'], 'S01') !== false) {
        header("location: officeView/applicationForm.php");
    } elseif (strpos($_SESSION['user'], 'O01') !== false) {
        header("location: officerView/index.php");
    }
}

$error = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();
    $myusername = $_POST['Username'];
    $mypassword = $_POST['Password'];

    //for driver log in
    if (strpos($myusername, 'E01') !== false) {
        $sql = "SELECT *  FROM tbl_userdriver WHERE licenseNumber = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $_SESSION['user'] = $myusername;
            if (isset($_SESSION['redirect_to'])) {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            } else {
                header("location: driverView/index.php");
            }
        }
    } elseif (strpos($myusername, 'O01') !== false) {
        $sql = "SELECT *  FROM tbl_userstaff WHERE staffID = '$myusername' and password = '$mypassword' and status='Yes';";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $_SESSION['user'] = $myusername;
            if (isset($_SESSION['redirect_to'])) {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            } else {
                header("location: officerView/index.php");
            }
        }
    } elseif (strpos($myusername, 'S01') !== false) {
        $sql = "SELECT *  FROM tbl_userstaff WHERE staffID = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $_SESSION['user'] = $myusername;
            if (isset($_SESSION['redirect_to'])) {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            } else {
                header("location: officeView/index.php");
            }
        }
    } elseif (strpos($myusername, 'admin') !== false) {
        $sql = "SELECT *  FROM tbl_userstaff WHERE staffID = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $_SESSION['user'] = $myusername;
            if (isset($_SESSION['redirect_to'])) {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            } else {
                header("location: serverView/index.php");
            }
        }
    } else {
        $error = "Your Login Username or Password is Invalid";
    }
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
    <title>eTiquet Log-in</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">




</head>

<body style="background:#164172;">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">

            <header id="header">
                <div class="container d-flex">

                    <div class="logo mr-auto">

                        <!-- Uncomment below if you prefer to use an image logo -->
                        <a href="index.html"><img src="assets/img/eTiquetLogoWhite.jpg" alt="" style="height:200px;width:auto"></a>
                    </div>

                    <nav class="nav-menu d-none d-lg-block">
                        <ul>
                            <li class="active"><a href="../index.php">Home</a></li>
                            <li><a href="../index.php#about">About</a></li>
                            <li><a href="../index.php#services">Services</a></li>
                            <li><a href="../index.php#contact">Contact</a></li>

                        </ul>
                    </nav><!-- .nav-menu -->

                </div>
            </header><!-- End Header -->
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-9 col-lg-12 col-xl-10">
                            <div class="card shadow-lg o-hidden border-0 my-5">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-lg-6 d-none d-lg-flex">
                                            <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;../image/login.png&quot;);"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="p-5">
                                                <div class="text-center">
                                                    <h4 class="text-dark mb-4">Welcome Back!</h4>
                                                </div>
                                                <form action="" method="POST" id="loginform">
                                                    <div class="form-group"><input class="form-control py-4" id="inputEmailAddress" name="Username" type="text" placeholder="Enter username" /></div>
                                                    <div class="form-group"><input class="form-control py-4" id="inputPassword" type="password" name="Password" placeholder="Enter password" /></div>
                                                    <button class="btn btn-block text-white btn-user" type="submit" style="background:#164172;">Login</button>
                                                    <hr><button class="btn btn-dark btn-block text-white btn-google btn-user" type="button" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#logInQR" onclick="loginqr()"><i class="fas fa-qrcode"></i>&nbsp; Login with QR Code</button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="logInQR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Kindly align your QR code</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    <video id="preview" class="p-1 border" style="width: 100%; margin-top:3%" height="auto"> </video>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeLogin()">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                </form>
                                                <div class="text-center"><a class="small" href="#" style="color:#164172;">Forgot Password?</a></div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/jquery-sticky/jquery.sticky.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        function loginqr() {
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
        }
        var scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });
        scanner.addListener('scan', function(content) {
            var sql="";
            if(content.includes('E01')){
                sql=" select * from tbl_userdriver where licenseNumber = '" + content + "'";
            }else
                sql=" select * from tbl_userstaff where staffID = '" + content + "'";
            const Http = new XMLHttpRequest();
            Http.open("GET", "sql.php?query="+sql);
            Http.send();
            Http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    result = JSON.parse(Http.responseText);
                    if (isEmpty(result)) {
                        alert("invalid QR Code");
                    } else {
                        //encrypting user content license
                        document.getElementById('inputEmailAddress').value= content;
                        document.getElementById('inputPassword').value=result[0].password;
                        document.getElementById('loginform').submit();
                    }
                }
            }
        });

        function closeLogin() {
            scanner.stop();
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