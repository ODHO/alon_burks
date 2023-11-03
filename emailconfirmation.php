<?php
include 'connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$verificationCode = $_POST['verification_code']; // Assuming you use POST method to submit the code
$email = $_POST['email']; // Assuming you pass the email as a hidden field in the form

if (isset($_POST['confirm'])) {
    // Check if the verification code matches the one stored in the database
    $checkCodeQuery = "SELECT * FROM provider_registration WHERE email='$email' AND verification_code='$verificationCode' AND is_verified=0";
    $checkCodeResult = $conn->query($checkCodeQuery);

    if ($checkCodeResult->num_rows > 0) {
        // Update the user's status to verified
        $updateStatusQuery = "UPDATE provider_registration SET is_verified=1 WHERE email='$email'";
        if ($conn->query($updateStatusQuery) === TRUE) {
            // Redirect to a success page or perform other actions
            header("Location: success.php");
            exit;
        } else {
            $error_message = "Error updating user status.";
        }
    } else {
        $error_message = "Invalid verification code. Please try again.";
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

<body id="sign-in-page">
    <section id="sign-in-form">
        <a href="index.php">
        <div class="signin-sitelogo">
            <img src="./assets/images/signup/sitelogo-singup.png"/>
        </div>
    </a>
            <div class="row justify-content-center h-100"> 
               
                <div class="col-lg-7 mb-3" style="padding: 230px; text-align: center;">
                <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="post">
        <h2>Email Verification</h2>
                    <img src="./assets/images/Line 43.png"/>
                    <p>Please enter  4 digit numeric Code sent to Your Email to verify.</p>
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
            <label for="verification_code">Verification Code:</label>
            <input type="text" id="verification_code" name="verification_code" required>
                    </div>
                    <p style="text-align: left;">Didn’t Receive the  code? <a style="float: right;" href="#">Resend</a></p>

                    <div class="mt-4"> 
                        <button class="btn btn-danger px-4 validate" type="submit" name="confirm">Verify</button> 
                    </div>
            
        </form>
                    

                </div>

                <div class="col-lg-5 mb-3 mb-lg-0 mx-auto" style="background-image: url(./assets/images/signup/bg.png); background-repeat: no-repeat;
                background-size: cover; padding: 270px 30px;">
                    <img width="auto" src="./assets/images/logo.png"/><br>
                    <p>Your Lawns <br>Tensions Are<br> gone </p>
                </div>
<!-- row end -->
            </div>
    </section>

<!-- footer end -->

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