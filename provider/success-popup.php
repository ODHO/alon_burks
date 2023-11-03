<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- GOOGLE FONTS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Aaron Burks  </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Modal popup -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/sitelogo-singup.png" />
</head>
<body>
    <div class="congrats">
        <div class="innercongrats">
            <img src="./images/successcheck.png" width="100px"/>
            <h2 style="color: #333; padding-top: 20px;"><b>Your Offer Sent Successfully, now this offer<br> is in Pending Offers</b></h2>
        </div>
    </div>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.php -->
    <?php 
     include 'header.php'
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.php -->
      <!-- <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border me-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border me-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
           <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div> 
        </div>
      </div> -->
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
              </ul>
            </div>
            <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 11 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
              <p class="text-gray mb-0">The total number of sessions</p>
            </div>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 7 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
              <p class="text-gray mb-0 ">Call Sarah Graves</p>
            </div>
          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <div class="wrapper d-flex">
                    <p>Catherine</p>
                  </div>
                  <p>Away</p>
                </div>
                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                <small class="text-muted my-auto">23 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Sarah Graves</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">47 min</small>
              </li>
            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php
      include 'SideMenu.php'
      ?>
      <!-- partial -->
      <div class="main-panel">
        <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title">Your Counter Offer For the services</h4>
        </div>
        <div class="modal-body">
          <ul class="services-selected-counteroffer">
            <li><em><img src="./images/counteroffer/1.png"/> Snow Removal</em><span>$ 100.00</span></li>
            <li><em><img src="./images/counteroffer/2.png"/> Spring Cleanup</em><span>$ 100.00</span></li>
            <li><em><img src="./images/counteroffer/3.png"/> Grass Cutting</em><span>$ 100.00</span></li>
            <li class="totalcharges"><em><img src="./images/counteroffer/4.png"/> Total Charges</em><span>$300</span></li>   
          </ul>
          <ul class="percent-counter">
            <li><em>Platform Charges</em><span>10%</span></li>
            <li><em>Your will Earn</em><span>$270</span></li>
          </ul>
          <div class="text-area-counter">
            <h2>Note To support Your Counter Offer</h2>
            <textarea></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Send</button>
        </div>
      </div>
      
    </div>
  </div>
        <!-- START ROW MAIN-PANEL -->
        <div class="row">

        
          <div class="order-in-progress">
            <h1><b style="color: #70BE44;">New </b>Offers</h1>
            <!-- FIRST NEW OFFER -->
        <div class="first-offer">
            <div class="profileheadsection">
            <div class="row">
                <div class="col-md-3">
                    <div class="offerprofile-name">
                        <img src="./images/profileman.png"/>
                        <h3>David Johnson<br><b>User ID # 4ISK4DH</b></h3>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <h3 class="address"><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd Street,
                        House No- B-242</h3>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <h6 style="color: #4492BE;"><img src="./images/scheduled.png"/> 21, August,4:00 AM, SUN</h6>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <h4 style="color: #70BE44;">Offered On 22,August,2022</h4>
                </div>
            </div>
        </div>

        <div class="service-selectedsection">
            <div class="row">
                <div class="col-md-6">
                    <div class="order-details-progress">
                        <h2>Order details</h2>
                        <ul class="orderdetails-lists">
                          <li><em>Lawn mowing</em><span style="color: #70BE44;">$ 100.00</span></li>
                          <li><em>Snow Removal</em><span style="color: #70BE44;">$ 100.00</span></li>
                          <li><em>Grass Cutting</em><span style="color: #70BE44;">$ 100.00</span></li>
                          <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ 300.00</b></span></li>
                        </ul>
                      </div>
                </div>
                <div class="col-md-6">
                    <h6>Task Description</h6>
                    <p>I'm Stuck at Norway highway near Crown valley street, I 
                        have to wash & tint my car as soon as possible because 
                        of this extreme sunny weather. kindly come fast ASAP 
                        I'm waiting for your service. </p>
                </div>
            </div>
        </div>

        <div class="location-images-section">
            <h2>Location Images </h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="location-images">

                        <ul class="gallery-images">
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>

                        </ul>
                      </div>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>

        <div class="buttons-newoffers" style="padding: 30px 0px;">
            <div class="row">
                <div class="col-md-6">
                    <a href="#/"><button type="button" data-toggle="modal" data-target="#myModal">Counter Offer</button></a>
                </div>
                <div class="col-md-6">
                    <a class="ignore1" href="#"><button>Ignore</button></a>
                </div>
            </div>

          </div>

