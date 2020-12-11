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
<link href="../driverView/styles2.css" rel="stylesheet" />

<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
	
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
				<input type="hidden" id="user" value=<?php echo "\'".$_SESSION['user']."\'"; ?> >
			</div>
		</nav>
	</div>
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid" style="background-color: white; display: block;" id="divImage">
			<center>
				<img id="driverImage" height="auto" style="width:60%;margin-top:2%" src=<?php echo "\"" . $rowDri['driverImage'] . "\""; ?>>
				<div class="form-group">
					<br>
					<a href="index.php"><button class="btn btn-secondary" id="close" type="button">Close</button></a>
					<button class="btn btn-primary" style="background:#164172" id="confirm" type="button" onclick="confirmDriver()">Confirm</button>
				</div>
			</center>
		</div>

                <div class="container-fluid" style="background-color: white; display: none;margin-top:2%" id="driverInfo">
		<section id="form-layout" class="form-layout" >

<div class="row">
  <div class="col-xl-2 col-lg-3" data-aos="fade-up">
	<div class="content">
<img id="driverImage" height="auto" style="width:100%" src=<?php echo "\"" . $rowDri['driverImage'] . "\""; ?>>


	</div>
	  <br>
	<!-- for add violation-->
							<div class="col-md-12 mb-3">
								<button type="button" class="btn btn-danger" style="width:100%" onclick="addViolation()">Add Violations</button>
							</div>
							<!-- for done-->
							<div class="col-md-12 mb-3">
								<a href="index.php"> <button type="button" class="btn btn-secondary" style="width:100%">Done</button></a>
							</div>

  </div>

  <div class="col-xl-10 col-lg-9 d-flex">
	<div class="icon-boxes d-flex flex-column">
	  <div class="row">
		<div class="col-xl-12 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
		  <div class="icon-box mt-4 mt-xl-0">
			  <div class="resume">
					<div class="row">
  <div class="col-lg-6">
	<h3 class="resume-title"></h3>
	<div class="resume-item pb-0">
	  <h4><?php echo $rowDri['lastName'];?>, <?php echo $rowDri['firstName'];?> <?php echo $rowDri['middleName'];?></h4>
	  <p><em>Last Name, First Name Middle Name</em></p>

		<h5><?php echo $rowDri['nationality'];?></h5><p><em>Nationality</em></p>

		<h5><?php echo $rowDri['gender'];?></h5>
		<p><em>Sex</em></p>

		<h5><?php echo $rowDri['birthDate'];?></h5>
		<p><em>Date of Birth</em></p>

		<h5><?php echo $rowDri['height'];?></h5>
		<p><em>Height (m)</em></p>

		<h5><?php echo $rowDri['weight'];?></h5>
		<p><em>Weight (kg) </em></p>

		<h5><?php echo $rowDri['bloodType'];?></h5>
		<p><em>Blood Type</em></p>

		<h5><?php echo $rowDri['eyesColor'];?></h5>
		<p><em>Eye Color</em></p>


	</div>

  </div>
  <div class="col-lg-6">
	<h3 class="resume-title"></h3>
	<div class="resume-item">
	  <h4><?php echo $rowDoc['licenseNumber'];?></h4>
	<p><em>License Number</em></p>
		<input hidden id ="licenseNum" value=<?php echo $rowDri['licenseNumber'];?>>

	  <h5><?php echo $rowDoc['licenseExpiration'];?></h5>
	  <p><em>Expiration Date </em></p>

		<h5><?php echo $rowDoc['licenseType'];?></h5>
	  <p><em>Type of Licence</em></p>

		<h5><?php echo $rowDoc['restrictions'];?></h5>
	  <p><em>Restriction </em></p>

		<h5><?php echo $rowDoc['driverCondition'];?></h5>
	  <p><em>Condition</em></p>

	</div>
	  <div class="resume-item">
	  <h4><?php echo $rowDri['spouseName'];?></h4>
	<p><em>In case of Emergency</em></p>

	  <h5><?php echo $rowDri['spouseContact'];?></h5>
	  <p><em>Contact Number </em></p>


	</div>

  </div>
</div>
				  <div class="row">
  <div class="col-lg-12">
	<h3 class="resume-title"></h3>
	<div class="resume-item pb-0">
	  <h4><?php echo $rowDri['address'];?></h4>
	  <p><em>Address</em></p>

	</div>

  </div>

