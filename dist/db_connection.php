<?php

function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $db = "db_etiquet";
 $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db); 
 if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
 $conn->set_charset("utf8");
 return $conn;
 }
 
function CloseCon($conn)
 {
mysqli_close ($conn);
 }
   
?>
