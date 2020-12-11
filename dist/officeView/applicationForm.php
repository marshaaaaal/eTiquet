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
<title>eTiquet - Application Form</title>
<link href="../css/styles.css" rel="stylesheet" />
<link href="../css/styles2.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
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

<a class="nav-link" href="applicationForm.php">
<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
Application Form
</a>
<a class="nav-link" href="driverTable.php">
<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
Drivers' List
</a>
<a class="nav-link" href="payQueue.php">
<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
Payment Queue
</a>
<a class="nav-link" href="violationRec.php">
<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
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
<h1 class="mt-4">Application for driver's license</h1>


<div class="shadow p-3 mb-5 bg-white rounded">
<form method ="POST" action = "../SaveRecords/saveDriver.php" enctype="multipart/form-data">

<h4>Full Name:</h4>
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtL_Name">LAST NAME</label>
        <input required class="form-control  " id="txtL_Name" name="txtL_Name" type="text"  />
    </div>
    <div class="col">
        <label class="small mb-1" for=" ">FIRST NAME</label>
        <input required class="form-control " id="txtF_Name" name="txtF_Name" type="text" />
    </div>
    <div class="col">
        <label class="small mb-1" for=" ">MIDDLE NAME</label>
        <input required class="form-control " id="txtM_Name" name="txtM_Name" type="text"  />
    </div>

    <input type = "hidden" id="driverImage2" name = "img" />
    <div class="col">

    <!-- Button trigger camera modal -->
    <label class="small mb-1" for=" ">OPEN CAMERA</label>
    <button type="button" id="launchCam" class="form-control btn btn-primary" style="display:block" data-toggle="modal" data-target="#exampleModal" onclick="openCamera()">
    Launch Camera
    </button>
    </div>
    <!-- Modal for trigger camera -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Camera</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeCamera()">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <video id="webcam" style="display:block"  autoplay playsinline width="470" height="480"></video>
            <canvas id="canvas" style="display:block" class="d-none"></canvas>
            <img type = "file" id="driverImage" name = "driverImage" style="display:block" src="" width="470" height="480" ></img>
            <audio id="snapSound" src="audio/snap.wav" preload = "auto"></audio>
        </div>
        <div class="modal-footer">
            <button type="button" id="closeCam" class="btn btn-secondary" data-dismiss="modal"  style="display:block"  onclick="closeCamera()">Close</button>
            <button type="button" id="retakeImg" class="btn btn-primary" style="display:none" onclick="launchWebcam()" >Re-take image</button>
            <button type="button" id="captureImg" class="btn btn-primary"  style="display:block"  onclick="captureImage()">Capture</button>
        </div>
        </div>
    </div>
    </div>

        
</div>
    
<hr>
    
<div class="row"> 
<div class="col-12 col-md-8">
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtNationality">NATIONALITY</label>
        <input required class="form-control " id="txtNationality" name="txtNationality" type="text" aria-describedby="emailHelp"/>
    </div>
    <div class="col">
        <label class="small mb-1" for="optGender">GENDER</label>
        <select required aria-required="true" class="form-control" name="optGender" id="optGender" >
            <option selected disabled value=""></option>
            <option   >Male</option>
            <option  >Female</option>
        </select>
    </div>
</div> <!--ROW1-->
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txt">TEL NO./ CP NO.</label>
        <input required class="form-control  " id="txtCpNum" name="txtCpNum" type="number" aria-describedby="emailHelp"/>
    </div>
    <div class="col">
        <label class="small mb-1" for="txt">TIN</label>
        <input class="form-control " id="txtTin" name="txtTin" type="number" aria-describedby="emailHelp"/>
    </div>
