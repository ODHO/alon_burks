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

    <!-- MESSAGE CHAT -->
    <!-- MESSAGE CHAT BOX CDNS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

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
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php
      include 'SideMenu.php'
      ?>
      <!-- partial -->
      <div class="main-panel">
        <!-- START ROW MAIN-PANEL -->
        <!-- MESSAGE BOX START  -->
      <!-- char-area -->
<section class="message-area">
    <div class="container">
        <h2 style="color: #000; font-weight: bold;">Messages</h2>
        <p style="color: #70BE44; padding-bottom: 20px;">Here are your Customers Chats </p>
      <div class="row">
        <div class="col-12">
          <div class="chat-area">
            <!-- chatlist -->
            <div class="chatlist">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="chat-header">
                    <div class="msg-search">
                      <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" aria-label="search">
                      <a class="add" href="#"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/add.svg" alt="add"></a>
                    </div>
  
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab"" aria-selected="true">Open</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Closed-tab" data-bs-toggle="tab" data-bs-target="#Closed" type="button" role="tab"" aria-selected="false">Closed</button>
                      </li>
                    </ul>
                  </div>
  
                  <div class="modal-body">
                    <!-- chat-list -->
                    <?php
            include 'connection.php';

            $userId = $_SESSION['user_id'];
            $providerName = $_SESSION['providerName'];

            $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND (status = 'completed-pending' OR status = 'working' OR status = 'order_in_progress') ORDER BY status = 'completed-pending' DESC, status = 'working' DESC, status = 'order_in_progress' DESC";
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
            <!-- FIRST PROGRESS PROFILE -->
           
                    <!-- Assuming this part of the code is inside an HTML document -->
<div class="chat-lists">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
            <?php
             include 'connection.php';

             $userId = $_SESSION['user_id'];
             $providerName = $_SESSION['providerName'];
 
             $sql = "SELECT * FROM customer_proposal WHERE provider_id = ?";
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

                    echo $proposalId;
                    echo $customerId;
                    // Output a list item for each customer with a link to their chat
                    echo '<div class="chat-list">';
                    echo '<a href="chat.php?customer=' . $customerId . '">'; // You should have a chat page (chat.php) to handle the chat
                    echo '<div class="d-flex align-items-center">';
                    echo '<div class="flex-shrink-0">';
                    echo '<img class="img-fluid" style="border-radius: 136px;object-fit: fill;width: 60px;height: 60px;" src="../customer/'. $profile_picture .'" alt="user img">';
                    echo '</div>';
                    echo '<div class="flex-grow-1 ms-3">';
                    echo '<h3>' . $customerName . '</h3>';
                    echo '<p>front end developer</p>'; // Modify this to display relevant customer info
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                  }
                }
              } else {
                echo 'Error executing the query.';
              }
            ?>
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
                    <!-- chat-list -->
                  </div>
                </div>
              </div>
            </div>
            <!-- chatlist -->
  
            <!-- chatbox -->
            <div class="chatbox showbox">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="msg-head">
                    <div class="row">
                      <div class="col-8">
                        <div class="d-flex align-items-center">
                          <span class="chat-icon"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg" alt="image title"></span>
                          <div class="flex-shrink-0">
                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                          </div>
                          <div class="flex-grow-1 ms-3">
                            <h3>Mehedi Hasan</h3>
                            <p>front end developer</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <ul class="moreoption">
                          <li class="navbar nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
  
                  <div class="modal-body">
                    <div class="msg-body">
                      <ul>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:06 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:16 am</span>
                        </li>
                        <li class="repaly">
                          <p>yes!</p>
                          <span class="time">10:20 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:26 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:32 am</span>
                        </li>
                        <li class="repaly">
                          <p>How are you?</p>
                          <span class="time">10:35 am</span>
                        </li>
                        <li>
                          <div class="divider">
                            <h6>Today</h6>
                          </div>
                        </li>
  
                        <li class="repaly">
                          <p> yes, tell me</p>
                          <span class="time">10:36 am</span>
                        </li>
                        <li class="repaly">
                          <p>yes... on it</p>
                          <span class="time">junt now</span>
                        </li>
  
                      </ul>
                    </div>
                  </div>
  
                  <div class="send-box">
                    <form action="">
                      <input type="text" class="form-control" aria-label="message…" placeholder="Write message…">
  
                      <button type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                    </form>
  
                    <div class="send-btns">
                      <div class="attach">
                        <div class="button-wrapper">
                          <span class="label">
                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/upload.svg" alt="image title"> attached file
                          </span><input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                        </div>
  
                        <select class="form-control" id="exampleFormControlSelect1">
                          <option>Select template</option>
                          <option>Template 1</option>
                          <option>Template 2</option>
                        </select>
  
                        <div class="add-apoint">
                          <a href="#" data-toggle="modal" data-target="#exampleModal4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 16 16" fill="none">
                              <path d="M8 16C3.58862 16 0 12.4114 0 8C0 3.58862 3.58862 0 8 0C12.4114 0 16 3.58862 16 8C16 12.4114 12.4114 16 8 16ZM8 1C4.14001 1 1 4.14001 1 8C1 11.86 4.14001 15 8 15C11.86 15 15 11.86 15 8C15 4.14001 11.86 1 8 1Z" fill="#7D7D7D" />
                              <path d="M11.5 8.5H4.5C4.224 8.5 4 8.276 4 8C4 7.724 4.224 7.5 4.5 7.5H11.5C11.776 7.5 12 7.724 12 8C12 8.276 11.776 8.5 11.5 8.5Z" fill="#7D7D7D" />
                              <path d="M8 12C7.724 12 7.5 11.776 7.5 11.5V4.5C7.5 4.224 7.724 4 8 4C8.276 4 8.5 4.224 8.5 4.5V11.5C8.5 11.776 8.276 12 8 12Z" fill="#7D7D7D" />
                            </svg> Appoinment</a>
                        </div>
                      </div>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- chatbox -->
  
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- char-area -->
      <!-- MESSAGE BOX END -->
        <!-- END ROW MAIN PANEL -->
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
    jQuery(document).ready(function() {
    
        $(".chat-list a").click(function() {
            alert("test");
            $(".chatbox").addClass('showbox');
            return false;
        });
    
        $(".chat-icon").click(function() {
            $(".chatbox").removeClass('showbox');
        });
    
    
    });</script>