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
    $sql = "SELECT service_name, price, counter_price FROM customer_services WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $providerId, $proposalId, $userId);

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
?>
<!DOCTYPE html>
<html lang="zxx">

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

<body class="dashboard">
  
<?php
include 'Black_logo_header.php'
?>



<section id="dashboard-main-miles">

<div class="dashboard-innermiles">
<div class="container">
    <h2>Dashboard</h2>
    <div class="row">
    <?php
include 'connection.php';

$userId = $_SESSION['user_id'];

// Create an array to store the count for each status
$statusCounts = array(
    'order_in_progress' => 0,
    'scheduled_offer' => 0,
    'replied_offer' => 0,
    // Add more statuses as needed
);

$sql = "SELECT * FROM customer_proposal WHERE customer_id = ?";
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

// Output the count of proposals for each status
echo '<div class="col-lg-4 mb-3 mb-lg-0">';
echo '<div class="miles-runners">';
echo '<number>' . $statusCounts['order_in_progress'] . '</number>';
echo '<p>Completed Tasks</p>';
echo '</div>';
echo '</div>';

echo '<div class="col-lg-4 mb-3 mb-lg-0">';
echo '<div class="miles-runners">';
echo '<number>' . $statusCounts['scheduled_offer'] . '</number>';
echo '<p>Scheduled Hiring\'s</p>';
echo '</div>';
echo '</div>';

echo '<div class="col-lg-4 mb-3 mb-lg-0">';
echo '<div class="miles-runners">';
echo '<number>' . $statusCounts['replied_offer'] . '</number>';
echo '<p>Recent Offer\'s</p>';
echo '</div>';
echo '</div>';

// You can continue this pattern for other statuses if needed
?>

        <!-- <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="miles-runners">
                <number>20</number>
                <p>Completed Tasks</p>
            </div>
        </div>
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="miles-runners">
                <number>40</number>
                <p>Scheduled Hiring's</p>
            </div>
        </div> -->
        <!-- <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="miles-runners">
                <number>140</number>
                <p>Recent Offers</p>
            </div>
        </div> -->
    </div>
</div>
</div>
</section>


<!-- DASHBOARD HIRING START -->

<section id="dashboard-hiringsection" style="padding: 60px 0px;">
<div class="container">