</div>

		  </div>
			  </div>

		</div>


	  </div>
	</div>
  </div>
</div>
					
<br>
						
                        
					
					</section>                
					<div class="container">
		<div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                List of <?php echo $rowDri['lastName']; ?>'s Violations
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead  style="background:#164172;color:white">
                                            <tr>
                                             <th>Violation Number</th>
                                                <th>Issued Date</th>
                                                <th >Status/Remarks</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Violation Number</th>
                                                <th>Issued Date</th>
                                                <th >Status/Remarks</th>
                                            <th>Actions</th>
                                            </tr>
                                        </tfoot>
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



		<br>
		
		
		
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
<div class="col-md-6" style="margin-bottom:10px">
<button type="button" class="btn btn-primary" id="btnVehicle" data-toggle="modal" data-target="#vehicleScan" style="width:100%">Vehicle</button>
</div>
<div class="col-md-6" style="margin-bottom:10px">
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
<div class="col-md-6" style="margin-bottom:10px">
<button id="" type="button" class="btn btn-primary" style="display:block" onclick="scanVehicle()">Scan Vehicle QR Code</button>
</div>
<div class="col-md-6" style="margin-bottom:10px">
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
<img id="orPic" src="" heigh="auto" style="width:70%"></img>
</div>
<div class="col-md-6">
<label id="lblcr" for="cr"> Certificate Of Registration</label>
<img id="crPic" src="" heigh="auto" style="width:70%"></img>
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
<button type="button" id="manualInputOrcr" class="btn btn-primary" style="display:none" onclick="btnManualInputForm()">Manual input</button><br><br>
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
<button type="button" class="btn btn-secondary" id="btnVehicle" data-dismiss="modal" style="width:100%">Close</button><br>
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
<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closedcScan()">Close</button><br>
<button id="submitRep" class="btn btn-primary" type="button" onclick="submitReport()" placeholder="Kindly Input a vehicle information">Submit</button>
</div>
</div>
</div>
</div>
</div>
</form>
	


	
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="../js/scripts.js"></script>
<script type="text/javascript" src="driverinfroscript.js"></script>

        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
		<script src="../assets/demo/datatables-demo.js"></script>
		<script>
			

//scanner for vehicle
var Vscanner = new Instascan.Scanner({ video: document.getElementById('preview1'), scanPeriod: 5, mirror: false });
Vscanner.addListener('scan', function (content) {
    //do something// search for the scanned qr code in tbl_vehicle
    vehicleInfo(content);
});
//scan vehicle
function scanVehicle() {
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            Vscanner.start(cameras[0]);
            $('[name="options"]').on('change', function () {
                if ($(this).val() == 1) {
                    if (cameras[0] != "") {
                        Vscanner.start(cameras[0]);
                    }
                    else {
                        alert('No Front Camera Found');
                    }
                }
                else if ($(this).val() = 2) {
                    if (cameras[1] != "") {
                        Vscanner.start(cameras[1]);
                    }
                    else {
                        alert('No Back Camera Found');
                    }
                }
            });
        }
        else {
            alert('No Camera Found');
        }
    }).catch(function (e) {
        alert(e);
    });
    document.getElementById("vscanner").style.display = "block";
    document.getElementById("vChoose").style.display = "none";
    document.getElementById("manualInputOrcr").style.display = "block";
    document.getElementById("closeVscan").style.display = "block";
    document.getElementById("manualInputForm").style.display = "none";
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
//function for getting vehicle infos
function vehicleInfo(plateNum) {

    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from tbl_vehicle where plateNumber = '" + plateNum + "'");
    Http.send();
    Http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(Http.responseText);
            if (isEmpty(result)) {
                alert("Plate Number Doesn't Exist");
            } else {

                //hide and show of things.s.s.s.s........
                document.getElementById("plateNumInput").style.display = "none";
                document.getElementById("vscanner").style.display = "none";
                document.getElementById("orcr").style.display = "block";
                document.getElementById("manualInputForm").style.display = "none";
                document.getElementById("manualInputOrcr").style.display = "none";
                document.getElementById("startVscan").style.display = "none";
                document.getElementById("closeVscan").style.display = "block";
                //put data on the ID for the lbl fields in summary
                document.getElementById("txtPlateNumber").value = result[0].plateNumber;
                document.getElementById("txtChassisNumber").value = result[0].chassisNumber;
                document.getElementById("txtEngineNumber").value = result[0].engineNumber;
                document.getElementById("txtFileNumber").value = result[0].fileNumber;
                document.getElementById("txtRegisteredOwner").value = result[0].registeredOwner;

                document.getElementById("btnmodalConfirm").disabled = false;
                console.log(result[0].officialReceipt);
                console.log(result[0].certificateRegistration);
                document.getElementById("orPic").src = result[0].officialReceipt;
                document.getElementById("crPic").src= result[0].certificateRegistration;

            }
        }
    }
}
//scanner for user confirmation
var Dscanner = new Instascan.Scanner({ video: document.getElementById('preview2'), scanPeriod: 5, mirror: false });
Dscanner.addListener('scan', function (content) {
    if (content.localeCompare(document.getElementById("txtlicense").value) == 0) {
        alert("The data has been successfully submitted");
        document.getElementById("confirmationForm").submit();
    }

    else
        alert("invalid QR code");
});
//close driver scan
function closedcScan() {
    document.getElementById("modalSummary").style.display = "block";
    document.getElementById("confirmationQR").style.display = "none";
    document.getElementById("confirmationPass").style.display = "none";
    Dscanner.stop();
}

