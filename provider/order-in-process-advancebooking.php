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
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/sitelogo-singup.png" />
</head>
<body class="advancebooking">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
   <?php include 'header.php';?>
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
     <?php include 'SideMenu.php';?>
      <!-- partial -->
      <div class="main-panel">
        <!-- MAIN PANEL ROW START -->
        <div class="order-in-progress">
            <h1><b style="color: #70BE44;">Order</b> In Progress</h1>
            <div class="onetime-advancebokingbutton">
                <ul>
                  <li><a href="#"><button style="color: #959595; background-color: #E6E6E6;">One Time Service</button></a></li>
                  <li><a href="#"><button style="color: #fff; background-color: #70BE44;">Advance Bookings</button></a></li>
                </ul>
              </div>
        <div class="inprogressadvancebooking-box">
            <div class="row align-items-center">
                <div class="col-lg-3 mb-4 mb-lg-0 align-items-center">
                    <div class="prf-imgwithtext">
                        <img src="./images/user.png">
                       <h2> David Johnson</h2>
                       <p>Garden Maintenance</p>
                    </div>
                </div>
                <div class="col-lg-3 mb-2 mb-lg-0 align-items-center">
                  <div class="user-location">
                    <p><img src="./images/mappin.png"/>San Francisco, 5th Avenue 22nd Street, House No- B-242</p>
                  </div>
              </div>
                <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                    <div class="scheduled-today">
                        <h3 style="color: #00B2FF;">Scheduled Today</h3>
                        <ul class="date">
                            <li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                    <div class="inprocess-button">
                        <a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled Today</button></a>
                        <p>Hired On 23rd August 2023</p>
                </div>
            </div>
        </div>
        <div class="services-selected">
            <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0 align-items-center">
                <h2>Service Status</h2>
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0 align-items-center">
                <form action="">
                    <select name="status" id="status">
                      <option value="way">On the Way</option>
                      <option value="reached">Reached</option>
                    </select>

                  </form>
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0 align-items-center">
                <h2>Customer Verification</h2>
            </div>
            <div class="col-lg-3 mb-3 mb-lg-0 align-items-center">
                <a href="#"><button style="background-color: #70BE44; color: #fff;" class="verified">Verified</button></a>
            </div>
        </div>
        </div>

        <div class="row align-items-center advancebookingschedule">
          <table style="padding: 20px;">
            <tbody><tr style="margin-bottom:10px;">
              <th width="25%">Service Cost Offer</th>
              <th width="65%">Advance Booking Timings</th>
              <th width="10%">Status</th>
            </tr>
            <tr style="margin-bottom:10px;">
              <td width="25%"><li class="services-advance"><span><img src="./images/doubletick.png"/></span><strong> Snow Removal </strong><span><img src="./images/Snow Plow.png"/></span></li></td> 
              <td width="65%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
              <td width="10%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
            </tr>
            <tr style="margin-bottom:10px;">
              <td width="25%"><li class="services-advance"><span><img src="./images/doubletick.png"/></span><strong> Spring Cleanup </strong><span><img src="./images/Cover Up.png"/></span></li></td>
              <td width="65%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
              <td width="10%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
            </tr>
            <tr>
              <td width="25%"><li class="services-advance"><span><img src="./images/doubletick.png"/></span><strong> Grass Cutting </strong><span><img src="./images/Grass.png"/></span></li></td>
              <td width="65%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
              <td width="10%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
            </tr>
           
          </tbody></table>

          <div class="reschedule-detailsbuton">
            <ul>
              
              <li>
                <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                   background-color: #70BE44; color: #fff;">View Details</button></a>
              </li>
            </ul>
          </div>
  </div>
    </div>
        

       
    </div>
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
<style>
  .advancebookingschedule li.services-advance strong {
    padding: 0 13px;
}

.advancebookingschedule li.services-advance span img {
    width: 20px;
}
.advancebookingschedule li.services-advance span {
    float: unset;
}
.advancebookingschedule li.services-advance {
    background: #ff10 !important;
}
  .user-location p img {
      position: absolute;
      left: 0;
      top: 8px;
  }
  .user-location p {
      color: #090909;
      font-size: 16px;
      padding-left: 5px;
      line-height: 22px;
      font-family: 'Cairo';
  }
  </style>
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