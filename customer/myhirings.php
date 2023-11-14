<?php
session_start();
include('../helper/encryption.php');
include('../helper/decryption.php');
include 'connection.php';
$encrp = new encryption();
$decrp = new decryption();
// Function to get customer information from the provider_registration table
global $proposalId;
function getCustomerInfo($providerId)
{
    global $conn;
    $sql =
        "SELECT id, fullname, profile_picture, address FROM provider_registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $providerId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }
    return [
        "fullname" => "N/A",
        "address" => "N/A",
        "profile_picture" => "N/A",
    ]; // Provide default values if customer info not found
}
// Function to get the price of a service from the categories table
function getCustomerServicesAndPrices($providerId, $proposalId, $userId)
{
    global $conn;
    $sql =
        "SELECT service_name, price, counter_price FROM customer_services WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $providerId, $proposalId, $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $servicesAndPrices = [];

        while ($row = $result->fetch_assoc()) {
            $serviceCustomers = $row["service_name"];
            $priceService = $row["price"];
            $counterPrice = $row["counter_price"];
            $servicesAndPrices[] = [
                "service_name" => $serviceCustomers,
                "price" => $priceService,
                "counter_price" => $counterPrice,
            ];
            // print_r($servicesAndPrices);
        }

        return $servicesAndPrices;
    }

    return [];
}
function getServicePrice($service)
{
    global $conn;
    $sql = "SELECT price FROM customer_services WHERE service_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $service);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["price"];
        }
    }
    return "N/A"; // Provide a default value if service price not found
}
function getCustomerImagesForProvider($providerId, $proposalId, $customerId)
{
    global $conn;
    $sql =
        "SELECT image_path FROM customer_images WHERE provider_id = ? AND proposal_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $providerId, $proposalId, $customerId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row["image_path"];
        }
        return $images;
    }
    return [];
}

function getServiceImages($service)
{
    global $conn;
    $servicesImages = [];

    // Create a prepared statement to select servicesImages based on service names
    $sql = "SELECT image FROM categories WHERE heading IN (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $categories = implode("', '", $service); // Assuming service names are in an array
        $stmt->bind_param("s", $categories);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $servicesImages[] = $row["image"];
            }
        }
    }

    return $servicesImages;
}
function ratingcount($providerId, $proposalId){
  global $conn;
  $sql =
      "SELECT count(rating) AS rating FROM ratings WHERE provider_id = ? AND proposal_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $providerId, $proposalId);
  if ($stmt->execute()) {
      $result = $stmt->get_result();
      $rating = [];
      while ($row = $result->fetch_assoc()) {
          $rating[] = $row['rating'];
      }
      return $rating;
  }
  return "0";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['user_id'], $_POST['proposal_id'], $_POST['provider_id'], $_POST['starrating'])) {
      // $duserId = $decrp -> decrypting($_POST['user_id']);
      // $dproposalId = $decrp -> decrypting($_POST['proposal_id']);
      // $dproviderId = $decrp -> decrypting($_POST['provider_id']);

      $duserId = $_POST['user_id'];
      $dproposalId = $_POST['proposal_id'];
      $dproviderId = $_POST['provider_id'];

      $starrating = $_POST['starrating'];
      $feedback = $_POST['Feedback'];
      global $conn;
      try {
          $sql = "INSERT INTO ratings (proposal_id, provider_id, user_id, rating, Feedback) VALUES (?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('iiiss', $dproposalId, $dproviderId, $duserId, $starrating, $feedback);
          $stmt->execute();
          $stmt->close();
          echo "<script>alert('Thank you for Rating..');</script>";
          // return true;
      } catch (Exception $e) {
          return false;
      }
  }
}
?>
<!DOCTYPE html>
<html lang="zxx" class="myhirings">