function confirmViolation() {
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            Dscanner.start(cameras[0]);
            $('[name="options"]').on('change', function () {
                if ($(this).val() == 1) {
                    if (cameras[0] != "") {
                        Dscanner.start(cameras[0]);
                    }
                    else {
                        alert('No Front Camera Found');
                    }
                }
                else if ($(this).val() = 2) {
                    if (cameras[1] != "") {
                        Dscanner.start(cameras[1]);
                    }
                    else {
                        alert('No Back Camera Found');
                    }
                }
            });
        }
        else {
            alert('No Camera Found');
        }
    }).catch(function (e) {
        alert(e);
    });
    document.getElementById("modalSummary").style.display = "none";
    document.getElementById("confirmationQR").style.display = "block";
}

function enterPassword() {
    Dscanner.stop();
    document.getElementById("confirmationQR").style.display = "none";
    document.getElementById("confirmationPass").style.display = "block";
}

function modalConfirm() {
    document.getElementById("txtmP_Apprehension").value = document.getElementById("txtP_Apprehension").value;
    document.getElementById("txtmlicense").value = document.getElementById("txtlicense").value;
    document.getElementById("txtmC_items").value = document.getElementById("txtC_items").value;
    var i;
    for (i = 1; i <= 5; i++) {
        if (document.getElementById("violation1_" + i).checked)
            document.getElementById("mviolation1_" + i).checked = true;
    }
    for (i = 1; i <= 3; i++) {
        if (document.getElementById("violation2_" + i).checked)
            document.getElementById("mviolation2_" + i).checked = true;
    }
    for (i = 1; i <= 4; i++) {
        if (document.getElementById("violation3_" + i).checked)
            document.getElementById("mviolation3_" + i).checked = true;
    }
}
//for driver image confirmation
function confirmDriver() {
    document.getElementById('divImage').style.display = "none";
    document.getElementById('driverInfo').style.display = "block";
}


function addViolation() {
    document.getElementById('apprehensionReport').style.display = "block";
    document.getElementById('driverInfo').style.display = "none";
}

function submitReport() {
    var licnum = document.getElementById("txtlicense").value;
    var pass = document.getElementById("txtpassw").value;
    const Http = new XMLHttpRequest();
    Http.open("GET", "../sql.php?query=select * from tbl_userdriver where licenseNumber = '" + licnum + "'");
    Http.send();
    Http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            result = JSON.parse(Http.responseText);
            if (pass.localeCompare(result[0].password) != 0) {
                const div = document.createElement('div');
                div.innerHTML = `
                <div class="alert alert-danger" role="alert">
                Incorrect Password!
                </div>`;
                document.getElementById('loginalert').appendChild(div);

                setTimeout(function () {
                    $(".alert").alert('close');
                }, 2000);
            }
            else {
                document.getElementById("confirmationForm").submit();
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
<?php unset($_GET['LN']); ?>

</html>