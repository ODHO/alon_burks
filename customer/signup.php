<?php
include "connection.php";
// Include configuration file  
require_once '../config.php'; 
 
// Include the Stripe PHP library 
require_once '../stripe-php/init.php'; 

// \Stripe\Stripe::setApiKey(STRIPE_API_KEY); 
$stripe = new \Stripe\StripeClient(STRIPE_API_KEY);

session_start();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$defaultRoleId = 3; // Change this to the actual ID for "customer"

if (isset($_POST["register"])) { 
    // Retrieve user input from the form
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $country = $_POST["country"];
    $region = $_POST["region"];
    $city = $_POST["city"];
    $zipcode = $_POST["zipcode"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if the email already exists in the registration table
    $checkEmailQuery = "SELECT * FROM provider_registration WHERE email='$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        $error_message = "Email already exists. Please use a different email.";
    } else {
        // Password validation
        if ($password !== $confirm_password) {
            $error_message = "Passwords do not match. Please try again.";
        } else {
            // Handle profile picture upload
            if ($_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
                $profilePictureName = $_FILES["profile_picture"]["name"];
                $profilePictureTmpName = $_FILES["profile_picture"]["tmp_name"];
                $profilePictureDestination =
                    "profile_pictures/" . $profilePictureName; // Choose a destination directory
                // Move the uploaded profile picture to the destination
                if (
                    move_uploaded_file(
                        $profilePictureTmpName,
                        $profilePictureDestination
                    )
                ) {
                    // File was uploaded successfully, you can store $profilePictureDestination in the database.
                } else {
                    $error_message =
                        "Error uploading profile picture: " .
                        $_FILES["profile_picture"]["error"];
                }
            }
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
           //Creating Stripe instance for Creating CustomerId
           $customer = $stripe->customers->create([
              'name' => $_POST["fullname"],
              'email' => $_POST["email"]
              // 'description' => 'My First Test Customer (created for API docs at https://www.stripe.com/docs/api)',
            ]);
            //Creating Stripe instance for Creating Account
            $account = $stripe->accounts->create([
                'type' => 'custom',
                'country' => 'US',
                'email' => $_POST["email"],
                'capabilities' => [
                  'card_payments' => ['requested' => true],
                  'transfers' => ['requested' => true],
                ],
              ]);
            // Insert user data into the database
            $sql = "INSERT INTO provider_registration (fullname, email, phone, address, country, region, city, zipcode, password, role_id, profile_picture, stripe_customerId,stripe_accountId)
            VALUES ('$fullname', '$email', '$phone', '$address', '$country', '$region', '$city', '$zipcode', '$hashed_password', $defaultRoleId, '$profilePictureDestination', '$customer->id','$account->id')";
            if ($conn->query($sql) === true) {
                // Generate a random verification code (e.g., a 6-digit number)
                $verificationCode = sprintf("%04d", mt_rand(1000, 9999));
                // Store the verification code and set is_verified to 0 in the database
                $updateVerificationQuery = "UPDATE provider_registration SET verification_code='$verificationCode', is_verified=0 WHERE email='$email'";
                if ($conn->query($updateVerificationQuery) === true) {
                    // Send the verification email
                    $to = $email;
                    $subject = "Account Verification Code";
                    $message = "Your verification code is: $verificationCode";
                    $headers = "From: mubashirodho@gmail.com"; // Replace with your email address

                    if (mail($to, $subject, $message, $headers)) {
                        $error_message =
                            "Registration successful! Check your email for the verification code.";
                    } else {
                        $error_message =
                            "Error sending the verification email.";
                    }
                } else {
                    $error_message = "Error updating the verification code.";
                }
                $_SESSION['user_email'] = $email; 
                // Redirect to login.php after successful registration
                header("Location: emailconfirmation.php");
                exit();
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
// Close the database connection
$conn->close();
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
  <!-- Stripe JS library -->
  <script src="https://js.stripe.com/v3/"></script>
  <script src="../assets/js/checkout.js" STRIPE_PUBLISHABLE_KEY="pk_test_51ODWQpHjRTxHUNUSZYRHffKB4qGfbk404Q3vO1CAmXmsOB8cIsiE7pjiiqxPeghsxc1jXrMBcD6tYQVa0gp9gblm00cQb7S181" defer></script>

</head>
<body style="height:100%;">
  <section id="my-hiringpanel">
        <section id="sign-up-form">
          <div class="row justify-content-center h-100">
            <div class="col-lg-7 mb-3" style="padding: 50px;">
              <div style="text-align: center;" class="sign-up-inner">
                <a href="index.php">
                    <div class="site-logo-form">
                        <img src="./images/signup/sitelogo-singup.png"/>
                    </div>
                </a>
                <h2>Create an Account</h2>
                <img style="margin-bottom: 5px;" width="auto" src="./images/Line 43.png" />
                <form id="contact" action="Signup.php" method="post" enctype="multipart/form-data">
                <div class="img-wrapper">
                  <p style="text-align: left;margin-left: 10px;">Your Profile Picture</p>

                    <label for="profile_picture" class="img-upload-btn">
                      <div class="preview">
                        <p class="no-pic"><img src="../assets/images/becomesprovider/regupload.png" alt=""></p>
                        <img src="" class="profile-img" style="opacity: 0;">
                      </div> 
                    </label>
                    <input type="file" id="profile_picture" name="profile_picture" accept=".jpg, .jpeg, .png" style="opacity: 0;">
                  </div>
                  <fieldset>
                    <input placeholder="Full Name" name="fullname" type="text" tabindex="1" required autofocus>
                  </fieldset>
                  <fieldset>
                    <input placeholder="Email Address@" name="email" type="email" tabindex="2" required>
                  </fieldset>
                  <fieldset>
                    <input placeholder="Phone #@" name="phone" type="tel" tabindex="3" required>
                  </fieldset>
                  <fieldset>
                    <input placeholder="Street Address@" name="address" type="text" tabindex="4" required>
                  </fieldset>
                  <div class="row">
                    <div class="col-lg-4 mb-3">
                      <fieldset>
                        <select id="country" name="country" class='form-control'>
                          <option value="">-- Country --</option>
                        </select>
                      </fieldset>
                    </div>
                    <div class="col-lg-4 mb-3">
                      <fieldset>
                        <select id="region" name="region" class='form-control'>
                          <option value="">-- Region --</option>
                        </select>
                      </fieldset>
                    </div>
                    <div class="col-lg-4 mb-3">
                      <fieldset>
                        <select id="city" name="city" class='form-control'>
                          <option value="">-- City --</option>
                        </select>
                      </fieldset>
                    </div>
                  </div>
                  <fieldset>
                    <input placeholder="Zip Code" name="zipcode" type="text" tabindex="5" required>
                  </fieldset>
                  <fieldset>
                    <input placeholder="Password" name="password" type="password" tabindex="6" required>
                  </fieldset>
                  <fieldset>
                    <input placeholder="Confirm password" name="confirm_password" type="password" tabindex="7" required>
                  </fieldset>
                  <fieldset>
                    <button type="submit" name="register" id="contact-submit" data-submit="...Sending">Sign up</button>
                  </fieldset>
                  <div id="error-messages" style="color: red;"></div>
                </form>
                <h4 style="font-size:16px;margin-top:10px;">Already have an account? <a href="../signin.php">Login</a></h4>

                <div class="sign-up-register-social">
                  <h4>Or register With</h4>
                  <div class="social-links-signup">
                    <ul>
                      <li><a href="#"><img src="./images/social/2.png" /></a></li>
                      <li><a href="#"><img src="./images/social/1.png" /></a></li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-lg-5 mb-3 mb-lg-0 mx-auto" style="background-image: url(./images/signup/bg.png); background-repeat: no-repeat;
                background-size: cover; padding: 270px 30px;">
              <img width="auto" src="./images/logo.png" /><br>
              <p>Your Lawns <br>Tensions Are<br> gone </p>
            </div>
            <!-- row end -->
          </div>
        </section>

    </div>
  </section>


  <script>
                                    const input = document.querySelector("input");
const preview = document.querySelector(".preview");
const para = document.querySelector(".no-pic");
const image = document.querySelector(".profile-img");
input.addEventListener("change", updateImageDisplay);
function updateImageDisplay() {
  para.style.display = "none";
  const curFiles = input.files;
  image.src = URL.createObjectURL(curFiles[0]);
  image.style.opacity = 1;
}

                                </script>
  <!-- footer end -->
  <script>
    // Check if the error message variable is not empty
    var errorMessage = "<?php echo $error_message; ?>";
    if (errorMessage !== "") {
      // Display the error message in the error <div>
      document.getElementById("error-messages").textContent = errorMessage;
    }
  </script>

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
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
  <script src="plugins/google-map/gmap.js"></script>

  <!-- Main Script -->
  <script src="js/script.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <!-- <script  src="./script.js"></script> -->

  <script>
 $(document).ready(function() {
  //-------------------------------SELECT CASCADING-------------------------//
  var selectedCountry = (selectedRegion = selectedCity = countryCode = "");

  // This is a demo API key for testing purposes. You should rather request your API key (free) from http://battuta.medunes.net/
  var BATTUTA_KEY = "00000000000000000000000000000000";
  // Populate country select box from battuta API
  url =
    "https://battuta.medunes.net/api/country/all/?key=" +
    BATTUTA_KEY +
    "&callback=?";

  // EXTRACT JSON DATA.
  $.getJSON(url, function(data) {
    console.log(data);
    $.each(data, function(index, value) {
      // APPEND OR INSERT DATA TO SELECT ELEMENT. Set the country code in the id section rather than in the value.
      $("#country").append(
        '<option id="' +
          value.code +
          '" value="' +
          value.name +
          '">' +
          value.name +
          "</option>"
      );
    });
  });
  // Country selected --> update region list .
  $("#country").change(function() {
    selectedCountry = this.options[this.selectedIndex].text;
// get the id of the option which has the country code.
    countryCode = $(this)
      .children(":selected")
      .attr("id");
    // Populate country select box from battuta API
    url =
      "https://battuta.medunes.net/api/region/" +
      countryCode +
      "/all/?key=" +
      BATTUTA_KEY +
      "&callback=?";
    $.getJSON(url, function(data) {
      $("#region option").remove();
      $('#region').append('<option value="">Please select your region</option>');
      $.each(data, function(index, value) {
        // APPEND OR INSERT DATA TO SELECT ELEMENT.
        $("#region").append(
          '<option value="' + value.region + '">' + value.region + "</option>"
        );
      });
    });
  });
  // Region selected --> updated city list
  $("#region").on("change", function() {
    selectedRegion = this.options[this.selectedIndex].text;
    // Populate country select box from battuta API
    // countryCode = $("#country").val();
    region = $("#region").val();
    url =
      "https://battuta.medunes.net/api/city/" +
      countryCode +
      "/search/?region=" +
      region +
      "&key=" +
      BATTUTA_KEY +
      "&callback=?";
    $.getJSON(url, function(data) {
      console.log(data);
      $("#city option").remove();
      $('#city').append('<option value="">Please select your city</option>');
      $.each(data, function(index, value) {
        // APPEND OR INSERT DATA TO SELECT ELEMENT.
        $("#city").append(
          '<option value="' + value.city + '">' + value.city + "</option>"
        );
      });
    });
  });
  // city selected --> update location string
  $("#city").on("change", function() {
    selectedCity = this.options[this.selectedIndex].text;
    $("#location").html(
      "Locatation: Country: " +
        selectedCountry +
        ", Region: " +
        selectedRegion +
        ", City: " +
        selectedCity
    );
  });
});

// very simple process form function to collect input values.
function processForm() {
  var username = (password = country = region = city = "");
  username = $("#username").val();
  password = $("#password").val();
  country = $("#country").val();
  region = $("#region").val();
  city = $("#city").val();
  if (
    // username != "" &&
    // password != "" &&
    country != "" &&
    region != "" &&
    city != ""
  ) {
    $("#location").html(
      // "Username: " +
      //   username +
      //   " /Password: " +
      //   password +
        "Locatation: Country: " +
        country +
        ", Region: " +
        region +
        ", City: " +
        city
    );
  } else {
    $("#location").html("Fill Country, Region and City to view the location");
    return false;
  }
}

</script>
</body>

</html>