</div> <!--ROW2-->
<div class="row">
    <div class="col">
        <div class="form-check" style="margin-top:10px">
            <label class="small mb-1" for=" ">CIVIL STATUS</label> <br>
            <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioSingle" name="radioCS" value = "Single">SINGLE</label> <br> 
            <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioMarried" name="radioCS" value = "Married"> MARRIED</label> <br>   
            <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioWidow" name="radioCS" value = "Widow"> WIDOW/ER</label> <br> 
            <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioSeparated" name="radioCS" value = "Separated"> SEPARATED </label> 
        </div>
    </div>
    <div class="col">
        <div class="form-group form-check" style="margin-top:10px">
            <label class="small mb-1" for=" " >EDUCATIONAL ATTAINMENT</label> <br>
            <div class="form-row ">
                <div class="col-md-6">
                    <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioI_Schooling" name="radioEducation" value = "IinformalSchooling"> INFORMAL SCHOOLING</label>
                    <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioElementary" name="radioEducation" value = "Elementary"> ELEMENTARY</label> 
                    <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioH_School" name="radioEducation"value = "HighSchool"> HIGH SCHOOL</label> 
                </div> 
                <div class="col-md-6">
                    <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioVocational" name="radioEducation"value = "Vocational"> VOCATIONAL</label> 
                    <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioCollege" name="radioEducation"value = "College" > COLLEGE</label>  
                    <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioP_Graduate" name="radioEducation" value = "PostGraduate"> POST GRADUATE</label>     
                </div> 
            </div>      
        </div>
    </div>
</div> <!--ROW3-->
</div> <!--LEFT PART 1-->
<div class="col-6 col-md-4">
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtB_Date">BIRTH DATE</label>
        <input required class="form-control " id="B_Date" name="B_Date" type="date" aria-describedby="emailHelp"/>
    </div>
</div> <!--ROW1-->
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtB_Date">BIRTH PLACE</label>
        <select required aria-required="true" class="form-control" name="optB_Province" id="optB_Province"   onchange="getBProvince()">
            <option selected disabled value="">Province</option>
            <?php 
            $sql = "select * from refprovince order by provDesc ";
            $res = mysqli_query($conn,$sql);
            $x=0;
            while($list = mysqli_fetch_assoc($res)){
                $reg[$x] = $list['provDesc'];
                $code[$x] = $list['provCode'];
                echo "<option id=".$code[$x].">".$reg[$x]."</option>";
                $x++;
            }
            ?>
        </select>          
    </div> 
</div><!--ROW2-->
<div class="row" style="margin-top:10px">
    <div class="col">
        <select required aria-required="true" class="form-control mb-3" name="optBC_Municipality" id="optBC_Municipality" >
            <option selected disabled value="">City/Municipality</option>
        </select> 
    </div>
</div> <!--ROW3-->
</div> <!--RIGHT PART 1-->
</div>
    
<hr>

<h4>Present Address:</h4>
<div class="row">
    <div class="col">
        <label class="small mb-1" for=" ">REGION</label>
        <select required aria-required="true" class="form-control" name="optRegion" id="optRegion" onchange="getRegion()" >
            <option selected disabled value="">Region</option>
            <?php 
            $sql = "select * from refregion";
            $res = mysqli_query($conn,$sql);
            $x=0;
            while($list = mysqli_fetch_assoc($res)){
                $reg[$x] = $list['regDesc'];
                $code[$x] = $list['regCode'];
                echo "<option id=".$code[$x].">".$reg[$x]."</option>";
                $x++;
            }
            ?>
        </select>
    </div>
    <div class="col">
        <label class="small mb-1" for=" ">PROVINCE</label>
        <select required aria-required="true" class="form-control" name="optProvince" id="optProvince" onchange="getProvince()" >
            <option selected disabled value="">Province</option>
        </select>
    </div>
    <div class="col">
        <label class="small mb-1" for="txtCity">CITY/MUNICIPALITY</label>
        <select required aria-required="true" class="form-control" name="optC_Municipality" id="optC_Municipality" onchange="getCity()" >
            <option selected disabled value="">City/Municipality</option>
        </select>
    </div>
</div> <!--ROW1-->
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtBaranngay">BARANGGAY</label>
        <select required aria-required="true" class="form-control" name="optBaranggay" id="optBaranggay" >
            <option selected disabled value="">Baranggay</option>
        </select>
    </div>
    <div class="col">
        <label class="small mb-1" for="txt">STREET/HOUSE NO.</label>
        <input class="form-control" id="txtS_House" name="txtS_House" type="text" aria-describedby="emailHelp"  />
    </div>
