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
  

  <?php include 'Black_logo_header.php';?>
<!-- Section start -->
<section id="my-offers-main">
<div class="container">
    <div class="row">
        <div class="main-text">
            <h1 style="color: black;">My Offers</h1>
            <p style="color: #70BE44;">Here are your past services you availed and hired!</p>
        </div>
    </div>
    <div class="myoffer-button-serv">
        <ul>
            <li><a href="myoffers.php"><button style="background-color: #E6E6E6; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #9D9D9D;
                ">One Time Service</button></a></li>
            <li><a href="advance_my_offers.php"><button style="background-color: #70BE44; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #FFFFFF;
                ">Advance Booking</button></a></li>
        </ul>
    </div>
    <div class="row">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">All Offers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Pending offers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Replied Offers</a>
            </li>
            
        </ul><!-- Tab panes -->
        
        <div class="tab-content">
            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                <!-- SECOND OFFER ONETIME START -->
                
                
            <?php
              include 'connection.php';

              $userId = $_SESSION['user_id'];
              $customerFullName = $_SESSION['customerFullName'];

              $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'replied_offer' AND proposal_status = 'AdvancedProposal'";
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

                // Now you have an array containing the selected services and their prices for the customer
                
                // Output the retrieved customer name and address
                $customerName = $customerInfo['fullname'];
                $customerAddress = $customerInfo['address'];
                $profile_picture = $customerInfo['profile_picture'];
            ?>
                <div id="accepts<?php echo $proposalId?>" class="modal your-offer-selected popup-selected"  role="dialog">
                  <div class="popup-selected-modal">
                    <div class="popupsucessfully main-panel">
                      <img src="./images/checktick.png" />
                      <h4>Are you sure you want to accept this offer?</h4>
                        <div class="modal-footer" style="width: -webkit-fill-available;">
                            <button type="button" class="btn" data-dismiss="modal">No</button>
                            <button type="button" data-dismiss="modal" onclick="acceptOffers(<?php echo $proposalId; ?>)">Accept</button>
                        </div>
                        <script>
                            function acceptOffers(proposalId) {
                                const providerId = document.getElementById('providerId').value;
                                const customerId = document.getElementById('customerId').value;
                                const customerFullName = document.getElementById('customerFullName').value;
                                const messageContent = `${customerFullName} has Accepted your Counter offer.`;

                                // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                xhr.setRequestHeader('Content-Type', 'application/json');
                                xhr.send(JSON.stringify({
                                    proposalId: proposalId,
                                    statusFrom: 'customer_send',
                                    status: 'scheduled_offer',
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
                </div>

                        <div class="modal your-offer-selected popup-selected" id="rejects<?php echo $proposalId?>" role="dialog">
                            <div class="popup-selected-modal">
                                <div class="popupsucessfully main-panel">
                                    <img src="./images/close.png" />
                                    <h4 class="pb-4">Are you sure you want to reject this offer?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal">No</button>
                                        <button type="button" data-dismiss="modal" onclick="rejectOffers(<?php echo $proposalId; ?>)">yes</button>
                                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerFullName?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId?>" />
                                    </div>
                                    <script>
                                        function rejectOffers(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has rejected your Counter offer.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                status: 'reject_offer',
                                                statusFrom: 'customer_send',
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
                        </div>


                <!-- SECOND OFFER ONETIME START -->
                <div class="my-offers onetime" style="margin-bottom: 40px;">
                    <!-- MY OFR PROFILE INFO START -->
                    <div class="my-ofr-profl-info">
                        <div class="row">
                            <div class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                                <div class="prf-imgwithtext">
                                <img src="../provider/<?php echo $profile_picture?>" />
                                <h2> <?php echo $customerName?></h2>
                                <p>Garden Maintenance</p>
                                </div>
                            </div>
    
                            <div style="text-align: right;" class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                                <h5 class="pending"><span style="background-color: #70BE44;">Replied</span></h5>
                                <h6 style="color: #72B763;">Offered On <?php echo date('d-M-Y , D', strtotime($current_time))?></h6>
                            </div>
                        </div>
                        <div class="row bio-myoffer onetimepayment repliedoffer" style="padding-top: 30px;padding-bottom: 30px;">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <h4 style="padding-bottom: 30px;">Counter Offer</h4>
                                <?php
                                $platformChargesPercentage = 10;

                                $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;

                                $amountYouWillEarn = $totalAmount - $platformCharges;

                                $serviceCustomers1Index = 0;

                                $counter = 1;
                                foreach ($selectedServices as $service) {
                                    // $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                                    $serviceImages = getServiceImages([$service]);
                                    $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];

                                    $servicesNew = $serviceCustomers1Item['service_name'];
                                    $servicePrice = $serviceCustomers1Item['counter_price'];
                                    $counterNote = $serviceCustomers1Item['counter_note'];

                                    $serviceCustomers1Index++;
                                    ?>
                                    <p style="
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                        ">
                                <em>
                                    <?php 
                                    foreach ($serviceImages as $imagePath) {
                                        ?>
                                        <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                    <?php $counter++; } ?>
                                </em>
                                <span>$<?php echo $servicePrice ?></span>
                                </p>
                               
                                    <?php 
                                    $counter++; } ?>
                                    <div class="totalselected">
                                    <ul>
                                    <li><em><img src="./images/providerselected/total.png"/>Total Charges</em><span>$<?php echo $counterTotall?></span></li></ul>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3 mb-lg-0" style="padding-left: 30px;">
                            
                                <div class="custom-bookingtime">
                                    <h4 style="padding-bottom: 10px;">Booking Timings</h4>
                                    <ul>
                                    <?php foreach ($advanceProposals as $proposal): ?>
                                    <li style="margin-top:10px">
                                        <em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em>
                                        <span><?php echo $proposal['selected_time']; ?></span>
                                        
                                    </li>
                                <?php endforeach; ?>
                                    </ul>
                                </div>
                                <h4 style="padding-bottom: 30px;">Counter Reasoning </h4>
                                <p class="onetimepara"><?php echo $counterNote?></p>
                            </div>  
                        </div>
                        <div class="content1<?php echo $proposalId?> hidden">
                            <div class="row bio-myoffer onetimepayment" style="padding-top: 30px;">
                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                        <h4 style="padding-bottom: 30px;">Service Cost Offer</h4>
                                        <?php
                                            $platformChargesPercentage = 10;

                                            $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;

                                            $amountYouWillEarn = $totalAmount - $platformCharges;

                                            $serviceCustomers1Index = 0;

                                            $counter = 1;
                                            foreach ($selectedServices as $service) {
                                                // $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                                                $serviceImages = getServiceImages([$service]);
                                                $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];

                                                $servicesNew = $serviceCustomers1Item['service_name'];
                                                $servicePrice = $serviceCustomers1Item['price'];
                                                // $counterNote = $serviceCustomers1Item['counter_note'];

                                                $serviceCustomers1Index++;
                                                ?>
                                                <p style="
                                                        display: flex;
                                                        justify-content: space-between;
                                                        align-items: center;
                                                    ">
                                                    <em>
                                                        <?php 
                                                        foreach ($serviceImages as $imagePath) {
                                                            ?>
                                                            <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                                        <?php $counter++; } ?>
                                                    </em>
                                                    <span>$<?php echo $servicePrice ?></span>
                                                </p>
                                                        
                                            <?php 
                                            $counter++; } 
                                        ?>
                                        <!-- <p><em><img src="./images/providerselected/Cover Up.png"/> Spring Cleanup</em><span>$300</span></p>
                                        <p><em><img src="./images/providerselected/Grass.png"/> Grass Cutting</em><span>$300</span></p> -->
                                        <div class="totalselected">
                                            <ul>
                                                <li><em><img src="./images/providerselected/total.png"/>Total Charges</em><span>$ <?php echo $totalAmount?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3 mb-lg-0" style="padding-left: 30px;">
                                    
                                        <div class="custom-bookingtime">
                                            <h4 style="padding-bottom: 10px;">Booking Time</h4>
                                            <ul>
                                            <?php foreach ($advanceProposals as $proposal): ?>
                                    <li style="margin-top:10px">
                                        <em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em>
                                        <span><?php echo $proposal['selected_time']; ?></span>
                                        
                                    </li>
                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <h4 style="padding-bottom: 30px;">Task Description</h4>
                                        <p class="onetimepara"><?php echo $userContent?></p>
                                    </div>
                            </div>
                            </div>
                            <div class="onetimepayment">
                                    <div class="row viewimages-onetime ">
                                        <div style="justify-content: space-between;">
                                            <a href="javascript:void(0);">
                                                <button type="button" data-toggle="modal" data-target="#accepts<?php echo $proposalId;?>"
                                                    data-proposal-id="<?php echo $proposalId; ?>">Accept Offer</button>
                                            </a>
                                            
                                            <button class="read-more-button1<?php echo $proposalId?>">See More</button>
                                            <a class="ignore1" href="javascript:void(0);"><button type="button" data-toggle="modal" style="background:red" data-target="#rejects<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Reject</button></a>
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
<?php
              include 'connection.php';
              
              $userId = $_SESSION['user_id'];

              $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND (status = 'new_offer' AND proposal_status = 'AdvancedProposal')";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('s', $userId);

              if ($stmt->execute()) {
                  $result = $stmt->get_result();
                  if ($result->num_rows == 0) {
                    // No orders found for the provider
                    echo '<h2 class="text-center texter">No New orders available.</h2>';
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
                $advanceProposals = getAdvanceProposals($providerId, $proposalId, $userId);

                // Retrieve customer name and address based on customerId
                $customerInfo = getCustomerInfo($providerId);

                $customerImages = getCustomerImagesForProvider($providerId, $proposalId, $customerId);
                $serviceCustomers = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                $serviceCustomers1 = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                
                // $counterTotall = $serviceCustomers1['counter_totall'];

                // Now you have an array containing the selected services and their prices for the customer
                
                // Output the retrieved customer name and address
                $customerName = $customerInfo['fullname'];
                $customerAddress = $customerInfo['address'];
                $profile_picture = $customerInfo['profile_picture'];
            ?>
                <div class="my-offers onetime" style="margin-bottom: 40px;">
                    <div class="my-ofr-profl-info">

                        <div class="row">
                            <div class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                                <div class="prf-imgwithtext">
                                <img src="../provider/<?php echo $profile_picture ?>"/>
                                <h2> <?php echo $customerName?></h2>
                                <p>Garden Maintenance</p>
                                </div>
                            </div>

                            <div style="text-align: right;" class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                                <h5 class="pending"><span>Pending</span></h5>
                                <h6 style="color: #72B763;">Offered On <?php echo date('d-M-Y , D', strtotime($current_time))?></h6>
                            </div>
                        </div>

                        <div class="row bio-myoffer onetimepayment" style="padding-top: 30px;">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <h4 style="padding-bottom: 30px;">Service Cost Offer</h4>
                                <?php
                                    $platformChargesPercentage = 10;

                                    $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;

                                    $amountYouWillEarn = $totalAmount - $platformCharges;

                                    $serviceCustomers1Index = 0;

                                    $counter = 1;
                                    foreach ($selectedServices as $service) {
                                        // $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                                        $serviceImages = getServiceImages([$service]);
                                        $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];

                                        $servicesNew = $serviceCustomers1Item['service_name'];
                                        $servicePrice = $serviceCustomers1Item['price'];
                                        // $counterNote = $serviceCustomers1Item['counter_note'];

                                        $serviceCustomers1Index++;
                                        ?>
                                        <p style="
                                                display: flex;
                                                justify-content: space-between;
                                                align-items: center;
                                            ">
                                            <em>
                                                <?php 
                                                foreach ($serviceImages as $imagePath) {
                                                    ?>
                                                    <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                                <?php $counter++; } ?>
                                            </em>
                                            <span>$<?php echo $servicePrice ?></span>
                                        </p>
                                                
                                    <?php 
                                    $counter++; } 
                                ?>
                                <!-- <p><em><img src="./images/providerselected/Cover Up.png"/> Spring Cleanup</em><span>$300</span></p>
                                <p><em><img src="./images/providerselected/Grass.png"/> Grass Cutting</em><span>$300</span></p> -->
                                <div class="totalselected">
                                    <ul>
                                        <li><em><img src="./images/providerselected/total.png"/>Total Charges</em><span>$ <?php echo $totalAmount?></span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3 mb-lg-0" style="padding-left: 30px;">
                            
                                <div class="custom-bookingtime">
                                    <h4 style="padding-bottom: 10px;">Booking Time</h4>
                                    <ul>
                                    <?php foreach ($advanceProposals as $proposal): ?>
                                    <li style="margin-top:10px">
                                        <em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em>
                                        <span><?php echo $proposal['selected_time']; ?></span>
                                        
                                    </li>
                                <?php endforeach; ?>
                                    </ul>
                                </div>
                                <h4 style="padding-bottom: 30px;">Task Description</h4>
                                <p class="onetimepara"><?php echo $userContent?></p>
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="content<?php echo $proposalId?> hidden">
                                    <div class="gallery-servces moretext" style="text-align:center;">
                                        <h2>Service Place</h2>
                                        <ul class="my-galleryserv" style="display:flex; justify-content:center;">
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
                            </div>
                            <div class="row viewimages-onetime">
                                <button class="read-more-button<?php echo $proposalId?>">See More</button>
                            </div>
                                <!-- <a href="#"><button>View Images</button></a> -->
                            
                        </div>


                    </div>
                </div>
                
                <script>
                    const content<?php echo $proposalId ?> = document.querySelector('.content<?php echo $proposalId ?>');
                    const readMoreButton<?php echo $proposalId ?> = document.querySelector('.read-more-button<?php echo $proposalId ?>');

                    readMoreButton<?php echo $proposalId ?>.addEventListener('click', function () {
                        if (content<?php echo $proposalId ?>.classList.contains('hidden')) {
                            content<?php echo $proposalId ?>.classList.remove('hidden');
                            readMoreButton<?php echo $proposalId ?>.textContent = 'See Less';
                        } else {
                            content<?php echo $proposalId ?>.classList.add('hidden');
                            readMoreButton<?php echo $proposalId ?>.textContent = 'See More';
                        }
                    });
                </script>
                <?php
     }
    }
} else {
    echo 'Error executing the query.';
}
?>                              <!-- MY OFR PROFILE INFO END -->
            </div>
            <div class="tab-pane" id="tabs-2" role="tabpanel">
            <?php
              include 'connection.php';

              $userId = $_SESSION['user_id'];

              $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'new_offer' AND proposal_status = 'AdvancedProposal'";
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
                $counterTotall = $row['counter_totall'];
                $current_time = $row['current_time'];
                $advanceProposals = getAdvanceProposals($providerId, $proposalId, $userId);

                // Retrieve customer name and address based on customerId
                $customerInfo = getCustomerInfo($providerId);

                $customerImages = getCustomerImagesForProvider($providerId, $proposalId, $customerId);
                $serviceCustomers = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                $serviceCustomers1 = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                
                // $counterTotall = $serviceCustomers1['counter_totall'];

                // Now you have an array containing the selected services and their prices for the customer
                
                // Output the retrieved customer name and address
                $customerName = $customerInfo['fullname'];
                $customerAddress = $customerInfo['address'];
                $profile_picture = $customerInfo['profile_picture'];
            ?>
                <div class="my-offers onetime" style="margin-bottom: 40px;">
                  <div class="my-ofr-profl-info">
                    <div class="row">
                        <div class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                            <div class="prf-imgwithtext">
                                <img src="../provider/<?php echo $profile_picture ?>"/>
                               <h2> <?php echo $customerName?></h2>
                               <p>Garden Maintenance</p>
                            </div>
                        </div>
                        <div style="text-align: right;" class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                            <h5 class="pending"><span>Pending</span></h5>
                            <h6 style="color: #72B763;">Offered On <?php echo date('d-M-Y , D', strtotime($current_time))?></h6>
                        </div>
                    </div>
                    <div class="row bio-myoffer onetimepayment" style="padding-top: 30px;">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <h4 style="padding-bottom: 30px;">Service Cost Offer</h4>
                            <?php
                                $platformChargesPercentage = 10;
                                $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;
                                $amountYouWillEarn = $totalAmount - $platformCharges;
                                $serviceCustomers1Index = 0;
                                $counter = 1;
                                foreach ($selectedServices as $service) {
                                    // $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                                    $serviceImages = getServiceImages([$service]);
                                    $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];
                                    $servicesNew = $serviceCustomers1Item['service_name'];
                                    $servicePrice = $serviceCustomers1Item['price'];
                            $serviceCustomers1Index++;
                            ?>
                            <p style="display: flex;justify-content: space-between;align-items: center;">
                                <em>
                                    <?php 
                                    foreach ($serviceImages as $imagePath) {
                                        ?>
                                        <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                    <?php $counter++; } ?>
                                </em>
                                <span>$<?php echo $servicePrice ?></span>
                            </p>
                            <?php 
                            $counter++; } ?>
                            <div class="totalselected">
                                <ul>
                                    <li><em><img src="./images/providerselected/total.png"/>Total Charges</em><span>$ <?php echo $totalAmount?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3 mb-lg-0" style="padding-left: 30px;">
                            <div class="custom-bookingtime">
                                <h4 style="padding-bottom: 10px;">Booking Time</h4>
                                <ul>
                                <?php foreach ($advanceProposals as $proposal): ?>
                                    <li style="margin-top:10px">
                                        <em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em>
                                        <span><?php echo $proposal['selected_time']; ?></span>
                                        
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                            <h4 style="padding-bottom: 30px;">Task Description</h4>
                            <p class="onetimepara"><?php echo $userContent?></p>
                        </div>
                        <div class="col-lg-12 mt-4">
                            <div class="content1<?php echo $proposalId?> hidden">
                            <div class="gallery-servces moretext" style="text-align:center;">
                                <h2>Service Place</h2>
                                <ul class="my-galleryserv" style="display:flex; justify-content:center;">
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
                        </div>
                        <div class="row viewimages-onetime">
                            <button class="read-more-button1<?php echo $proposalId?>">See More</button>
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
                <!-- MY OFR PROFILE INFO END -->
              
            </div>
            <div class="tab-pane" id="tabs-3" role="tabpanel">
            <?php
              include 'connection.php';
              $customerFullName = $_SESSION['customerFullName'];
              $userId = $_SESSION['user_id'];

              $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'replied_offer' AND proposal_status = 'AdvancedProposal'";
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
                $counterTotall = $row['counter_totall'];
                $current_time = $row['current_time'];

                // Retrieve customer name and address based on customerId
                $customerInfo = getCustomerInfo($providerId);
                $advanceProposals = getAdvanceProposals($providerId, $proposalId, $userId);

                $customerImages = getCustomerImagesForProvider($providerId, $proposalId, $customerId);
                $serviceCustomers = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                $serviceCustomers1 = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                
                // $counterTotall = $serviceCustomers1['counter_totall'];

                // Now you have an array containing the selected services and their prices for the customer
                
                // Output the retrieved customer name and address
                $customerName = $customerInfo['fullname'];
                $customerAddress = $customerInfo['address'];
                $profile_picture = $customerInfo['profile_picture'];
            ?>
                        <div class="modal your-offer-selected popup-selected" id="confirmationModal<?php echo $proposalId?>" role="dialog">
                            <div class="popup-selected-modal">
                                <div class="popupsucessfully main-panel">
                                    <img src="./images/checktick.png" />
                                    <h4 class="pb-4">Are you sure you want to accept this offer?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal">No</button>
                                        <button type="button" data-dismiss="modal"
                                            onclick="acceptOffer(<?php echo $proposalId; ?>)">Accept</button>
                                    </div>
                                </div>
                                <script>
                                        function acceptOffer(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has Accepted your Counter offer.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                status: 'scheduled_offer',
                                                statusFrom: 'customer_send',
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

                        <div class="modal your-offer-selected popup-selected" id="reject<?php echo $proposalId?>" role="dialog">
                            <div class="popup-selected-modal">
                                <div class="popupsucessfully main-panel">
                                    <img src="./images/close.png" />
                                    <h4 class="pb-4">Are you sure you want to reject this offer?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal">No</button>
                                        <button type="button" data-dismiss="modal"
                                            onclick="rejectOffer(<?php echo $proposalId; ?>)">yes</button>
                                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerFullName?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId?>" />
                                    </div>
                                </div>
                                <script>
                                        function rejectOffer(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has rejected your Counter offer.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                status: 'reject_offer',
                                                statusFrom: 'customer_send',
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
                        
            

                <!-- SECOND OFFER ONETIME START -->
                <div class="my-offers onetime" style="margin-bottom: 40px;">
                    <!-- MY OFR PROFILE INFO START -->
                    <div class="my-ofr-profl-info">
                        <div class="row">
                            <div class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                                <div class="prf-imgwithtext">
                                <img src="../provider/<?php echo $profile_picture?>" />
                                <h2> <?php echo $customerName?></h2>
                                <p>Garden Maintenance</p>
                                </div>
                            </div>
    
                            <div style="text-align: right;" class="col-lg-6 mb-3 mb-lg-0 align-self-center">
                                <h5 class="pending"><span style="background-color: #70BE44;">Replied</span></h5>
                                <h6 style="color: #72B763;">Offered On <?php echo date('d-M-Y , D', strtotime($current_time))?></h6>
                            </div>
                        </div>
                        <div class="row bio-myoffer onetimepayment repliedoffer" style="padding-top: 30px;padding-bottom: 30px;">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <h4 style="padding-bottom: 30px;">Counter Offer</h4>
                                <?php
                                $platformChargesPercentage = 10;

                                $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;

                                $amountYouWillEarn = $totalAmount - $platformCharges;

                                $serviceCustomers1Index = 0;

                                $counter = 1;
                                foreach ($selectedServices as $service) {
                                    // $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                                    $serviceImages = getServiceImages([$service]);
                                    $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];

                                    $servicesNew = $serviceCustomers1Item['service_name'];
                                    $servicePrice = $serviceCustomers1Item['counter_price'];
                                    $counterNote = $serviceCustomers1Item['counter_note'];

                                    $serviceCustomers1Index++;
                                    ?>
                                    <p style="
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                        ">
                                <em>
                                    <?php 
                                    foreach ($serviceImages as $imagePath) {
                                        ?>
                                        <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                    <?php $counter++; } ?>
                                </em>
                                <span>$<?php echo $servicePrice ?></span>
                                </p>
                               
                                    <?php 
                                    $counter++; } ?>
                                    <div class="totalselected">
                                    <ul>
                                    <li><em><img src="./images/providerselected/total.png"/>Total Charges</em><span>$<?php echo $counterTotall?></span></li></ul>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3 mb-lg-0" style="padding-left: 30px;">
                            
                                <div class="custom-bookingtime">
                                    <h4 style="padding-bottom: 10px;">Booking Timings</h4>
                                    <ul>
                                    <?php foreach ($advanceProposals as $proposal): ?>
                                    <li style="margin-top:10px">
                                        <em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em>
                                        <span><?php echo $proposal['selected_time']; ?></span>
                                        
                                    </li>
                                <?php endforeach; ?>
                                    </ul>
                                </div>
                                <h4 style="padding-bottom: 30px;">Counter Reasoning </h4>
                                <p class="onetimepara"><?php echo $counterNote?></p>
                            </div>  
                        </div>
                        <div class="content2<?php echo $proposalId?> hidden">
                            <div class="row bio-myoffer onetimepayment" style="padding-top: 30px;">
                                    <div class="col-lg-6 mb-3 mb-lg-0">
                                        <h4 style="padding-bottom: 30px;">Service Cost Offer</h4>
                                        <?php
                                            $platformChargesPercentage = 10;

                                            $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;

                                            $amountYouWillEarn = $totalAmount - $platformCharges;

                                            $serviceCustomers1Index = 0;

                                            $counter = 1;
                                            foreach ($selectedServices as $service) {
                                                // $displayTotal = isset($counterTotall) ? $counterTotall : $totalAmount;
                                                $serviceImages = getServiceImages([$service]);
                                                $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];

                                                $servicesNew = $serviceCustomers1Item['service_name'];
                                                $servicePrice = $serviceCustomers1Item['price'];
                                                // $counterNote = $serviceCustomers1Item['counter_note'];

                                                $serviceCustomers1Index++;
                                                ?>
                                                <p style="
                                                        display: flex;
                                                        justify-content: space-between;
                                                        align-items: center;
                                                    ">
                                                    <em>
                                                        <?php 
                                                        foreach ($serviceImages as $imagePath) {
                                                            ?>
                                                            <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                                        <?php $counter++; } ?>
                                                    </em>
                                                    <span>$<?php echo $servicePrice ?></span>
                                                </p>
                                                        
                                            <?php 
                                            $counter++; } 
                                        ?>
                                        <!-- <p><em><img src="./images/providerselected/Cover Up.png"/> Spring Cleanup</em><span>$300</span></p>
                                        <p><em><img src="./images/providerselected/Grass.png"/> Grass Cutting</em><span>$300</span></p> -->
                                        <div class="totalselected">
                                            <ul>
                                                <li><em><img src="./images/providerselected/total.png"/>Total Charges</em><span>$ <?php echo $totalAmount?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3 mb-lg-0" style="padding-left: 30px;">
                                    
                                        <div class="custom-bookingtime">
                                            <h4 style="padding-bottom: 10px;">Booking Time</h4>
                                            <ul>
                                            <?php foreach ($advanceProposals as $proposal): ?>
                                    <li style="margin-top:10px">
                                        <em><?php echo date('d-M-Y , D', strtotime($proposal['selected_date'])); ?></em>
                                        <span><?php echo $proposal['selected_time']; ?></span>
                                        
                                    </li>
                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <h4 style="padding-bottom: 30px;">Task Description</h4>
                                        <p class="onetimepara"><?php echo $userContent?></p>
                                    </div>
                            </div>
                            </div>
                            <div class="onetimepayment">
                                    <div class="row viewimages-onetime ">
                                        <div style="justify-content: space-between;">
                                        <a href="javascript:void(0);">
                                            <button type="button" data-toggle="modal" data-target="#confirmationModal<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Accept Offer</button>
                                        </a>
                                        <button class="read-more-button2<?php echo $proposalId?>">See More</button>

                                        <a class="ignore1" href="javascript:void(0);"><button type="button" data-toggle="modal" style="background:red" data-target="#reject<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Reject</button></a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
               


                <script>
                    const content2<?php echo $proposalId ?> = document.querySelector('.content2<?php echo $proposalId ?>');
                    const readMoreButton2<?php echo $proposalId ?> = document.querySelector('.read-more-button2<?php echo $proposalId ?>');

                    readMoreButton2<?php echo $proposalId ?>.addEventListener('click', function () {
                        if (content2<?php echo $proposalId ?>.classList.contains('hidden')) {
                            content2<?php echo $proposalId ?>.classList.remove('hidden');
                            readMoreButton2<?php echo $proposalId ?>.textContent = 'See Less';
                        } else {
                            content2<?php echo $proposalId ?>.classList.add('hidden');
                            readMoreButton2<?php echo $proposalId ?>.textContent = 'See More';
                        }
                    });
                </script>
                </div>
               


                
        <?php
     }
    }
} else {
    echo 'Error executing the query.';
}
?>
            <!-- SECOND OFFER ONETIME END -->

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
