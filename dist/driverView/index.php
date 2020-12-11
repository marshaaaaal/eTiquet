<?php
session_start();
if(!isset($_SESSION['user'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: ../login.php");
}
if(strpos($_SESSION['user'], 'O01') !== false){
    header("location: ../officerView/index.php");
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
    <title>Driver Interface</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../driverView/styles2.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script type="text/javascript" src="script.js"></script>
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

                        <a class="nav-link active" href="index.php">
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
                <div class="container-fluid">
					
                    
                        <?php

                    $documentsTable = array();
                    $licenseNumber = $_SESSION['user'];
                    $sql = "SELECT * FROM tbl_documents where licenseNumber = '$licenseNumber'";
                    $result = mysqli_query($conn,$sql) or die($conn->error);
            
                        if($result){
    
                            while($row = mysqli_fetch_assoc($result)){
                                    $documentsTable[] = $row;
                            }
                                
                        }

                        
                    $driversTable = array();
                    $driverNumber = $documentsTable[0]['licenseNumber'];
                    $sql = "SELECT * FROM tbl_drivers where licenseNumber  = '$driverNumber'";
                    $result = mysqli_query($conn,$sql) or die($conn->error);
            
                        if($result){
    
                            while($row = mysqli_fetch_assoc($result)){
                                $driversTable[] = $row;
                                 
                            }
                        }
                        
                    
                    ?>
                    <br>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Driver's Profile / <?php echo $documentsTable[0]['licenseType'];?></li>
                    </ol>
                    
                    
                        
                </div>
				
				<section id="form-layout" class="form-layout">
					
      <div class="container">

        <div class="row">
          <div class="col-xl-2 col-lg-3" data-aos="fade-up">
            <div class="content">
      	<img src=<?php echo "\"".$driversTable[0]['driverImage']."\"";?> style="width:100%" height=auto>
				
				
            </div>
			
			  <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-more" data-toggle="modal" data-target="#generateQR" style="width:100%" onclick="makeCode()">
                                            Generate QR CODE
                                        </button>
			  
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
              <h4><?php echo $driversTable[0]['lastName'];?>, <?php echo $driversTable[0]['firstName'];?> <?php echo $driversTable[0]['middleName'];?></h4>
              <p><em>Last Name, First Name Middle Name</em></p>
				
				<h5><?php echo $driversTable[0]['nationality'];?></h5><p><em>Nationality</em></p>
				
				<h5><?php echo $driversTable[0]['gender'];?></h5>
				<p><em>Sex</em></p>
				
				<h5><?php echo $driversTable[0]['birthDate'];?></h5>
				<p><em>Date of Birth</em></p>
				
				<h5><?php echo $driversTable[0]['height'];?></h5>
				<p><em>Height (m)</em></p>
				
				<h5><?php echo $driversTable[0]['weight'];?></h5>
				<p><em>Weight (kg) </em></p>
				
				<h5><?php echo $driversTable[0]['bloodType'];?></h5>
				<p><em>Blood Type</em></p>
				
				<h5><?php echo $driversTable[0]['eyesColor'];?></h5>
				<p><em>Eye Color</em></p>
				
				
            </div>
            
          </div>
          <div class="col-lg-6">
            <h3 class="resume-title"></h3>
            <div class="resume-item">
              <h4><?php echo $documentsTable[0]['licenseNumber'];?></h4>
			<p><em>License Number</em></p>
				<input hidden id ="licenseNum" value=<?php echo $documentsTable[0]['licenseNumber'];?>>

              <h5><?php echo $documentsTable[0]['licenseExpiration'];?></h5>
              <p><em>Expiration Date </em></p>
				
				<h5><?php echo $documentsTable[0]['licenseType'];?></h5>
              <p><em>Type of Licence</em></p>
				
				<h5><?php echo $documentsTable[0]['restrictions'];?></h5>
              <p><em>Restriction </em></p>
				
				<h5><?php echo $documentsTable[0]['driverCondition'];?></h5>
              <p><em>Condition</em></p>
				
            </div>
			  <div class="resume-item">
              <h4><?php echo $driversTable[0]['spouseName']; ?></h4>
			<p><em>In case of Emergency</em></p>

              <h5><?php echo $driversTable[0]['spouseContact']; ?></h5>
              <p><em>Contact Number </em></p>
			
              
            </div>
            
          </div>
        </div>
						  <div class="row">
          <div class="col-lg-12">
            <h3 class="resume-title"></h3>
            <div class="resume-item pb-0">
              <h4><?php echo $driversTable[0]['address'];?></h4>
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

      </div>
					
    </section>
<div class="container"> 				
<button type="button" class="btn btn-more btn-lg btn-block" data-toggle="modal" data-target="#moreInformation">
  More information</button>
							  
				</div>			  <!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="moreInformation">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo $documentsTable[0]['licenseNumber'];?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
					  <div class="resume">
							<div class="row">
          <div class="col-lg-6">
            <h3 class="resume-title"></h3>
            <div class="resume-item pb-0">
              <h4>Basic Information</h4>
				
				<h5><?php echo $driversTable[0]['contactNumber'];?></h5><p><em>Tel no./Cp No.</em></p>
				
				<h5><?php echo $driversTable[0]['tinNumber'];?></h5>
				<p><em>Tin</em></p>
				
				<h5><?php echo $driversTable[0]['civilStatus'];?></h5>
				<p><em>Civil Status</em></p>
				
				<h5><?php echo $driversTable[0]['EA'];?></h5>
				<p><em>Educational Attainement</em></p>
				
				<h5><?php echo $driversTable[0]['birthPlace'];?></h5>
				<p><em>Birth Place </em></p>
				
				<h5><?php echo $driversTable[0]['DSA'];?></h5>
				<p><em>Driving Skill Acquired</em></p>
			
            </div>
            
          </div>
          <div class="col-lg-6">
            <h3 class="resume-title"></h3>
            <div class="resume-item">
              <h4>Physique</h4>

              <h5><?php echo $driversTable[0]['hairColor'];?></h5>
              <p><em>Hair </em></p>
				
				<h5><?php echo $driversTable[0]['eyesColor'];?></h5>
              <p><em>Eyes</em></p>
				
				<h5><?php echo $driversTable[0]['bodyBuilt'];?></h5>
              <p><em>Built </em></p>
				
				<h5><?php echo $driversTable[0]['complexion'];?></h5>
              <p><em>Complexion</em></p>
				
				<h5><?php echo $driversTable[0]['bloodType'];?></h5>
              <p><em>Blood Type</em></p>
				
				<h5><?php echo $driversTable[0]['organDonor'];?></h5>
              <p><em>Organ Donor</em></p>
				
            </div>
            
          </div>
        </div>
						  <div class="row">
          <div class="col-lg-6">
            <h3 class="resume-title"></h3>
            <div class="resume-item">
              <h4>Parent's Information</h4>
						
				<h5><?php echo $driversTable[0]['fatherName'];?></h5>
              <p><em>Father's Name</em></p>
				
				<h5><?php echo $driversTable[0]['motherName'];?></h5>
              <p><em>Mother's Name</em></p>
				
            </div>
			  
			  <div class="resume-item">
              <h4>Spouse's Information</h4>
						
				<h5><?php echo $driversTable[0]['spouseName'];?></h5>
              <p><em>Spouse's Name</em></p>
			
				
            </div>
            
          </div>
			<div class="col-lg-6">
            <h3 class="resume-title"></h3>
            <div class="resume-item">
              <h4>Employer's Information</h4>
						
				<h5><?php echo $driversTable[0]['employerName'];?></h5>
              <p><em>Employer's Name</em></p>
				
				<h5><?php echo $driversTable[0]['employerNumber'];?></h5>
              <p><em>Contact Number</em></p>
				
				<h5><?php echo $driversTable[0]['employerAddress'];?></h5>
              <p><em>Business Address</em></p>
				
            </div>
			  
			 
          </div>
							
        </div>
						  <div class="row">
          <div class="col-lg-12">
            <h3 class="resume-title"></h3>
            <div class="resume-item">
              <h4>License Information</h4>
						
				<h5><?php echo $documentsTable[0]['status'];?></h5>
              <p><em>Status</em></p>
				
				<h5><?php echo $documentsTable[0]['licenseIssued'];?></h5>
              <p><em>Issued Date</em></p>
				
				<h5><?php echo $documentsTable[0]['licenseExpiration'];?></h5>
              <p><em>Expiration Date</em></p>
				
				
				
            </div>
			  
			  
            
          </div>
							 
					
        </div>
						  
				
                                    
                                    
                                    
                                
						  
                  </div>
					 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
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
				
				
            </main>
            
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script type="text/javascript">
        var qrcode = new QRCode('qrCode');
        makeCode();
        function makeCode(){
            var input = document.getElementById('licenseNum');
            qrcode.makeCode(input.value);
        }
    </script>

</body>

</html>