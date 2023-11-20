<?php
session_start();
include 'connection.php';

if (isset($_POST['verify'])) {
    $enteredCode1 = $_POST['code1'];
    $enteredCode2 = $_POST['code2'];
    $enteredCode3 = $_POST['code3'];
    $enteredCode4 = $_POST['code4'];
    $code = $enteredCode1 . $enteredCode2 . $enteredCode3 . $enteredCode4;

    // Get the user's email from the session
    $email = $_SESSION['user_email'];

    // Query the database to check if the entered code matches the stored code
    $query = "SELECT verification_code FROM provider_registration WHERE email = '$email'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedCode = $row['verification_code'];
        $_SESSION["user_id"] = $row["id"];
        $_SESSION['customerFullName']= $row['fullname'];
        // echo "Entered Code: " . $code; // Debug statement
        // echo "Stored Code: " . $storedCode; // Debug statement

        if ($code == $storedCode) {
            // Update the user's is_verified status to 1 (verified)
            $updateQuery = "UPDATE provider_registration SET is_verified = 1 WHERE email = '$email'";
            if ($conn->query($updateQuery) === TRUE) {
                // Verification successful, you can redirect the user to a success page or login page.
                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = "Error updating verification status.";
            }
        } else {
            $error_message = "Invalid verification code. Please try again.";
        }
    } else {
        $error_message = "User not found in the database.";
    }
}

//$conn->close();
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
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body id="sign-in-page">
    <section id="sign-in-form">
        <div class="signin-sitelogo">
            <img src="./images/signup/sitelogo-singup.png"/>
        </div>
            <div class="row justify-content-center h-100"> 
               
                <div class="col-lg-7 mb-3" style="padding: 230px; text-align: center;">
                    <h2>Email Verification</h2>
                <img src="./images/Line 43.png"/>
                    <p>Please enter  4 digit numeric Code sent to Your Email to verify.</p>
                   <!--<form id="contact" action="" method="post">-->
    <!--<div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">-->
    <!--    <input class="m-2 text-center form-control rounded" type="text" name="code" maxlength="1" />-->
    <!--    <input class="m-2 text-center form-control rounded" type="text" maxlength="1" />-->
    <!--    <input class="m-2 text-center form-control rounded" type="text" maxlength="1" />-->
    <!--    <input class="m-2 text-center form-control rounded" type="text" maxlength="1" />-->
    <!--</div>-->
    <!--<p style="text-align: left;">Didn't Receive the code? <a style="float: right;" href="#">Resend</a></p>-->

    <!--<div class="mt-4">-->
        <!--<button type="submit" class="btn btn-danger px-4 validate" name="verify">Verify</button>-->
    <!--</div>-->
<!--</form>-->
<form id="contact" method="post" action="">
            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                <input class="m-2 text-center form-control rounded" type="text" name="code1" maxlength="1" />
                <input class="m-2 text-center form-control rounded" type="text" name="code2" maxlength="1" />
                <input class="m-2 text-center form-control rounded" type="text" name="code3" maxlength="1" />
                <input class="m-2 text-center form-control rounded" type="text" name="code4" maxlength="1" />
            </div>
            <p style="text-align: left;">Didn't Receive the code? <a style="float: right;" href="#">Resend</a></p>
            <div class="mt-4">
                <input type="submit" name="verify" value="Verify" class="btn btn-danger px-4 validate" />
            </div>
        </form>
                
                </div>

                <div class="col-lg-5 mb-3 mb-lg-0 mx-auto" style="background-image: url(./images/signup/bg.png); background-repeat: no-repeat;
                background-size: cover; padding: 270px 30px;">
                    <img width="auto" src="./images/logo.png"/><br>
                    <p>Your Lawns <br>Tensions Are<br> gone </p>
                </div>
<!-- row end -->
            </div>
    </section>

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