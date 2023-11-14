<?php
session_start();

?>
<!DOCTYPE html>
<html lang="zxx" class="my-offer">

<head>
  <meta charset="utf-8">
  <title>Aaron Burks</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <!-- theme meta -->
  <meta name="theme-name" content="agen" />
  <!-- HORIZONTAL COLUMN ALIGN LINKS -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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

<body class="services-page">
  

<?php
include 'Black_logo_header.php'
?>


<!-- Section start -->
<section id="my-offers-main">
<div class="container">
    <div class="row">
    <h2 style="color: #000; font-weight: bold;">My Hirings</h2>
        <p style="color: #70BE44;">Here are your past services you availed and hired!</p>
    </div>
    <div class="myoffer-button-serv">
        <ul>
            <li><a href="myhirings.php"><button style="background-color: #E6E6E6; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #9D9D9D;
                ">One Time Service</button></a></li>
            <li><a href="myrecurrings.php"><button style="background-color: #70BE44; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #fff;
                ">Advance Booking</button></a></li>
        </ul>
    </div>
    <div class="row">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">In progress</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Scheduled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Completed</a>
            </li>
            
        </ul><!-- Tab panes -->
        
        <div class="tab-content" style="margin: 0; padding: 0;">
            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <div class="inprogressadvancebooking-box">
                    <div class="row align-items-center">
                        <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                            <div class="prf-imgwithtext">
                                <img src="./images/hiring/hiring1.png"/>
                               <h2> David Johnson</h2>
                               <p>Garden Maintenance</p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                            <div class="scheduled-today">
                                <h3 style="color: #E72121;">Scheduled Today</h3>
                                <ul class="date">
                                    <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                            <div class="inprocess-button">
                                <a href="#"><button class="process">In Process</button></a>
                                <p>Hired On 23rd August 2023</p>
                        </div>
                    </div>
                </div>
                <div class="services-selected">
                  <ul>
                    <li>
                      <em><b style="color: #000;">Services Selected</b></em>
                      <span><img src="./images/servicecheck.png"/> Snow Removal</span>
                      <span><img src="./images/servicecheck.png"/> Grass Cutting</span>
                      <span><img src="./images/servicecheck.png"/> Spring Cleanup</span>
                    </li>
                  </ul>
                </div>

                <div class="row align-items-center advancebookingschedule">
                  <table style="padding: 20px;">
                    <tr  style="margin-bottom:10px;">
                      <th width="85%">Advance Booking Timings</th>
                      <th width="15%">Status</th>
                    </tr>
                    <tr  style="margin-bottom:10px;"> 
                      <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                      <td width="15%"><a href="#"><button class="process">In Process</button></a></td>
                    </tr>
                    <tr  style="margin-bottom:10px;">
                      <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                      <td width="15%"><a href="#"><button style="background-color: #00B2FF;"  class="process">Scheduled </button></a></td>
                    </tr>
                    <tr>
                      <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                      <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
                    </tr>
                   
                  </table>

                  <div class="reschedule-detailsbuton">
                    <ul>
                      <li>
                        <a href="#"><button style="background-color: #E72121; color: #fff;">Re Schedule</button></a>
                      </li>
                      <li>
                        <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                           background-color: #fff; color: #70BE44;">View Details</button></a>
                      </li>
                    </ul>
                  </div>
          </div>
            </div>

