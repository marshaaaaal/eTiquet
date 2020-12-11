<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("location: ../login.php");
}
include '../db_connection.php';


$conn = OpenCon();
$txtlicense = $_POST['txtlicense'];
$txtP_Apprehension = $_POST['txtP_Apprehension'];
$txtC_items = $_POST['txtC_items'];
$txtP_number = $_POST['txtPlateNumber'];
$txtN_driver = $_POST['txtN_driver'];



$violation1 = "";
$violation2 = "";
$violation3 = "";
//inserting data
$date = date('Y/m/d', mktime(0, 0, 0, date('m'), date('d')+5, date('Y')));
echo $date;
$sql = "select distinct violationNumber from tbl_driverviolation";
$res = mysqli_query($conn, $sql);
$lastElement = array();
while ($list = mysqli_fetch_assoc($res)) $lastElement[] = $list;

$sql1 = "select distinct violationNumber from tbl_nodlviolation";
$res1 = mysqli_query($conn, $sql1);
$lastElement1 = array();
while ($list1 = mysqli_fetch_assoc($res1)) $lastElement1[] = $list1;


$lastElementDriver = substr($lastElement[count($lastElement) - 1]['violationNumber'], 8);
$lastElementNoDriver = substr($lastElement1[count($lastElement1) - 1]['violationNumber'], 8);

$compRes  = strcmp($lastElementDriver, $lastElementNoDriver);
if ($compRes > 0 && $compRes !== 0)
    $temp_violation = "V01-" . substr(date("Y"), 2) . '-' . str_pad((intval($lastElementDriver) + 1), 6, '0', STR_PAD_LEFT);
else
    $temp_violation = "V01-" . substr(date("Y"), 2) . '-' . str_pad((intval($lastElementNoDriver) + 1), 6, '0', STR_PAD_LEFT);

if (!empty($_POST['violation1']))
    foreach ($_POST['violation1'] as $checked) {
        $sql = 'INSERT INTO `tbl_driverviolation` ( `violationNumber`, `licenseNumber`, `staffID`, `violationID`,`name`, `apprehensionPlace`, `plateNumber`,`confiscatedItem`,`issuedDate`, `dueDate`) 
        VALUES (\'' . $temp_violation . '\',\'' . $txtlicense . '\',\'' . $_SESSION['user'] . '\', \'' . $checked . '\',\'' . $txtN_driver . '\' ,\'' . $txtP_Apprehension . '\', \'' . $txtP_number . '\', \'' . $txtC_items . '\', \'' . date('Y/m/d') . '\', \'' . $date . '\')';
        $conn->query($sql);
        echo $sql;
    }

if (!empty($_POST['violation2']))
    foreach ($_POST['violation2'] as $checked) {
        $sql = 'INSERT INTO `tbl_driverviolation` ( `violationNumber`, `licenseNumber`, `staffID`, `violationID`, `name`, `apprehensionPlace`, `plateNumber`,`confiscatedItem`, `issuedDate`, `dueDate`)
        VALUES (\'' . $temp_violation . '\',\'' . $txtlicense . '\',\'' . $_SESSION['user'] . '\', \'' . $checked . '\',\'' . $txtN_driver . '\' ,\'' . $txtP_Apprehension . '\', \'' . $txtP_number . '\', \'' . $txtC_items . '\', \'' .date('Y/m/d') . '\', \'' . $date . '\')';
        $conn->query($sql);
        echo $sql;
    }

if (!empty($_POST['violation3']))
    foreach ($_POST['violation3'] as $checked) {
        $sql = 'INSERT INTO `tbl_driverviolation` ( `violationNumber`, `licenseNumber`, `staffID`, `violationID`, `name`, `apprehensionPlace`, `plateNumber`,`confiscatedItem`, `issuedDate`, `dueDate`) 
        VALUES (\'' . $temp_violation . '\',\'' . $txtlicense . '\',\'' . $_SESSION['user'] . '\', \'' . $checked . '\',\'' . $txtN_driver . '\' ,\'' . $txtP_Apprehension . '\', \'' . $txtP_number . '\', \'' . $txtC_items . '\', \'' . date('Y/m/d') . '\', \'' . $date . '\')';
        $conn->query($sql);
        echo $sql;
    }

header("location: ../officerView/index.php");
CloseCon($conn);
