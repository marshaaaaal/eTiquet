<?php 
include ('db_connection.php');
session_start();
if(isset($_SESSION['user'])){
    if(strpos($_SESSION['user'], 'E01') !== false){
        header("location: driverView/index.php");
    }
    elseif(strpos($_SESSION['user'], 'S01') !== false){
        header("location: officeView/driverTable.php");
    }
    elseif(strpos($_SESSION['user'], 'O01') !== false){
        header("location: officerView/index.php");
    }
    
}

$error = " ";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = OpenCon();
    $myusername = $_POST['Username'];
    $mypassword = $_POST['Password'];
    
    //for driver log in
    if(strpos($myusername, 'E01') !== false){
        $sql = "SELECT *  FROM tbl_userdriver WHERE licenseNumber = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $_SESSION['user'] = $myusername;
            if(isset($_SESSION['redirect_to']))
            {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            }else{
                header("location: driverView/index.php");
            }
        }
    }
    elseif(strpos($myusername, 'O01') !== false){
        $sql = "SELECT *  FROM tbl_userstaff WHERE staffID = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $_SESSION['user'] = $myusername;
            if(isset($_SESSION['redirect_to']))
            {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            }else{
                header("location: officerView/index.php");
            }
        }
    }
    elseif(strpos($myusername, 'S01') !== false){
        $sql = "SELECT *  FROM tbl_userstaff WHERE staffID = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $_SESSION['user'] = $myusername;
            if(isset($_SESSION['redirect_to']))
            {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            }else{
                header("location: officeView/driverTable.php");
            }
        }
    }
    elseif(strpos($myusername, 'admin') !== false){
        $sql = "SELECT *  FROM tbl_userstaff WHERE staffID = '$myusername' and password = '$mypassword';";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $_SESSION['user'] = $myusername;
            if(isset($_SESSION['redirect_to']))
            {
                $url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header('location:' . $url);
            }else{
                header("location: serverView/index.php");
            }
        }
    }
    else {
        $error = "Your Login Username or Password is Invalid";
    }
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
        <title>eTiquet Log-in</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">eTiquet Login</h3></div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Username (ID)</label>
                                                <input class="form-control py-4" id="inputEmailAddress" name="Username" type="text" placeholder="Enter username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword" type="password" name="Password" placeholder="Enter password" />
                                            </div>
                                           
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                              
                                                <input type="submit" class="btn btn-primary" value="Sign-in">
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