</div>
            <div class="tab-pane" id="tabs-2" role="tabpanel">
              <div class="inprogressadvancebooking-box">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                        <div class="prf-imgwithtext">
                            <img src="./images/hiring/hiring1.png"/>
                           <h2> David Johnson</h2>
                           <p>Garden Maintenance</p>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                        <div class="scheduled-today">
                            <h3 style="color: #E72121;">Scheduled Today</h3>
                            <ul class="date">
                                <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                        <div class="inprocess-button">
                            <a href="#"><button class="process">In Process</button></a>
                            <p>Hired On 23rd August 2023</p>
                    </div>
                </div>
            </div>
            <div class="services-selected">
              <ul>
                <li>
                  <em><b style="color: #000;">Services Selected</b></em>
                  <span><img src="./images/servicecheck.png"/> Snow Removal</span>
                  <span><img src="./images/servicecheck.png"/> Grass Cutting</span>
                  <span><img src="./images/servicecheck.png"/> Spring Cleanup</span>
                </li>
              </ul>
            </div>
            <div class="row align-items-center advancebookingschedule">
              <table style="padding: 20px;">
                <tr  style="margin-bottom:10px;">
                  <th width="85%">Advance Booking Timings</th>
                  <th width="15%">Status</th>
                </tr>
                <tr  style="margin-bottom:10px;"> 
                  <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                  <td width="15%"><a href="#"><button class="process">In Process</button></a></td>
                </tr>
                <tr  style="margin-bottom:10px;">
                  <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                  <td width="15%"><a href="#"><button style="background-color: #00B2FF;"  class="process">Scheduled </button></a></td>
                </tr>
                <tr>
                  <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                  <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
                </tr>
               
              </table>

              <div class="reschedule-detailsbuton">
                <ul>
                  <li>
                    <a href="#"><button style="background-color: #E72121; color: #fff;">Re Schedule</button></a>
                  </li>
                  <li>
                    <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                       background-color: #fff; color: #70BE44;">View Details</button></a>
                  </li>
                </ul>
              </div>
      </div>
        </div>
        <div class="inprogressadvancebooking-box" style="margin-top: 40px;">
          <div class="row align-items-center">
              <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                  <div class="prf-imgwithtext">
                      <img src="./images/hiring/hiring1.png"/>
                     <h2> David Johnson</h2>
                     <p>Garden Maintenance</p>
                  </div>
              </div>
              <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                  <div class="scheduled-today">
                      <h3 style="color: #E72121;">Scheduled Today</h3>
                      <ul class="date">
                          <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                      </ul>
                  </div>
              </div>
              <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                  <div class="inprocess-button">
                      <a href="#"><button class="process">In Process</button></a>
                      <p>Hired On 23rd August 2023</p>
              </div>
          </div>
      </div>
      <div class="services-selected">
        <ul>
          <li>
            <em><b style="color: #000;">Services Selected</b></em>
            <span><img src="./images/servicecheck.png"/> Snow Removal</span>
            <span><img src="./images/servicecheck.png"/> Grass Cutting</span>
            <span><img src="./images/servicecheck.png"/> Spring Cleanup</span>
          </li>
        </ul>
      </div>
      <div class="row align-items-center advancebookingschedule">
        <table style="padding: 20px;">
          <tr  style="margin-bottom:10px;">
            <th width="85%">Advance Booking Timings</th>
            <th width="15%">Status</th>
          </tr>
          <tr  style="margin-bottom:10px;"> 
            <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button class="process">In Process</button></a></td>
          </tr>
          <tr  style="margin-bottom:10px;">
            <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #00B2FF;"  class="process">Scheduled </button></a></td>
          </tr>
          <tr>
            <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
          </tr>
         
        </table>

        <div class="reschedule-detailsbuton">
          <ul>
            <li>
              <a href="#"><button style="background-color: #E72121; color: #fff;">Re Schedule</button></a>
            </li>
            <li>
              <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                 background-color: #fff; color: #70BE44;">View Details</button></a>
            </li>
          </ul>
        </div>
