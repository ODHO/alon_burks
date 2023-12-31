<?php
session_start();

$checkBank = checkUserBank();

if($checkBank['isAccountVerified'] == '0'){
  header("Location: ../connectback.php");
}

function checkUserBank()
{
    $user = "";
    global $conn;
    // Sanitize the input to prevent SQL injection
    $user_id = $_SESSION['user_id'];

    // Retrieve provider services from the database using the provider ID
    $sql = "SELECT isAccountVerified FROM provider_registration WHERE id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = $row;
        }
    }
    return $user;
}
function getReviews(){
  global $conn;
  $sql =
      "SELECT rating, Feedback, created_at,fullname,profile_picture
       FROM ratings inner join `provider_registration` on 
         `provider_registration`.`id` = `ratings`.`user_id` WHERE provider_id = ? order by ratings.id desc limit 4";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $_SESSION["user_id"]);
  if ($stmt->execute()) {
      $result = $stmt->get_result();
      $rating = [];
      while ($row = $result->fetch_assoc()) {
          $rating[] = $row;
      }
      return $rating;
  }
  return "0";
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
include 'connection.php';
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
function getReviews($userId, $proposalId) {
  global $conn;
  $sql = "SELECT * FROM ratings WHERE provider_id = ? AND proposal_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $userId, $proposalId);

  $reviews = array();

  if ($stmt->execute()) {
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
          $review = array(
              'user_id' => $row['user_id'],
              'rating' => $row['rating'],
              'Feedback' => $row['Feedback'],
              'created_at' => $row['created_at']
          );

          $reviews[] = $review;
      }
  }

  return $reviews;
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
          <?php
include 'connection.php';

$userId = $_SESSION['user_id'];

// Create an array to store the count for each status
$statusCounts = array(
    'order_in_progress' => 0,
    'scheduled_offer' => 0,
    'replied_offer' => 0,
    'completed' => 0,
    'completed-pending' => 0,
    // Add more statuses as needed
);

$sql = "SELECT * FROM customer_proposal WHERE provider_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $userId);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $status = $row['status'];

            // Update the count for the respective status
            if (array_key_exists($status, $statusCounts)) {
                $statusCounts[$status]++;
            }
        }
    }
}

