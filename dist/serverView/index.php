<?php
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: ../login.php");
}
if (strpos($_SESSION['user'], 'E01') !== false) {
    header("location: ../driverView/index.php");
} elseif (strpos($_SESSION['user'], 'O01') !== false) {
    header("location: ../officerView/index.php");
} elseif (strpos($_SESSION['user'], 'S01') !== false) {
    header("location: ../officeView/index.php");
}
include '../db_connection.php';

$conn = OpenCon();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* The switch - the box around the slider */
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        }

        /* The slider */
        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
    </style>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>eTiquet - Server Admin</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/styles2.css" rel="stylesheet" />
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
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Officer Control
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
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Registered Drivers' Violation Records
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead style="background:#164172;color:white">
                                        <tr>
                                            <th>Officer ID</th>
                                            <th>Name</th>
                                            <th>Toggle</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Officer Id</th>
                                            <th>Name</th>
                                            <th>Toggle</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM tbl_userstaff INNER JOIN tbl_staff ON tbl_userstaff.staffID =  tbl_staff.staffID WHERE tbl_staff.staffID LIKE 'O01%';";
                                        $result = mysqli_query($conn, $sql);
                                        $rows = array();
                                        $ctr = 0;
                                        $violationNum = "";
                                        while ($r = mysqli_fetch_assoc($result)) {
                                            $rows[] = $r;
                                            
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $rows[$ctr]["staffID"]; ?></th>
                                                    <td><?php echo ucfirst($rows[$ctr]["lastName"]).', '.ucfirst($rows[$ctr]["firstName"]),', '.ucfirst($rows[$ctr]["middleName"]); ?></td>
                                                    <td><label class="switch">
                                                    <?php 
                                                    $c ="";
                                                    if(strcmp($rows[$ctr]["status"],"Yes")==0)
                                                        $c = "checked";
                                                    ?>
                                                    <input type="checkbox" <?php echo $c; ?> onclick=<?php echo "\"toggle('".$rows[$ctr]['staffID'].$c."')\""; ?>>
                                                    <span class="slider round"></span>
                                                    </label>
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
    <script src="../js/address.js"></script>

    <!--code for getting addresss-->
    <script>
        function toggle(officerID) {

            var sql ="";
            if(officerID.includes("checked")){
                officerID= officerID.substr(0,13);
                sql ="UPDATE tbl_userstaff SET status = 'No' WHERE staffID = '"+officerID+"';";
            }
            else{
                sql ="UPDATE tbl_userstaff SET status = 'Yes' WHERE staffID = '"+officerID+"';";
            }
            const Http = new XMLHttpRequest();
            Http.open("GET", "../sql.php?query="+sql);
            Http.send();
            // location.reload();
        }

        
    </script>
</body>

</html>