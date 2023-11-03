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
      $profile_picture_local_path = 'application_images/' . $profile_picture_filename;

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
  <!-- GOOGLE FONTS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Aaron Burks  </title>
  <!-- plugins:css -->
 <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/sitelogo-singup.png" />
  <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'> -->

</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.php -->
    <?php 
     include 'header.php'
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
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
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
              </ul>
            </div>
            <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 11 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
              <p class="text-gray mb-0">The total number of sessions</p>
            </div>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 7 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
              <p class="text-gray mb-0 ">Call Sarah Graves</p>
            </div>
          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <div class="wrapper d-flex">
                    <p>Catherine</p>
                  </div>
                  <p>Away</p>
                </div>
                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                <small class="text-muted my-auto">23 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Sarah Graves</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">47 min</small>
              </li>
            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php
      include 'SideMenu.php'
      ?>
      <!-- partial -->
      <div class="main-panel">
        <h2 style="color: #70BE44;"><b>Profile Settings</b></h2>
        <h1 style="color: #4F4F4F; padding-bottom: 20px; font-family: Cairo; font-weight: bold;">Package Subscribed</h1>
        <div class="dasboard-heading profile-setting">
          
          <div class="row">
            <div class="col-md-3">
              <p><b>Basic Seller Package</b><br>
                Monthly</p>
            </div>
            <div class="col-md-3">
              <p><b>Subscribe Date</b><br>
                20-June-2023</p>
            </div>
            <div class="col-md-3">
              <p><b>Expiry Date</b><br>
                20-July-2023</p>
            </div>
            <div class="col-md-3">
              <p><b>Upgrade to pro</b><br>
                <a href="profilesetting-planrenew.php"><button>Plan Settings </button></a></p>
            </div>
          </div>
        </div>
        
        <?php
                if (isset($_SESSION['user_id'])) {
                ?>
        <form id="contact" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="profile-setting-picture" style="padding: 50px 0px;">
              <h2>Your Profile</h2>
              <!-- Profile Picture Upload -->
              <?php
                          if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'provider') {
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
                      <input class="file-upload" type="file" name="profile_picture" accept="image/*"/>
                  </div>
              </div>
          </div>
          <div class="row profile-setting-form">
              <fieldset>
                  <input placeholder="Full Name" name="fullname" type="text" tabindex="1" required  value="<?php echo $fullname; ?>">
              </fieldset>
              <fieldset>
                  <input placeholder="Email Address@" name="email" type="email" tabindex="2" required value="<?php echo $email; ?>">
              </fieldset>
              <fieldset>
                  <input placeholder="Phone #@" name="phone" type="tel" tabindex="3" required value="<?php echo $phone; ?>">
              </fieldset>
              <fieldset>
                  <input placeholder="Street Address@" name="address" type="text" tabindex="4" required value="<?php echo $address; ?>">
              </fieldset>
              <div class="row">
                                          <div class="col-lg-4 mb-3">
                                          <fieldset>
                                              <select id="country" name="country" class='form-control'>
                                              <option value=""><?php echo $country; ?></option>
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
                                      </div>
              <fieldset>
                  <input placeholder="Zip Code" name="zipcode" type="text" tabindex="5" required value="<?php echo $zipcode; ?>">
              </fieldset>
              <div id="error-messages" style="color:red;"></div>
              <fieldset>
                  <button type="submit" name="update_profile">Save</button>
              </fieldset>
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
  <!-- End custom js for this page-->
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
