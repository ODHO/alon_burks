<?php
session_start();
include 'connection.php'; // Include your database connection script

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $email = $phone = $address = $country = $region = $city = $zipcode = '';
$error_message = '';

// Check if the form is submitted
if (isset($_POST['update_profile'])) {
    // Retrieve user input from the form
    $id = $_SESSION['user_id']; // Get the user's ID from the session
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $region = $_POST['region'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
// echo $_SESSION['user_id'];
// die();
    // Check if a new profile picture is uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $profile_picture_filename = $_FILES['profile_picture']['name'];
        $profile_picture_local_path = 'profile_pictures/' . $profile_picture_filename;

        // Move the uploaded profile picture to the destination folder
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture_local_path)) {
            $profile_picture = $profile_picture_local_path;
        } else {
            $error_message = "Error uploading profile picture.";
        }
    }

    // Build the base SQL query
    $update_sql = "UPDATE provider_registration SET";

    // Create an array to store the fields that the user wants to update
    $update_fields = array();

    // Check if each field is set in the form data and add it to the update_fields array
    if (!empty($fullname)) {
        $update_fields[] = "fullname='$fullname'";
    }
    if (!empty($phone)) {
        $update_fields[] = "phone='$phone'";
    }
    if (!empty($address)) {
        $update_fields[] = "address='$address'";
    }
    if (!empty($country)) {
        $update_fields[] = "country='$country'";
    }
    if (!empty($region)) {
        $update_fields[] = "region='$region'";
    }
    if (!empty($city)) {
        $update_fields[] = "city='$city'";
    }
    if (!empty($zipcode)) {
        $update_fields[] = "zipcode='$zipcode'";
    }
    if (!empty($email)) {
        $update_fields[] = "email='$email'";
    }
    // Add the profile_picture update only if a new image is uploaded
    if (!empty($profile_picture)) {
        $update_fields[] = "profile_picture='$profile_picture'";
    }

    // Check if there are fields to update
    if (!empty($update_fields)) {
        // Combine the update fields into the SQL query
        $update_sql .= ' ' . implode(', ', $update_fields);

        // Add the WHERE clause to update the user based on their ID
        $update_sql .= " WHERE id='$id'"; // Assuming 'id' is the primary key

        // Execute the SQL query
        if ($conn->query($update_sql) === TRUE) {
            $error_message = "Profile updated successfully.";
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
    } else {
        // No fields to update
        $error_message = "No fields to update.";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

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
  <link rel="stylesheet" href="../provider/vendors/mdi/css/materialdesignicons.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

  
</head>
<body>
  <div class="container-scroller ndnd">
    <!-- partial:partials/_navbar.php -->
    <?php 
     include 'header.php'
    ?>
    <!-- partial -->
    <div class="container page-body-wrapper">
      <!-- partial:partials/_settings-panel.php -->
      <!-- <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="ti-settings"></i></div>
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close ti-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border me-3"></div>Light</div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border me-3"></div>Dark</div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
           <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default"></div>
          </div> 
        </div>
      </div> -->
    
      <!-- partial -->
      <div class="main-panel py-4">
       
        
        <?php
                if (isset($_SESSION['user_id'])) {
                ?>
        <form id="contact" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="profile-setting-picture" style="padding: 50px 0px;">
              <h2>Your Profile</h2>
              <!-- Profile Picture Upload -->
              <?php
                          if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'customer') {
                              $userId = $_SESSION['user_id'];
                              $userDataQuery = "SELECT fullname, city, phone, email, profile_picture, zipcode, address, country, region FROM provider_registration WHERE id = $userId";
                              $result = $conn->query($userDataQuery);
                              if ($result->num_rows > 0) {
                                  $row = $result->fetch_assoc();
                                  $fullname = $row['fullname'];
                                  $email = $row['email'];
                                  $city = $row['city'];
                                  $zipcode = $row['zipcode'];
                                  $region = $row['region'];
                                  $phone = $row['phone'];
                                  $address = $row['address'];
                                  $country = $row['country'];
                                  $profileImage = $row['profile_picture'];
                                  // $user_id = $_SESSION['id'];
                                  ?>  
              <div class="small-12 medium-2 large-2 columns">
                  <div class="circle">
                      <img class="profile-pic" src="./<?php echo $profileImage; ?>">
                  </div>
                  <div class="p-image">
                  <i class="menu-icon mdi mdi-pencil"></i>
                      <input class="file-upload" type="file" name="profile_picture" accept="image/*"></input>

                  </div>
              </div>
          </div>
          <div class="row profile-setting-form">
            <div class="col-lg-12">
            <fieldset>
                  <input placeholder="Full Name" name="fullname" type="text" tabindex="1" required  value="<?php echo $fullname; ?>">
              </fieldset>
            </div>
            <div class="col-lg-12">
            <fieldset>
            <input placeholder="Email Address@" name="email" type="email" tabindex="2" required value="<?php echo $email; ?>">
              </fieldset>
            </div>
            <div class="col-lg-12">
            <fieldset>
            <input placeholder="Phone #@" name="phone" type="tel" tabindex="3" required value="<?php echo $phone; ?>">
              </fieldset>
            </div>
            <div class="col-lg-12">
            <fieldset>
            <input placeholder="Street Address@" name="address" type="text" tabindex="4" required value="<?php echo $address; ?>">
              </fieldset>
            </div>
              
             
                                          <div class="col-lg-4 mb-3">
                                          <fieldset>
                                              <select id="country" name="country" class='form-control'>
                                              <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                              </select>
                                          </fieldset>
                                          </div>
                                          <div class="col-lg-4 mb-3">
                                          <fieldset>
                                              <select id="region" name="region" class='form-control'>
                                              <option value=""><?php echo $region; ?></option>
                                              </select>
                                          </fieldset>
                                          </div>
                                          <div class="col-lg-4 mb-3">
                                          <fieldset>
                                              <select id="city" name="city" class='form-control'>
                                              <option value=""><?php echo $city; ?></option>
                                              </select>
                                          </fieldset>
                                          </div>
                                          <div class="col-lg-12">
                                          <fieldset>
                                                <input placeholder="Zip Code" name="zipcode" type="text" tabindex="5" required value="<?php echo $zipcode; ?>">
                                            </fieldset>
                                          </div>
                                            <div id="error-messages" style="color:red;"></div>
                                            <div class="col-lg-12">
                                            <fieldset>
                                                <button type="submit" name="update_profile">Save</button>
                                            </fieldset>
                                            </div>
              <?php
                              } else {
                                  echo "User Not Found";
                              }
                          }
                      ?>
          </div>
        </form>
<?php
                } else {
                ?>
            <?php
              }
            ?>


      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
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