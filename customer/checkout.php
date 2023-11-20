<?php
  session_start();
  include "../helper/encryption.php";
  include "../helper/decryption.php";
  include "connection.php";
  $encrp = new encryption();
  $decrp = new decryption();
  function getProposalDetails()
  {
      global $conn;
      // $sql_proposal =
      //       "SELECT * FROM `customer_proposal` inner join `customer_services` on 
      //       `customer_proposal`.`provider_id` = `customer_services`.`provider_id` 
      //       inner join `provider_registration` on `customer_proposal`.`provider_id` = `provider_registration`.`id`
      //       where `customer_proposal`.`id` = ?";

  $sql_proposal =
      "SELECT * FROM `customer_proposal`
      inner join `provider_registration` on `customer_proposal`.`provider_id` = `provider_registration`.`id`
      where `customer_proposal`.`id` = ?";
      $stmt_proposal = $conn->prepare($sql_proposal);
      $stmt_proposal->bind_param("s", $_GET["proposalid"]);
      if ($stmt_proposal->execute()) {
          $result_proposal = $stmt_proposal->get_result();
          return $result_proposal->fetch_assoc();
      }
      return "0";
  }
  function getCustomerDetails()
  {
    global $conn;
    $sql = "SELECT id, fullname, profile_picture, phone, address FROM provider_registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION["user_id"]);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }
    return "";//array('fullname' => 'N/A', 'address' => 'N/A', 'profile_picture' => 'N/A'); // Provide default values if customer info not found}
  }
  function getCompletedProposalCount($providerId)
  {
      global $conn;
      $countCompletedSql = "SELECT COUNT(*) as completed_pending_count FROM customer_proposal WHERE provider_id = ? AND (status = 'completed-pending' OR status = 'completed')";
      $countCompletedStmt = $conn->prepare($countCompletedSql);
      $countCompletedStmt->bind_param('s', $providerId);
      
      if ($countCompletedStmt->execute()) {
          $countCompletedResult = $countCompletedStmt->get_result();
          $countCompletedRow = $countCompletedResult->fetch_assoc();
          return $countCompletedRow['completed_pending_count'];
      }
      return 0;
  }
  function getAvailableHours($providerId)
  {
    global $conn;
    $sql = "SELECT * FROM `provider_services` WHERE `provider_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $providerId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }
    return "";//array('fullname' => 'N/A', 'address' => 'N/A', 'profile_picture' => 'N/A'); // Provide default values if customer info not found}
  }
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
  //Fetching Data
  $customer = getCustomerDetails(); 
  $proposal = getProposalDetails();
  $countCompletedRow = getCompletedProposalCount($proposal['provider_id']);
  $availablehours = getAvailableHours($proposal['provider_id']);
  $serviceCustomers = getCustomerServicesAndPrices($proposal['provider_id'], $_GET["proposalid"], $_SESSION["user_id"]);
  // getCustomerServicesAndPrices($providerId, $proposalId, $userId)
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
  <!-- Stripe JS library -->
  <script src="https://js.stripe.com/v3/"></script>
  <script src="../assets/js/checkout.js" itemPrice="<?php echo $proposal['total_amount']; ?>" itemName="<?php echo $proposal['selected_services']; ?>" STRIPE_PUBLISHABLE_KEY="pk_test_51ODWQpHjRTxHUNUSZYRHffKB4qGfbk404Q3vO1CAmXmsOB8cIsiE7pjiiqxPeghsxc1jXrMBcD6tYQVa0gp9gblm00cQb7S181" defer></script>
</head>

<body class="checkout">
  

    <header class="navigation fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
          <a class="navbar-brand" href="index.php"><img src="images/signup/sitelogo-singup.png" alt="Egen"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      
          <div class="collapse navbar-collapse text-center" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a style="color:#000;" class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="services.php">Services</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="notifications.php">Notifications</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="myhirings.php">My Hirings</a>
              </li>
              <li class="nav-item">
                <a style="color:#000;" class="nav-link" href="provider.php">Provider</a>
              </li> 
            </ul>
          </div>
        </nav>
      </header>