// Calculate the total count for both statuses
$totalCompletedCount = $statusCounts['completed'] + $statusCounts['completed-pending'];
$totalCompletedCount1 = $statusCounts['scheduled_offer'] + $statusCounts['order_in_progress'];
?>

          <div class="milestone-calculation">
            <div class="row">
              <div class="col-md-3">
                <h2>
                  Completed Orders
                </h2>
                <div class="mile">
                  <h2><?php echo $totalCompletedCount?></h2>
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
                  <h2><?php echo $totalCompletedCount1?></h2>
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
            <?php
            include 'connection.php';

            $userId = $_SESSION['user_id'];
            $providerName = $_SESSION['providerName'];

            $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND proposal_status = 'OneTime' AND (status = 'completed-pending' OR status = 'working' OR status = 'order_in_progress') ORDER BY status = 'completed-pending' DESC, status = 'working' DESC, status = 'order_in_progress' DESC";
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
           

            <div class="progress-profile">
           
              <div class="row">
             
                <div class="col-md-9">
                  <div class="progress-profile-detail">
                    <ul>
                      <li class="profile-name"><h5><img src="./images/homee.png"/><b><?php echo $customerName?> </b><br>userID# <?php echo $customerId?></h5></li>
                      <li><h5><img src="./images/mappin.png"/><?php echo $customerAddress?></h5></li>
                        <li><h5><img src="./images/time.png"/> <?php echo $selectedDate , str_repeat('&nbsp;', 5), $selectedTime?></h5></li>
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
                    <h3>Customer Verification</h3>
                    <a href="#"><button>Verified</button></a>
                  </div>
                  
                  <div class="service-status" style="width: 100%;">
                    <h3>Service Status</h3>
                    
                    <select id='gMonth2' onchange="showStatusPopup(this.value)">
                          <option value=''>--Select Status--</option>
                          <?php if ($row['status'] === 'order_in_progress') { ?>
                              <option selected value='1'>Not-Working</option>
                          <?php } elseif ($row['status'] === 'working') { ?>
                              <option selected value='2'>Working</option>
                              <!-- <option value='2'>Completed</option> -->
                          <?php } elseif ($row['status'] === 'completed-pending') { ?>
                              <option selected value='5'>Working</option>
                              <option value='3'>Completed</option>
                          <?php } ?>
                    </select>

              <script>
              function showStatusPopup(selectedStatus) {
                  // Hide all popups first
                  document.getElementById('notWorkingPopup<?php echo $proposalId?>').style.display = 'hide';
                  document.getElementById('workingPopup<?php echo $proposalId?>').style.display = 'hide';
                  document.getElementById('completedPopup<?php echo $proposalId?>').style.display = 'hide';

                  if (selectedStatus === '1') {
                      // Display the "Not-Working" popup
                      document.getElementById('notWorkingPopup<?php echo $proposalId?>').style.display = 'block';
                  } else if (selectedStatus === '2') {
                      // Display the "Working" popup
                      document.getElementById('workingPopup<?php echo $proposalId?>').style.display = 'block';
                  } else if (selectedStatus === '3') {
                      // Display the "Completed" popup
                      document.getElementById('completedPopup<?php echo $proposalId?>').style.display = 'block';
                  } else {
                      // Handle any other status or no selection
                  }
              }
              
              </script>



                  </div>
                </div>

                          <div class="modal your-offer-selected popup-selected" id="notWorkingPopup<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Acceptance</h5>
                                       
                                    </div>
                                    <div class="modal-body h-auto">
                                        <h2 class="pb-4">You cannot change status until customer verifies the previous status ?</h2>
                                    
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="closePopup2('<?php echo $proposalId; ?>')">Close</button>
                                          </div>
                                    </div>
                                    
                                </div>
                            </div>
                          </div>

                          <div class="modal" id="workingPopup<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Acceptance</h5>
                                       
                                    </div>
                                    <div class="modal-body h-auto">
                                        <h2 class="pb-4">You cannot change status until customer verifies the previous status </h2>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" onclick="closePopup1('<?php echo $proposalId; ?>')" class="bg-danger">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="completedPopup<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Acceptance</h5>
                                       
                                    </div>
                                    <div class="modal-body h-auto">
                                    <h2>Please move your proposal to the completed portion.</h2>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" onclick="closePopup('<?php echo $proposalId; ?>')">Close</button>
                                            <button type="button" class="btn btn-primary" class="move-button" onclick="moveToCompleted(<?php echo $proposalId; ?>)">Move</button>
                                            <input type="hidden" name="providerId" value="<?php echo $userId ?>" id="providerId" />
                                              <input type="hidden" name="customerId" value="<?php echo $customerId ?>" id="customerId" />
                                              <input type="hidden" name="providerName" value="<?php echo $providerName ?>" id="providerName" />
                                          </div>
                                          <script>
                                        function moveToCompleted(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const providerName = document.getElementById('providerName').value;
                                            const messageContent = `Did you like the ${providerName} services? Rate your service provider`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                statusFrom: 'provider_send',
                                                status: 'completed',
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
                                        function closePopup(proposalId) {
                                            // You can use jQuery or vanilla JavaScript to hide the modal
                                            // Example using jQuery:
                                            $("#completedPopup" + proposalId).modal("hide");

                                            const modal = document.getElementById("completedPopup" + proposalId);
                                            modal.style.display = "none";
                                        }
                                        function closePopup2(proposalId) {
                                            // You can use jQuery or vanilla JavaScript to hide the modal
                                            // Example using jQuery:
                                            $("#notWorkingPopup" + proposalId).modal("hide");

                                            const modal = document.getElementById("notWorkingPopup" + proposalId);
                                            modal.style.display = "none";
                                        }
                                        function closePopup1(proposalId) {
                                            // You can use jQuery or vanilla JavaScript to hide the modal
                                            // Example using jQuery:
                                            $("#workingPopup" + proposalId).modal("hide");

                                            const modal = document.getElementById("workingPopup" + proposalId);
                                            modal.style.display = "none";
                                        }
                                    </script>
                                    </div>
                                    
                                    
                                   
                                </div>
                            </div>
                        </div>



                <div class="viewgallery">
                    <a href="#/" class="viewbuttn">View More <img src="./images/dropdown.png"/></a>
                    <div class="progress-gallery">
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
          <?php
            }
  }
} else {
  echo 'Error executing the query.';
}
?>
          </div>
          <!-- MAIN COLUMN 8 END -->
            </div>


            <!-- MAIN -COLUMNS 4 -->
            <div class="col-md-4">
                <div class="service-statistics">
                  <h2><b style="color: #70BE44;">Service</b> Statistics</h2>
                  <ul class="statistics-list">
                    <li><img src="./images/doubletick.png"/><em>Completed task</em><span><?php
include 'connection.php';

$userId = $_SESSION['user_id'];

// Create an array to store the count for each status
$statusCounts = array(
    'order_in_progress' => 0,
    'scheduled_offer' => 0,
    'replied_offer' => 0,
    'completed' => 0,
    'completed-pending' => 0,
    // Add more statuses as needed
);

$sql = "SELECT * FROM customer_proposal WHERE provider_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $userId);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $status = $row['status'];

            // Update the count for the respective status
            if (array_key_exists($status, $statusCounts)) {
                $statusCounts[$status]++;
            }
        }
    }
}

