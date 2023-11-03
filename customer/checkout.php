<?php
session_start();

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8">
  <title>Aaron Burks</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <!-- theme meta -->
  <meta name="theme-name" content="agen" />
  
  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <!-- venobox css -->
  <link rel="stylesheet" href="plugins/venobox/venobox.css">
  <!-- card slider -->
  <link rel="stylesheet" href="plugins/card-slider/css/style.css">

  <!-- Main Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body class="checkout">
  

    <header class="navigation fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
          <a class="navbar-brand" href="index.php"><img src="images/signup/sitelogo-singup.png" alt="Egen"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          <div class="collapse navbar-collapse text-center" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a style="color:#000;" class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="services.php">Services</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="notifications.php">Notifications</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="myhirings.php">My Hirings</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="provider.php">Provider</a>
              </li> 
            </ul>
          </div>
        </nav>
      </header>



<!-- PROVIDER SEC START -->
<section id="provider-booking-payment">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    
                    <form id="msform">
                <fieldset>
                            <div class="form-card" style="padding: 60px 0px;">
                              <div class="row">
                                 <div class="col-lg-7 mb-7 mb-lg-0">
                                  <div class="payment-heading">
                                    <h2>Payment Details</h2>
                                    <h3>Cardholder Name:</h3>
                                    <h4>John Johnson</h4>
                                    <label for="ccn">Credit Card Number:</label>
                                    <input id="ccn" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" 
                                     autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">

                                     <!-- EXP AND CVC ROW -->
                                  <div class="row">
                                    <div class="col-lg-6 mb-6 mb-lg-0">
                                      <label for="ccn">Exp Date</label>
<input class="cc-expires" maxlength="4" name="credit-expires" pattern="\d*" placeholder="MM / YY" type="tel" />
                                    </div>

                                    <div class="col-lg-6 mb-6 mb-lg-0 ffa">
                                      <label for="ccn">CVC</label>
                                      <input class="cc-cvc" maxlength="3" name="credit-cvc" pattern="\d*" placeholder="CVC" type="tel" />
                                    </div>
                                  </div>
                                     <!-- EXP AND CVC ROW END -->
                                     <input name="phone" placeholder="Phone No." type="text22" />

                                     <div class="payment-method">
                                      <h4>Payment Method</h4>
                                      <ul class="payment-images">
                                        <li><img src="./images/paymentpictures/debit.png"/></li>
                                        <li><img src="./images/paymentpictures/visa.png"/></li>
                                        <li><img src="./images/paymentpictures/paypal.png"/></li>
                                      </ul>
                                     </div>
                                  </div>
                                 </div>
                                 <div class="col-lg-5 mb-5 mb-lg-0">
                                  <div class="order-details-checkout">
                                    <div class="text-order-image">
                                      <img src="./images/hiring/hiring1.png"/>
                                      <h2>David Johnson <br> <span>Lawn Mower</span></h2>
                                      
                                    </div>
                                    <ul class="order-details-minor" style="width: 100%;">
                                      <li><i style="color: #70BE44" class="fa fa-check" aria-hidden="true"></i> 50+ Completed task</li>
                                      <li><i style="color: #70BE44" class="fa fa-map-marker" aria-hidden="true"></i> Texas, USA Street 2416 A-216</li>
                                      <li><i style="color: #70BE44;" class="fa fa-clock" aria-hidden="true"></i> Available hour 12:00 - 24:00 </li>
                                  </ul>
                                    <div class="pricedetails1">
                                      <h4>Price Details</h4>
                                      <ul>
                                        <li><em>Hourly Rate</em> <span style="color: #70BE44;">$30/hr</span></li>
                                        <li><em>Support Platform Fee's</em> <span style="color: #70BE44;">$6.55/hr</span></li>
                                        <li><em>Min-Max Rate</em> <span style="color: #70BE44;">$150-250 Approx</span></li>
                                      </ul>
                                    </div>
                                    <div class="taskdes-checkout">
                                      <h4>Task Description</h4>
                                      <p>I'm Stuck at Norway highway near Crown valley street, I have to 
                                        wash & tint my car as soon as possible because of this extreme 
                                        sunny weather. kindly come fast ASAP I'm waiting for you service. 
                                      </p>
                                    </div>
                                  </div>
                                 </div>
                                </div>
                            </div> 
                            </fieldset>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROVIDER SEC END -->

<!-- footer start -->
<footer id="footer-section">
<div class="container">
  <div class="footer-widgets">
    <div class="row" style="padding: 60px 0px 30px 0px;">
      <div class="col-lg-3 mb-3 mb-lg-0">
        <img class="footerlogo" src="./images/footerlogo.png" width="100%"/>
        <div class="social-links">
          <ul>
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Company</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Commericals</a></li>
            <li><a href="#">Exclusive</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">residential individuals</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Contact</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">Help/FAQs</a></li>
            <li><a href="#">Press</a></li>
            <li><a href="#">Affilates</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Services</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">Lawn Mowing</a></li>
            <li><a href="#">Grass cutting</a></li>
            <li><a href="#">Spring Clean up</a></li>
            <li><a href="#">Lawn Maintenance</a></li>
            <li><a href="#">Seeding/ Aeration</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="footer-copyright">
  <div class="container">
<p>Copyright are Reserved@Apexcreativedesign.com</p>
  </div>
</div>
</footer>

<!-- footer end -->

<!-- jQuery -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="plugins/slick/slick.min.js"></script>

<!-- Main Script -->
<script src="js/script.js"></script>
</body>
</html>