</div><!--ROW2-->
    
<hr>

<div class="row">
<div class="col-5 col-md-3">
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtHeight">HEIGHT (cm)</label>
        <input required class="form-control " id="txtHeight" name="txtHeight" type="number" aria-describedby="emailHelp"/>
    </div>
</div><!--ROW1-->
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txtWeight">WEIGHT (kg)</label>
        <input required class="form-control " id="txtWeight" name="txtWeight" type="number" aria-describedby="emailHelp"/>
    </div>
</div><!--ROW2-->
<div class="row" >
    <div class="col">
        <div class="form-group">
            <label class="small mb-2" for=" ">BLOOD TYPE</label>
            <select required aria-required="true" class="form-control" name="optB_Type" id="optB_Type"   >
                <option selected disabled value=""></option>
                <option  >A+</option>
                <option  >A-</option>
                <option   >B+</option>
                <option   >B-</option>
                <option   >O+</option>
                <option   >O-</option>
                <option   >AB+</option>
                <option   >AB-</option>
            </select>
        </div>
    </div>
</div><!--ROW3-->
</div>

<div class="col-13 col-md-9">
<div class="row">
    <div class="col">
        <div class="form-check">
            <label class="small mb-1" for=" ">ORGAN DONOR</label> <br>
            <label  required class="small mb-2 form-check-label" ><input class="form-check-input" type="radio" id="radioOD_Yes" name="radioOD" value="Yes" > YES</label> <br> 
            <label  required class="small mb-4 form-check-label" ><input class="form-check-input" type="radio" id="radioOD_No" name="radioOD" value = "No"> NO </label> <br>   
        </div>
    </div>
    <div class="col">
        <label class="small mb-1" for=" ">BUILT</label> <br>
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioB_Light" name="radioBuilt" value = "light" > LIGHT</label> <br> 
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioB_Medium" name="radioBuilt" value = "medium"> MEDUIM</label> <br>   
        <label  class="small mb-2 form-check-label" ><input required class="form-check-input" type="radio" id="radioB_Heavy" name="radioBuilt"value = "heavy" > HEAVY </label>
    </div>
    <div class="col">
        <label class="small mb-1" for=" ">COMPLEXION</label> <br>
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioC_Light" name="radioComplexion"value = "light" > LIGHT</label> <br> 
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioC_Fair" name="radioComplexion" value = "medium"> FAIR</label> <br>   
        <label  class="small mb-2 form-check-label" ><input required class="form-check-input" type="radio" id="radioC_Dark" name="radioComplexion" value = "fair"> DARK </label>
    </div>
</div><!--ROW1-->
<div class="row" style="margin-left:10px">
    <div class="col">
        <label class="small mb-1" for=" ">HAIR</label> <br>
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioH_Black" name="radioHair" onclick="Color('H')" value = "black">  BLACK</label> <br> 
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioH_Brown" name="radioHair" onclick="Color('H')" value = "brown"> BROWN</label> <br>   
        <label  class="small mb-1 form-check-label" ><input required   class="form-check-input" type="radio" id="radioH_Blonde" name="radioHair"onclick="Color('H')" value = "blonde"> BLONDE</label> <br> 
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioH_Gray" name="radioHair" onclick="Color('H')" value = "gray"> GRAY </label> <br> 
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioH_Others" name="radioHair" onclick="Others('H')" value = "others" >  others (Specify):  </label>
        <input type="text" name= "txtH_Others" id = "txtH_Others" placeholder ="Specify if Others" disabled  required>
    </div>
    <div class="col">
        <label class="small mb-1" for=" ">EYES</label> <br>
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioE_Black" name="radioEyes" onclick="Color('E')"value = "black"> BLACK</label> <br> 
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioE_Brown" name="radioEyes" onclick="Color('E')"value = "brown"> BROWN</label> <br>   
        <label  class="small mb-1 form-check-label" ><input required class="form-check-input" type="radio" id="radioE_Gray" name="radioEyes" onclick="Color('E')"value = "gray"> GRAY </label> <br> 
        <label  class="small mb-2 form-check-label" ><input required class="form-check-input" type="radio" id="radioE_Others" name="radioEyes" onclick="Others('E')" value = "others"> others (Specify):  </label>
        <input type="text" name= "txtE_Others" id = "txtE_Others" placeholder ="Specify if Others" disabled  required>
    </div>