// Calculate the total count for both statuses
$totalCompletedCount = $statusCounts['completed'] + $statusCounts['completed-pending'];
$totalCompletedCount1 = $statusCounts['scheduled_offer'] + $statusCounts['order_in_progress'];
echo $totalCompletedCount;
?></span></li>
                    <li><img src="./images/time.png"/><em>Today’s Job Hours</em><span style="color: #70BE44;">5:45</span></li>
                    <li><img src="./images/star.png"/><em>Job Success</em><span style="color: red;">10%</span></li>
                  </ul>
                  <h2><b style="color: #70BE44;">Recent</b> Feedbacks</h2>
                  <?php 
                    $getReviews = getReviews();
                    foreach($getReviews as $getReview){
                      // foreach($getReview as $review){
                        ?>
                        <div class="services-feedbacks">
                            <img src="../customer/<?php echo $getReview['profile_picture'];?>" width="50" heigth="50"/>
                            <h4><?php echo $getReview['Feedback'];?></h4>
                            <ul class="feedback-date-category">
                              <li>
                                <?php
                                  $sec = time() - strtotime($getReview['created_at']);
                                      if($sec < 30) {
                                        /* if less than a minute, return seconds */
                                        echo "Few seconds ago";
                                        // return $sec . " seconds ago";
                                      }
                                      else if($sec < 60) {
                                        /* if less than a minute, return seconds */
                                        echo "Few minutes ago";
                                        // return $sec . " seconds ago";
                                      }
                                      else if($sec < 60*60) {
                                        /* if less than an hour, return minutes */
                                        echo intval($sec / 60) . " minutes ago";
                                        // return intval($sec / 60) . " minutes ago"s;
                                      }
                                      else if($sec < 24*60*60) {
                                        /* if less than a day, return hours */
                                        // return intval($sec / 60 / 60) . " hours ago";
                                        echo intval($sec / 60 / 60) . " hours ago";
                                      }
                                      else {
                                        /* else returns days */
                                        // return intval($sec / 60 / 60 / 24) . " days ago";
                                        echo intval($sec / 60 / 60 / 24) . " days ago";
                                      }
                                ?>
                                <!-- 1 hours ago -->
                              </li>
                              <li style="color: #227A4E;"><?php echo $getReview['fullname'];?></li>
                            </ul>
                          </div>
                        <?php
                      // }
                    ?>
                    <?php
                    }
                    // print_r($getReview);
                  ?>
                  
                  <!-- <div class="services-feedbacks">
                    <img src="./images/profileman.png"/>
                    <h4>Mick taison is available for the job with his expertise skills</h4>
                  <?php
            include 'connection.php';

            $userId = $_SESSION['user_id'];
            $providerName = $_SESSION['providerName'];

            $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? ORDER BY id";
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
              $servicesAndPrices = getCustomerServicesAndPrices($customerId, $proposalId);
              $serviceCustomers1 = getCustomerServicesAndPrices($customerId, $proposalId);
              
              $reviews = getReviews($userId, $proposalId);

              
              // Now you have an array containing the selected services and their prices for the customer
              
              // Output the retrieved customer name and address
              $customerName = $customerInfo['fullname'];
              $customerAddress = $customerInfo['address'];
              $profile_picture = $customerInfo['profile_picture'];
            
foreach ($reviews as $review) {
    ?>
    <div class="services-feedbacks">
                    <img class="profile" src="../customer/<?php echo $profile_picture?>"/>
                    <h4><?php echo $review['Feedback']; ?></h4>
                    <ul class="feedback-date-category">
                      <li><?php echo date('F j, Y, g:i a', strtotime($review['created_at'])); ?></li>
                      <li style="color: #227A4E;"><?php echo implode(', ', array_column($servicesAndPrices, 'service_name')); ?></li>
                    </ul>
                  </div> -->
                  </div>
    <?php
}
            }
  }
} else {
  echo 'Error executing the query.';
}
?>
                 
                </div>
                <!-- Schedule tasks -->
                <div class="schedule-tasks-progress">
                  <h2><b style="color: #70BE44;">Scheduled</b> Tasks</h2>
                  <?php
              include 'connection.php';

              $userId = $_SESSION['user_id'];
              $providerName = $_SESSION['providerName'];

              $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND status = 'scheduled_offer' AND proposal_status = 'OneTime'";
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
                  <div class="task-list">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="profilename">
                          <img class="profile" style="width:45px;height:45px" src="../customer/<?php echo $profile_picture?>"/>
                          <h5><?php echo $customerName?><br><span>userID#<?php echo $customerId?></span></h5>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <h6><?php echo date('d-M-Y', strtotime($selectedDate))?><br><span><?php echo $selectedTime?></span></h6>
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