<!-- PROVIDER SEC START -->
<section id="provider-booking-payment">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                
            
                    <form id="msform" method="POST">
                <fieldset>
                            <div class="form-card" style="padding: 60px 0px;">
                              <div class="row">
                                 <div class="col-lg-7 mb-7 mb-lg-0">
                                  <div class="payment-heading">
                                    <h2>Payment Details</h2>
                                    <h3</h3>
                                    <h4><?php  echo $customer['fullname']; ?></h4>
                                      <div id="paymentElement">
                                        <!-- Stripe.js injects the Payment Element -->
                                      </div>
                                    <!-- <label for="ccn">Credit Card Number:</label> -->
                                    <!-- <input id="ccn" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" 
                                     autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
                                     <div class="row">
                                    <div class="col-lg-6 mb-6 mb-lg-0">
                                      <label for="ccn">Exp Date</label>
                                      <input class="cc-expires" maxlength="4" name="credit-expires" pattern="\d*" placeholder="MM / YY" type="tel" />
                                    </div> -->
                                    <!-- <div class="col-lg-6 mb-6 mb-lg-0 ffa">
                                      <label for="ccn">CVC</label>
                                      <input class="cc-cvc" maxlength="3" name="credit-cvc" pattern="\d*" placeholder="CVC" type="tel" />
                                    </div> -->
                                  <!-- </div> -->
                                     <input name="phone" placeholder="Phone No." type="text22" value="<?php echo $customer['phone']; ?>" />
                                     <input name="customerID" type="hidden" id="customerID" value="<?php echo $customer['id']; ?>" />

                                     <div class="payment-method">
                                      <h4>Payment Method</h4>
                                      <ul class="payment-images">
                                        <li><img src="./images/paymentpictures/debit.png"/></li>
                                        <li><img src="./images/paymentpictures/visa.png"/></li>
                                        <li><img src="./images/paymentpictures/paypal.png"/></li>
                                      </ul>
                                     </div>
                                  </div>
                                 </div>
                                 <div class="col-lg-5 mb-5 mb-lg-0">
                                  <div class="order-details-checkout">
                                    <div class="text-order-image">
                                      <img src="../provider/<?php echo $proposal['profile_picture']; ?>" width="60" height="60" alt="<?php echo $proposal['fullname']; ?>"/>
                                      <h2><?php echo $proposal['fullname']; ?> <br> <span><?php echo $proposal['selected_services']; ?></span></h2>
                                    </div>
                                    
                                    <ul class="order-details-minor" style="width: 100%;">
                                      <li><i style="color: #70BE44" class="fa fa-check" aria-hidden="true"></i>
                                      <?php 
                                        if($countCompletedRow > 50 ){
                                          echo '+50 Completed tasks';
                                        }else{
                                          echo $countCompletedRow; echo ' Completed tasks';
                                        }
                                      ?>
                                      </li>
                                      <li><i style="color: #70BE44" class="fa fa-map-marker" aria-hidden="true"></i><?php echo $proposal['address'];?> Texas, USA Street 2416 A-216</li>
                                      <li><i style="color: #70BE44;" class="fa fa-clock" aria-hidden="true"></i> Available hour <?php echo date('g:ia', strtotime($availablehours['working_timings_from']));?> - <?php echo date('g:ia', strtotime($availablehours['working_timings_to']));?></li>
                                  </ul>
                                    <div class="pricedetails1">
                                      <h4>Price Details</h4>
                                      <ul>
                                        <li><em>Rates</em> <span style="color: #70BE44;"><?php echo '$ '.$proposal['total_amount'];?></span></li>
                                        <!-- <li><em>Support Platform <br/>Fee's (10%)</em> <span style="color: #70BE44;"> -->
                                        <?php
                                          // $displayTotal = isset($counterTotall)
                                          //     ? $counterTotall
                                          //     : $proposal['total_amount'];
                                          //       foreach ($serviceCustomers as $servicenew) {

                                          //         $services = $servicenew["service_name"];
                                          //         $servicePrice = $servicenew["price"];
                          
                                          //         // Check if counter service price is available
                                          //         if (isset($servicenew["counter_price"])) {
                                          //             $counterPrice = $servicenew["counter_price"];
                                          //         } else {
                                          //             // If counter price is not available, use the original service price
                                          //             $counterPrice = $servicePrice;
                                          //         }
                                                  
                                          //     } 
                                              //echo '$ '. $displayTotal;
                                        ?>
                                        <!-- </span></li> -->
                                        <li><em>Min-Max Rate</em> <span style="color: #70BE44;">$150-250 Approx</span></li>
                                      </ul>
                                    </div>
                                    <div class="taskdes-checkout">
                                      <h4>Task Description</h4>
                                      <p><?php echo $proposal['user_content']; ?></p>
                                    </div>
                                    <button id="submitBtn" class="btn btn-success">
                                      <div class="spinner hidden" id="spinner"></div>
                                      <span id="buttonText">Pay Now</span>
                                  </button>
                                  </div>
                                 </div>
                                </div>
                            </div> 
                            </fieldset>
                        
                                            </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROVIDER SEC END -->

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