</div>
           <!--  SECOND NEWOFFER -->
           <div class="first-offer" style="margin-top: 20px;">
            <div class="profileheadsection">
            <div class="row">
                <div class="col-md-3">
                    <div class="offerprofile-name">
                        <img src="./images/profileman.png"/>
                        <h3>David Johnson<br><b>User ID # 4ISK4DH</b></h3>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <h3 class="address"><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd Street,
                        House No- B-242</h3>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <h6 style="color: #4492BE;"><img src="./images/scheduled.png"/> 21, August,4:00 AM, SUN</h6>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <h4 style="color: #70BE44;">Offered On 22,August,2022</h4>
                </div>
            </div>
        </div>

        <div class="service-selectedsection">
            <div class="row">
                <div class="col-md-6">
                    <div class="order-details-progress">
                        <h2>Order details</h2>
                        <ul class="orderdetails-lists">
                          <li><em>Lawn mowing</em><span style="color: #70BE44;">$ 100.00</span></li>
                          <li><em>Snow Removal</em><span style="color: #70BE44;">$ 100.00</span></li>
                          <li><em>Grass Cutting</em><span style="color: #70BE44;">$ 100.00</span></li>
                          <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ 300.00</b></span></li>
                        </ul>
                      </div>
                </div>
                <div class="col-md-6">
                    <h6>Task Description</h6>
                    <p>I'm Stuck at Norway highway near Crown valley street, I 
                        have to wash & tint my car as soon as possible because 
                        of this extreme sunny weather. kindly come fast ASAP 
                        I'm waiting for your service. </p>
                </div>
            </div>
        </div>

        <div class="location-images-section">
            <h2>Location Images </h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="location-images">

                        <ul class="gallery-images">
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>
                          <li>
                            <img src="./images/feature.png"/>
                          </li>

                        </ul>
                      </div>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>

        <div class="buttons-newoffers" style="padding: 30px 0px;">
            <div class="row">
                <div class="col-md-6">
                  <a href="#/"><button type="button" data-toggle="modal" data-target="#myModal">Counter Offer</button></a>
                </div>
                <div class="col-md-6">
                    <a class="ignore1" href="#"><button>Ignore</button></a>
                </div>
            </div>

          </div>


         

</div>

<!-- THIRD NEW OFFER -->
<div class="first-offer" style="margin-top: 20px;">
    <div class="profileheadsection">
    <div class="row">
        <div class="col-md-3">
            <div class="offerprofile-name">
                <img src="./images/profileman.png"/>
                <h3>David Johnson<br><b>User ID # 4ISK4DH</b></h3>
            </div>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <h3 class="address"><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd Street,
                House No- B-242</h3>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <h6 style="color: #4492BE;"><img src="./images/scheduled.png"/> 21, August,4:00 AM, SUN</h6>
        </div>
        <div class="col-md-3 d-flex align-items-center">
            <h4 style="color: #70BE44;">Offered On 22,August,2022</h4>
        </div>
    </div>
</div>

<div class="service-selectedsection">
    <div class="row">
        <div class="col-md-6">
            <div class="order-details-progress">
                <h2>Order details</h2>
                <ul class="orderdetails-lists">
                  <li><em>Lawn mowing</em><span style="color: #70BE44;">$ 100.00</span></li>
                  <li><em>Snow Removal</em><span style="color: #70BE44;">$ 100.00</span></li>
                  <li><em>Grass Cutting</em><span style="color: #70BE44;">$ 100.00</span></li>
                  <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ 300.00</b></span></li>
                </ul>
              </div>
        </div>
        <div class="col-md-6">
            <h6>Task Description</h6>
            <p>I'm Stuck at Norway highway near Crown valley street, I 
                have to wash & tint my car as soon as possible because 
                of this extreme sunny weather. kindly come fast ASAP 
                I'm waiting for your service. </p>
        </div>
    </div>
</div>

<div class="location-images-section">
    <h2>Location Images </h2>
    <div class="row">
        <div class="col-md-6">
            <div class="location-images">

                <ul class="gallery-images">
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>
                  <li>
                    <img src="./images/feature.png"/>
                  </li>

                </ul>
              </div>
        </div>
        <div class="col-md-6">
            
        </div>
    </div>
</div>

<div class="buttons-newoffers" style="padding: 30px 0px;">
    <div class="row">
        <div class="col-md-6">
          <a href="#/"><button type="button" data-toggle="modal" data-target="#myModal">Counter Offer</button></a>
        </div>
        <div class="col-md-6">
            <a class="ignore1" href="#"><button>Ignore</button></a>
        </div>
    </div>

  </div>


 

</div>

</div>
            <!-- END ROW MAIN-PANEL -->
        </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <script src="script.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
