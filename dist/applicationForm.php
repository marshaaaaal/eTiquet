<?php
session_start();
if(!isset($_SESSION['user'])){
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("location: login.php");

}
include 'db_connection.php';

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
        <title>LTO - Application Form</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Start Bootstrap</a>
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
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
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
                                Dashboard
                            </a>
                            <a class="nav-link" href="applicationForm.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Application Form
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Application for driver's license</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Application Form</li>
                        </ol>
                        <form>
                            <!--start Names-->
                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                <label class="large mb-1" for=" ">NAME</label>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for="txtL_Name">LAST NAME</label>
                                            <input class="form-control  " id="txtL_Name" name="txtL_Name" type="text"  />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for=" ">FIRST NAME</label>
                                            <input class="form-control " id="txtF_Name" name="txtF_Name" type="text" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="small mb-1" for=" ">MIDDLE NAME</label>
                                            <input class="form-control " id="txtM_Name" name="txtM_Name" type="text"  />
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <!--end Names-->
                            <br>
                            <div class="form-row">
                                <div class="col-md-8">
                                     <!--start address-->
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <label class="large mb-1" for=" ">PRESENT ADDRESS</label> <br>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group">
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
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label class="small mb-1" for=" ">PROVINCE</label>
                                                    <select required aria-required="true" class="form-control" name="optProvince" id="optProvince" onchange="getProvince()" >
                                                        <option selected disabled value="">Province</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="txtCity">CITY/MUNICIPALITY</label>
                                                    <select required aria-required="true" class="form-control" name="optC_Municipality" id="optC_Municipality" onchange="getCity()" >
                                                        <option selected disabled value="">City/Municipality</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                            <div class="form-group">
                                                    <label class="small mb-1" for="txtBaranngay">BARANGGAY</label>
                                                    <select required aria-required="true" class="form-control" name="optBaranggay" id="optBaranggay" >
                                                        <option selected disabled value="">Baranggay</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="txt">STREET/HOUSE NO.</label>
                                                    <input class="form-control" id="txtS_House" name="txtS_House" type="text" aria-describedby="emailHelp"  />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <!--end address-->
                                <!--start contacts-->
                                <div class="col-md-4">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="large mb-1" for="txtPresentAddress">CONTACTS</label> <br>
                                                    <label class="small mb-1" for="txt">TEL NO./ CP NO.</label>
                                                    <input class="form-control  " id="txtCpNum" name="txtCpNum" type="number" aria-describedby="emailHelp"/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="txt">TIN</label>
                                                    <input class="form-control " id="txtTin" name="txtTin" type="number" aria-describedby="emailHelp"/>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    
                                </div>
                                <!--end contacts-->
                            </div>
                            <br>
                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                <div class="form-row">
                                    <!--Nationality-->
                                    <div class="col-md-4">
                                        <label class="small mb-1" for="txtNationality">NATIONALITY</label>
                                        <input class="form-control " id="txtNationality" name="txtNationality" type="text" aria-describedby="emailHelp"/>
                                    </div>
                                    <!--end Nationality-->
                                    <!--Gender-->
                                    <div class="col-md-2">
                                        <label class="small mb-1" for="optGender">GENDER</label>
                                        <select required aria-required="true" class="form-control" name="optGender" id="optGender" onchange="getGender()" >
                                            <option selected disabled value=""></option>
                                            <option  value="">Male</option>
                                            <option  value="">Female</option>
                                        </select>
                                    </div>
                                    <!--end gender-->
                                    <!--bdate-->
                                    <div class="col-md-4">
                                        <label class="small mb-1" for="txtB_Date">BIRTH DATE</label>
                                        <input class="form-control " id="txtB_Date" name="txtB_Date" type="date" aria-describedby="emailHelp"/>
                                    </div>
                                    <!--end bdate-->
                                    <!--height-->
                                    <div class="col-md-1">
                                        <label class="small mb-1" for="txtHeight">HEIGHT (cm)</label>
                                        <input class="form-control " id="txtHeight" name="txtHeight" type="number" aria-describedby="emailHelp"/>
                                    </div>
                                    <!--weight-->
                                    <div class="col-md-1">
                                        <label class="small mb-1" for="txtWeight">WEIGHT (cm)</label>
                                        <input class="form-control " id="txtWeight" name="txtWeight" type="number" aria-describedby="emailHelp"/>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <br>
                          
                            <!--a-->
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <div class="form-group">
                                            <label class="large mb-1" for=" " >DRIVING SKILL LICENSE ACQUIRED OR WILL BE ACQUIRED THRU (DSA)</label> <br>
                                            <input type="checkbox" id="checkD_School" name="checkD_School" > <label  class="small mb-1" > DRIVING SCHOOL</label> <br>
                                            <input type="checkbox" id="checkLP_Person" name="checkLP_Person" > <label  class="small mb-2" > LICENSED PRIVATE PERSON</label> <br>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-md-4">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <div class="form-group">
                                            <label class="large mb-1" for=" " >EDUCATIONAL ATTAINMENT (EA)</label> <br>
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <input type="radio" id="radioI_Schooling" name="radioI_Schooling" > <label  class="small mb-1" >INFORMAL SCHOOLING</label><br>
                                                        <input type="radio" id="radioElementary" name="radioElementary" > <label  class="small mb-1" > ELEMENTARY</label> <br>
                                                        <input type="radio" id="radioH_School" name="radioH_School" > <label  class="small mb-1" > HIGH SCHOOL</label> <br>
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <input type="radio" id="radioVocational" name="radioVocational" > <label  class="small mb-1" > VOCATIONAL</label> <br>
                                                        <input type="radio" id="radioCollege" name="radioCollege" > <label  class="small mb-1" > COLLEGE</label>  <br>
                                                        <input type="radio" id="radioP_Graduate" name="radioP_Graduate" > <label  class="small mb-1" >POST GRADUATE</label> <br>      
                                                    </div> 
                                                </div>      
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <div class="form-group">
                                            <label class="large mb-2" for=" ">BLOOD TYPE</label>
                                            <select required aria-required="true" class="form-control" name="optB_Type" id="optB_Type" onchange="getBlood()" >
                                                <option selected disabled value=""></option>
                                                <option  value="">A+</option>
                                                <option  value="">A-</option>
                                                <option  value="">B+</option>
                                                <option  value="">B-</option>
                                                <option  value="">O+</option>
                                                <option  value="">O-</option>
                                                <option  value="">AB+</option>
                                                <option  value="">AB-</option>
                                            </select>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <div class="form-group">
                                            <label class="large mb-1" for=" ">ORGAN DONOR</label> <br>
                                            <input type="radio" id="radioYes" name="radioYes" > <label  class="small mb-2" > YES</label> <br> 
                                            <input type="radio" id="radioNo" name="radioNo" > <label  class="small mb-4" >NO </label> <br>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-2">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <label class="large mb-1" for=" ">CIVIL STATUS</label> <br>
                                        <input type="radio" id="radioSingle" name="radioSingle" > <label  class="small mb-1" > SINGLE</label> <br> 
                                        <input type="radio" id="radioMarried" name="radioMarried" > <label  class="small mb-1" >MARRIED</label> <br>   
                                        <input type="radio" id="radioWidow" name="radioWidow" > <label  class="small mb-1" > WIDOW/ER</label> <br> 
                                        <input type="radio" id="radioSeparated" name="radioSeparated" > <label  class="small mb-1" >SEPARATED </label> <br><br> 
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <label class="large mb-1" for=" ">HAIR</label> <br>
                                        <input type="radio" id="radioH_Black" name="radioH_Black" > <label  class="small mb-1" > BLACK</label> <br> 
                                        <input type="radio" id="radioH_Brown" name="radioH_Brown" > <label  class="small mb-1" > BROWN</label> <br>   
                                        <input type="radio" id="radioH_Blonde" name="radioH_Blonde" > <label  class="small mb-1" > BLONDE</label> <br> 
                                        <input type="radio" id="radioH_Gray" name="radioH_Gray" > <label  class="small mb-1" > GRAY </label> <br> 
                                        <input type="radio" id="radioH_Others" name="radioH_Others" > <label  class="small mb-1" > others (Specify):  </label>
                                        <input type="text" name= "txtH_Others" id = "txtH_Others" > <br> 
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <label class="large mb-1" for=" ">EYES</label> <br>
                                        <input type="radio" id="radioE_Black" name="radioE_Black" > <label  class="small mb-1" > BLACK</label> <br> 
                                        <input type="radio" id="radioE_Brown" name="radioE_Brown" > <label  class="small mb-1" > BROWN</label> <br>   
                                        <input type="radio" id="radioE_Gray" name="radioE_Gray" > <label  class="small mb-1" > GRAY </label> <br> 
                                        <input type="radio" id="radioE_Others" name="radioE_Others" > <label  class="small mb-1" > others (Specify):  </label>
                                        <input type="text" name= "txtE_Others" id = "txtE_Others" > <br> <br>   
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <label class="large mb-1" for=" ">BUILT</label> <br>
                                        <input type="radio" id="radioB_Light" name="radioB_Light" > <label  class="small mb-1" > LIGHT</label> <br> 
                                        <input type="radio" id="radioB_Medium" name="radioB_Medium" > <label  class="small mb-1" > MEDUIM</label> <br>   
                                        <input type="radio" id="radioB_Heavy" name="radioB_Heavy" > <label  class="small mb-2" > HEAVY </label><br> <br><br> 
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                        <label class="large mb-1" for=" ">COMPLEXION</label> <br>
                                        <input type="radio" id="radioC_Light" name="radioC_Light" > <label  class="small mb-1" > LIGHT</label> <br> 
                                        <input type="radio" id="radioC_Fair" name="radioC_Fair" > <label  class="small mb-1" > FAIR</label> <br>   
                                        <input type="radio" id="radioC_Dark" name="radioC_Dark" > <label  class="small mb-2" > DARK </label><br> <br><br> 
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="form-row">
                                <div class="col-md-5">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                                <label class="large mb-1" for=" ">BIRTH PLACE</label>
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for=" ">PROVINCE</label>
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
                                                    <div class="col-md-6">
                                                        <label class="small mb-1" for=" ">CITY/MUNICIPALITY</label>
                                                        <select required aria-required="true" class="form-control mb-3" name="optBC_Municipality" id="optBC_Municipality" >
                                                            <option selected disabled value="">City/Municipality</option>
                                                        </select>  
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    

                                        <div class="col-md-12">
                                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
                                                <label class="large mb-1" for=" ">EMPLOYER'S INFORMATION</label>
                                                <div class="form-row">
                                                    <div class="col-md-7">
                                                        <label class="small mb-1" for=" ">BUSINESS NAME</label>
                                                        <input class="form-control  " id="txtEB_Name" name="txtEB_Name" type="text"  />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="small mb-1" for=" ">TELEPHONE NUMBER</label>
                                                        <input class="form-control  mb-3" id="txtET_Num" name="txtET_Num" type="text"  />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="small mb-1" for=" ">ADDRESS</label>
                                                        <input class="form-control  mb-5" id="txtE_Address" name="txtE_Address" type="text"  />
                                                        <br><br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-row">
                                        <div class= "col-md-12">
                                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
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
                                                <br>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
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
                                                <br>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="container-fluid" style="background-color: rgb(235, 235, 235);">
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
                                                <br>
                                            </div>
                                            <br>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4 mb-0"><a class="btn btn-primary btn-block" href="login.html">Create Account</a></div>
                        </form>
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
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
        
        <!--code for getting addresss-->
        <script>
        function getRegion(){
                var result;
                var list = document.getElementById("optRegion");
                var optionVal = list.options[list.selectedIndex].id;
                const Http = new XMLHttpRequest();
                Http.open("GET", "sql.php?query=select * from refProvince where regCode = '" + optionVal + "'");
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
                  Http.open("GET", "sql.php?query=select * from refcitymun where provcode = '" + optionVal + "'");
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
                  Http.open("GET", "sql.php?query=select * from refcitymun where provcode = '" + optionVal + "'");
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
                Http.open("GET", "sql.php?query=select * from refbrgy where citymuncode = '" + optionVal + "'");
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



        </script>
    </body>
</html>