</div><!--ROW2-->
</div>
</div>

<hr>    
<div class="row">
<div class="col-12 col-md-8">
<div class="row">
    <div class="col">
        <label class="large mb-1" for=" ">FATHER'S NAME</label> <label class="small mb-1"> (indicate even if deceased)</label>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for="txtFL_Name">LAST NAME</label>
                    <input class="form-control  " id="txtFL_Name" name="txtFL_Name" type="text"  />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">FIRST NAME</label>
                    <input class="form-control " id="txtFF_Name" name="txtFF_Name" type="text" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">MIDDLE NAME</label>
                    <input class="form-control " id="txtFM_Name" name="txtFM_Name" type="text"  />
                </div>
            </div>
        </div>
    </div>
</div><!--ROW1-->
<hr>
<div class="row">
    <div class="col">
        <label class="large mb-1" for=" ">MOTHER'S NAME</label> <label class="small mb-1"> (indicate even if deceased)</label>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">LAST NAME</label>
                    <input class="form-control  " id="txtML_Name" name="txtML_Name" type="text"  />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">FIRST NAME</label>
                    <input class="form-control " id="txtMF_Name" name="txtMF_Name" type="text" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">MIDDLE NAME</label>
                    <input class="form-control " id="txtMM_Name" name="txtMM_Name" type="text"  />
                </div>
            </div>      
        </div>
    </div>
</div><!--ROW2-->
<hr>
<div class="row">
    <div class="col">
        <label class="large mb-1" for=" ">SPOUSE NAME</label> <label class="small mb-1"> (indicate even if deceased)</label>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">LAST NAME</label>
                    <input class="form-control  " id="txtSL_Name" name="txtSL_Name" type="text"  />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">FIRST NAME</label>
                    <input class="form-control " id="txtSF_Name" name="txtSF_Name" type="text" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="small mb-1" for=" ">MIDDLE NAME</label>
                    <input class="form-control " id="txtSM_Name" name="txtSM_Name" type="text"  />
                </div>
            </div>      
        </div>
    </div>
</div><!--ROW3-->

</div>

<div class="col-6 col-md-4">
<label class="large mb-1" for=" ">EMPLOYER'S INFORMATION</label>
<div class="row">
    <div class="col">
        <label class="small mb-1" for=" ">BUSINESS NAME</label>
        <input class="form-control  " id="txtEB_Name" name="txtEB_Name" type="text"  />
    </div>
</div><!--ROW1-->
<div class="row">
    <div class="col">
        <label class="small mb-1" for=" ">TELEPHONE NUMBER</label>
        <input class="form-control  mb-3" id="txtET_Num" name="txtET_Num" type="text"  />
    </div>
</div><!--ROW2-->
<div class="row" >
    <div class="col">
        <label class="small mb-1" for=" ">ADDRESS</label>
        <input class="form-control  mb-3" id="txtE_Address" name="txtE_Address" type="text"  />
    </div>
</div><!--ROW3-->
</div>
</div>
    
<hr>

