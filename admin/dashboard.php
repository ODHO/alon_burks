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
  <div class="container-scroller">
    <?php include 'header.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
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
      <!-- partial:partials/_sidebar.html -->
      <?php include 'SideMenu.php'; ?>

      <!-- partial -->
      <div class="main-panel">
        <!-- START ROW MAIN-PANEL -->
        <div class="row">
            <!-- main column 8 -->
            <div class="col-md-8"> 
              <div class="dasboard-heading">
            <div class="row">
              <div class="col-md-3">
                <p><b>Basic Seller Package</b><br>
                  Monthly</p>
              </div>
              <div class="col-md-3">
                <p><b>Subscribe Date</b><br>
                  20-June-2023</p>
              </div>
              <div class="col-md-3">
                <p><b>Expiry Date</b><br>
                  20-July-2023</p>
              </div>
              <div class="col-md-3">
                <p><b>Upgrade to pro</b><br>
                  <a href="#"><button>Renew plan</button></a></p>
              </div>
            </div>
          </div>

          <div class="milestone-calculation">
            <div class="row">
              <div class="col-md-3">
                <h2>
                  Completed Orders
                </h2>
                <div class="mile">
                  <h2>20</h2>
                  <select id='gMonth2' onchange="show_month()">
                    <option value=''>--Select Month--</option>
                    <option selected value='1'>Janaury</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                    </select> 
                </div>
              </div>
              <div class="col-md-3">
                <h2>
                  Offers
                </h2>
                <div class="mile">
                  <h2>20</h2>
                  <select id='gMonth2' onchange="show_month()">
                    <option value=''>--Select Month--</option>
                    <option selected value='1'>Janaury</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                    </select> 
                </div>
              </div>
              <div class="col-md-6">
                <h2>
                  Earnings
                </h2>
                <div class="mile">
                  <h2>$ 680.00</h2>
                  <a href="#"><button>Withdraw</button></a>
                </div>
              </div>
            </div>
          </div>

          <div class="order-in-progress" style="position: relative;">
            <h1><b style="color: #70BE44;">Order</b> In Progress</h1>
            <div class="onetime-advancebokingbutton">
              <ul>
                <li><a href="#"><button style="color: #fff; background-color: #70BE44;">One Time Service</button></a></li>
                <li><a href="#"><button style="color: #959595; background-color: #E6E6E6;">Advance Bookings</button></a></li>
              </ul>
            </div>
            <div class="progress-profile">
              <div class="row">
                <div class="col-md-9">
                  <div class="progress-profile-detail">
                    <ul>
                      <li class="profile-name"><h5><img src="./images/homee.png"/><b>Danny </b><br>userID#321</h5></li>
                      <li><h5><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd <br>Street,
                        House No- B-242</h5></li>
                        <li><h5><img src="./images/time.png"/> 21, August,4:00 <br>AM, SUN</h5></li>
                    </ul>
                  </div>

                  <div class="services-needed">
                    <ul>
                      <li><h4>Services Needed</h4></li>
                      <li>Snow removal <img src="./images/check.png"/></li>
                      <li>Grass Cutting <img src="./images/check.png"/></li>
                      <li class="number">2</li>
                    </ul>
                  </div>

                  <div class="progress-notify">
                    <h2>Hey! I want to remove all the snow from my garden and want a full service garden mainteniance.</h2>
                  </div>

                  <div class="viewgallery">
                    <a href="#/" class="viewbuttn">View More <img src="./images/dropdown.png"/></a>
                    <div class="progress-gallery">
                      <ul>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                      </ul>
                    </div>
                  </div>

                  


                </div>
                <div class="col-md-3">
                  <div class="verification" style="width: 100%;">
                    <h3>Customer Verification</h3>
                    <a href="#"><button>Verified</button></a>
                  </div>
                  
                  <div class="service-status" style="width: 100%;">
                    <h3>Service Status</h3>
                    <select id='gMonth2' onchange="show_month()">
                      <option value=''>--Select Status--</option>
                      <option selected value='1'>Working</option>
                      <option value='2'>Not-Working</option>
                      </select> 
                  </div>
                </div>
              </div>
            </div>

            <!-- SECOND PROGRESS PROFILE -->
            <div class="progress-profile">
              <div class="row">
                <div class="col-md-9">
                  <div class="progress-profile-detail">
                    <ul>
                      <li class="profile-name"><h5><img src="./images/homee.png"/><b>Danny </b><br>userID#321</h5></li>
                      <li><h5><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd <br>Street,
                        House No- B-242</h5></li>
                        <li><h5><img src="./images/time.png"/> 21, August,4:00 <br>AM, SUN</h5></li>
                    </ul>
                  </div>

                  <div class="services-needed">
                    <ul>
                      <li><h4>Services Needed</h4></li>
                      <li>Snow removal <img src="./images/check.png"/></li>
                      <li>Grass Cutting <img src="./images/check.png"/></li>
                      <li class="number">2</li>
                    </ul>
                  </div>

                  <div class="progress-notify">
                    <h2>Hey! I want to remove all the snow from my garden and want a full service garden mainteniance.</h2>
                  </div>

                  <div class="viewgallery">
                    <a href="#/" class="viewbuttn">View More <img src="./images/dropdown.png"/></a>
                    <div class="progress-gallery">
                      <ul>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                      </ul>
                    </div>
                  </div>

                  


                </div>
                <div class="col-md-3">
                  <div class="verification" style="width: 100%;">
                    <h3>Customer Verification</h3>
                    <a href="#"><button>Verified</button></a>
                  </div>
                  
                  <div class="service-status" style="width: 100%;">
                    <h3>Service Status</h3>
                    <select id='gMonth2' onchange="show_month()">
                      <option value=''>--Select Status--</option>
                      <option selected value='1'>Working</option>
                      <option value='2'>Not-Working</option>
                      </select> 
                  </div>
                </div>
              </div>
            </div>

            <!-- THIRD PROGRESS PROFILE -->
            <div class="progress-profile">
              <div class="row">
                <div class="col-md-9">
                  <div class="progress-profile-detail">
                    <ul>
                      <li class="profile-name"><h5><img src="./images/homee.png"/><b>Danny </b><br>userID#321</h5></li>
                      <li><h5><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd <br>Street,
                        House No- B-242</h5></li>
                        <li><h5><img src="./images/time.png"/> 21, August,4:00 <br>AM, SUN</h5></li>
                    </ul>
                  </div>

                  <div class="services-needed">
                    <ul>
                      <li><h4>Services Needed</h4></li>
                      <li>Snow removal <img src="./images/check.png"/></li>
                      <li>Grass Cutting <img src="./images/check.png"/></li>
                      <li class="number">2</li>
                    </ul>
                  </div>

                  <div class="progress-notify">
                    <h2>Hey! I want to remove all the snow from my garden and want a full service garden mainteniance.</h2>
                  </div>

                  <div class="viewgallery">
                    <a href="#/" class="viewbuttn">View More <img src="./images/dropdown.png"/></a>
                    <div class="progress-gallery">
                      <ul>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                        <li><img src="./images/feature.png"></li>
                      </ul>
                    </div>
                  </div>

                  


                </div>
                <div class="col-md-3">
                  <div class="verification" style="width: 100%;">
                    <h3>Customer Verification</h3>
                    <a href="#"><button>Verified</button></a>
                  </div>
                  
                  <div class="service-status" style="width: 100%;">
                    <h3>Service Status</h3>
                    <select id='gMonth2' onchange="show_month()">
                      <option value=''>--Select Status--</option>
                      <option selected value='1'>Working</option>
                      <option value='2'>Not-Working</option>
                      </select> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- MAIN COLUMN 8 END -->
            </div>


            <!-- MAIN -COLUMNS 4 -->
            <div class="col-md-4">
                <div class="service-statistics">
                  <h2><b style="color: #70BE44;">Service</b> Statistics</h2>
                  <ul class="statistics-list">
                    <li><img src="./images/doubletick.png"/><em>Completed task</em><span>2</span></li>
                    <li><img src="./images/time.png"/><em>Today’s Job Hours</em><span style="color: #70BE44;">5:45</span></li>
                    <li><img src="./images/star.png"/><em>Job Success</em><span style="color: red;">10%</span></li>
                  </ul>
                  <h2><b style="color: #70BE44;">Recent</b> Feedbacks</h2>
                  <div class="services-feedbacks">
                    <img src="./images/profileman.png"/>
                    <h4>Mick taison is available for the job with his expertise skills</h4>
                    <ul class="feedback-date-category">
                      <li>1 hours ago</li>
                      <li style="color: #227A4E;">Window Tint, Mechanic , Tuning .</li>
                    </ul>
                  </div>
                  <div class="services-feedbacks">
                    <img src="./images/profileman.png"/>
                    <h4>Mick taison is available for the job with his expertise skills</h4>
                    <ul class="feedback-date-category">
                      <li>1 hours ago</li>
                      <li style="color: #227A4E;">Window Tint, Mechanic , Tuning .</li>
                    </ul>
                  </div>
                </div>
                <!-- Schedule tasks -->
                <div class="schedule-tasks-progress">
                  <h2><b style="color: #70BE44;">Scheduled</b> Tasks</h2>
                  <div class="task-list">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="profilename">
                          <img src="./images/profileman.png"/>
                          <h5>Danny <br><span>userID#321</span></h5>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h6>23rd September<br><span>02:00 PM</span></h6>
                      </div>
                    </div>
                  </div>
                  <!-- 2ND TASK LIST -->
                  <div class="task-list">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="profilename">
                          <img src="./images/profileman.png"/>
                          <h5>Danny <br><span>userID#321</span></h5>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h6>23rd September<br><span>02:00 PM</span></h6>
                      </div>
                    </div>
                  </div>

                  <!-- 3RD TASK LIST -->
                  <div class="task-list">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="profilename">
                          <img src="./images/profileman.png"/>
                          <h5>Danny <br><span>userID#321</span></h5>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h6>23rd September<br><span>02:00 PM</span></h6>
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
<script>
  $(document).ready(function(){
		$(".viewbuttn").on("click",function(){
			var $this = $(this);
			$this.next().slideToggle();
			if($this.text() === "View More"){
				$this.text("Close");
			}else{
			  $this.text("View More");
			}
		})
	});
</script>