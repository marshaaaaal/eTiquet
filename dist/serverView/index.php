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
elseif(strpos($_SESSION['user'], 'S01') !== false){
header("location: ../officeView/index.php");
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
Staff registration form
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
<h1 class="mt-4">Registration form for staff</h1>


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
</div>
<div class="row">
    <div class="col">
        <label class="small mb-1" for="txt">TEL NO./ CP NO.</label>
        <input required class="form-control  " id="txtCpNum" name="txtCpNum" type="number" aria-describedby="emailHelp"/>
    </div>
</div> <!--ROW2-->

</div> <!--LEFT PART 1-->

</div> <!--RIGHT PART 1-->
</div>
    
<hr>

<div class="shadow p-3 mb-5 bg-white rounded">
<h4>Address:</h4>
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
<script src="../js/address.js"></script>

<!--code for getting addresss-->
<script>
    function Others(data){
    document.getElementById("txt"+data+"_Others").disabled = false;
    }
    function Color(data){
    document.getElementById("txt"+data+"_Others").disabled = true;
    }
</script>
</body>
</html>