<div class="row">
<div class="col-12 col-md-8">
<div class="row">
    <div class="col">
        <div class="form-check">
            <label class="small mb-1" for=" ">RESTRICTIONS</label> <br>
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionOne" name="Restriction[]" value = "1" >1. MOTORCYCLE/MOTORIZED TRICYCLES/E-BIKES(LSV) TRIKES(A-1)</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionTwo" name="Restriction[]" value = "2" >2. VEHICLES UP TO 4500 KGS. GVW (MANUAL AND AUTOMATIC CLUTCH)</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionThree" name="Restriction[]" value = "3" >3. VEHICLES ABOVE 4500 KGS. GVW (MANUAL AND AUTOMATIC CLUTCH)</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionFour" name="Restriction[]" value = "4" >4. AUTOMATIC CLUTCH ONLY UP TO 4500 KGS. GVW</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionFive" name="Restriction[]" value = "5" >5. AUTOMATIC CLUTCH ONLY UP ABOVE 4500 KGS. GVW</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionSix" name="Restriction[]"  value = "6">6. ARTICULATED 1600 GVW AND BELOW</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionSeven" name="Restriction[]"  value = "7">7. ARTICULATED 1601 UP TO 4500 GVW</label> <br> 
            <label  class="small mb-1 form-check-label" ><input   class="form-check-input" type="checkbox" id="RestrictionEight" name="Restriction[]" value = "8">8. ARTICULATED 4501 GVW AND ABOVE (TRUCK - TRAILER)</label> <br> 
        </div>
    </div>
</div><!--row1-->
</div>
<div class="col-6 col-md-4">
<div class="row" >
    <div class="col">
        <div class="form-group">
            <label class="small mb-1" for=" " >DRIVING SKILL LICENSE ACQUIRED OR WILL BE ACQUIRED THRU (DSA)</label> <br>
            <label  class="small mb-1" > <input type="checkbox" id="checkD_School" name="checkDSA[]" value = "DS"> DRIVING SCHOOL</label> <br>
            <label  class="small mb-2" > <input type="checkbox" id="checkLP_Person" name="checkDSA[]" value = "LPP"> LICENSED PRIVATE PERSON</label> <br>
        </div>
    </div>
</div><!--row1-->
<div class="row">
    <div class="col">
        <div class="form-check">
            <label class="small mb-1" for=" ">CONDITIONS</label> <br>
            <label  class="small mb-1 form-check-label" ><input class="form-check-input" type="checkbox" id="Condition_A" name="Condition[]" value = "A">A. WEARING CORRECTIVE LENSES</label> <br> 
            <label  class="small mb-1 form-check-label" ><input class="form-check-input" type="checkbox" id="Condition_B" name="Condition[]" value = "B">B. DRIVE ONLY WITH CUSTOMIZED VEHICLE</label> <br> 
            <label  class="small mb-1 form-check-label" ><input class="form-check-input" type="checkbox" id="Condition_C" name="Condition[]" value = "C">C. DRIVE ONLY W/ SPECIAL EQUIPMENT FOR UPPER OR LOWER LIMBS</label> <br> 
            <label  class="small mb-1 form-check-label" ><input class="form-check-input" type="checkbox" id="Condition_D" name="Condition[]" value = "D">D. DAYLIGHT DRIVING ONLY</label> <br> 
            <label  class="small mb-1 form-check-label" ><input class="form-check-input" type="checkbox" id="Condition_E" name="Condition[]"  value = "E">E. WITH HEARING AID</label> <br> 
        </div>
    </div>
</div><!--row2-->
</div>

</div>
    <center>
<div class="form-group mt-4 mb-0"> 
    <input type="submit" class="btn btn-primary" name="submit">
</div>
		 </center>
    
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

<!--code for getting addresss-->
<script>

    const webcamElement = document.getElementById('webcam');
    const canvasElement = document.getElementById('canvas');
    const snapSoundElement = document.getElementById('snapSound');
    const webcam = new Webcam(webcamElement, 'user', canvasElement, snapSoundElement);
     
    function openCamera(){
        var btnName =  document.getElementById('launchCam').innerText.localeCompare("Launch Camera");
        
        if( btnName == 0){
            launchWebcam();
        }
       
    }

    function closeCamera(){
        if(document.getElementById('driverImage').style.display.localeCompare("block") ==0 ){
            document.getElementById('launchCam').innerText  = "Show Image";
        }
        webcam.stop();
       
       
        
    }

    function captureImage(){
        let picture = webcam.snap();
        webcamElement.style.display = "none";
        document.getElementById('driverImage').src = picture;

        document.getElementById('driverImage').style.display = "block";
        document.getElementById('captureImg').style.display = "none";
        document.getElementById('retakeImg').style.display = "block";

        document.getElementById('driverImage2').value = picture;
    }


    function launchWebcam(){
        document.getElementById('launchCam').innerText  = "Launch Camera";
        webcam.start()
        .then(result =>{
            console.log("webcam started");
        })
        .catch(err => {
            console.log(err);
        });

        webcamElement.style.display = "block";
        document.getElementById('driverImage').src = "";
        document.getElementById('driverImage').style.display = "none";
        document.getElementById('captureImg').style.display = "block";
        document.getElementById('retakeImg').style.display = "none";
    }
    
    
    
    
   

