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
    $sql = "SELECT service_name, price FROM customer_services WHERE customer_id = ? AND proposal_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $customerId, $proposalId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $servicesAndPrices = array();

        while ($row = $result->fetch_assoc()) {
            $serviceCustomers = $row['service_name'];
            $priceService = $row['price'];
            $servicesAndPrices[] = array('service_name' => $serviceCustomers, 'price' => $priceService);
            
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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
        rel="stylesheet">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Aaron Burks </title>
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
        
            <?php
      include 'SideMenu.php'
      ?>
            <!-- partial -->
            <div class="main-panel">
                
                <!-- START ROW MAIN-PANEL -->
                <div class="row">


                    <div class="order-in-progress">
                        <h1><b style="color: #70BE44;">New </b>Offers</h1>
                        <div class="onetime-advancebokingbutton">
                            <ul>
                                <li><a href="new-offers.php"><button style="color: #fff; background-color: #70BE44;">One
                                            Time Service</button></a></li>
                                <li><a href="new-offers-advancebooking.php"><button
                                            style="color: #959595; background-color: #E6E6E6;">Advance
                                            Bookings</button></a></li>
                            </ul>
                        </div>
                        <!-- FIRST NEW OFFER -->
                        <?php
                include 'connection.php';

                $userId = $_SESSION['user_id'];
                $providerName = $_SESSION['providerName'];

                $sql = "SELECT * FROM customer_proposal WHERE provider_id = ? AND status = 'new_offer' AND proposal_status = 'OneTime' ";
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
                  $current_time = $row['current_time'];

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
                  // $image_path = $customerImages['image_path'];
                ?>
                        <div class="modal" id="confirmationModal<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Acceptance</h5>
                                       
                                    </div>
                                    <div class="modal-body h-auto">
                                        <h2 class="pb-4">Are you sure you want to accept this offer?</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            onclick="acceptOffer(<?php echo $proposalId; ?>)">Accept</button>
                                    </div>
                                    <script>
                                        function acceptOffer(proposalId) {
                                            const counterNote = document.getElementById('counterNote').value;
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const providerName = document.getElementById('providerName').value;
                                            const messageContent = `${providerName} has accepted your offer you have to pay firstly then your order will be schedule. <a href='http://localhost:81/alon_burks/customer/checkout.php?proposalid=${proposalId}' target='_blank'>Pay..</a>`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                statusFrom: 'provider_send',
                                                status: 'scheduled_offer',
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
                        <div class="modal" id="reject<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                   
                                    <div class="modal-body h-auto">
                                        <h2 class="pb-4">Are you sure you want to reject this offer?</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            onclick="rejectOffer(<?php echo $proposalId; ?>)">yes</button>
                                    </div>
                                    <script>
                                        function rejectOffer(proposalId) {
                                            const counterNote = document.getElementById('counterNote').value;
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const providerName = document.getElementById('providerName').value;
                                            const messageContent = `${providerName} has rejected your offer.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
                                                status: 'reject_offer',
                                                statusFrom: 'provider_send',
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

                        <!-- counter modal -->
                       <!-- Counter Offer Modal -->
                       <div class="modal" id="new<?php echo $proposalId?>" role="dialog" data-proposal-id="<?php echo $proposalId ?>" data-total-amount="<?php echo $totalAmount ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h4 class="modal-title">Your Counter Offer For the services</h4>
                                    </div>
                                     
                                    <div class="modal-body" data-proposal="<?php echo $proposalId ?>">
                                    <ul class="services-selected-counteroffer">
                                        <?php
                                        $platformChargesPercentage = 10; // 10% platform charges

                                        // Calculate platform charges
                                        $platformCharges = ($totalAmount * $platformChargesPercentage) / 100;

                                        // Calculate the amount you'll earn
                                        $amountYouWillEarn = $totalAmount - $platformCharges;

                                        // Initialize an index variable for serviceCustomers1
                                        $serviceCustomers1Index = 0;

                                        // Iterate through selected services
                                        $counter = 1;
                                        foreach ($selectedServices as $service) {
                                            // Retrieve the price of the service from the categories table
                                            $serviceImages = getServiceImages([$service]);
                                            $serviceCustomers1Item = $serviceCustomers1[$serviceCustomers1Index];

                                            // Get service name and price
                                            $servicesNew = $serviceCustomers1Item['service_name'];
                                            $servicePrice = $serviceCustomers1Item['price'];

                                            // Increment the index for serviceCustomers1
                                            $serviceCustomers1Index++;

                                            // Display service images and details
                                            ?>
                                            <li>
                                                
                                                <em>
                                                    <?php 
                                                    
                                                    foreach ($serviceImages as $imagePath) { 
                                                        
                                                        ?>
                                                        <img src="../admin/uploads/<?php echo $imagePath ?>" alt="Service Image" /><?php echo $servicesNew ?>
                                                    <?php $counter++; } ?>
                                                    <span>$<em style="font-size: 19px;" data-id="<?php echo $servicesNew;?>" data-service-id="<?php echo $counter; ?>" onblur="updateServicePrice(this);" id="<?php echo $counter; ?>_id" contenteditable="true"><?php echo $servicePrice; ?></em></span>
                                                </em>
                                            </li>
                                        <?php  //$counter++;
                                        $counter++; } ?>

                                        <li class="totalcharges">
                                            <em>
                                                <img src="./images/counteroffer/4.png" /> Total Charges
                                            </em>
                                            <span>$<?php echo $totalAmount ?></span>
                                        </li>
                                    </ul>


                                        <ul class="percent-counter">
                                            <li>
                                                <em>Platform Charges (<?php echo $platformChargesPercentage ?>%)</em>
                                                <!-- <span>$<?php //echo $platformCharges ?></span> -->
                                            </li>
                                            <li>
                                                <em>Your will Earn</em>
                                                <span>$<?php echo $amountYouWillEarn ?></span>
                                            </li>
                                        </ul>

                                          <div class="text-area-counter">
                                              <h2>Note To Support Your Counter Offer</h2>
                                              <textarea name="counter_note" id="counterNote"></textarea>
                                              <input type="hidden" name="providerId" value="<?php echo $userId ?>" id="providerId" />
                                              <input type="hidden" name="customerId" value="<?php echo $customerId ?>" id="customerId" />
                                              <input type="hidden" name="providerName" value="<?php echo $providerName ?>" id="providerName" />
                                          </div>
                                    </div>
                                   



                                    <div class="modal-footer">
                                        <a href="javascript:void(0);">
                                            <button id="sendButton_<?php echo $proposalId; ?>">Send</button>
                                        </a>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <div class="first-offer">
                            <div class="profileheadsection">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div>
                                            <div
                                                style="width:60px;height:60px;border-radius: 112px;margin-bottom:10px;">
                                                <img style="width: 100%;object-fit: fill;height: 100%;border-radius: 118px;"
                                                    src="../customer/<?php echo $profile_picture; ?>"/>
                                            </div>
                                            <h3>
                                                <?php echo $customerName?><br><b>User ID #
                                                    <?php echo $customerId?>
                                                </b>
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <h3 class="address"><img src="./images/mappin.png" />
                                            <?php echo $customerAddress?>
                                        </h3>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                    <?php foreach ($selectedDate as $key => $date): ?>
                                        <h6 style="color: #4492BE;"><img src="./images/scheduled.png" />
                                        <?php echo date('d-M-Y , D', strtotime($date)); ?><?php echo $selectedTime[$key]; ?>
                                        </h6>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <h4 style="color: #70BE44;font-size: 14px;">Offered On
                                            <?php echo $current_time ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                            <div class="service-selectedsection">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="order-details-progress">
                                            <h2>Order details</h2>
                                            <ul class="orderdetails-lists">
                                            <?php foreach ($serviceCustomers as $servicenew) {
                                                            $services = $servicenew['service_name'];
                                                            $servicePrice = $servicenew['price'];

                                                            // echo $serviceCustomers; echo "<br/>";
                                                            // echo $servicePrice;echo "<br/>";
                                                            ?>
                                                <li><em><?php echo $services ?></em><span style="color: #70BE44;">$<?php echo $servicePrice; ?></span></li>
                                                <?php
                                            }?>
                                            <li class="total-amount"><em><b>Total amount paid</b></em><span style="color: #70BE44;"><b>$ <?php echo $totalAmount?></b></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Task Description</h6>
                                        <p>
                                            <?php echo $userContent?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="location-images-section">
                                <h2>Location Images </h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="location-images">

                                            <ul class="gallery-images">
                                                <?php
                                      foreach (array_slice($customerImages, 0, 5) as $imagePath) {
                                      ?>
                                                <li>
                                                    <img src="../customer/<?php echo $imagePath; ?>"
                                                        alt="Customer Image" />
                                                </li>
                                                <?php
                                      }
                                      ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                            </div>

                            <div class="buttons-newoffers" style="padding: 30px 0px;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="javascript:void(0);">
                                            <button type="button" data-toggle="modal" data-target="#confirmationModal<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Accept Offer</button>
                                        </a>
                                    </div>



                                    <div class="col-md-4">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#new<?php echo $proposalId?>" 
                                        data-total-amount="<?php echo $totalAmount; ?>" 
                                        data-selected-services="<?php echo json_encode($selectedServices); ?>" 
                                        data-service-customers="<?php echo json_encode($serviceCustomers1); ?>"><button style="background-color: #fff; border-color: #70BE44; color: #70BE44;">Counter Offer</button>
                                    </a>

                                    </div>
                                    <div class="col-md-4">
                                        <a class="ignore1" href="javascript:void(0);"><button type="button" data-toggle="modal" data-target="#reject<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Ignore</button></a>
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
           
             <script>
  // Function to calculate the updated total amount based on edited service prices
  function updateTotalAmount(modal) {
    const editablePrices = modal.querySelectorAll('[contenteditable="true"]');
    let updatedTotalAmount = 0;

    editablePrices.forEach((priceElement) => {
      // Parse the edited price (default to 0 if not a valid number)
      const editedPrice = parseFloat(priceElement.textContent) || 0;
      updatedTotalAmount += editedPrice;
    });

    // Calculate platform charges (10%)
    const platformChargesPercentage = 10;
    const platformCharges = (updatedTotalAmount * platformChargesPercentage) / 100;

    // Calculate the amount you'll earn
    const amountYouWillEarn = updatedTotalAmount - platformCharges;

    // Display the updated total amount and "Your will Earn"
    const totalAmountElement = modal.querySelector('.totalcharges span');
    const amountYouWillEarnElement = modal.querySelector('.percent-counter li:last-child span');

    if (totalAmountElement) {
      totalAmountElement.textContent = '$' + updatedTotalAmount.toFixed(2);
    }

    if (amountYouWillEarnElement) {
      amountYouWillEarnElement.textContent = '$' + amountYouWillEarn.toFixed(2);
    }
  }

  // Add input and blur event listeners to each editable price element for all modals
  const modals = document.querySelectorAll('.modal');
  modals.forEach((modal) => {
    const editablePrices = modal.querySelectorAll('[contenteditable="true"]');
    editablePrices.forEach((priceElement) => {
      priceElement.addEventListener('input', () => updateTotalAmount(modal));
      priceElement.addEventListener('blur', () => updateTotalAmount(modal));
    });

    // Initialize total amount and "Your will Earn" when the page loads
    updateTotalAmount(modal);
  });
</script>
<script>
function updateServicePrice(proposalId) {
    // Get the modal element
    const modal = document.getElementById(`new${proposalId}`);
    
    // Get the total amount from the modal
   // Calculate the total amount
   const totalAmountElement = modal.querySelector('.totalcharges span');
    const totalAmount = parseFloat(totalAmountElement.textContent.replace('$', '')) || 0;
    const counterNote = document.getElementById('counterNote').value;
    const providerId = document.getElementById('providerId').value;
    const customerId = document.getElementById('customerId').value;
    const providerName = document.getElementById('providerName').value;


    // Collect the updated service prices and their names
    const updatedServicePrices = [];
    const editablePrices = modal.querySelectorAll('[contenteditable="true"]');
    
    editablePrices.forEach((priceElement) => {
        const editedPrice = parseFloat(priceElement.textContent) || 0;
        const serviceName = priceElement.dataset.id; // Service name
        updatedServicePrices.push({ name: serviceName, price: editedPrice });
    });

    // Calculate the platform charges
    const platformChargesPercentage = 10;
    const platformCharges = (totalAmount * platformChargesPercentage) / 100;

    // Calculate the amount the user will earn
    const amountYouWillEarn = totalAmount - platformCharges;

    // Create an object with the updated service prices and the total amount
    const data = {
        proposalId: proposalId,
        providerId: providerId,
        customerId: customerId,
        providerName: providerName,
        servicePrices: updatedServicePrices,
        totalAmount: totalAmount,
        platformCharges: platformCharges,
        amountYouWillEarn: amountYouWillEarn,
        counterNote: counterNote,

    };

    console.log('data', data);
    // return;
    // Send the data to the server using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update-service-price.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server (e.g., display a success message).
            const response = JSON.parse(xhr.responseText);
            
            if (response.success) {
                location.reload(); // This will refresh the current page    
                // Optionally, close the modal or redirect to another page.
            } else {
                alert('Counter offer could not be sent. Please try again.');
            }
        }
    };

    xhr.send(JSON.stringify(data));
}

// Add a click event listener to each "Send" button
const modalFooterButtons = document.querySelectorAll('[id^="sendButton_"]');
modalFooterButtons.forEach((button) => {
    const proposalId = button.id.split('_')[1];
    button.addEventListener('click', () => updateServicePrice(proposalId));
});
</script>



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