<div class="row">
<div class="col-lg-6 mb-3 mb-lg-0">
<div class="dash-hiring-inner" style="padding: 30px 0px;">
  <h2>My Hiring's</h2>
  <?php
              include 'connection.php';

              $userId = $_SESSION['user_id'];

              $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND (status = 'order_in_progress' OR status = 'scheduled_offer') ORDER BY status = 'order_in_progress' DESC, status = 'scheduled_offer' DESC";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('s', $userId);

              if ($stmt->execute()) {
                  $result = $stmt->get_result();
                  if ($result->num_rows == 0) {
                    // No orders found for the provider
                    echo '<h2 class="text-center texter">No new Hirings available.</h2>';
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
                $counterTotall = $row['counter_totall'];
                $current_time = $row['current_time'];

                // Retrieve customer name and address based on customerId
                $customerInfo = getCustomerInfo($providerId);

                $customerImages = getCustomerImagesForProvider($providerId, $proposalId, $customerId);
                $serviceCustomers = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                $serviceCustomers1 = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                // Output the retrieved customer name and address
                $customerName = $customerInfo['fullname'];
                $customerAddress = $customerInfo['address'];
                $profile_picture = $customerInfo['profile_picture'];
            ?>
                              <div class="hiring-list-main" style="padding: 30px 30px; margin-bottom: 30px;">
                                <div class="dash-text-wthicn">
                                  <div class="text-inner">
                                    <img src="../provider/<?php echo $profile_picture?>">
                                    <div class="dash-text-all">
                                  <h5><?php echo $customerName?></h5>
                                  <h6>Garden Maintenance</h6>
                                  <h4>Hired On <?php echo $current_time?></h4>
                                  </div>
                                  </div>
                                  <div class="dash-order-list">
                                    <ul>
                                      <li><em><img src="./images/dashboard/calender.png"/> <?php echo $selectedDate , str_repeat('&nbsp;', 5), $selectedTime?></em></li>
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
                                            <?php 
                                                    foreach ($serviceImages as $imagePath) {
                                                        ?>
                                                        <!-- <img src="../admin/uploads/ <?php //echo $imagePath ?>" alt="Service Image" /> -->
                                                        <li><em><img src="../admin/uploads/<?php echo $imagePath?>"/> <?php echo $servicesNew ?></em></li>
                                                        <?php $counter++; } ?>
                                                        <?php 
                                        $counter++; } ?>
        </ul>
      </div>
    </div>
    <?php if ($row['status'] === 'scheduled_offer') { ?>
        <div class="schedulebutton">
            <a href="#"><button><img src="./images/dashboard/check.png"/> Scheduled</button></a>
        </div>
        <?php } else { ?>
            <div class="schedulebutton">
                <a href="#"><button style="background:#51A699;"><img src="./images/dashboard/check.png"/> Order In Progress</button></a>
            </div>
            <?php } ?>
    <!-- <div class="schedulebutton">
      <a href="#"><button><img src="./images/dashboard/check.png"/> Scheduled</button></a>
    </div> -->
    
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
?>
</div>
</div>

<div class="col-lg-6 mb-3 mb-lg-0">
    <div class="recent-offer-inner">
      <h2>Recent Offers</h2>
      <?php
              include 'connection.php';

              $userId = $_SESSION['user_id'];
              $customerFullName = $_SESSION['customerFullName'];

              $sql = "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'replied_offer'";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param('s', $userId);

              if ($stmt->execute()) {
                  $result = $stmt->get_result();
                  if ($result->num_rows == 0) {
                    // No orders found for the provider
                    echo '<h2 class="text-center texter">No Recent orders available.</h2>';
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
                $currentTotall = $row['counter_totall'];

                // Retrieve customer name and address based on customerId
                $customerInfo = getCustomerInfo($providerId);

                $customerImages = getCustomerImagesForProvider($providerId, $proposalId, $customerId);
                $serviceCustomers = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                $serviceCustomers1 = getCustomerServicesAndPrices($providerId, $proposalId, $userId);
                
                
                // Now you have an array containing the selected services and their prices for the customer
                
                // Output the retrieved customer name and address
                $customerName = $customerInfo['fullname'];
                $customerAddress = $customerInfo['address'];
                $profile_picture = $customerInfo['profile_picture'];
            ?>
             <div class="modal" id="accept<?php echo $proposalId?>" role="dialog">
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

                        <div class="modal" id="rejects<?php echo $proposalId?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        
                                    </div>
                                    <div class="modal-body h-auto">
                                        <h2 class="pb-4">Are you sure you want to reject this offer?</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerFullName?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId?>" />
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            onclick="rejectOffers(<?php echo $proposalId; ?>)">yes</button>
                                    </div>
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

                                    <div class="recent-text-inner" style="padding: 30px 0px;">
                                        <img src="../provider/<?php echo $profile_picture?>">
                                        <div class="dash-text-all">
                                          <h5><?php echo $customerName?></h5>
                                          <h6>Garden Maintenance</h6>
                                          <h4>offered On <?php echo $current_time?></h4>
                                        </div>
                                        <div class="dash-order-list">
                                          <ul>
                                            <li><em><img src="./images/dashboard/calender.png"/> <?php echo $selectedDate , str_repeat('&nbsp;', 5), $selectedTime?></em></li>
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
                                            // $counterNote = $serviceCustomers1Item['counter_note'];

                                            $serviceCustomers1Index++;
                                            ?>
                                            <?php 
                                                    foreach ($serviceImages as $imagePath) {
                                                        ?>
                                                        <!-- <img src="../admin/uploads/ <?php //echo $imagePath ?>" alt="Service Image" /> -->
                                                        <li><em><img src="../admin/uploads/<?php echo $imagePath?>"/> <?php echo $servicesNew ?></em></li>
                                                        <?php $counter++; } ?>
                                                        <?php 
                                        $counter++; } ?>
                                        <li style="
    display: flow-root;
"><span>Counter Offer : $<?php echo $currentTotall?></span></li>
                                          </ul>
                                        </div>
                                        <div class="recent-button">
                                        <a href="javascript:void(0);">
                                            <button type="button" data-toggle="modal" data-target="#accept<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Accept Offer</button>
                                        </a>
                                        <a class="ignore1" href="javascript:void(0);"><button type="button" data-toggle="modal" style="background:red" data-target="#rejects<?php echo $proposalId;?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Reject</button></a>
                                        </div>
                                    </div>
    
            
    <?php
     }
    }
} else {
    echo 'Error executing the query.';
}
?>
  <!-- 2ND RECENT OFFER  -->
  



</div>
</div>

</div>
<!-- ROW END -->


</div>
<!-- CONTAINER END -->
</section>



<!-- DASHBOARD HIRING END -->


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
<!-- venobox -->
<script src="plugins/venobox/venobox.min.js"></script>
<!-- shuffle -->
<script src="plugins/shuffle/shuffle.min.js"></script>
<!-- apear js -->
<script src="plugins/counto/apear.js"></script>
<!-- counter -->
<script src="plugins/counto/counTo.js"></script>
<!-- card slider -->
<script src="plugins/card-slider/js/card-slider-min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="plugins/google-map/gmap.js"></script>

<!-- Main Script -->
<script src="js/script.js"></script>

</body>
</html>

