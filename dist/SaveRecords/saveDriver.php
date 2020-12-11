<?php
ob_start();
session_start();
if(!isset($_SESSION['user'])){
    header("location: ../login.php");
}
include '../db_connection.php';


if(isset($_POST['submit'])){
    $conn = OpenCon();

    //for dirvers table
    $driverLastName = $_POST['txtL_Name'];
    $driverMiddleName= $_POST['txtM_Name'];
    $driverFirstName = $_POST['txtF_Name'];
    $address= $_POST['optRegion'] .",".$_POST['optProvince'] .",".$_POST['optC_Municipality'] .",".  $_POST['optBaranggay'] .",". $_POST['txtS_House'] ;
    $cpNum =  $_POST['txtCpNum'];
    $TIN=  $_POST['txtTin'];
    $nationality=  $_POST['txtNationality'];
    $gender=  $_POST['optGender'];
    $birthDate=  $_POST['B_Date'];
    $height=  $_POST['txtHeight'];
    $weight=  $_POST['txtWeight'];
    $DSA = "";
    if (empty($_POST['checkDSA']))
        $DSA = "None";
    else
        foreach($_POST['checkDSA'] as $checked){
            $DSA =  $DSA .", ". $checked ;
        }
    $DSA = ltrim($DSA, ', ');
    $EA=  $_POST['radioEducation'];
    $bloodType =  $_POST['optB_Type'];
    $OG =  $_POST['radioOD'];
    $CivilStatus =  $_POST['radioCS'];
    if ($_POST['radioHair']=="others")
        $hair = $_POST['txtH_Others'];
    else
        $hair =  $_POST['radioHair'];


    if ($_POST['radioEyes']=="others")
        $eyes = $_POST['txtE_Others'];
    else
        $eyes =  $_POST['radioEyes'];

    $built =  $_POST['radioBuilt'];
    $complexion =  $_POST['radioComplexion'];
    $birthPlace =  $_POST['optB_Province'] .",".  $_POST['optBC_Municipality'];
    $fatherName =  $_POST['txtFL_Name'] .",".$_POST['txtFF_Name'] .",". $_POST['txtFM_Name'];
    $motherName =  $_POST['txtML_Name'] .",".$_POST['txtMF_Name'] .",". $_POST['txtMM_Name'];
    $spouseName =  $_POST['txtSL_Name'] .",".$_POST['txtSF_Name'] .",". $_POST['txtSM_Name'];
    $employerName =  $_POST['txtEB_Name'];
    $employerNumber=  $_POST['txtET_Num'];
    $employerAddress=  $_POST['txtE_Address'];


    //getting image from form
    $img = $_POST['img'];

    //for documents
    $restrictions ="";
    $conditions = "";
    if(!empty($_POST['Restriction']))
        foreach($_POST['Restriction'] as $checked){
            $restrictions =  $restrictions.", ". $checked;
        }
    $restrictions = ltrim($restrictions, ', ');

    if (empty($_POST['Condition']))
        $conditions = "None";
    else
        foreach($_POST['Condition'] as $checked){
            $conditions = $conditions.", ". $checked;
        }
    $conditions = ltrim($conditions, ', ');
    $licenseExp = date("Y")+5 . date("/m/d");
    $sql = "select * from tbl_drivers";
    $res = mysqli_query($conn,$sql);
    $x=0;
    while($list = mysqli_fetch_assoc($res))
        $x++;

    $temp_license = 'E01-'.substr(date("Y"), 2).'-'.str_pad(($x+1), 6, '0', STR_PAD_LEFT);
    //inserting data
    $sqlDriver = 'INSERT INTO tbl_drivers (licenseNumber,driverImage, lastName, firstName, middleName, address, contactNumber, tinNumber,nationality,gender,birthDate,height,weight,DSA,EA,bloodType,organDonor,civilStatus,hairColor,eyesColor,bodyBuilt,complexion,birthPlace,fatherName,motherName,spouseName, employerName,employerNumber,employerAddress) 
                  VALUES (\''. $temp_license.'\',\''.$img.'\',\''.$driverLastName.'\', \''.$driverFirstName.'\', \''.$driverMiddleName.'\', \''.$address.'\', \''.$cpNum.'\', \''.$TIN.'\', \''.$nationality.'\', \''.$gender.'\', \''.$birthDate.'\', \''.$height.'\', \''.$weight.'\', \''.$DSA.'\', \''.$EA.'\', \''.$bloodType.'\', \''.$OG.'\',  \''.$CivilStatus.'\', \''.$hair.'\', \''.$eyes.'\', \''.$built.'\', \''.$complexion.'\', \''.$birthPlace.'\', \''.$fatherName.'\',\''.$motherName.'\',\''.$spouseName.'\', \''.$employerName.'\', \''.$employerNumber.'\', \''.$employerAddress.'\')';
    
    $sqlDocuments = 'INSERT INTO tbl_documents (licenseNumber, restrictions, driverCondition, licenseExpiration) 
                     VALUES (\''. $temp_license.'\',\''.$restrictions.'\',\''.$conditions.'\',\''.  $licenseExp.'\')';

    $sqlUser = 'INSERT INTO tbl_userdriver (licenseNumber, password) VALUES (\''. $temp_license.'\',\''.randomPassword().'\')';

    
    $conn->query($sqlDocuments);
    $conn->query($sqlDriver);
    $conn->query($sqlUser);
    
    header("location: ../officeView/driverTable.php");

    CloseCon($conn);
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
ob_end_flush();
