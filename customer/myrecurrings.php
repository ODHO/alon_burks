<?php
session_start();
// Function to get customer information from the provider_registration table
function getCustomerInfo($providerId) {
  global $conn;
  $sql = "SELECT fullname, profile_picture, address FROM provider_registration WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $providerId);
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
function getCustomerServicesAndPrices($providerId, $proposalId, $userId) {
    global $conn;
    $sql = "SELECT service_name, price, counter_price, counter_note FROM customer_services WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $providerId, $proposalId, $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $servicesAndPrices = array();

        while ($row = $result->fetch_assoc()) {
            $serviceCustomers = $row['service_name'];
            $priceService = $row['price'];
            $counterPrice = $row['counter_price'];
            $counterNote = $row['counter_note'];
            $servicesAndPrices[] = array('service_name' => $serviceCustomers, 'price' => $priceService, 'counter_price' => $counterPrice, 'counter_note' => $counterNote);
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
  function getCustomerImagesForProvider($providerId, $proposalId, $customerId) {
    global $conn;
    $sql = "SELECT image_path FROM customer_images WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $providerId, $proposalId, $customerId);
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
function getAdvanceProposals($providerId, $proposalId, $userId) {
    global $conn;
    
    $proposals = array();
  
    $sql = "SELECT * FROM advance_proposal WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $providerId, $proposalId, $userId);
  
    if ($stmt->execute()) {
        $result = $stmt->get_result();
  
        while ($row = $result->fetch_assoc()) {
            $proposals[] = $row;
        }
    }
  
    return $proposals;
  }
  // Function to get the status for a given date and time
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
<html lang="zxx" class="my-offer">

<head>
  <meta charset="utf-8">
  <title>Aaron Burks</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <!-- theme meta -->
  <meta name="theme-name" content="agen" />
  <!-- HORIZONTAL COLUMN ALIGN LINKS -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <!-- ** Plugins Needed for the Project ** -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <!-- venobox css -->
  <link rel="stylesheet" href="plugins/venobox/venobox.css">
  <!-- card slider -->
  <link rel="stylesheet" href="plugins/card-slider/css/style.css">

  <!-- Main Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body class="services-page">
  

   <?php include 'Black_logo_header.php'; ?>

<!-- Section start -->
<section id="my-offers-main">
<div class="container">
    <div class="row">
        <div class="main-text">
            <h1 style="color: black;">My Hirings</h1>
            <p style="color: #70BE44;">Here are your past services you availed and hired!</p>
        </div>
    </div>
    <div class="myoffer-button-serv">
        <ul>
            <li><a href="#"><button style="background-color: #E6E6E6; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #9D9D9D;
                ">One Time Service</button></a></li>
            <li><a href="#"><button style="background-color: #70BE44; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #fff;
                ">Advance Booking</button></a></li>
        </ul>
    </div>
  
    <div class="row">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">In progress</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Scheduled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Completed</a>
            </li>
            
        </ul><!-- Tab panes -->
        <div class="tab-content" style="margin: 0; padding: 0;">
            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <?php
                  include 'connection.php';

                  $userId = $_SESSION['user_id'];
                  $customerFullName = $_SESSION['customerFullName'];

                  $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND (status = 'scheduled_offer' or status = 'working' or status = 'completed-pending' or status = 'completed') AND proposal_status = 'AdvancedProposal'";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param('s', $userId);

                  if ($stmt->execute()) {
                      $result = $stmt->get_result();
                      if ($result->num_rows == 0) {
                        echo '<h2 class="text-center texter">No Replied orders available.</h2>';
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
                    $counterTotall = $row['counter_totall'];
                    $current_time = $row['current_time'];

                    // Retrieve customer name and address based on customerId
                    $customerInfo = getCustomerInfo($providerId);
                    $advanceProposals = getAdvanceProposals($providerId, $proposalId, $userId);
                    // print_r($advanceProposals);
                    // die();
                    $customerImages = getCustomerImagesForProvider($providerId, $proposalId, $customerId);
                    $serviceCustomers = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                    $serviceCustomers1 = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                    
                    // $counterTotall = $serviceCustomers1['counter_totall'];
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
                    // Output the retrieved customer name and address
                    $customerName = $customerInfo['fullname'];
                    $customerAddress = $customerInfo['address'];
                    $profile_picture = $customerInfo['profile_picture'];
                ?>
                <div style="margin-top:50px">
                  <div class="inprogressadvancebooking-box">
                    <div class="row align-items-center">
                        <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                            <div class="prf-imgwithtext">
                                <img src="../provider/<?php echo $profile_picture?>"/>
                               <h2> <?php echo $customerName?></h2>
                               <p>Garden Maintenance</p>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                          <div class="scheduled-today">
                           <?php
                            // Find the earliest upcoming date and time from advance proposals
                           
                            
                            // Check if there are upcoming dates
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
                                        <div style="display:flex; gap:10px;align-items: center;">
                                            <a href="#"><button style="background-color: #E72121;padding: 17px 6px;" class="process">Working</button></a>
                                            <a type="button" data-toggle="modal" data-target="#completed<?php echo $proposalId; ?>"
                                              data-proposal-id="<?php echo $proposalId; ?>">Verify</a>
                                        </div>
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
                                        <div style="display:flex; gap:10px;align-items: center;">
                                            <a href="#"><button style="background-color: #E72121;padding: 17px 6px;" class="process">Scheduled</button></a>
                                            <a type="button" data-toggle="modal" data-target="#confirmationModal<?php echo $proposalId; ?>"
                                              data-proposal-id="<?php echo $proposalId; ?>">Verify</a>
                                        </div>
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
                            <p>Hired On <?php echo date('d-M-Y , D', strtotime($current_time))?></p>
                        </div>

                        </div>
                    </div>

                    <!-- arrived Modal -->
                        <div class="modal your-offer-selected popup-selected" id="confirmationModal<?php echo $proposalId?>" role="dialog">
                            <div class="popup-selected-modal">
                                <div class="popupsucessfully main-panel">
                                    <img src="./images/verification.png" />
                                    <h4 class="pb-4">Kindly Verify that service provider has arrived?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal" class="bg-danger">No</button>
                                        <button type="button" data-dismiss="modal"
                                            onclick="acceptOffer(<?php echo $proposalId; ?>)">Yes, they are</button>
                                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerName?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId?>" />
                                    </div>
                                </div>
                                <script>
                                        function acceptOffer(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const sheduledDate = document.getElementById('sheduledDate').textContent;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has started working.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            console.log(proposalId, providerId, customerId, customerFullName, sheduledDate);
                                            // return;
                                            const xhr = new XMLHttpRequest();
                                            // console.log(sheduledDate);
                                            // die();
                                            xhr.open('POST', 'update_advance_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                sheduledDate: sheduledDate,
                                                status: 'working',
                                                statusFrom: 'none',
                                                customerId: customerId,
                                                providerId: providerId,
                                                customerFullName: customerFullName,
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

                        <!-- completed modal -->
                        <div class="modal your-offer-selected popup-selected" id="completed<?php echo $proposalId?>" role="dialog">
                            <div class="popup-selected-modal">
                            <div class="popupsucessfully main-panel">
                                    <img src="./images/verification.png" />
                                    <h4 class="pb-4">Service provider has completed their tasks?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal" class="bg-danger">No</button>
                                        <button type="button" data-dismiss="modal"
                                            onclick="completed(<?php echo $proposalId; ?>)">yes he completed</button>
                                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerName?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId?>" />
                                    </div>
                                </div>
                                <script>
                                        function completed(proposalId) {
                                          const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has  completed their tasks.`;
                                            const sheduledDate = document.getElementById('sheduledDate').textContent;


                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            console.log(proposalId, providerId, customerId, customerFullName, sheduledDate);
                                            // return;
                                            const xhr = new XMLHttpRequest();
                                            // console.log(sheduledDate);
                                            // die();
                                            xhr.open('POST', 'update_advance_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                sheduledDate: sheduledDate,
                                                status: 'completed-pending',
                                                statusFrom: 'none',
                                                customerId: customerId,
                                                providerId: providerId,
                                                customerFullName: customerFullName,
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

                    <div class="row align-items-center advancebookingschedule hiringadvance">
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
                                <span><img src="./images/servicecheck.png"/></span>
                                <strong> <?php echo $services ?> </strong>
                                <span><img style="width: 14%;" src="../admin/uploads/<?php echo $serviceImages[0]?>"/></span>
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
                      
                      
                      </tbody></table>
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
                            <a><button type="button" data-bs-toggle="modal" data-bs-target="#mymodal<?php echo $proposalId?>" style="background-color: #E72121; color: #fff;">Re Schedule</button></a>
                          </li>
                          <li>
                            <a><button class="read-more-button1<?php echo $proposalId?>" style="box-shadow: 7px 3px 22px 0px #00000030;
                              background-color: #fff; color: #70BE44;">View Details</button></a>
                          </li>
                        </ul>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="modal fade" id="mymodal<?php echo $proposalId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3>Set Your Advance Booking</h3>
                            </div>
                            <?php foreach ($advanceProposals as $index => $proposal): ?>
                                <?php if ($proposal['status'] === 'completed') {
                                   $formattedEarliestDateTime = date('d-M-Y, D g:i A', $earliestDateTime);
                                  ?>
                                  <div class="proposal" style="background-color: #70BE4442; margin-top:20px;">
                                      <div>
                                        <div class="row">
                                          <div class="col-lg-4">
                                          <input style="flex-direction: row-reverse;" id="selected_date" value="<?php echo $proposal['selected_date'] ?>" type="date" disabled>
                                          </div>
                                          <div class="col-lg-4">
                                          <input style="flex-direction: row-reverse;" id="selected_date" value="<?php echo $proposal['selected_date'] ?>" type="date" disabled>
                                          </div>
                                          <div class="col-lg-4">
                                          <input style="flex-direction: row-reverse;" id="selected_date" value="<?php echo $proposal['selected_date'] ?>" type="date" disabled>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <?php
                                } if ($proposal['status'] === 'completed-pending') {
                                  ?>
                                  <div class="proposal" style="background-color: #70BE4442; margin-top:20px;padding: 29px 10px;">
                                      <div>
                                        <div class="innerrow align-items-center">
                                          <div class="col-lg-5">
                                          <em style="font-size:20px;" id='sheduledDate'><?php echo date('d-M-Y , D', strtotime($proposal['selected_date']));?></em>
                                          </div>
                                          <div class="col-lg-4">
                                          <em style="font-size:15px;">
                                          <?php echo date("g:i A", strtotime($proposal['selected_time'])); ?> - <?php echo date("g:i A", strtotime($proposal['selected_time_to'])); ?>
                                          </em>
                                          </div>
                                          <div class="col-lg-3">
                                          <button style="background-color: #70BE44;border: none;padding: 10px;border-radius: 6px;color: white;padding-left: 20px;padding-right: 20px;" class="process">Completed </button>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <?php
                                } else if ($proposal['status'] === 'Scheduled'): ?>
                                    <div class="proposal" style="background-color: #70BE4442; margin-top:20px;">
                                        <div class="row">
                                          <div class="edit-buttons mb-3">
                                            <ul style="justify-content: end;">
                                              <!-- <li><button >Update</button></li> -->
                                              <li><button onclick="updateAdvanceBooking(<?php echo $index ?>, <?php echo $proposalId ?>)">Save</button></li>
                                            </ul>
                                          </div>
                                        </div>
                                        <div class="innerrow">
                                            <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                                                <div style="display:flex; align-items:center">
                                                    <input style="flex-direction: row-reverse;" id="selected_date(<?php echo $index ?>)" value="<?php echo $proposal['selected_date'] ?>" type="date">
                                                    <input style="flex-direction: row-reverse;display:none;" id="selected_date_ref(<?php echo $index ?>)" value="<?php echo $proposal['selected_date'] ?>" type="date">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                                                <ul class="time-advance" style="display: flex;justify-content: space-between;gap:7px">
                                                    <div style="text-align: left;">
                                                        <p style="text-align:left; font-size:20px">From</p>
                                                        <li><input type="time" style="padding: 6px;" value="<?php echo date("H:i", strtotime($proposal['selected_time'])); ?>" id="from(<?php echo $index ?>)"></li>
                                                        <li><input type="time" style="padding: 6px;display:none;" value="<?php echo date("H:i", strtotime($proposal['selected_time'])); ?>" id="from_ref(<?php echo $index ?>)"></li>
                                                    </div>
                                                    <div style="text-align: left;">
                                                        <p style="text-align:left; font-size:20px">To</p>
                                                        <li><input type="time" style="padding: 6px;" value="<?php echo date("H:i", strtotime($proposal['selected_time_to'])); ?>" id="to(<?php echo $index ?>)"></li>
                                                        <li><input type="time" style="padding: 6px;display:none;" value="<?php echo date("H:i", strtotime($proposal['selected_time_to'])); ?>" id="to_ref(<?php echo $index ?>)"></li>
                                                    </div>
                                                </ul>
                                                <input type="hidden" value="<?php echo $userId ?>" id="customer-id" placeholder="Enter Customer ID">
                                                <input type="hidden" value="<?php echo $proposalId ?>" id="provider-id" placeholder="Enter Provider ID">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function updateAdvanceBooking(index, proposalId) {
                                            console.log(proposalId);
                                            // Get updated values from the form
                                            const selectedDate = document.getElementById('selected_date(<?php echo $index ?>)').value;
                                            const selectedDateRef = document.getElementById('selected_date_ref(<?php echo $index ?>)').value;
                                            const selectedTimeFrom = document.getElementById('from(<?php echo $index ?>)').value;
                                            const selectedTimeFromRef = document.getElementById('from_ref(<?php echo $index ?>)').value;
                                            const selectedTimeTo = document.getElementById('to(<?php echo $index ?>)').value;
                                            const selectedTimeToRef = document.getElementById('to_ref(<?php echo $index ?>)').value;
                                            const customerId = document.getElementById('customer-id').value;
                                            const providerId = document.getElementById('provider-id').value;
                                            console.log(selectedDate, selectedDateRef, selectedTimeFrom, selectedTimeFromRef, selectedTimeTo, selectedTimeToRef, customerId, providerId, proposalId);
                                            return;
                                            $.ajax({
                                                type: 'POST',
                                                
                                                url: 'update_advance_booking.php', // Adjust the URL to your server-side script
                                                data: {
                                                    proposalId: proposalId,
                                                    selectedDate: selectedDate,
                                                    selectedDateRef: selectedDateRef,
                                                    selectedTimeFrom: selectedTimeFrom,
                                                    selectedTimeFromRef: selectedTimeFromRef,
                                                    selectedTimeTo: selectedTimeTo,
                                                    selectedTimeToRef: selectedTimeToRef,
                                                    customerId: customerId,
                                                    providerId: providerId
                                                },
                                                success: function (response) {
                                                    // Handle the server response here
                                                    console.log(response);
                                                    // location.reload(); // This will refresh the current page

                                                    // Optionally, close the modal or provide feedback to the user
                                                },
                                                error: function (error) {
                                                    // Handle errors here
                                                    console.error(error);
                                                }
                                            });
                                        }
                                    </script>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                </div>




                <script>
                    const content1<?php echo $proposalId ?> = document.querySelector('.content1<?php echo $proposalId ?>');
                    const readMoreButton1<?php echo $proposalId ?> = document.querySelector('.read-more-button1<?php echo $proposalId ?>');

                    readMoreButton1<?php echo $proposalId ?>.addEventListener('click', function () {
                        if (content1<?php echo $proposalId ?>.classList.contains('hidden')) {
                            content1<?php echo $proposalId ?>.classList.remove('hidden');
                            readMoreButton1<?php echo $proposalId ?>.textContent = 'View Less';
                        } else {
                            content1<?php echo $proposalId ?>.classList.add('hidden');
                            readMoreButton1<?php echo $proposalId ?>.textContent = 'View Details';
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
          
            <div class="tab-pane" id="tabs-2" role="tabpanel">
          
            </div>

            <div class="tab-pane" id="tabs-3" role="tabpanel">
              <div class="inprogressadvancebooking-box">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-4 mb-lg-0 align-items-center">
                        <div class="prf-imgwithtext">
                            <img src="./images/hiring/hiring1.png"/>
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
                            <a href="#"><button style="background-color: #00B2FF;" class="process">Schedule</button></a>
                            <p>Hired On 23rd August 2023</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center advancebookingschedule hiringadvance">
                  <table style="padding: 20px;">
                    <tbody><tr style="margin-bottom:10px;">
                      <th width="25%">Service Cost Offer</th>
                      <th width="65%">Advance Booking Timings</th>
                      <th width="10%">Status</th>
                    </tr>
                    <tr style="margin-bottom:10px;">
                      <td width="25%"><li class="services-advance"><span><img src="./images/servicecheck.png"/></span><strong> Snow Removal </strong><span><img src="./images/providerselected/Snow Plow.png"/></span></li></td> 
                      <td width="65%" class="date-inner"><li><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                      <td width="10%"><a href="#"><button style="background-color: #70BE44;" class="process">Completed</button></a></td>
                    </tr>
                    <tr style="margin-bottom:10px;">
                      <td width="25%"><li class="services-advance"><span><img src="./images/servicecheck.png"/></span><strong> Spring Cleanup </strong><span><img src="./images/providerselected/Cover Up.png"/></span></li></td>
                      <td width="65%" class="date-inner"><li style="background-color: #FCE2E2;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                      <td width="10%"><a href="#"><button style="background-color: #70BE44;" class="process">Completed </button></a></td>
                    </tr>
                    <tr>
                      <td width="25%"><li class="services-advance"><span><img src="./images/servicecheck.png"/></span><strong> Grass Cutting </strong><span><img src="./images/providerselected/Grass.png"/></span></li></td>
                      <td width="65%" class="date-inner"><li style="background-color: #FFEEB5;"><em>29-June-2023 , MON</em><span>10 am -12 am</span></li></td>
                      <td width="10%"><a href="#"><button style="background-color: #70BE44;" class="process">Completed </button></a></td>
                    </tr>
                  
                  </tbody></table>

                  <div class="reschedule-detailsbuton">
                    <ul>
                      <li>
                        <a href="#"><button style="background-color: #70BE44; color: #fff;">Give us Review</button></a>
                      </li>
                      <li>
                        <a href="#"><button style="box-shadow: 7px 3px 22px 0px #00000030;
                          background-color: #fff; color: #70BE44;">View Details</button></a>
                      </li>
                    </ul>
                  </div>
                </div>
             </div>
            </div>
        </div>
    </div>
</div>
</section>


<!-- Start end -->



<!-- footer start -->
<footer id="footer-section">
<div class="container">
  <div class="footer-widgets">
    <div class="row" style="padding: 60px 0px 30px 0px;">
      <div class="col-lg-3 mb-3 mb-lg-0">
        <img class="footerlogo" src="./images/footerlogo.png" width="100%"/>
        <div class="social-links">
          <ul>
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Company</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Commericals</a></li>
            <li><a href="#">Exclusive</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">residential individuals</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Contact</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">Help/FAQs</a></li>
            <li><a href="#">Press</a></li>
            <li><a href="#">Affilates</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Services</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">Lawn Mowing</a></li>
            <li><a href="#">Grass cutting</a></li>
            <li><a href="#">Spring Clean up</a></li>
            <li><a href="#">Lawn Maintenance</a></li>
            <li><a href="#">Seeding/ Aeration</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="footer-copyright">
  <div class="container">
<p>Copyright are Reserved@Apexcreativedesign.com</p>
  </div>
</div>
</footer>


<!-- Modal -->

<!-- footer end -->

<!-- jQuery -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="plugins/slick/slick.min.js"></script>

<!-- Main Script -->
<script src="js/script.js"></script>
</body>
</html>
<style>
  .hiringadvance table tbody th {
    font-size: 21px;
}
.hiringadvance tbody li.services-advance span {
    float: unset;
}

.hiringadvance tbody li.services-advance {
    background: #ff10 !important;
}
.modal .innerrow h5 {
    font-size: 20px;
    font-weight: 500;
    color: #393939;
}
.modal .innerrow h1 {
    font-size: 29px;
    display: flex;
    gap: 14px;
    align-items: center;
}

.modal .main-rescheduled {
  background: #70BE4442 !important;
  padding: 40px 10px;
    border-radius: 20px;
}
.modal .innerrow {
  background: none !important;
  padding: 0px 0px !important;
    border-radius: 0px !important;
}
div.modal .modal-dialog {
    max-width: 50%;
}
.modal .innerrow img {
    width: 50px;
}
div.modal .modal-dialog .modal-content {
    padding: 27px 20px;
}
.edit-buttons ul li button:hover {
    background: #000;
}
.edit-buttons ul li button {
    width: 100px;
    padding: 7px 0;
    border: 0;
    border-radius: 10px;
    background: #afd19d;
    color: #ffff;
    transition: .9s;
}
.edit-buttons ul {
    display: flex;
    margin: 0 19px;
    padding: 0;
    gap: 20px;
}
</style>