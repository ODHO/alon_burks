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
    $sql = "SELECT service_name, counter_price, counter_totall, counter_note, price FROM customer_services WHERE customer_id = ? AND proposal_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $customerId, $proposalId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $servicesAndPrices = array();

        while ($row = $result->fetch_assoc()) {
            $serviceCustomers = $row['service_name'];
            $counterPrices = $row['counter_price'];
            $counterTotall = $row['counter_totall'];
            $counterNote = $row['counter_note'];
            $priceService = $row['price'];
            $servicesAndPrices[] = array('service_name' => $serviceCustomers, 'counter_price' => $counterPrices, 'counter_totall' => $counterTotall,'counter_note' => $counterNote, 'price' => $priceService);
            
        }

        return $servicesAndPrices;
    }

    return array('counter_note' => 'N/A');
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
function getCustomerImagesForProvider($customerId, $providerId) {
  global $conn;
  $sql = "SELECT image_path FROM customer_images WHERE customer_id = ? AND provider_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $customerId, $providerId);
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


function getServiceImages($services) {
  global $conn;
  $servicesImages = array();

  // Create a prepared statement to select service images based on service names
  $sql = "SELECT image FROM categories WHERE heading IN (";

  // Create placeholders for each service
  $placeholders = implode(',', array_fill(0, count($services), '?'));

  $sql .= $placeholders . ")";
  $stmt = $conn->prepare($sql);

  if ($stmt) {
      // Bind each service name to its corresponding placeholder
      foreach ($services as $index => $service) {
          $stmt->bind_param('s', $services[$index]);

          if ($stmt->execute()) {
              $result = $stmt->get_result();

              while ($row = $result->fetch_assoc()) {
                  $servicesImages[] = $row['image'];
              }
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
        <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title">Your Counter Offer For the services</h4>
        </div>
        <div class="modal-body">
            <h1 style="color: #000; font-weight: bold; font-family: 'Cairo';">Customer Offer</h1>
            <div class="service-selectedsection">
                <div class="row">
                    <div class="col-md-7">
                        <div class="order-details-progress">
                            <h2>Service Cost Offer</h2>
                            <ul class="orderdetails-lists">
                              <li><em><img src="./images/Snow Plow.png"> Snow Removal</em><span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em><img src="./images/Cover Up.png"> Spring Cleanup</em><span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em><img src="./images/Grass.png"> Grass Cutting</em><span style="color: #70BE44;">$ 100.00</span></li>
                              <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ 300.00</b></span></li>
                            </ul>
                          </div>
                    </div>
                    <div class="col-md-5">
                        <h2>Advance Booking Timings</h2>
                        <table style="padding: 20px;">
                            <tbody><tr style="margin-bottom:10px;">
                              <th width="100%"></th>
                            </tr>
                            <tr style="margin-bottom:10px;"> 
                              <td width="100%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                            <tr style="margin-bottom:10px;">
                              <td width="100%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                            <tr>
                              <td width="100%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                           
                          </tbody></table>
                    </div>
                   
    
                
                </div>
                <!-- second row start -->
                <div class="row">
                    <h1 style="color: #000; font-weight: bold; font-family: 'Cairo';">Your Counter</h1>
                    <div class="col-md-7">
                        <div class="order-details-progress">
                            <h2>Service Cost Offer</h2>
                            <ul class="orderdetails-lists">
                              <li><em><img src="./images/Snow Plow.png"> Snow Removal</em><span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em><img src="./images/Cover Up.png"> Spring Cleanup</em><span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em><img src="./images/Grass.png"> Grass Cutting</em><span style="color: #70BE44;">$ 100.00</span></li>
                              <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ 300.00</b></span></li>
                            </ul>
                          </div>
                    </div>
                    <div class="col-md-5">
                        <h2>Counter Booking Timings</h2>
                        <table style="padding: 20px;">
                            <tbody><tr style="margin-bottom:10px;">
                              <th width="100%"></th>
                            </tr>
                            <tr style="margin-bottom:10px;"> 
                              <td width="100%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                            <tr style="margin-bottom:10px;">
                              <td width="100%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                            <tr>
                              <td width="100%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                           
                          </tbody></table>
                    </div>
                    <div class="task-description">
                    <h2>Counter Reasoning </h2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                         Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                          when an unknown printer took a galley of type and scrambled it to make a type 
                          specimen book. It has survived not only five centuries, but also the leap into 
                          electronic typesetting, remaining essentially unchanged. It was popularised in 
                          the 1960s with the release of Letraset</p>
                </div>
                </div>
                <!-- second row end your counter offer -->
            </div>
        </div>
        <div class="modal-footer">
         <a href="success-popup.php"> <button>Send Counter</button></a>
        </div>
      </div>
      
    </div>
  </div>
        <!-- START ROW MAIN-PANEL -->
        <div class="row">
          <div class="order-in-progress">
            <h1><b style="color: #70BE44;">Replied </b>Offers</h1>
            <div class="onetime-advancebokingbutton">
              <ul>
                <li><a href="#"><button style="color: #959595; background-color: #E6E6E6;">One Time Service</button></a></li>
                <li><a href="#"><button style="color: #fff; background-color: #70BE44;">Advance Bookings</button></a></li>
              </ul>
            </div>
            <!-- FIRST NEW OFFER -->
      <?php
          include 'connection.php';
          $userId = $_SESSION['user_id'];
          $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND status = 'replied_offer' AND proposal_status = 'AdvancedProposal'";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('s', $userId);
          if ($stmt->execute()) {
              $result = $stmt->get_result();
              if ($result->num_rows == 0) {
                // No orders found for the provider
                echo '<h2 class="text-center texter">No new orders available.</h2>';
            } else {
        while ($row = $result->fetch_assoc()) {
            $proposalId = $row['id'];
            $customerId = $row['customer_id'];
            $providerId = $row['provider_id'];
            $selectedDate = explode(', ', $row['selected_date']);
            $selectedTime = explode(', ', $row['selected_time']);
            $userContent = $row['user_content'];
            $selectedServices = explode(', ', $row['selected_services']);
            $totalAmount = $row['total_amount'];
            $counterTotall = $row['counter_totall'];
            $current_time = $row['current_time'];
            $customerInfo = getCustomerInfo($customerId);
            $customerImages = getCustomerImagesForProvider($customerId, $userId);
            $serviceCustomers = getCustomerServicesAndPrices($customerId, $proposalId);
            $serviceCustomers1 = getCustomerServicesAndPrices($customerId, $proposalId);
            $serviceCustomers3 = getCustomerServicesAndPrices($customerId, $proposalId);
            $customerName = $customerInfo['fullname'];
            $customerAddress = $customerInfo['address'];
            $profile_picture = $customerInfo['profile_picture'];
            // $image_path = $customerImages['image_path'];
          ?>
          <div class="first-offer">
            <div class="profileheadsection">
              <div class="row">
                  <div class="col-md-3">
                    <div style="display:flex; gap:10px; align-items:center">
                        <div style="width:60px;height:60px;border-radius: 112px;margin-bottom:10px;">
                            <img style="width: 100%;object-fit: fill;height: 100%;border-radius: 118px;" src="../customer/<?php echo $profile_picture?>" />
                        </div>
                        <h3>
                            <?php echo $customerName?><br><b>User ID #
                                <?php echo $customerId?>
                            </b>
                        </h3>
                    </div>
                  </div>
                  <div class="col-md-3 d-flex align-items-center">
                      <!-- <h3 class="address"><img src="./images/mappin.png"/> San Francisco, 5th Avenue 22nd Street,
                          House No- B-242</h3> -->
                  </div>
                  <div class="col-md-3 d-flex align-items-center">
                      <!-- <h6 style="color: #4492BE;"><img src="./images/scheduled.png"/> 21, August,4:00 AM, SUN</h6> -->
                  </div>
                  <div class="col-md-3  align-items-center">
                      <div class="replied-button">
                          <a href="#"><button style="background-color: #00B2FF;">Pending</button></a><br>
                      </div>
                      <br><h4 style="color: #000; text-align: center;">Offered On <?php echo $current_time?></h4>
                  </div>
              </div>
            </div>

            <div class="service-selectedsection">
                <div class="row">
                    <div class="col-md-7">
                        <div class="order-details-progress">
                            <h2>Counter Service Offer</h2>
                            
                            <ul class="orderdetails-lists">
                            <?php foreach ($serviceCustomers1 as $servicenew) {
                            $services = $servicenew['service_name'];
                            $counterPrice = $servicenew['counter_price'];
                            $serviceImages = getServiceImages([$services]);
                            // echo $serviceCustomers; echo "<br/>";
                            // echo $servicePrice;echo "<br/>";
                          ?>
                          <li><em><img src="../admin/uploads/<?php echo $serviceImages[0]?>"/> <?php echo $services ?></em><span style="color: #70BE44;">$ <?php echo $counterPrice?></span></li>
                            
                          <?php } ?>
                          <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ <?php echo $counterTotall?></b></span></li>
                       
                            </ul>
                          </div>
                    </div>
                    <div class="col-md-5">
                        <h2>Advance Booking Timings</h2>
                        <table style="padding: 20px;">
                            <tbody><tr style="margin-bottom:10px;">
                              <th width="100%"></th>
                            </tr>
                            <tr style="margin-bottom:10px;"> 
                              <td width="100%" class="date-inner">
                                  <?php foreach ($selectedDate as $key => $date): ?>
                                      <li><em><?php echo date('d-M-Y , D', strtotime($date)); ?></em><span><?php echo $selectedTime[$key]; ?></span></li>
                                  <?php endforeach; ?>
                                </td>
                              </tr>
                            <!-- <tr style="margin-bottom:10px;">
                              <td width="100%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                            <tr>
                              <td width="100%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr> -->
                          
                          </tbody></table>
                    </div>
                      <div class="task-description">
                          <h2>Counter Description</h2>
                          <p>
                            <?php 
                            $counterNoteLimit = 1; // Set the limit to 1
                            $counterNoteCount = 0; // Initialize a counter variable
                            foreach ($serviceCustomers3 as $servicenew) {
                                  $counterNote = $servicenew['counter_note'];
                                  if ($counterNoteCount < $counterNoteLimit) {
                                    echo $counterNote;
                                    $counterNoteCount++; // Increment the counter
                                }
                                  // echo $serviceCustomers; echo "<br/>";
                                  // echo $servicePrice;echo "<br/>";
                            } 
                            ?>
                          </p>
                      </div>
                    </div>
                <div class="row content1<?php echo $proposalId?> hidden">
                    <div class="col-md-7">
                        <div class="order-details-progress">
                            <h2>Customer Offer Details</h2>
                            
                            <ul class="orderdetails-lists">
                            <?php foreach ($serviceCustomers as $servicenew) {
                            $services = $servicenew['service_name'];
                            $servicePrice = $servicenew['price'];
                            $serviceImages = getServiceImages([$services]);
                            // echo $serviceCustomers; echo "<br/>";
                            // echo $servicePrice;echo "<br/>";
                          ?>
                                                    <li><em><img src="../admin/uploads/<?php echo $serviceImages[0]?>"/> <?php echo $services ?></em><span style="color: #70BE44;">$ <?php echo $servicePrice?></span></li>

                            <?php } ?>
                          <li class="total-amount"><em><b>Total  amount paid</b></em><span style="color: #70BE44;"><b>$ <?php echo $totalAmount?></b></span></li>
                       
                            </ul>
                          </div>
                    </div>
                    <div class="col-md-5">
                        <h2>Advance Booking Timings</h2>
                        <table style="padding: 20px;">
                            <tbody><tr style="margin-bottom:10px;">
                              <th width="100%"></th>
                            </tr>
                            <tr style="margin-bottom:10px;"> 
                              <td width="100%" class="date-inner">
                                  <?php foreach ($selectedDate as $key => $date): ?>
                                      <li><em><?php echo date('d-M-Y , D', strtotime($date)); ?></em><span><?php echo $selectedTime[$key]; ?></span></li>
                                  <?php endforeach; ?>
                                </td>
                              </tr>
                            <!-- <tr style="margin-bottom:10px;">
                              <td width="100%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr>
                            <tr>
                              <td width="100%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                              </tr> -->
                          
                          </tbody></table>
                    </div>
                      <div class="task-description">
                          <h2>Customer Description</h2>
                          <p><?php echo $userContent?></p>
                      </div>
                    </div>
                    <div class="newoffer-button-advancebooking">
                        <ul style="left:auto">
                            <li>
                              <a><button style="background-color: #70BE44; border-color: #70BE44; color: #fff;" class="read-more-button1<?php echo $proposalId?>">View Details</button></a>
                            </li>
                        </ul>
                    </div>
            </div>
          </div>
          <script>
        const content1<?php echo $proposalId ?> = document.querySelector('.content1<?php echo $proposalId ?>');
        const readMoreButton1<?php echo $proposalId ?> = document.querySelector('.read-more-button1<?php echo $proposalId ?>');

        readMoreButton1<?php echo $proposalId ?>.addEventListener('click', function () {
            if (content1<?php echo $proposalId ?>.classList.contains('hidden')) {
                content1<?php echo $proposalId ?>.classList.remove('hidden');
                readMoreButton1<?php echo $proposalId ?>.textContent = 'See Less';
            } else {
                content1<?php echo $proposalId ?>.classList.add('hidden');
                readMoreButton1<?php echo $proposalId ?>.textContent = 'See More';
            }
        });
    </script>
      <?php
            }
          }
      } else {
          echo 'Error executing the query.';
      }
      ?>

 <!-- FIRST ROW END -->

 <!-- SECOND ROW START -->
 
 <!-- THIRD ROW END -->
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
