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
<body>
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
        <!-- START ROW MAIN-PANEL -->
        <div class="row">

        
          <div class="order-in-progress">
            <h1><b style="color: #70BE44;">Complete </b>Order</h1>
            <div class="onetime-advancebokingbutton">
              <ul>
                <li><a href="#"><button style="color: #fff; background-color: #70BE44;">One Time Service</button></a></li>
                <li><a href="#"><button style="color: #959595; background-color: #E6E6E6;">Advance Bookings</button></a></li>
              </ul>
            </div>
            <?php
            include 'connection.php';

            $userId = $_SESSION['user_id'];
            $providerName = $_SESSION['providerName'];

            $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND status = 'completed' ORDER BY current_time DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $userId);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 0) {
                  // No orders found for the provider
                  echo '<h2 class="text-center texter">No completed orders available.</h2>';
              } else {
          while ($row = $result->fetch_assoc()) {
              $proposalId = $row['id'];
              $customerId = $row['customer_id'];
              $providerId = $row['provider_id'];
              $selectedDate = $row['selected_date'];
              $selectedTime = $row['selected_time'];
              $userContent = $row['user_content'];
              $selectedServices = explode(', ', $row['selected_services']);
              $totalAmount = $row['total_amount'];
              $current_time = $row['current_time'];
              $counterTotall = $row['counter_totall'];

              // Retrieve customer name and address based on customerId
              $customerInfo = getCustomerInfo($customerId);

              $customerImages = getCustomerImagesForProvider($customerId, $userId, $proposalId);
              $serviceCustomers = getCustomerServicesAndPrices($customerId, $proposalId);
              $serviceCustomers1 = getCustomerServicesAndPrices($customerId, $proposalId);
              
              
              // Now you have an array containing the selected services and their prices for the customer
              
              // Output the retrieved customer name and address
              $customerName = $customerInfo['fullname'];
              $customerAddress = $customerInfo['address'];
              $profile_picture = $customerInfo['profile_picture'];
            ?>
            <!-- FIRST PROGRESS PROFILE -->
           
            <!-- FIRST PROGRESS PROFILE -->
            <div class="progress-profile">
              <div class="row">
                <div class="col-md-9">
                  <div class="progress-profile-detail">
                    <ul class="paid">
                      <li class="profile-name"><h5><img src="./images/homee.png"/><b><?php echo $customerName?></b><br>userID#<?php echo $customerId?></h5></li>
                      <li><h5><img src="./images/mappin.png"/><?php echo $customerAddress?></h5></li>
                        <li><h5><img src="./images/time.png"/>  <?php echo $selectedDate , str_repeat('&nbsp;', 5), $selectedTime?></h5></li>
                    </ul>
                  </div>

                  <div class="services-needed">
                    <ul>
                      <li><h4>Services Needed</h4></li>
                      < <?php foreach ($selectedServices as $service) { ?>
                            <li><?php echo $service; ?> <img src="./images/check.png"/></li>
                        <?php } ?>
                        <li class="number"><?php echo count($selectedServices); ?></li>
                    </ul>
                  </div>

                  <div class="progress-notify">
                    <h2><?php echo $userContent?></h2>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="verification" style="width: 100%;">
                    <h3>Customer Verification </h3>
                    <a href="#"><button>Paid</button></a>
                  </div>
                  <div class="verification" style="width: 100%;">
                    <h3>Service Status </h3>
                    <a href="#"><button>Completed</button></a>
                  </div>
                  
                  
                </div>

                
                <div class="viewgallery">
                    <a href="#/" class="viewbuttn">View More <img src="./images/dropdown.png"/></a>
                    <div class="progress-gallery">
                        <div class="row">
                        
                          <div class="col-md-7">
                            <div class="order-details-progress">
                              <h2>Order details</h2>
                              <ul class="orderdetails-lists">
                              <?php $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                          foreach ($serviceCustomers as $servicenew) {
                              $services = $servicenew['service_name'];
                              $servicePrice = $servicenew['price'];
                              
                              // Check if counter service price is available
                              if (isset($servicenew['counter_price'])) {
                                  $counterPrice = $servicenew['counter_price'];
                              } else {
                                  // If counter price is not available, use the original service price
                                  $counterPrice = $servicePrice;
                              }
                        ?>
                            <li>
                                <em><?php echo $services ?></em>
                                <span style="color: #70BE44;">$<?php echo $counterPrice ?></span>
                            </li>
                        <?php } ?>
                                <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ <?php echo $displayTotal?></b></span></li>
                              </ul>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <div class="service-rated">
                                <h2>Service Rated</h2>
                                <img src="./images/starrating.png" width="100%"/>
                                <h3>Your Feedback matter to us</h3>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                                    and more recently with desktop publishing software like Aldus PageMaker
                                     including versions of Lorem Ipsum.</p>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <?php
            }
  }
} else {
  echo 'Error executing the query.';
}
?>


         


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