function getRegion(){
var result;
var list = document.getElementById("optRegion");
var optionVal = list.options[list.selectedIndex].id;
const Http = new XMLHttpRequest();
Http.open("GET", "../sql.php?query=select * from refProvince where regCode = '" + optionVal + "'");
Http.send();
Http.onreadystatechange = function(){
if(this.readyState==4 && this.status==200){
result = JSON.parse(Http.responseText);
var i=0;
$('#optProvince')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">Province</option>')
;
$('#optC_Municipality')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">City/Municipality</option>')
;
$('#optBaranggay')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">Baranggay</option>')
;  
for(i=0;i<result.length;i++){
$('#optProvince')
.find('option')
.end()
.append('<option  id = '+result[i].provCode+'>'+result[i].provDesc+'</option>')
;
}
}

}


}

function getProvince(){

var result;
var list = document.getElementById("optProvince");
var optionVal = list.options[list.selectedIndex].id;
const Http = new XMLHttpRequest();
Http.open("GET", "../sql.php?query=select * from refcitymun where provcode = '" + optionVal + "'");
Http.send();
Http.onreadystatechange = function(){
if(this.readyState==4 && this.status==200){
result = JSON.parse(Http.responseText);
var i=0;
$('#optC_Municipality')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">City/Municipality</option>')
;
$('#optBaranggay')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">Baranggay</option>')
; 
for(i=0;i<result.length;i++){
$('#optC_Municipality')
.find('option')
.end()
.append('<option id = '+result[i].citymunCode+'>'+result[i].citymunDesc+'</option>')
;
}
}

}


} 
function getBProvince(){

var result;
var list = document.getElementById("optB_Province");
var optionVal = list.options[list.selectedIndex].id;
const Http = new XMLHttpRequest();
Http.open("GET", "../sql.php?query=select * from refcitymun where provcode = '" + optionVal + "'");
Http.send();
Http.onreadystatechange = function(){
if(this.readyState==4 && this.status==200){
result = JSON.parse(Http.responseText);
var i=0;
$('#optBC_Municipality')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">City/Municipality</option>')
;
for(i=0;i<result.length;i++){
$('#optBC_Municipality')
.find('option')
.end()
.append('<option id = '+result[i].citymunCode+'>'+result[i].citymunDesc+'</option>')
;
}
}

}


} 
function getCity(){
var result;
var list = document.getElementById("optC_Municipality");
var optionVal = list.options[list.selectedIndex].id;
const Http = new XMLHttpRequest();
Http.open("GET", "../sql.php?query=select * from refbrgy where citymuncode = '" + optionVal + "'");
Http.send();
Http.onreadystatechange = function(){
if(this.readyState==4 && this.status==200){
result = JSON.parse(Http.responseText);
var i=0;
$('#optBaranggay')
.find('option')
.remove()
.end()
.append('<option selected disabled  value="">Baranggay</option>')
;  
for(i=0;i<result.length;i++){
$('#optBaranggay')
.find('option')
.end()
.append('<option id = '+result[i].brgyCode+'>'+result[i].brgyDesc+'</option>')
;
}
}

}


}

function Others(data){
document.getElementById("txt"+data+"_Others").disabled = false;
}

function Color(data){
document.getElementById("txt"+data+"_Others").disabled = true;
}

</script>
</body>
</html>
