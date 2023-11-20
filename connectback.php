<?php
    error_reporting(0);
    session_start();
    include 'connection.php';
    // Include configuration file  
    require_once 'config.php'; 
    
    // Include the Stripe PHP library 
    require_once 'stripe-php/init.php'; 

    // \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
    $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);

    if(isset($_POST['submit'])){
        global $conn;
        // Check if the user is logged in and has a valid session
        if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'provider') {
            if(isset($_POST['country']) && isset($_POST['bank']) && isset($_POST['account_no'])){
                $country = $_POST['country'];
                $bank = explode('|', $_POST['bank']);
                $bank = $bank[1];
                $accountno = $_POST['account_no'];
                $routingno = $_POST['routing_no'];
                $userId = $_SESSION['user_id'];
                $bankAccount = "";
                $checkRecordQuery = "SELECT * FROM provider_registration WHERE id =".$userId;
                $result = $conn->query($checkRecordQuery);
                if ($result->num_rows > 0) {
                    $bankAccount = $result->fetch_assoc();
                }
                //connecting stripe account
                // $accounts = $stripe->accountLinks->create([
                //     'account' => $bankAccount['stripe_accountId'],
                //     'refresh_url' => 'http://localhost:81/alon_burks/connectback.php',
                //     'return_url' => 'http://localhost:81/alon_burks/connectback.php',
                //     'type' => 'account_onboarding'
                // ]);

                //     
                $sql =
                $sql = "INSERT INTO provider_bank (provider_id, country_registered, bank_name, account_no, routing_no)
                        VALUES ('$userId', '$country', '$bank', '$accountno', '$routingno')";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute()) {
                    $updateQuery = "UPDATE provider_registration SET isAccountVerified = true WHERE id=".$userId;
                    $stmtupdate = $conn->prepare($updateQuery);
                    if ($stmtupdate->execute()) {
                        header("Location: provider/dashboard.php");
                    }
                }
                // print_r($accounts);
            }
        }
    } 

    
?>
<!DOCTYPE html>
<html class="signup-page-build" lang="zxx">
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
  <link rel="stylesheet" href="assets/plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="assets/plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="assets/plugins/themify-icons/themify-icons.css">
  <!-- venobox css -->
  <link rel="stylesheet" href="assets/plugins/venobox/venobox.css">
  <!-- card slider -->
  <link rel="stylesheet" href="assets/plugins/card-slider/css/style.css">

  <!-- Main Stylesheet -->
  <link href="assets/css/style.css" rel="stylesheet">
  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

</head>

<body id="connect-account" style="height: auto !important;">
    <section id="provider-booking-payment">
       
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <!-- <form id="msform" action="./provider/service-settings.php"> -->
                    <form id="msform" action="" method="POST">
                            <div class="form-card" id="conn-bank">
                              <div class="row">
                                 <div class="col-lg-6 mb-6 mb-lg-0 back-sec01">
                                    <a href="index.php">
                                    <div class="payment-site-logo">
                                        <img src="assets/images/signup/sitelogo-singup.png"/>
                                    </div>
                                    </a>
                                  <div id="plan-purchase" class="payment-heading">
                                    <h5>Connect Bank Account</h5>
                                    <div class="connect-bank">
                                        <img src="assets/images/connectbank/line.png">
                                    </div>
                                    <h3>Cardholder Name:</h3>
                                    <select id="country" name="country">
                                        <option value="USA">USA</option>
                                        <option value="Canada">Canada</option>
                                        <!-- Add more countries as needed -->
                                    </select>

                                    <select id="bank" name="bank">
                                        <option value="0">Select Bank</option>
                                    </select>

                                    <!-- <h4>Select Bank</h4> -->
                                    <!-- A/C Number-Start -->

                                    <input id="ccn" type="tel" name="account_no" inputmode="numeric" pattern="[0-9\s]{13,19}" 
                                            autocomplete="ac-number" maxlength="19" placeholder="Account Number / IBAN No:">

                                    <!-- A/C Number-End -->
                                     
                                    <!-- SWIFT / Routing number-Start -->

                                     <input id="ccn" type="tel" inputmode="numeric" name="routing_no" pattern="[0-9\s]{13,19}" 
                                     autocomplete="swift-routing-number" maxlength="19" placeholder="SWIFT / Routing number">

                                     <!-- SWIFT / Routing number-End -->

                                     <!-- Verify-Btn-start -->
                                        <button name="submit" type="submit" id="verify-submit" data-submit="verification">Verify</button>

                                     <!-- Verify-Btn-start -->
                                  </div>
                                 </div>
                                 <div class="col-lg-6 mb-6 mb-lg-0 bankserwo" style="background-image: url(assets/images/connectbank/connbank.png);">
                                        <div class="bank-logo-content-area">
                                            <img src="assets/images/connectbank/bacc.png" alt="">
                                            <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
                                                 passages, and more recently with desktop publishing software like Aldus PageMaker 
                                                 including versions of Lorem Ipsum.</p>
                                        </div>
                                    </div>
                                 </div>
                                </div>
                            </div> 
                        
                    </form>
                </div>
            </div>
        </div>
    </section>

<!-- footer end -->
<script>
    // Bank data for different countries
    const bankData = {
        "USA": ["Bank of America", "Wells Fargo", "JPMorgan Chase"],
        "Canada": ["Royal Bank of Canada", "Toronto-Dominion Bank", "Scotiabank"],
        // Add more countries and banks as needed
    };

    // Function to populate the bank select options
    function populateBanks() {
        const countrySelect = document.getElementById('country');
        const bankSelect = document.getElementById('bank');

        // Get the selected country
        const selectedCountry = countrySelect.value;

        // Clear the current bank options
        bankSelect.innerHTML = '';

        // Populate the bank options based on the selected country
        if (selectedCountry in bankData) {
            const banks = bankData[selectedCountry];
            banks.forEach((bank, index) => {
                const option = document.createElement('option');
                option.value = index + 1 +'|'+ bank; // Assign a unique value to each bank option
                option.text = bank;
                bankSelect.appendChild(option);
            });
        } else {
            // If the selected country doesn't have bank data, show a default option
            const defaultOption = document.createElement('option');
            defaultOption.value = 0;
            defaultOption.text = 'Select Bank';
            bankSelect.appendChild(defaultOption);
        }
    }

    // Add an event listener to the country select to update the banks when the country changes
    document.getElementById('country').addEventListener('change', populateBanks);

    // Initial population of banks based on the default selected country
    populateBanks();
</script>

<!-- jQuery -->
<script src="assets/plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="assets/plugins/slick/slick.min.js"></script>
<!-- venobox -->
<script src="assets/plugins/venobox/venobox.min.js"></script>
<!-- shuffle -->
<script src="assets/plugins/shuffle/shuffle.min.js"></script>
<!-- apear js -->
<script src="assets/plugins/counto/apear.js"></script>
<!-- counter -->
<script src="assets/plugins/counto/counTo.js"></script>
<!-- card slider -->
<script src="assets/plugins/card-slider/js/card-slider-min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="assets/plugins/google-map/gmap.js"></script>

<!-- Main Script -->
<script src="assets/js/script.js"></script>

</body>
</html>