</div>
  </div>
            </div>

            <div class="tab-pane" id="tabs-3" role="tabpanel">
              <div class="inprogressadvancebooking-box">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                        <div class="prf-imgwithtext">
                            <img src="./images/hiring/hiring1.png"/>
                           <h2> David Johnson</h2>
                           <p>Garden Maintenance</p>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                        <div class="scheduled-today">
                            <h3 style="color: #00B2FF;">Scheduled Today</h3>
                            <ul class="date">
                                <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                        <div class="inprocess-button">
                            <a href="#"><button style="background-color: #00B2FF;" class="process">Schedule</button></a>
                            <p>Hired On 23rd August 2023</p>
                    </div>
                </div>
            </div>
            <div class="services-selected">
              <ul>
                <li>
                  <em><b style="color: #000;">Services Selected</b></em>
                  <span><img src="./images/servicecheck.png"/> Snow Removal</span>
                  <span><img src="./images/servicecheck.png"/> Grass Cutting</span>
                  <span><img src="./images/servicecheck.png"/> Spring Cleanup</span>
                </li>
              </ul>
            </div>
            <div class="row align-items-center advancebookingschedule">
              <table style="padding: 20px;">
                <tr  style="margin-bottom:10px;">
                  <th width="85%">Advance Booking Timings</th>
                  <th width="15%">Status</th>
                </tr>
                <tr  style="margin-bottom:10px;"> 
                  <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                  <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled</button></a></td>
                </tr>
                <tr  style="margin-bottom:10px;">
                  <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                  <td width="15%"><a href="#"><button style="background-color: #00B2FF;"  class="process">Scheduled </button></a></td>
                </tr>
                <tr>
                  <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                  <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
                </tr>
               
              </table>

              <div class="reschedule-detailsbuton">
                <ul>
                  <li>
                    <a href="#"><button style="background-color: #70BE44; color: #fff;">Give us Review</button></a>
                  </li>
                  <li>
                    <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                       background-color: #fff; color: #70BE44;">View Details</button></a>
                  </li>
                </ul>
              </div>
      </div>
        </div>

        <!-- SECOND SCHEDULE ROW START -->

        <div class="inprogressadvancebooking-box" style="margin-top: 60px;">
          <div class="row align-items-center">
              <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                  <div class="prf-imgwithtext">
                      <img src="./images/hiring/hiring1.png"/>
                     <h2> David Johnson</h2>
                     <p>Garden Maintenance</p>
                  </div>
              </div>
              <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                  <div class="scheduled-today">
                      <h3 style="color: #00B2FF;">Scheduled Today</h3>
                      <ul class="date">
                          <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                      </ul>
                  </div>
              </div>
              <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                  <div class="inprocess-button">
                    <a href="#"><button style="background-color: #00B2FF;" class="process">Schedule</button></a>
                      <p>Hired On 23rd August 2023</p>
              </div>
          </div>
      </div>
      <div class="services-selected">
        <ul>
          <li>
            <em><b style="color: #000;">Services Selected</b></em>
            <span><img src="./images/servicecheck.png"/> Snow Removal</span>
            <span><img src="./images/servicecheck.png"/> Grass Cutting</span>
            <span><img src="./images/servicecheck.png"/> Spring Cleanup</span>
          </li>
        </ul>
      </div>
      <div class="row align-items-center advancebookingschedule">
        <table style="padding: 20px;">
          <tr  style="margin-bottom:10px;">
            <th width="85%">Advance Booking Timings</th>
            <th width="15%">Status</th>
          </tr>
          <tr  style="margin-bottom:10px;"> 
            <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled</button></a></td>
          </tr>
          <tr  style="margin-bottom:10px;">
            <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #00B2FF;"  class="process">Scheduled </button></a></td>
          </tr>
          <tr>
            <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
          </tr>
         
        </table>

        <div class="reschedule-detailsbuton">
          <ul>
            <li>
              <a href="#"><button style="background-color: #70BE44; color: #fff;">Give us Review</button></a>
            </li>
            <li>
              <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                 background-color: #fff; color: #70BE44;">View Details</button></a>
            </li>
          </ul>
        </div>
</div>
  </div>

        <!-- SECOND SCHEDULE ROW END -->

        <!-- THIRD SCHEDULE ROW START -->
        <div class="inprogressadvancebooking-box" style="margin-top: 60px;">
          <div class="row align-items-center">
              <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                  <div class="prf-imgwithtext">
                      <img src="./images/hiring/hiring1.png"/>
                     <h2> David Johnson</h2>
                     <p>Garden Maintenance</p>
                  </div>
              </div>
              <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                  <div class="scheduled-today">
                      <h3 style="color: #00B2FF;">Scheduled Today</h3>
                      <ul class="date">
                          <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                      </ul>
                  </div>
              </div>
              <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                  <div class="inprocess-button">
                    <a href="#"><button style="background-color: #00B2FF;" class="process">Schedule</button></a>
                      <p>Hired On 23rd August 2023</p>
              </div>
          </div>
      </div>
      <div class="services-selected">
        <ul>
          <li>
            <em><b style="color: #000;">Services Selected</b></em>
            <span><img src="./images/servicecheck.png"/> Snow Removal</span>
            <span><img src="./images/servicecheck.png"/> Grass Cutting</span>
            <span><img src="./images/servicecheck.png"/> Spring Cleanup</span>
          </li>
        </ul>
      </div>
      <div class="row align-items-center advancebookingschedule">
        <table style="padding: 20px;">
          <tr  style="margin-bottom:10px;">
            <th width="85%">Advance Booking Timings</th>
            <th width="15%">Status</th>
          </tr>
          <tr  style="margin-bottom:10px;"> 
            <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #70BE44;" class="process">Completed</button></a></td>
          </tr>
          <tr  style="margin-bottom:10px;">
            <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #70BE44;"  class="process">Completed </button></a></td>
          </tr>
          <tr>
            <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
            <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
          </tr>
         
        </table>

        <div class="reschedule-detailsbuton">
          <ul>
            <li>
              <a href="#"><button style="background-color: #70BE44; color: #fff;">Give us Review</button></a>
            </li>
            <li>
              <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                 background-color: #fff; color: #70BE44;">View Details</button></a>
            </li>
          </ul>
        </div>
</div>
  </div>
        <!-- THIRD SCHEDULE ROW END -->
            </div>
            
        
    </div>
</div>
</div>
</section>


<!-- Start end -->



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
