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
// Assuming you have a function to retrieve advance proposals from the database
// Assuming you have a function to retrieve advance proposals from the database
function getAdvanceProposals($providerId, $proposalId, $customerId) {
  global $conn;
  
  $proposals = array();

  $sql = "SELECT * FROM advance_proposal WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $providerId, $proposalId, $customerId);

  if ($stmt->execute()) {
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
          $proposals[] = $row;
      }
  }

  return $proposals;
}
function getStatusForEarliestDate($advanceProposals, $earliestDateTime) {
  foreach ($advanceProposals as $proposal) {
      $proposalDateTime = strtotime($proposal['selected_date'] . ' ' . $proposal['selected_time']);
      
      if ($proposalDateTime === $earliestDateTime) {
          return $proposal['status'];
      }
  }

  return ''; // Default status if not found
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
     
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <?php include 'SideMenu.php';?>

      <!-- partial -->
      <div class="main-panel">
        <!-- MAIN PANEL ROW START -->
        
        <div class="order-in-progress">
            <h1><b style="color: #70BE44;">Scheduled </b>Order</h1>
              <div class="onetime-advancebokingbutton">
                <ul>
                  <li><a href="#"><button style="color: #959595; background-color: #E6E6E6;">One Time Service</button></a></li>
                  <li><a href="#"><button style="color: #fff; background-color: #70BE44;">Advance Bookings</button></a></li>
                </ul>
              </div>
              <?php
                include 'connection.php';

// Function to calculate the time difference between two dates
function getTimeDifference($date1, $date2)
{
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    return $interval->format('%R%a days');
}

// Function to get advance proposals sorted by the proximity of the selected date to the current date
function getSortedAdvanceProposals($providerId, $proposalId, $customerId)
{
    $advanceProposals = getAdvanceProposals($providerId, $proposalId, $customerId);

    // Get the current date
    $currentDate = date('Y-m-d');

    // Calculate the time difference for each proposal
    foreach ($advanceProposals as &$proposal) {
        $selectedDate = $proposal['selected_date'];
        $timeDifference = getTimeDifference($currentDate, $selectedDate);
        $proposal['time_difference'] = $timeDifference;
    }

    // Sort proposals based on time difference
    usort($advanceProposals, function ($a, $b) {
        return strcmp($a['time_difference'], $b['time_difference']);
    });

    return $advanceProposals;
}

                $userId = $_SESSION['user_id'];
                $providerName = $_SESSION['providerName'];

                $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND (status = 'scheduled_offer' or status = 'working' or status = 'completed-pending') AND proposal_status = 'AdvancedProposal' order by current_time desc";
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
                  $selectedTimeTo = explode(', ', $row['selected_time_to']);
                  $userContent = $row['user_content'];
                  $selectedServices = explode(', ', $row['selected_services']);
                  $totalAmount = $row['total_amount'];
                  $current_time = $row['current_time'];
                  $counterTotall = $row['counter_totall'];
                  $customerInfo = getCustomerInfo($customerId);
                  $advanceProposals = getAdvanceProposals($providerId, $proposalId, $customerId);
                  $customerImages = getCustomerImagesForProvider($customerId, $userId, $proposalId);
                  $serviceCustomers = getCustomerServicesAndPrices($customerId, $proposalId);
                  $serviceCustomers1 = getCustomerServicesAndPrices($customerId, $proposalId);
                  $earliestDateTime = null;
                  // Check if there are upcoming dates
                  $earliestDateTime = null;

                  foreach ($advanceProposals as $proposal) {
                      $proposalDateTime = strtotime($proposal['selected_date'] . ' ' . $proposal['selected_time']);
  
                      // Check if the proposal date is greater than or equal to today's date
                      if ($proposalDateTime >= strtotime('today')) {
                          if (!$earliestDateTime || $proposalDateTime < $earliestDateTime) {
                              $earliestDateTime = $proposalDateTime;
                          }
                      }
                  }
                  // Now you have an array containing the selected services and their prices for the customer
                  $status = getStatusForEarliestDate($advanceProposals, $earliestDateTime);

                  // Check if there are upcoming dates
                  $hasUpcomingDates = $earliestDateTime !== null;
                  $customerName = $customerInfo['fullname'];
                  $customerAddress = $customerInfo['address'];
                  $profile_picture = $customerInfo['profile_picture'];
                  $sortedAdvanceProposals = getSortedAdvanceProposals($providerId, $proposalId, $customerId);

                ?>
            <div style="margin-top:50px">
              <div class="inprogressadvancebooking-box">
                <div class="row align-items-center">
                    <div class="col-lg-3 mb-4 mb-lg-0 align-items-center">
                        <div class="prf-imgwithtext">
                            <img src="../customer/<?php echo $profile_picture?>">
                          <h2> <?php echo $customerName?></h2>
                          <p>Garden Maintenance</p>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-2 mb-lg-0 align-items-center">
                      <div class="user-location">
                        <p><img src="./images/mappin.png"/><?php echo $customerAddress ?></p>
                      </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                    <div class="scheduled-today">
                    <?php
                            // Find the earliest upcoming date and time from advance proposals
                           
                            
                            
                            $hasUpcomingDates = $earliestDateTime !== null;

                            if ($hasUpcomingDates) {
                              // Check if the earliest date is today's date
                              $isScheduledToday = date('Y-m-d', $earliestDateTime) === date('Y-m-d');
                          
                              // Display the appropriate heading based on whether it's scheduled today or not
                              if ($isScheduledToday) {
                                  echo '<h3 style="color: #E72121;">Scheduled Today</h3>';
                              } else {
                                  echo '<h3 style="color: #70BE44;">Scheduled</h3>';
                              }
                          
                              // Display the nearest upcoming dates
                              
                              $formattedEarliestDateTime = date('d-M-Y, D g:i A', $earliestDateTime);
                              echo "<ul class='date'><li><em id='sheduledDate'>{$formattedEarliestDateTime}</em></li></ul>";
                          } else {
                              // Display a message if there are no upcoming dates
                              echo '<h3 style="color: #70BE44;">Scheduled</h3>';
                              echo "<ul class='date'><li>No upcoming bookings.</li></ul>";
                          }
                            ?>
                            </div>
</div>



                    <div class="col-lg-2 mb-2 mb-lg-0 align-items-center">
                        <div class="inprocess-button">
                        <?php if ($hasUpcomingDates) {
        $isScheduledToday = date('Y-m-d', $earliestDateTime) === date('Y-m-d');
        if ($isScheduledToday) {
            if ($status === 'working') { 
                ?>
                    <a href="#"><button style="background-color: #E72121;padding: 17px 6px;" class="process">Working</button></a>
                <?php
            } else if ($status === 'completed-pending') {
                ?>
                <a href="#"><button style="background-color: #E72121;padding: 17px 6px;" class="process">Completed</button></a>
                <?php
            } else if ($status === 'completed') {
                ?>
                <a href="#"><button style="background-color: #00B2FF;padding: 17px 6px;" class="process">Completed</button></a>
                <?php
            } else {
                ?>
                    <a href="#"><button style="background-color: #E72121;padding: 17px 6px;" class="process">Scheduled</button></a>
                <?php
            }
        } else { ?>
            <a href="#"><button style="background-color: #70BE44;" class="process">Scheduled</button></a>
            <?php
        }
    } else { ?>
        <a href="#"><button style="background-color: #70BE44;" class="process">Scheduled</button></a>
        <?php
    } ?>
                            <p>Hired On Hired On <?php echo date('d-M-Y , D', strtotime($current_time))?></p>
                        </div>
                    </div>
                    <?php
                       if ($hasUpcomingDates) {
                        $isScheduledToday = date('Y-m-d', $earliestDateTime) === date('Y-m-d');
                       if ($isScheduledToday) {
                       ?>
                        <div class="services-selected">
                          <div class="row">
                            <div class="col-lg-3 mb-3 mb-lg-0 align-items-center">
                                <h2>Service Status</h2>
                            </div>
                            <div class="col-lg-3 mb-3 mb-lg-0 align-items-center">
                                <form action="">
                                <select id='gMonth2' onchange="showStatusPopup(this.value)">
                          <option value=''>--Select Status--</option>
                          <?php if ($row['status'] === 'Scheduled') { ?>
                              <option selected value='1'>Not-Working</option>
                          <?php } elseif ($proposal['status'] === 'working') { ?>
                              <option selected value='4'>Working</option>
                              <option value='2'>Completed</option>
                              <!-- <option value='2'>Completed</option> -->
                          <?php } elseif ($proposal['status'] === 'completed-pending') { ?>
                              <option value='5' selected>Working</option>
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
                                            const sheduledDate = document.getElementById('sheduledDate').textContent;
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

                       <?php
                    } 
                  } else {
                        null;
                    }
                    ?>
                    
          

                <div class="row align-items-center advancebookingschedule">
                  <table style="padding: 20px;">
                      <tbody><tr style="margin-bottom:10px;">
                        <th width="30%">Services Cost Offer</th>
                        <th></th>
                        <th width="55%">Advance Booking Timings</th>
                        <th width="15%">Status</th>
                      </tr>
                      <tr style="margin-bottom:10px;">
                        <td width="25%">
                        
                          <?php foreach ($serviceCustomers as $servicenew) {
                                $services = $servicenew['service_name'];
                                $serviceImages = getServiceImages([$services]);
                                ?>
                              <li class="services-advance">
                                <span><img src="./images/doubletick.png"/></span>
                                <strong> <?php echo $services ?> </strong>
                                <span><img src="../admin/uploads/<?php echo $serviceImages[0]?>"/></span>
                              </li>
                          <?php } ?>
                        </td> 
                        <td width="5%">
                       
                        <?php $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount; 
                        foreach ($serviceCustomers as $servicenew) {
                                $servicePrice = $servicenew['price'];

                                if (isset($servicenew['counter_price'])) {
                                  $counterPrice = $servicenew['counter_price'];
                              } else {
                                  // If counter price is not available, use the original service price
                                  $counterPrice = $servicePrice;
                              }
                                ?>
                              <li style="margin-top:10px;" class="price-advance" style="background-color:#D9D9D9;">
                                
                                <strong>$<?php echo $counterPrice; ?></strong>
                              </li>
                          <?php } ?>
                        </td>
                        <td width="55%" class="date-inner">
                        <?php foreach ($advanceProposals as $proposal): ?>
                            <?php if ($proposal['status'] === 'working') { 
                              echo '';
                            } else {
                              ?>
                            <li style="margin-top:10px;"><em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em><span><?php echo $proposal['selected_time']; ?> - <?php echo $proposal['selected_time_to']; ?></span></li>
                              <?php
                            }?>

                          <?php endforeach; ?>
                        </td>

                        <td width="15%">
                        <?php foreach ($advanceProposals as $proposal): ?>
                            <?php if ($proposal['status'] === 'working') { 
                              echo '';
                              ?>
                           
                            <?php } else if ($proposal['status'] === 'completed-pending') { ?>
                          <a href="#"><button style="background-color: #70BE44;margin-top:10px;" class="process">Completed </button></a>
                          <?php } else if ($proposal['status'] === 'completed') {  ?>
                            <a href="#"><button style="background-color: #70BE44;margin-top:10px;" class="process">Completed </button></a>
                          <?php } else { ?>
                            <a href="#"><button style="background-color: #E72121;margin-top:10px;" class="process">Scheduled </button></a>
                          <?php } ?>
                          <?php endforeach; ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="viewgallery">

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
                          <div class="task-description">
                          <h2>Customer Description</h2>
                          <p style="text-align: left;"><?php echo $userContent?></p>
                      </div>
                        </div>
                    </div>
                  </div>
                  <div class="reschedule-detailsbuton">
                    <ul>
                      <li>
                        <button style="box-shadow: 7px 3px 22px 0px #00000030;
                          background-color: #70BE44; color: #fff;" class="read-more-button1<?php echo $proposalId?>">View Details</button>
                      </li>
                    </ul>
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
                readMoreButton1<?php echo $proposalId ?>.textContent = 'View Details';
            }
        });
    </script>
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