<?php
session_start();
if(isset($_SESSION['user'])){
    if(strpos($_SESSION['user'], 'E01') !== false){
        header("location: dist/driverView/index.php");
    }
    elseif(strpos($_SESSION['user'], 'S01') !== false){
        header("location: dist/officeView/applicationForm.php");
    }
    elseif(strpos($_SESSION['user'], 'O01') !== false){
        header("location: dist/officerView/index.php");
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>eTiquet - Home</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- Third party plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        
      <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">

    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top" style="margin: 0px;"><img src="image/eTiquetLogo2.png" width="20%"></a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <div>
        <div class="overlay">
                        <img class="overlay-img" src="image/cover.jpg">

        </div>
            <img class="overlay-logo" src="image/logo.png">
        </div>
        <div class="masthead">
            <div class="masthead-bg"></div>
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-12 my-auto">
                        <div class="masthead-content text-white py-5 py-md-0">
                            <h1 class="mb-3" style="font-family: 'Concert One', cursive;">eTiquet</h1>
                            <p class="mb-5 text-justify" style="font-family: poppins">An online web application that allows the <strong> Land Transportation Office </strong> to check driver's license, anytime and anywhere, without hassle. </p>
                            <div class="input-group input-group-newsletter">    
                                <a href="dist/login.php"><button type="button" class="btn btn-primary">Log In</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="social-icons">
            <ul class="list-unstyled text-center mb-0">
                <li class="list-unstyled-item">
                    <a href="#">
                       <i class="far fa-envelope"></i>
                    </a>
                </li>
                <li class="list-unstyled-item">
                    <a href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- About-->
        <section class="page-section bg-primary" id="about">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="text-white mt-0">About</h2>
                        <hr class="divider light my-4" />
                        <p class="text-white-50 mb-4" >An electronic Ticket (eTiquet) is a web application that allows drivers to store their personal information in a QR Code for verification during checkpoints. It is a handy and convenient alternative for a physical driver's license because you can bring it anywhere with the comfort that the holder's personal data are safe. The electronic ticket permits any driver the right to drive any vehicle in accordance with the restrictions stated in their profile. One tap and scan, and the ticketing officers can verify the driver's license authenticity and check the profile of the riders and as well as in giving violations intended for the drivers.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <h2 class="text-center mt-0" style="font-family: 'Concert One', cursive;">At Your Service</h2>
                <hr class="divider my-4" />
                <h3 class="text-center mt-0" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Here's how eTiquet make you checkpoint very short...</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Click</h3>
    <p class="card-text">Some example text.</p>
  </div>
</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Scan</h3>
    <p class="card-text">Some example text.</p>
  </div>
</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Verify</h3>
    <p class="card-text">Some example text.</p>
  </div>
</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Drive</h3>
    <p class="card-text">Some example text.</p>
  </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Call to action-->
        <section class="page-section bg-dark">
          <div class="container">
                <h2 class="text-center mt-0 text-white" style="font-family: 'Concert One', cursive;">Service for Officer</h2>
                <hr class="divider my-4" />
                <h3 class="text-center mt-0 text-white" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Here's how eTiquet make you checkpoint very short...</h3>
                <div class="row">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top"  src="image/Scan.PNG" alt="Card image">
  <div class="card-body">
    <h3 class="card-title ">Scan</h3>
    <p class="card-text">Scan your QR Code.</p>
  </div>
</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="image/Verify.PNG" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Verify</h3>
    <p class="card-text">Verify if it's not fake.</p>
  </div>
</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="image/Submit.PNG" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Submit</h3>
    <p class="card-text">Submit the Violations.</p>
  </div>
</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="card" style="width:300px">
  <img class="card-img-top" src="image/Done.PNG" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Done</h3>
    <p class="card-text">Good Job.</p>
  </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
<!--Section: Contact v.2-->
<section class="mb-4">

    <!--Section heading-->
    <h2 class="h1-responsive font-weight-bold text-center my-4">Contact us</h2>
    <!--Section description-->
    <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
        a matter of hours to help you.</p>

    <div class="row">

        <!--Grid column-->
        <div class="col-md-9 mb-md-0 mb-5">
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">

                <!--Grid row-->
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Your name">
                        </div>
                    </div>
                    <!--Grid column-->
<br>
                    <!--Grid column-->
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input type="text" id="email" name="email" class="form-control" placeholder="Your email">
                        </div>
                    </div>
                    <!--Grid column-->

                </div>
                <!--Grid row-->
<br>
                <!--Grid row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form mb-0">
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject">
                        </div>
                    </div>
                </div>
                <!--Grid row-->

                <!--Grid row-->
                <br>
                <div class="row">

                    <!--Grid column-->
                    <div class="col-md-12">

                        <div class="md-form">
                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" placeholder="Your message"></textarea>
                            </div>

                    </div>
                </div>
                <!--Grid row-->

            </form>
<br>
            <div class="text-center text-md-left">
                <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
            </div>
            <div class="status"></div>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-3 text-center">
            <ul class="list-unstyled mb-0">
                <li><i class="fas fa-map-marker-alt fa-2x"></i>
                    <p>NAGA CITY</p>
                </li>

                <li><i class="fas fa-phone mt-4 fa-2x"></i>
                    <p>+ 639000000</p>
                </li>

                <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                    <p>LTO@gmail.com</p>
                </li>
            </ul>
        </div>
        <!--Grid column-->

    </div>

</section>
<!--Section: Contact v.2-->                    
                
            </div>
        </section>
      
        <!-- Bootstrap core JS-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