<head>
  <meta charset="utf-8">
  <title>My Hirings</title>

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
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body class="services-page dashboard">


  
<?php include "Black_logo_header.php"; ?>

  <section id="my-hiringpanel">

    <div class="container">
      <div class="myoffer-button-serv">
        <h2 style="color: #000; font-weight: bold;">My Hirings</h2>
        <p style="color: #70BE44;">Here are your past services you availed and hired!</p>
        <ul>
          <li><a href="myhirings.php"><button style="background-color: #70BE44; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #fff;
                ">One Time Service</button></a></li>
          <li><a href="myrecurrings.php"><button style="background-color: #E6E6E6; font-family: Cairo;
                font-size: 30px;
                font-weight: 600;
                line-height: 56px;
                letter-spacing: 0em;
                text-align: left;
                color: #9D9D9D;
                ">Advance Booking</button></a></li>
        </ul>
      </div>
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Scheduled</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Pending</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">In progress</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">Completed</a>
        </li>
      </ul><!-- Tab panes -->
    </div>

    <div class="tab-content">


      <div class="tab-pane active" id="tabs-1" role="tabpanel">
      <?php
      // include "connection.php";

      $userId = $_SESSION["user_id"];

      $sql =
          "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'scheduled_offer' ORDER BY current_time DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $userId);

      if ($stmt->execute()) {
          $result = $stmt->get_result();
          if ($result->num_rows == 0) {
              // No orders found for the provider
              echo '<h2 class="text-center texter">No new orders available.</h2>';
          } else {
              while ($row = $result->fetch_assoc()) {

                  $proposalId = $row["id"];
                  $customerId = $row["customer_id"];
                  $providerId = $row["provider_id"];
                  $selectedDate = $row["selected_date"];
                  $selectedTime = $row["selected_time"];
                  $userContent = $row["user_content"];
                  $selectedServices = explode(", ", $row["selected_services"]);
                  $totalAmount = $row["total_amount"];
                  $counterTotall = $row["counter_totall"];
                  $current_time = $row["current_time"];

                  // Retrieve customer name and address based on customerId
                  $customerInfo = getCustomerInfo($providerId);

                  $customerImages = getCustomerImagesForProvider(
                      $providerId,
                      $proposalId,
                      $customerId
                  );
                  $serviceCustomers = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );
                  $serviceCustomers1 = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );

                  // Now you have an array containing the selected services and their prices for the customer

                  // Output the retrieved customer name and address
                  $customerId = $customerInfo["id"];
                  $customerName = $customerInfo["fullname"];
                  $customerAddress = $customerInfo["address"];
                  $profile_picture = $customerInfo["profile_picture"];
                  ?>
                  

        <!-- hiring panel start -->
        <section id="hiring" style="padding: 60px 0px;">
          <div class="container">
            <div class="hiring-inner">
              <div class="row first-inner">
                <div class="col-lg-3 mb-3 mb-lg-0">
                  <div class="textwith-icon1">
                    <img src="../provider/<?php echo $profile_picture; ?>" />
                    <div class="text-inner">
                      <?php
                      // echo $providerId;
                      // echo $customerId;
                      ?>

                      <h5><?php echo $customerName; ?></h5>
                      <h6>Garden Maintenance</h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">
                    <i class="fa fa-check" aria-hidden="true"></i> 50+ Completed task
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">
                    <i class="fa fa-clock" aria-hidden="true"></i> <?php echo $selectedDate,
                        str_repeat("&nbsp;", 5),
                        $selectedTime; ?>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2 last-textinner">
                    <ul class="button-sec">
                      <li><a href="#">Cancel Service</a></li>
                      <li><a href="#"><button>Scheduled</button></a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="row second-inner">
                <div class="col-lg-5 mb-8 mb-lg-0">
                  <h2>Services Selected</h2>
                  <div class="pricedetails">
                    <ul>
                    <?php
                    $displayTotal = isset($counterTotall)
                        ? $counterTotall
                        : $totalAmount;
                    foreach ($serviceCustomers as $servicenew) {

                        $services = $servicenew["service_name"];
                        $servicePrice = $servicenew["price"];

                        // Check if counter service price is available
                        if (isset($servicenew["counter_price"])) {
                            $counterPrice = $servicenew["counter_price"];
                        } else {
                            // If counter price is not available, use the original service price
                            $counterPrice = $servicePrice;
                        }
                        ?>
                            <li>
                                <em><?php echo $services; ?></em>
                                <span style="color: #70BE44;">$<?php echo $counterPrice; ?></span>
                            </li>
                        <?php
                    }
                    ?>
                            <li class="custom-total-price">
                                <em>Total Cost offer</em>
                                <span style="color: #70BE44;">$<?php echo $displayTotal; ?></span>
                            </li>
                    </ul>
                  </div>


                </div>
                <div class="col-lg-1 mb-1 mb-lg-0"></div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                  <div class="task">
                    <h2>Task Description</h2>
                    <p><?php echo $userContent; ?></p>
                  </div>
                </div>
              </div>

              <div class="row-second-inner">
                <div class="panel content<?php echo $proposalId; ?> hidden">
                  <div class="gallery-servces moretext">
                    <h2>Service Place</h2>
                    <ul class="my-galleryserv">
                    <?php foreach (
                        array_slice($customerImages, 0, 5)
                        as $imagePath
                    ) { ?>
                                <li>
                                    <img src="../customer/<?php echo $imagePath; ?>" alt="Customer Image" />
                                </li>
                            <?php } ?>
                    </ul>
                  </div>
                </div>

                <a class="btn flip read-more-button<?php echo $proposalId; ?>">See More</a>

              </div>

            </div>

          </div>
        </section>
        <script>
        const content<?php echo $proposalId; ?> = document.querySelector('.content<?php echo $proposalId; ?>');
        const readMoreButton<?php echo $proposalId; ?> = document.querySelector('.read-more-button<?php echo $proposalId; ?>');

        readMoreButton<?php echo $proposalId; ?>.addEventListener('click', function () {
            if (content<?php echo $proposalId; ?>.classList.contains('hidden')) {
                content<?php echo $proposalId; ?>.classList.remove('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See Less';
            } else {
                content<?php echo $proposalId; ?>.classList.add('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See More';
            }
        });
    </script>
        <?php
              }
          }
      } else {
          echo "Error executing the query.";
      }
      ?>
      <!-- HIring Panel End -->
      </div>


      <div class="tab-pane" id="tabs-2" role="tabpanel">
      <?php
      // include "connection.php";

      $userId = $_SESSION["user_id"];

      $sql =
          "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'new_offer' ORDER BY current_time DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $userId);

      if ($stmt->execute()) {
          $result = $stmt->get_result();
          if ($result->num_rows == 0) {
              // No orders found for the provider
              echo '<h2 class="text-center texter">No new orders available.</h2>';
          } else {
              while ($row = $result->fetch_assoc()) {

                  $proposalId = $row["id"];
                  $customerId = $row["customer_id"];
                  $providerId = $row["provider_id"];
                  $selectedDate = $row["selected_date"];
                  $selectedTime = $row["selected_time"];
                  $userContent = $row["user_content"];
                  $selectedServices = explode(", ", $row["selected_services"]);
                  $totalAmount = $row["total_amount"];
                  $current_time = $row["current_time"];
                  $counterTotall = $row["counter_totall"];

                  // Retrieve customer name and address based on customerId
                  $customerInfo = getCustomerInfo($providerId);

                  $customerImages = getCustomerImagesForProvider(
                      $providerId,
                      $proposalId,
                      $customerId
                  );
                  $serviceCustomers = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );
                  $serviceCustomers1 = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );

                  // Now you have an array containing the selected services and their prices for the customer

                  // Output the retrieved customer name and address
                  $customerId = $customerInfo["id"];
                  $customerName = $customerInfo["fullname"];
                  $customerAddress = $customerInfo["address"];
                  $profile_picture = $customerInfo["profile_picture"];
                  ?>


        <section id="hiring" style="padding: 60px 0px;">
          <div class="container">
            <div class="hiring-inner">
              <div class="row first-inner">
                <div class="col-lg-3 mb-3 mb-lg-0">
                  <div class="textwith-icon1">
                    <img src="../provider/<?php echo $profile_picture; ?>" />
                    <div class="text-inner">
                      <h5><?php echo $customerName; ?></h5>
                      <h6>Garden Maintenance</h6>
                      <a href="message.php"><button class="messagebutton"
                          style="background-color: #70BE44; color: #fff;">Message Provider</button></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">
                    <p><img src="./images/strr.png" />4.9</p>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">

                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2 last-textinner">
                    <ul class="button-sec">
                      <li class="onetimepayment"><a type="button" data-toggle="modal" data-target="#confirmationModal<?php echo $proposalId; ?>"
                                                data-proposal-id="<?php echo $proposalId; ?>">Verify</a></li>
                      <li class="arrive1d"><a href="#"><button>Arrived</button></a></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="row second-inner">
                <div class="col-lg-5 mb-8 mb-lg-0">
                  <h2>Services Selected</h2>
                  <div class="pricedetails">
                    <ul>
                    <?php
                    $displayTotal = isset($counterTotall)
                        ? $counterTotall
                        : $totalAmount;
                    foreach ($serviceCustomers as $servicenew) {

                        $services = $servicenew["service_name"];
                        $servicePrice = $servicenew["price"];

                        // Check if counter service price is available
                        if (isset($servicenew["counter_price"])) {
                            $counterPrice = $servicenew["counter_price"];
                        } else {
                            // If counter price is not available, use the original service price
                            $counterPrice = $servicePrice;
                        }
                        ?>
                            <li>
                                <em><?php echo $services; ?></em>
                                <span style="color: #70BE44;">$<?php echo $counterPrice; ?></span>
                            </li>
                        <?php
                    }
                    ?>
                      <li class="custom-total-price"><em>Total Cost offer</em> <span style="color: #70BE44;">$
                          <?php echo $displayTotal; ?></span></li>
                    </ul>
                  </div>

                </div>
                <div class="col-lg-1 mb-1 mb-lg-0"></div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                  <div class="task">
                    <h2>Task Description</h2>
                    <p><?php echo $userContent; ?></p>
                  </div>
                </div>
              </div>

              <div class="row-second-inner">
                <div class="panel content<?php echo $proposalId; ?> hidden">
                  <div class="gallery-servces moretext">
                    <h2>Service Place</h2>
                    <ul class="my-galleryserv">
                    <?php foreach (
                        array_slice($customerImages, 0, 5)
                        as $imagePath
                    ) { ?>
                                <li>
                                    <img src="../customer/<?php echo $imagePath; ?>" alt="Customer Image" />
                                </li>
                            <?php } ?>
                    </ul>
                  </div>
                </div>

                <a class="btn flip read-more-button<?php echo $proposalId; ?>">See More</a>

              </div>

            </div>

          </div>
        </section>

        <script>
        const content<?php echo $proposalId; ?> = document.querySelector('.content<?php echo $proposalId; ?>');
        const readMoreButton<?php echo $proposalId; ?> = document.querySelector('.read-more-button<?php echo $proposalId; ?>');

        readMoreButton<?php echo $proposalId; ?>.addEventListener('click', function () {
            if (content<?php echo $proposalId; ?>.classList.contains('hidden')) {
                content<?php echo $proposalId; ?>.classList.remove('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See Less';
            } else {
                content<?php echo $proposalId; ?>.classList.add('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See More';
            }
        });
    </script>
        <?php
              }
          }
      } else {
          echo "Error executing the query.";
      }
      ?>
       
      </div>



      <div class="tab-pane" id="tabs-3" role="tabpanel">
      <?php
      // include "connection.php";

      $userId = $_SESSION["user_id"];
      $customerFullName = $_SESSION["customerFullName"];

      $sql =
          "SELECT * FROM customer_proposal WHERE customer_id = ? AND (status = 'working' OR status = 'order_in_progress') ORDER BY status = 'Working' DESC, status = 'order_in_progress' DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $userId);

      if ($stmt->execute()) {
          $result = $stmt->get_result();
          if ($result->num_rows == 0) {
              // No orders found for the provider
              echo '<h2 class="text-center texter">No new orders available.</h2>';
          } else {
              while ($row = $result->fetch_assoc()) {

                  $proposalId = $row["id"];
                  $customerId = $row["customer_id"];
                  $providerId = $row["provider_id"];
                  $selectedDate = $row["selected_date"];
                  $selectedTime = $row["selected_time"];
                  $userContent = $row["user_content"];
                  $selectedServices = explode(", ", $row["selected_services"]);
                  $totalAmount = $row["total_amount"];
                  $current_time = $row["current_time"];
                  $counterTotall = $row["counter_totall"];
                  // Retrieve customer name and address based on customerId
                  $customerInfo = getCustomerInfo($providerId);

                  $customerImages = getCustomerImagesForProvider(
                      $providerId,
                      $proposalId,
                      $customerId
                  );
                  $serviceCustomers = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );
                  $serviceCustomers1 = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );

                  // Now you have an array containing the selected services and their prices for the customer

                  // Output the retrieved customer name and address
                  $customerId = $customerInfo["id"];
                  $customerName = $customerInfo["fullname"];
                  $customerAddress = $customerInfo["address"];
                  $profile_picture = $customerInfo["profile_picture"];
                  ?>
                        <div class="modal your-offer-selected popup-selected" id="confirmationModal<?php echo $proposalId; ?>" role="dialog">
                            <div class="popup-selected-modal">
                                <div class="popupsucessfully main-panel">
                                    <img src="./images/verification.png" />
                                    <h4 class="pb-4">Kindly Verify that service provider has arrived?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal" class="bg-danger">No</button>
                                        <button type="button" data-dismiss="modal"
                                            onclick="acceptOffer(<?php echo $proposalId; ?>)">Yes, they are</button>
                                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerName; ?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId; ?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>" />
                                    </div>
                                </div>
                                <script>
                                        function acceptOffer(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has started working.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            console.log(proposalId, providerId, customerId, customerFullName);
                                            // return;
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
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
                        <div class="modal your-offer-selected popup-selected" id="completed<?php echo $proposalId; ?>" role="dialog">
                            <div class="popup-selected-modal">
                                <div class="popupsucessfully main-panel">
                                    <img src="./images/verification.png" />
                                    <h4 class="pb-4">Service provider has completed their tasks?</h4>
                                    <div class="modal-footer" style="width: -webkit-fill-available;">
                                        <button type="button" data-dismiss="modal" class="bg-danger">No</button>
                                        <button type="button" data-dismiss="modal"
                                            onclick="completed(<?php echo $proposalId; ?>)">yes he completed</button>
                                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerName; ?>" />
                                            <input type="hidden" id="providerId" name="providerId" value="<?php echo $providerId; ?>" />
                                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>" />
                                    </div>
                                </div>
                                <script>
                                        function completed(proposalId) {
                                            const providerId = document.getElementById('providerId').value;
                                            const customerId = document.getElementById('customerId').value;
                                            const customerFullName = document.getElementById('customerFullName').value;
                                            const messageContent = `${customerFullName} has  completed their tasks.`;

                                            // Send an AJAX request to update the status to "scheduled_offer" and send a message
                                            console.log(proposalId, providerId, customerId, customerFullName);
                                            // return;
                                            const xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'update_status.php'); // Create a PHP file to handle status updates and messages
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                            xhr.send(JSON.stringify({
                                                proposalId: proposalId,
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

        <section id="hiring" style="padding: 60px 0px;">
          <div class="container">
            <div class="hiring-inner">
              <div class="row first-inner">
                <div class="col-lg-3 mb-3 mb-lg-0">
                  <div class="textwith-icon1">
                    <img src="../provider/<?php echo $profile_picture; ?>" />
                    <div class="text-inner">
                      <h5><?php echo $customerName; ?></h5>
                      <h6>Garden Maintenance</h6>
                      <?php if ($row["status"] === "order_in_progress") { ?>
            
                      <a href="message.php"><button class="messagebutton"
                          style="background-color: #70BE44; color: #fff;">Message Provider</button></a>
                          
<?php } elseif ($row["status"] === "working") {
                          echo "";
                      } ?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">
                    <p><img src="./images/strr.png" />4.9</p>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">

                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2 last-textinner">
                    <ul class="button-sec">
                    <?php if ($row["status"] === "working") {
                        // Show the yellow button for "working" status
                        echo '<li><a style="background:#FFC400;border-radius:7px; color:white; padding:10px;" type="button" data-toggle="modal" data-target="#completed' .
                            $proposalId .
                            '" data-proposal-id="' .
                            $proposalId .
                            '">working</a></li>';
                    } elseif ($row["status"] === "order_in_progress") {
                        // Show two buttons for "order_in_progress" status
                        echo '<li class="onetimepayment"><a type="button" data-toggle="modal" data-target="#confirmationModal' .
                            $proposalId .
                            '" data-proposal-id="' .
                            $proposalId .
                            '">Verify</a></li>';
                        echo '<li class="arrive1d"><a href="#"><button>Arrived</button></a></li>';
                    } ?>
                    </ul>
                  </div>
                </div>
              </div>

           
              <div class="row second-inner">
                <div class="col-lg-5 mb-8 mb-lg-0">
                  <h2>Services Selected</h2>
                  <div class="pricedetails">
                    <ul>
                    <?php
                    $displayTotal = isset($counterTotall)
                        ? $counterTotall
                        : $totalAmount;
                    foreach ($serviceCustomers as $servicenew) {

                        $services = $servicenew["service_name"];
                        $servicePrice = $servicenew["price"];

                        // Check if counter service price is available
                        if (isset($servicenew["counter_price"])) {
                            $counterPrice = $servicenew["counter_price"];
                        } else {
                            // If counter price is not available, use the original service price
                            $counterPrice = $servicePrice;
                        }
                        ?>
                            <li>
                                <em><?php echo $services; ?></em>
                                <span style="color: #70BE44;">$<?php echo $counterPrice; ?></span>
                            </li>
                        <?php
                    }
                    ?>
                      <li class="custom-total-price"><em>Total Cost offer</em> <span style="color: #70BE44;">$
                          <?php echo $displayTotal; ?></span></li>
                    </ul>
                  </div>

                </div>
                <div class="col-lg-1 mb-1 mb-lg-0"></div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                  <div class="task">
                    <h2>Task Description</h2>
                    <p><?php echo $userContent; ?></p>
                  </div>
                </div>
              </div>

              <div class="row-second-inner">
                <div class="panel content<?php echo $proposalId; ?> hidden">
                  <div class="gallery-servces moretext">
                    <h2>Service Place</h2>
                    <ul class="my-galleryserv">
                    <?php foreach (
                        array_slice($customerImages, 0, 5)
                        as $imagePath
                    ) { ?>
                                <li>
                                    <img src="../customer/<?php echo $imagePath; ?>" alt="Customer Image" />
                                </li>
                            <?php } ?>
                    </ul>
                  </div>
                </div>

                <a class="btn flip read-more-button<?php echo $proposalId; ?>">See More</a>

              </div>

            </div>

          </div>
        </section>

        <script>
        const content<?php echo $proposalId; ?> = document.querySelector('.content<?php echo $proposalId; ?>');
        const readMoreButton<?php echo $proposalId; ?> = document.querySelector('.read-more-button<?php echo $proposalId; ?>');

        readMoreButton<?php echo $proposalId; ?>.addEventListener('click', function () {
            if (content<?php echo $proposalId; ?>.classList.contains('hidden')) {
                content<?php echo $proposalId; ?>.classList.remove('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See Less';
            } else {
                content<?php echo $proposalId; ?>.classList.add('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See More';
            }
        });
    </script>
        <?php
              }
          }
      } else {
          echo "Error executing the query.";
      }
      ?>


       
      </div>

      <div class="tab-pane rteserves" id="tabs-4" role="tabpanel">
      <?php
      // include "connection.php";

      $userId = $_SESSION["user_id"];

      $sql =
          "SELECT * FROM customer_proposal WHERE customer_id = ? AND status = 'completed' ORDER BY current_time DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $userId);

      if ($stmt->execute()) {
          $result = $stmt->get_result();
          if ($result->num_rows == 0) {
              // No orders found for the provider
              echo '<h2 class="text-center texter">No new orders available.</h2>';
          } else {
              while ($row = $result->fetch_assoc()) {

                  $proposalId = $row["id"];
                  $customerId = $row["customer_id"];
                  $providerId = $row["provider_id"];
                  $selectedDate = $row["selected_date"];
                  $selectedTime = $row["selected_time"];
                  $userContent = $row["user_content"];
                  $selectedServices = explode(", ", $row["selected_services"]);
                  $totalAmount = $row["total_amount"];
                  $current_time = $row["current_time"];
                  $counterTotall = $row["counter_totall"];

                  // Retrieve customer name and address based on customerId
                  $customerInfo = getCustomerInfo($providerId);

                  $customerImages = getCustomerImagesForProvider(
                      $providerId,
                      $proposalId,
                      $customerId
                  );
                  $serviceCustomers = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );
                  $serviceCustomers1 = getCustomerServicesAndPrices(
                      $providerId,
                      $proposalId,
                      $userId
                  );

                  // Now you have an array containing the selected services and their prices for the customer

                  // Output the retrieved customer name and address
                  $customerId = $customerInfo["id"];
                  $customerName = $customerInfo["fullname"];
                  $customerAddress = $customerInfo["address"];
                  $profile_picture = $customerInfo["profile_picture"];
                  ?>


                        
        <section id="hiring" style="padding: 60px 0px;">
          <div class="container">
            <div class="hiring-inner">
              <div class="row first-inner">
                <div class="col-lg-3 mb-3 mb-lg-0">
                  <div class="textwith-icon1">
                    <img src="../provider/<?php echo $profile_picture; ?>" />
                    <div class="text-inner">
                      <h5><?php echo $customerName; ?></h5>
                      <h6>Garden Maintenance</h6>
                      <a href="message.php"><button class="messagebutton"
                          style="background-color: #70BE44; color: #fff;">Message Provider</button></a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">
                  <?php 
                     $ratings = ratingcount($providerId,$proposalId);
                    ?>
                    <p><img src="./images/strr.png" /><?php echo $ratings[0]; ?></p>
                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2">

                  </div>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0 align-self-center">
                  <div class="textwith-icon2 last-textinner">
                  <ul class="button-sec">
                      <li><a style="color: #FF4D00;" href="#">Service Completed</a></li>
                      <li class="completed"><button onclick="showPopup(<?php echo $proposalId; ?>, <?php echo $providerId; ?>, <?php echo $_SESSION['user_id']; ?>)">Rate Service</button></li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="row second-inner">
                <div class="col-lg-5 mb-8 mb-lg-0">
                  <h2>Services Selected</h2>
                  <div class="pricedetails">
                    <ul>
                    <?php
                    $displayTotal = isset($counterTotall)
                        ? $counterTotall
                        : $totalAmount;
                    foreach ($serviceCustomers as $servicenew) {

                        $services = $servicenew["service_name"];
                        $servicePrice = $servicenew["price"];

                        // Check if counter service price is available
                        if (isset($servicenew["counter_price"])) {
                            $counterPrice = $servicenew["counter_price"];
                        } else {
                            // If counter price is not available, use the original service price
                            $counterPrice = $servicePrice;
                        }
                        ?>
                            <li>
                                <em><?php echo $services; ?></em>
                                <span style="color: #70BE44;">$<?php echo $counterPrice; ?></span>
                            </li>
                        <?php
                    }
                    ?>
                      <li class="custom-total-price"><em>Total Cost offer</em> <span style="color: #70BE44;">$
                          <?php echo $displayTotal; ?></span></li>
                    </ul>
                  </div>

                </div>
                <div class="col-lg-1 mb-1 mb-lg-0"></div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                  <div class="task">
                    <h2>Task Description</h2>
                    <p><?php echo $userContent; ?></p>
                  </div>
                </div>
              </div>

              <div class="row-second-inner">
                <div class="panel content<?php echo $proposalId; ?> hidden">
                  <div class="gallery-servces moretext">
                    <h2>Service Place</h2>
                    <ul class="my-galleryserv">
                    <?php foreach (
                        array_slice($customerImages, 0, 5)
                        as $imagePath
                    ) { ?>
                                <li>
                                    <img src="../customer/<?php echo $imagePath; ?>" alt="Customer Image" />
                                </li>
                            <?php } ?>
                    </ul>
                  </div>
                </div>
                <a class="btn flip read-more-button<?php echo $proposalId; ?>">See More</a>
              </div>
            </div>
          </div>
        </section>
        <script>
        const content<?php echo $proposalId; ?> = document.querySelector('.content<?php echo $proposalId; ?>');
        const readMoreButton<?php echo $proposalId; ?> = document.querySelector('.read-more-button<?php echo $proposalId; ?>');

        readMoreButton<?php echo $proposalId; ?>.addEventListener('click', function () {
            if (content<?php echo $proposalId; ?>.classList.contains('hidden')) {
                content<?php echo $proposalId; ?>.classList.remove('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See Less';
            } else {
                content<?php echo $proposalId; ?>.classList.add('hidden');
                readMoreButton<?php echo $proposalId; ?>.textContent = 'See More';
            }
        });
    </script>
        <?php
              }
          }
      } else {
          echo "Error executing the query.";
      }
      ?>
      </div>
    </div>
    <div class="full-screen hidden flex-container-center">
      <div class="rate-servicessss">
        <h2>Rate the service</h2>
        <div class="row-first" style="color:#000;">
        <form method="POST" action="">
        <?php
          // $euserId = $encrp -> encrypting($_SESSION["user_id"]);
          // $eproposalId = $encrp -> encrypting($proposalId);
          // $eproviderId = $encrp -> encrypting($providerId);
        ?>
          <input type="hidden" name="starrating" id="starrating" value="" />
          <input type="hidden" id="user_id" name="user_id" value="" />
          <input type="hidden" id="proposal_id" name="proposal_id" value="" />
          <input type="hidden" id="provider_id" name="provider_id" value="" />
            <div class="stars">
              <ion-icon class="star" id="1" onmouseover="change(this.id);" name="star-outline"></ion-icon>
              <ion-icon class="star" id="2" onmouseover="change(this.id);" name="star-outline"></ion-icon>
              <ion-icon class="star" id="3" onmouseover="change(this.id);" name="star-outline"></ion-icon>
              <ion-icon class="star" id="4" onmouseover="change(this.id);" name="star-outline"></ion-icon>
              <ion-icon class="star" id="5" onmouseover="change(this.id);" name="star-outline"></ion-icon>
            </div>
          </div>
          <h4>Your Feedback matter to us</h4>
          <textarea name="Feedback"></textarea>
          <button type="submit" name="rating" onclick="closePopup()">Send</button>
        </form>
      </div>
    </div>
  </section>
  <!-- footer start -->
  <footer id="footer-section">
    <div class="container">
      <div class="footer-widgets">
        <div class="row" style="padding: 60px 0px 30px 0px;">
          <div class="col-lg-3 mb-3 mb-lg-0">
            <img class="footerlogo" src="./images/footerlogo.png" width="100%" />
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://unpkg.com/ionicons@4.2.4/dist/ionicons.js"></script>
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
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
  <script src="plugins/google-map/gmap.js"></script>

  <!-- Main Script -->
  <script src="js/script.js"></script>

</body>

</html>

<script type="text/javascript">
  
   function change(id)
   {
    document.getElementById("starrating").value=id;
   }

  $('.moreless-button').click(function () {
    $('.moretext').slideToggle();
    if ($('.moreless-button').text() == "View Less") {
      $(this).text("View Less")
    } else {
      $(this).text("View Less")
    }
  });
</script>

<script>
  const popup = document.querySelector('.full-screen');

  function showPopup(proposalId, providerId, userId) {
    popup.classList.remove('hidden');
    document.getElementById("user_id").value=userId;
    document.getElementById("proposal_id").value=proposalId;
    document.getElementById("provider_id").value=providerId;
  }

  function closePopup() {
    popup.classList.add('hidden');
  }

</script>
<script>
  window.addEventListener('load', e => {

    const stars = document.querySelectorAll('.star');

    stars.forEach((star, index) => {
      star.addEventListener('click', e => {
        for (let i = 0; i <= index; i++) {
          stars[i].setAttribute('name', 'star');
          stars[i].style.opacity = 1;
        }
        for (let i = index + 1; i < stars.length; i++) {
          stars[i].setAttribute('name', 'star-outline');
          stars[i].style.opacity = 0.6;
        }
      });
    });

  });

</script>
<!-- <script>
  //to change text
  $('a#flip').click(function () {

    $(this).toggleClass("active");
    $('.panel').toggleClass("hide");

    if ($(this).hasClass("active")) {
      $(this).text("Read Less");
    } else {
      $(this).text("Read More");
    }

  });
  //to show panel
  $(document).ready(function () {
    $("#flip").click(function () {
      $("#panel").slideToggle("slow");
    });
  });
</script> -->