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
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body class="services-page">


  <header class="navigation fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Egen"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse text-center" id="navigation">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="services.php">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="notifications.php">Notifications</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="myhirings.php">My Hirings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="provider.php">Provider</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- banner -->
  <section id="main-banner" class="banner bg-cover position-relative d-flex justify-content-center align-items-center"
    data-background="images/banner/banner.png" style="text-align: center;     min-height: 50vh;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 style="color: #FFF; padding-top: 120px;">Provider</h2>
          <h5 style="color: white;">Here are your daily updates Notifications</h5>
        </div>
      </div>


    </div>
  </section>
  <!-- /banner -->

  <!-- PROVIDER SEC START -->
  <section id="provider-booking-payment">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card px-0 pt-4 pb-0 mt-3 mb-3">

            <form id="msform">
              <!-- progressbar -->
              <ul id="progressbar">
                <li class="active" id="account"><strong>Provider Selected</strong></li>
                <li id="personal"><strong>Set Booking</strong></li>
                <li id="payment"><strong>Your Offer</strong></li>
              </ul>
              <br>

              <!-- fieldsets -->

              <fieldset class="my-first-field">
                <!-- ROW PROVIDER selected START -->
                <div class="provider-selected-main">

                  <div class="row provider-gradedetails">
                    <div class="col-lg-3 col-sm-12 align-self-center">
                      <div class="provider-name">
                        <img src="./images/providerselected/providerimage.png" />
                        <h4>David Johnson</h4>
                      </div>
                    </div>
                    <div class="col-lg-5 col-sm-12 align-self-center">
                      <ul class="grade" style="width: 100%;">
                        <li><i style="color: #FFC400;" class="fa fa-star" aria-hidden="true"></i> 4.9</li>
                        <li>100%</li>
                        <li>Job Success</li>
                      </ul>
                    </div>
                    <div class="col-lg-1 col-sm-12 align-self-center">

                    </div>
                    <div class="col-lg-3 col-sm-12 align-self-center">
                      <h6 style="color: #70BE44;" class="price">$30/hr</h6>
                    </div>
                    <ul class="detaillist" style="width: 100%;">
                      <li><i style="color: #70BE44" class="fa fa-check" aria-hidden="true"></i> 50+ Completed task</li>
                      <li><i style="color: #70BE44" class="fa fa-map-marker" aria-hidden="true"></i> Texas, USA Street
                        2416 A-216</li>
                      <li><i style="color: #70BE44;" class="fa fa-clock" aria-hidden="true"></i> Available hour 12:00 -
                        24:00 </li>
                    </ul>
                    <div class="about-provider">
                      <h4 style="width: 100%;">About me</h4>
                      <p style="width: 100%;">I have 10+ years experience in vehicle mechanics and have my own
                        equipment, I would <br>
                        love to help you get your job done and satisfied reviews.
                      </p>
                      <h4 style="width: 100%;"><a href="#">Read More</a></h4>
                    </div>
                  </div>

                  <div class="row" style="padding: 40px 0px;">
                    <div class="col-lg-6 col-sm-12">
                      <div class="gallerinfo">
                        <h5>Work Done Gallery</h5>
                        <ul style="width: 100%;">
                          <li><img src="./images/providerselected/provider1.png" /></li>
                          <li><img src="./images/providerselected/provider1.png" /></li>
                          <li><img src="./images/providerselected/provider1.png" /></li>
                          <li><img src="./images/providerselected/provider1.png" /></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <div class="speciality-info">
                        <h5>Specialities</h5>
                        <ul class="specialitylist" style="width: 100%;">
                          <li><img src="./images/providerselected/Snow Plow.png" /> Removal</li>
                          <li><img src="./images/providerselected/Grass.png" /> Grass Cutting</li>
                          <li><img src="./images/providerselected/Cover Up.png" /> Spring Cleanup</li>
                        </ul>
                      </div>
                    </div>

                  </div>

                  <div class="row" style="width: 100%;">
                    <div class="col-lg-6 col-sm-12">
                      <div class="recent-jobs-inner">
                        <div class="row">
                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent">
                              <h3><img src="./images/providerselected/recent1.png" /> Alexendar Leo</h3>
                            </div>
                          </div>

                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent-grades">
                              <ul>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="font-size: 14px;
                                                line-height: 19px; color: #BEBEBE;">Sep 4, 2021 </li>
                              </ul>
                            </div>
                          </div>

                        </div>

                        <p>Had an amazing experience and problem solver this men is...Thumbs up.</p>
                        <div class="services-provided">
                          <h6><em>SERVICE PROVIDED</em> <span>grass cutting , lawn mowing , snow cleanup.</span></h6>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                      <div class="recent-jobs-inner">
                        <div class="row">
                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent">
                              <h3><img src="./images/providerselected/recent1.png" /> Alexendar Leo</h3>
                            </div>
                          </div>

                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent-grades">
                              <ul>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="font-size: 14px;
                                            line-height: 19px; color: #BEBEBE;">Sep 4, 2021 </li>
                              </ul>
                            </div>
                          </div>

                        </div>

                        <p>Had an amazing experience and problem solver this men is...Thumbs up.</p>
                        <div class="services-provided">
                          <h6><em>SERVICE PROVIDED</em> <span>grass cutting , lawn mowing , snow cleanup.</span></h6>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>
                <input type="button" name="next" class="next action-button" value="Book now" />
                <!-- ROW PROVIDER selected end -->

              </fieldset>

              <!-- PROVIDER END -->

              <!-- second FIELDSET START -->
              <fieldset>
                <div class="row booking-section" style="width: 100%;">
                  <h3 style="width: 100%;">Select Services & Set Your Booking</h3>
                  <div class="select-service-booking">
                    <h4>Select Services you need</h4>
                    <div class="row">
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                      <div class="col-lg-3 mb-3 mb-lg-0">
                        <label><input type="checkbox" name="checkbox" value="value">Snow removal</label>
                      </div>
                    </div>
                  </div>

                  <div class="upload-field-booking">
                    <h2>Upload Images of your Place</h2>
                    <label style="background-image: url(./images/providerselected/upload.PNG);">
                      <input type="file" name="File Upload" value="value" multiple max="5"></label>
                    <p style="text-align: left;">Minimum 5 images of Of your service area , make sure image should be
                      clear</p>
                  </div>

                  <div class="advancebook-bookingtab recurr" style="background-color: #70BE44;">
                    <div class="col-lg-9 mb-9 mb-lg-0">
                      <h2 style="color: #FFF;">Want Advance Booking for this Services</h2>
                    </div>
                    <div class="col-lg-3 mb-3 mb-lg-0">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-1">
                            <input type="checkbox" class="checkbox" />
                            <div class="knobs"></div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id='main'>
                    <h3>Choose Your Time & Date </h3>
                    <div id='app'></div>
                  </div>
                  <div class="row advnce" style="padding: 60px 0px;">
                    <div class="advancebooking-calender">
                      <h2>Set Your Advance Booking</h2>
                      <div class="innerrow">
                        <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                          <h1> <img src="./images/calender.png" />29-June-2023 , MON</h1>
                        </div>
                        <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                          <h5>Hours Require <span>02</span></h5>
                          <ul class="time-advance">
                            <li>10 am -12 am</li>
                            <li>10 am -12 am</li>
                          </ul>
                          <ul class="time-advance1">
                            <li>10 am -12 am</li>
                            <li>10 am -12 am</li>
                          </ul>
                        </div>

                      </div>
                      <div class="innerrow" style="margin-top: 30px; background-color: #E7212121;">
                        <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                          <h1> <img src="./images/calender.png" />29-June-2023 , MON</h1>
                        </div>
                        <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                          <h5>Hours Require <span>02</span></h5>
                          <ul class="time-advance">
                            <li>10 am -12 am</li>
                            <li>10 am -12 am</li>
                          </ul>
                          <ul class="time-advance1">
                            <li>10 am -12 am</li>
                            <li>10 am -12 am</li>
                          </ul>
                        </div>

                      </div>

                      <div class="innerrow"
                        style="margin-top: 30px; background-color: #ffc4006e                                          ;">
                        <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                          <h1> <img src="./images/calender.png" />29-June-2023 , MON</h1>
                        </div>
                        <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                          <h5>Hours Require <span>02</span></h5>
                          <ul class="time-advance">
                            <li>10 am -12 am</li>
                            <li>10 am -12 am</li>
                          </ul>
                          <ul class="time-advance1">
                            <li>10 am -12 am</li>
                            <li>10 am -12 am</li>
                          </ul>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="shortmessage">
                    <h4 style="text-align: center;">Describe your task</h4>
                    <textarea placeholder="Give your Note to the worker"></textarea>
                  </div>
                </div>
                <input type="button" name="next" class="next action-button" value="Continue" />
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
              </fieldset>
              <!-- THIRD FEILD END -->

              <fieldset>
                <div class="your-offer-selected advanceoffer">
                  <h2>Your offers for Advance booking Service</h2>
                  <div class="row advance-offer-new">
                    <div class="text-order-image">
                      <img src="./images/hiring/hiring1.png" />
                      <h2>David Johnson <br> <span>Lawn Mower</span></h2>

                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <div class="unorderlist-selected">
                        <h2>Service Cost Offer</h2>
                        <li><em><img src="./images/providerselected/Snow Plow.png" />Snow
                            Removal</em><span>$100.00</span></li>
                        <li><em><img src="./images/providerselected/Cover Up.png" />Spring
                            Cleanup</em><span>$100.00</span></li>
                        <li><em><img src="./images/providerselected/Grass.png" />Grass Cutting</em><span>$100.00</span>
                        </li>
                      </div>
                      <div class="totalselected">
                        <li><em><img src="./images/providerselected/total.png" />Total Charges</em><span>$300</span>
                        </li>
                      </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <h2>Advance Booking Timings</h2>
                      <div class="advancebookedtimings">
                        <ul>
                          <li style="background-color: #70BE4442;"><em>29-June-2023 , MON</em> <span>10 am -12 am</span>
                          </li>
                          <li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em> <span>10 am -12 am</span>
                          </li>
                          <li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em> <span>10 am -12 am</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="row description-advance">
                      <h2>Task Description</h2>
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type
                        specimen book. It has survived not only five centuries, but also the leap into
                        electronic typesetting, remaining essentially unchanged. It was popularised in
                        the 1960s with the release of Letraset</p>
                    </div>
                  </div>
                </div>

                <input type="button" name="next" class="submit next action-button"
                  value="Proceed & Send Request to Provider" />
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
              </fieldset>
              <fieldset>
                <div class="your-offer-selected popup-selected">
                  <div class="popup-selected-modal">
                    <div class="popupsucessfully">
                      <img src="./images/checktick.png" />
                      <p>Your Offer Has been successfully sent to service provider</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 mb-3 mb-lg-0">
                      <h2>Your offers for services selected</h2>
                      <div class="unorderlist-selected">
                        <li><em><img src="./images/providerselected/Snow Plow.png" />Snow
                            Removal</em><span>$100.00</span></li>
                        <li><em><img src="./images/providerselected/Cover Up.png" />Spring
                            Cleanup</em><span>$100.00</span></li>
                        <li><em><img src="./images/providerselected/Grass.png" />Grass Cutting</em><span>$100.00</span>
                        </li>
                      </div>
                      <div class="totalselected">
                        <li><em><img src="./images/providerselected/total.png" />Total Charges</em><span>$300</span>
                        </li>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-3 mb-lg-0">
                      <div class="selected-prfle-detl">
                        <div class="order-details-checkout">
                          <div class="text-order-image">
                            <img src="./images/hiring/hiring1.png" />
                            <h2>David Johnson <br> <span>Lawn Mower</span></h2>

                          </div>
                          <ul class="order-details-minor" style="width: 100%;">
                            <h4>Booking Timing</h4>
                            <li><i style="color: #70BE44;" class="fa fa-clock" aria-hidden="true"></i>
                              21, August,4:00 AM, SUN </li>
                          </ul>
                          <div class="pricedetails1">
                            <h4>Services Selected</h4>
                            <ul>
                              <li><em>Lawn mowing</em> <span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em>Snow Removal</em> <span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em>Grass Cutting</em> <span style="color: #70BE44;">$ 100.00</span></li>
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
            <img class="footerlogo" src="./images/footerlogo.png" width="100%" />
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

<script>
  $(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function () {

      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //Add Class Active
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate({ opacity: 0 }, {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          next_fs.css({ 'opacity': opacity });
        },
        duration: 500
      });
      setProgressBar(++current);
    });

    $(".previous").click(function () {

      current_fs = $(this).parent();
      previous_fs = $(this).parent().prev();

      //Remove class active
      $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

      //show the previous fieldset
      previous_fs.show();

      //hide the current fieldset with style
      current_fs.animate({ opacity: 0 }, {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          previous_fs.css({ 'opacity': opacity });
        },
        duration: 500
      });
      setProgressBar(--current);
    });

    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar")
        .css("width", percent + "%")
    }

    $(".submit").click(function () {
      return false;
    })

  });
</script>