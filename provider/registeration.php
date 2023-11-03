<?php
include 'connection.php';
session_start();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$defaultRoleId = 2;
$error_message = "";

if (isset($_POST['register'])) {
    // Retrieve user input from the form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $region = $_POST['region'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

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
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Handle image uploads
            $profile_picture = '';
            $id_card_image = '';

            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
                $profile_picture_filename = $_FILES['profile_picture']['name'];
                $profile_picture_local_path = 'application_images/' . $profile_picture_filename;
                move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture_local_path);
                $profile_picture = $profile_picture_local_path;
            }

            if (isset($_FILES['id_card_image']) && $_FILES['id_card_image']['error'] === 0) {
                $id_card_filename = $_FILES['id_card_image']['name'];
                $id_card_local_path = 'application_images/' . $id_card_filename;
                move_uploaded_file($_FILES['id_card_image']['tmp_name'], $id_card_local_path);
                $id_card_image = $id_card_local_path;
            }

            // Insert user data into the database
            $sql = "INSERT INTO provider_registration (fullname, email, phone, address, country, region, city, zipcode, password, role_id, id_card_image, profile_picture)
            VALUES ('$fullname', '$email', '$phone', '$address', '$country', '$region', '$city', '$zipcode', '$hashed_password', $defaultRoleId, '$id_card_image', '$profile_picture')";

            if ($conn->query($sql) === TRUE) {
                // Generate a random verification code
                $verificationCode = sprintf('%06d', mt_rand(1000, 9999));

                // Store the verification code and set is_verified to 0 in the database
                $updateVerificationQuery = "UPDATE provider_registration SET verification_code='$verificationCode', is_verified=0 WHERE email='$email'";
                if ($conn->query($updateVerificationQuery) === TRUE) {
                    // Send the verification email
                    $to = $email;
                    $subject = "Account Verification Code";
                    $message = "Your verification code is: $verificationCode";
                    $headers = "From: mubashirodho@gmail.com"; // Replace with your email address

                    if (mail($to, $subject, $message, $headers)) {
                        $error_message = "Registration successful! Check your email for the verification code.";
                    } else {
                        $error_message = "Error sending the verification email.";
                    }
                } else {
                    $error_message = "Error updating the verification code.";
                }

                // Redirect to login.php after successful registration
                header("Location: emailconfirmation.php");
                exit;
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
  <link rel="stylesheet" href="../assets/plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="../assets/plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="../assets/plugins/themify-icons/themify-icons.css">
  <!-- venobox css -->
  <link rel="stylesheet" href="../assets/plugins/venobox/venobox.css">
  <!-- card slider -->
  <link rel="stylesheet" href="../assets/plugins/card-slider/css/style.css">

  <!-- Main Stylesheet -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

</head>

<body id="regis-page">
    <section id="sign-up-form">
            <div class="row justify-content-center h-100" style="display: -webkit-inline-box;"> 

                <div class="col-lg-7 mb-3" style="padding: 100px;">

                    <div style="text-align: center;" class="sign-up-inner">
                      <a href="index.php">
                        <div class="registeration-form">
                            <img src="../assets/images/signup/sitelogo-singup.png"/>
                        </div>
                        </a>
                        <h2>Service Provider Registeration</h2>
                        <p class="regis-con">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                             and more recently with desktop publishing software like Aldus PageMaker including 
                             versions of Lorem Ipsum.
                        </p>
                        <img style="margin-bottom: 30px;" width="auto" src="../assets/images/becomesprovider/linn.png"/>
                            <form id="contact" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div>
                                  <!-- profile picture upload  -->
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
                                  <!-- profile picture upload end  -->

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
                                    <input placeholder="Password" name="password" type="text" tabindex="6" required>
                                </fieldset>
                                <fieldset>
                                    <input placeholder="Confirm password" name="confirm_password" type="text" tabindex="7" required>
                                </fieldset>
                                <fieldset>
                                <div class="id-card">
    <p class="card-reg">Upload Your ID Card</p>
    <label for="id_card_image_input" style="background-image: url(../assets/images/becomesprovider/idcard.png);">
        <img id="id_card_image_preview" src="#" alt="ID Card Preview" style="display: none;">
        <input type="file" id="id_card_image_input" name="id_card_image" accept="image/*" required onchange="previewIDCardImage(event)">
    </label>
</div>


                                </fieldset>
                                <div id="error-messages" style="color:red;"></div>

                                <button style="margin-top:20px;" type="submit" name="register" id="contact-submit" data-submit="...Sending">Email Verification</button>
                            </form>
                    </div>

                </div>
                <div class="col-lg-5 mb-3 mb-lg-0 mx-auto" style="background-image: url(../assets/images/signup/signinbg.png); background-repeat: no-repeat;
                background-size: cover; padding: 270px 30px;">
                    
                    <p>Hello, Friend! <br><b>Fill Your Info and start<br> a journey with us</b></p>
                    <a href="../signin.php"><button>Sign In</button></a>
                </div>
<!-- row end -->
            </div>
    </section>

<!-- footer end -->
<script>
    // Check if the error message variable is not empty
    var errorMessage = "<?php echo $error_message; ?>";
    if (errorMessage !== "") {
      // Display the error message in the error <div>
      document.getElementById("error-messages").textContent = errorMessage;
    }
  </script>
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
<script>
    function previewIDCardImage(event) {
        const input = event.target;
        const preview = document.getElementById('id_card_image_preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';

                // Hide the default picture
                const defaultPicture = document.querySelector('.id-card label');
                defaultPicture.style.background = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


<!-- jQuery -->
<script src="../assets/plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="../assets/plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="../assets/plugins/slick/slick.min.js"></script>
<!-- venobox -->
<script src="../assets/plugins/venobox/venobox.min.js"></script>
<!-- shuffle -->
<script src="../assets/plugins/shuffle/shuffle.min.js"></script>
<!-- apear js -->
<script src="../assets/plugins/counto/apear.js"></script>
<!-- counter -->
<script src="../assets/plugins/counto/counTo.js"></script>
<!-- card slider -->
<script src="../assets/plugins/card-slider/js/card-slider-min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="../assets/plugins/google-map/gmap.js"></script>

<!-- Main Script -->
<script src="../assets/js/script.js"></script>
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