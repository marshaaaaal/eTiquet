<?php

function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "ltoadmin";
 $dbpass = "1234";
 $db = "lto";
 $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn->error);
 $conn->set_charset("utf8");
 return $conn;
 }
 
function CloseCon($conn)
 {
mysqli_close ($conn);
 }
   
?>
