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
        <!-- START ROW MAIN-PANEL -->
        <div class="row">

        
          <div class="order-in-progress">
            <h1><b style="color: #70BE44;">Order</b> Scheduled</h1>
            <div class="onetime-advancebokingbutton">
              <ul>
                <li><a href="schedule-order.php"><button style="color: #fff; background-color: #70BE44;">One Time Service</button></a></li>
                <li><a href="schedule-orders-advancebooking.php"><button style="color: #959595; background-color: #E6E6E6;">Advance Bookings</button></a></li>
              </ul>
            </div>
            <?php
              include 'connection.php';

              $userId = $_SESSION['user_id'];
              $providerName = $_SESSION['providerName'];

              $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND status = 'scheduled_offer'";
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
                $selectedDate = $row['year'] . '-' . $row['month'] . '-' . $row['day'];
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
             <div class="modal" id="sheduled<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Acceptance</h5>
                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button> -->
                                    </div>
                                    <div class="modal-body h-auto">
                                        <h2 class="pb-4">Are you sure?</h2>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" name="providerId" value="<?php echo $userId ?>" id="providerId" />
                                              <input type="hidden" name="customerId" value="<?php echo $customerId ?>" id="customerId" />
                                              <input type="hidden" name="providerName" value="<?php echo $providerName ?>" id="providerName" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            onclick="acceptOffer(<?php echo $proposalId; ?>)">yes</button>
                                    </div>
                                    <script>
                                        function acceptOffer(proposalId) {
                                            // const counterNote = document.getElementById('counterNote').value;
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const providerName = document.getElementById('providerName').value;
                                            const messageContent = `${providerName} has accepted your offer.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                statusFrom: 'provider_send',
                                                status: 'order_in_progress',
                                                customerId: customerId,
                                                providerId: providerId,
                                                providerName: providerName,
                                                messageContent: messageContent,
                                            }));
                                            xhr.onreadystatechange = function () {
                                                if (xhr.readyState === 4 && xhr.status === 200) {
                                                    // Handle the server's response here, if needed
                                                    console.log(xhr.responseText);

                                                    // Reload the page after the status is updated
                                                    location.reload(); // This will refresh the current page
                                                }
                                            };
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
            <!-- FIRST PROGRESS PROFILE -->
            <div class="progress-profile">
              <div class="row">
                <div class="col-md-9">
                  <div class="progress-profile-detail">
                    <ul class="paid">
                      <li class="profile-name"><h5><img src="./images/homee.png"/><b><?php echo $customerName?>  </b><br>userID# <?php echo $customerId?></h5></li>
                      <li><h5><img src="./images/mappin.png"/><?php echo $customerAddress?></h5></li>
                        <li class="paid-text" style="color:#4492BE;">
                        <?php
                          $today = new DateTime(); // Get the current date
                          $selectedDateObj = new DateTime($selectedDate);

                          // Calculate the difference in days
                          $daysRemaining = $today->diff($selectedDateObj)->days;

                          // Determine the CSS class based on the condition
                          $dateClass = '';
                          $imageSrc = '';
                          $showStartButton = false;
                          $showSheduledButton = '';
                          if ($daysRemaining === 0) {
                            $dateClass = 'last-day-date';
                            $imageSrc = './images/schedule.png'; // Change to your desired image path
                            $showStartButton = true; // Set to true to show the button
                            $showSheduledButton = 'Scheduled Today'; 
                          } elseif ($daysRemaining === 1) {
                              $dateClass = 'other-date';
                              $imageSrc = './images/scheduled.png'; // Change to your desired image path
                              $showStartButton = false; // Set to true to show the button
                              $showSheduledButton = 'Scheduled'; 
                          } else {
                              $dateClass = 'other-date';
                              $imageSrc = './images/scheduled.png'; // Change to your desired image path
                              $showSheduledButton = 'Scheduled'; 
                          }

                          // Output the date with the appropriate CSS class
                        ?>
                        <h5 class="<?php echo $dateClass; ?>">
                              <img src="<?php echo $imageSrc; ?>"/> <?php echo $selectedDate?> <br><?php echo $selectedTime?>
                        </h5>


                        <!-- <h5><img src="./images/schedule.png"/> <?php echo $selectedDate?> <br><?php echo $selectedTime?></h5> -->
                      </li>
                    </ul>
                  </div>

                  <div class="services-needed">
                    <ul>
                      <li><h4>Services Needed</h4></li>
                      <?php foreach ($selectedServices as $service) { ?>
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
                    <h3>Order Amount </h3>
                    <a href="#"><button>Paid</button></a>
                  </div>
                  
                  <div class="service-status" style="width: 100%;">
                    <h3>Service Status</h3>
                    <a class="schedulebutton"><button><?php echo $showSheduledButton ?></button></a><br>
                    <?php
                    if ($showStartButton) {
                        echo '<a class="startorder" href="javascript:void(0);"><button type="button" data-toggle="modal" data-target="#sheduled' . $proposalId . '">Start Order Progress</button></a>';
                    }
                    ?>
                  </div>
                </div>

                
                <div class="viewgallery">
                    <a href="#/" class="viewbuttn read-more-button1<?php echo $proposalId?>">View More <img src="./images/dropdown.png"/></a>

                    <div class="content1<?php echo $proposalId?> hidden progress-gallery">
                        <div class="row">
                          <div class="col-md-5">
                            <div class="location-images">
                            <h5>Location Images </h5>
                            <ul class="gallery-images">
                            <?php
                            foreach (array_slice($customerImages, 0, 5) as $imagePath) {
                            ?>
                                <li>
                                    <img src="../customer/<?php echo $imagePath; ?>" alt="Customer Image" />
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                          </div>
                          </div>
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
                        </div>
                    </div>
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
<!-- <script>
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
</script> -->