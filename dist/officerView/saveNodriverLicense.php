<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: ../login.php");
}
include '../db_connection.php';


$conn = OpenCon();


//for saving data in nodriverlicense table
$sql = "select * from tbl_nodriverlicense";
$res = mysqli_query($conn, $sql);
$x = 1;

while ($list = mysqli_fetch_assoc($res))
    $x++;
$temp_lic = 'NDL-' . substr(date("Y"), 2) . '-' . str_pad(($x), 6, '0', STR_PAD_LEFT);
$name = explode(",", $_POST['txtName']);
$addr = $_POST['txtAddress'];
$cont = $_POST['txtContact'];
$sql = "INSERT INTO tbl_nodriverlicense (`noDriverLicenseNumber`, `lastName`, `firstName`, `middleName`, `address`, `contactNumber`,`issuedDate`)
           VALUES ('$temp_lic', '$name[0]', '$name[1]', '$name[2]', '$addr', '$cont', ".date('Y/m/d').");";
$conn->query($sql);

//adding rows to tbl_nowdlviolation
///////////////////
$violation1 = "";
$violation2 = "";
$violation3 = "";
$date = date('Y/m/d', mktime(0, 0, 0, date('m'), date('d')+5, date('Y')));

$sql = "select distinct violationNumber from tbl_driverviolation";
$res = mysqli_query($conn, $sql);
$lastElement = array();
while ($list = mysqli_fetch_assoc($res)) $lastElement[]=$list;

$sql1 = "select distinct violationNumber from tbl_nodlviolation";
$res1 = mysqli_query($conn, $sql1);
$lastElement1 = array();
while ($list1 = mysqli_fetch_assoc($res1)) $lastElement1[]=$list1;


$lastElementDriver = substr($lastElement[count($lastElement)-1]['violationNumber'], 8);
$lastElementNoDriver = substr($lastElement1[count($lastElement1)-1]['violationNumber'], 8);

$compRes  = strcmp($lastElementDriver, $lastElementNoDriver);
if ($compRes > 0 && $compRes !== 0)
    $tempViolationID = "V01-" . substr(date("Y"), 2) . '-' . str_pad((intval($lastElementDriver) + 1), 6, '0', STR_PAD_LEFT);
else
    $tempViolationID = "V01-" . substr(date("Y"), 2) . '-' . str_pad((intval($lastElementNoDriver) + 1), 6, '0', STR_PAD_LEFT);


if (!empty($_POST['violation1']))
    foreach ($_POST['violation1'] as $checked) {
        $sql = 'INSERT INTO `tbl_nodlviolation` (`violationNumber`, `staffID`, `violationID`, `noDriverLicenseNumber`, `plateNumber`, `apprehensionPlace`, `name`, `confiscatedItem`, `dueDate`, `issuedDate`)
             VALUES (\''.$tempViolationID.'\', \''. $_SESSION['user'] . '\',  \''.$checked.'\',  \''.$temp_lic.'\', \'' . $_POST['pNumber'] .'\', \'' . $_POST['txtP_Apprehension'] . '\',  \''. $_POST['txtName'] . '\',  \'' . $_POST['txtC_items'] . '\',  \''.$date.'\',  \''.date('Y/m/d').'\')';
        $conn->query($sql); 
        echo $sql;
    }
if (!empty($_POST['violation2']))
    foreach ($_POST['violation2'] as $checked) {
        $sql = 'INSERT INTO `tbl_nodlviolation` (`violationNumber`, `staffID`, `violationID`, `noDriverLicenseNumber`, `plateNumber`, `apprehensionPlace`, `name`, `confiscatedItem`,  `dueDate`, `issuedDate`)
              VALUES (\''.$tempViolationID.'\', \''. $_SESSION['user'] . '\',  \''.$checked.'\',  \''.$temp_lic.'\', \'' . $_POST['pNumber'] .'\', \'' . $_POST['txtP_Apprehension'] . '\',  \''. $_POST['txtName'] . '\',  \'' . $_POST['txtC_items'] . '\',  \''.$date.'\',\''.date('Y/m/d').'\')';
        $conn->query($sql);
         echo $sql;
    }
if (!empty($_POST['violation3']))
    foreach ($_POST['violation3'] as $checked) {
        $sql = 'INSERT INTO `tbl_nodlviolation` (`violationNumber`, `staffID`, `violationID`, `noDriverLicenseNumber`, `plateNumber`, `apprehensionPlace`, `name`, `confiscatedItem`,  `dueDate`,`issuedDate`)
              VALUES (\''.$tempViolationID.'\', \''. $_SESSION['user'] . '\',  \''.$checked.'\',  \''.$temp_lic.'\', \'' . $_POST['pNumber'] .'\', \'' . $_POST['txtP_Apprehension'] . '\',  \''. $_POST['txtName'] . '\',  \'' . $_POST['txtC_items'] . '\',  \''.$date.'\',\''.date('Y/m/d').'\')';
        $conn->query($sql);
        echo $sql;
    }

header("location: index.php");
