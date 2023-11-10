<?php
session_start();
// Function to get customer information from the provider_registration table
function getCustomerInfo($customerId) {
  global $conn;
  $sql = "SELECT fullname, profile_picture, address FROM provider_registration WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $customerId);
  if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          return $row;
      }
  }
  return array('fullname' => 'N/A', 'address' => 'N/A', 'profile_picture' => 'N/A'); // Provide default values if customer info not found
}
// Function to get the price of a service from the categories table
function getCustomerServicesAndPrices($customerId, $proposalId) {
  global $conn;
  $sql = "SELECT service_name, price, counter_price FROM customer_services WHERE customer_id = ? AND proposal_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $customerId, $proposalId);

  if ($stmt->execute()) {
      $result = $stmt->get_result();
      $servicesAndPrices = array();

      while ($row = $result->fetch_assoc()) {
          $serviceCustomers = $row['service_name'];
          $priceService = $row['price'];
          $counterPrice = $row['counter_price'];
          $servicesAndPrices[] = array('service_name' => $serviceCustomers, 'price' => $priceService, 'counter_price' => $counterPrice);
          // print_r($servicesAndPrices);
      }

      return $servicesAndPrices;
  }

  return array();
}
function getServicePrice($service) {
    global $conn;
    $sql = "SELECT price FROM customer_services WHERE service_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $service);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['price'];
        }
    }
    return 'N/A'; // Provide a default value if service price not found
  }
  function getCustomerImagesForProvider($customerId, $providerId, $proposalId) {
    global $conn;
    $sql = "SELECT image_path FROM customer_images WHERE customer_id = ? AND provider_id = ? AND proposal_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $customerId, $providerId, $proposalId);
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $images = array();
      while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_path'];
      }
      return $images;
    }
    return array();
  }


function getServiceImages($service) {
  global $conn;
  $servicesImages = array();

  // Create a prepared statement to select servicesImages based on service names
  $sql = "SELECT image FROM categories WHERE heading IN (?)";
  $stmt = $conn->prepare($sql);

  if ($stmt) {
      $categories = implode("', '", $service); // Assuming service names are in an array
      $stmt->bind_param('s', $categories);

      if ($stmt->execute()) {
          $result = $stmt->get_result();

          while ($row = $result->fetch_assoc()) {
              $servicesImages[] = $row['image'];
          }
      }
  }

  return $servicesImages;
}
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
     
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php
      include 'SideMenu.php'
      ?>
      <!-- partial -->
      <div class="main-panel">
        <!-- MAIN PANEL ROW START -->
        <div class="order-in-progress">
            <h1><b style="color: #70BE44;">Scheduled</b> Order</h1>
            <div class="onetime-advancebokingbutton">
              <ul>
                <li><a href="schedule-order.php"><button style="color: #fff; background-color: #70BE44;">One Time Service</button></a></li>
                <li><a href="schedule-orders-advancebooking.php"><button style="color: #959595; background-color: #E6E6E6;">Advance Bookings</button></a></li>
              </ul>
            </div>
           
        <!-- MAIN PANEL ROW END -->

        <!-- SECOND MAIN ROW START -->
        <!-- MAIN PANEL ROW START -->
        
        <div>
        <div class="inprogressadvancebooking-box" style="margin-top: 60px;">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                    <div class="prf-imgwithtext">
                        <img src="./images/user.png">
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
              <th width="85%">Advance Booking Timings</th>
              <th width="15%">Status</th>
            </tr>
            <tr style="margin-bottom:10px;"> 
              <td width="85%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
              <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
            </tr>
            <tr style="margin-bottom:10px;">
              <td width="85%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
              <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
            </tr>
            <tr>
              <td width="85%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
              <td width="15%"><a href="#"><button style="background-color: #00B2FF;" class="process">Scheduled </button></a></td>
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
        <!-- MAIN PANEL ROW END -->
        <!-- SECOND MAIN ROW END -->
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