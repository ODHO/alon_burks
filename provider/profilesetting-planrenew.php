<?php
session_start();

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
                <a href="#"><button>Renew plan</button></a></p>
            </div>
          </div>
        </div>
        <div class="pause-auto">
        <div class="row" style="padding: 15px 0px;">
            <div class="col-md-9 align-self-center">
                <h2 style="font-family: 'Cairo';">Pause Subscription</h2>
            </div>
            <div class="col-md-3 align-self-center pause-subcriptions">
                <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
            </div>
        </div>
        <hr>
        <div class="row pause-subcriptions" style="padding: 15px 0px;">
            <div class="col-md-9 align-self-center">
                <h2 style="font-family: 'Cairo';">Auto Plan Renewal </h2>
            </div>
            <div class="col-md-3 align-self-center auto-plan">
                <section class="model-3">
                    <div class="checkbox">
                      <input type="checkbox"/>
                      <label></label>
                    </div>
                  </section>
            </div>
        </div>

        <div class="row">
            <div class="delete-subscription">
                <a style="color: #E72121; font-size: 24px; text-decoration: unset; font-family: 'Cairo';" href="#">Delete Subscription</a>
            </div>
        </div>
    </div>

    <div class="select-your-plan" style="padding: 40px 0px;">
        <div class="heading-text">
            <h2 style="color: #757575;">Upgrade to new</h2>
            <h1 style="font-family: Cairo;
            font-size: 37px;
            font-weight: 700;
            line-height: 69px;
            letter-spacing: 0em;
            text-align: left;
            color: #215B00;">Select your Plan</h1>
        </div>
        <div class="row" style="padding: 30px 0px;">
        <?php
              // Include your database connection script
              include 'connection.php';

              // Query to retrieve packages from the database
              $selectQuery = "SELECT * FROM packages";
              $result = $conn->query($selectQuery);

              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      $package_name = $row['package_name'];
                      $package_limit = $row['package_limit'];
                      $package_description = $row['package_description'];
                      $package_price = $row['package_price'];
                      $package_status = $row['package_status'];

                      echo '<div class="col-lg-4 mb-4 mb-lg-0">';
                      echo '<div class="price-plan-subscribe">';
                      echo '<img src="./images/priceplans/1.png" width="auto"/>';
                      echo '<h1>' . $package_name . '</h1>';
                      echo '<p>' . $package_limit . '</p>';

                      echo '<ul>';
                      echo '<li>'. $package_description .'</li>';
                      echo '</ul>';

                      echo '<div class="price mb-3">';
                      echo '<h1>$ ' . $package_price . '</h1>';
                      echo '</div>';
                      
                      // Check if the package is enabled
                      if ($package_status === 'Enabled') {
                          echo '<a class="subscribe-button ">';
                          echo '<button>Subscribe</button>';
                          echo '</a>';
                      } else {
                          // Display a message indicating that the package is disabled
                          echo '<div class="package-btn">';
                          echo '<p>Package is disabled</p>';
                          echo '</div>';
                      }

                      echo '</div>';
                      echo '</div>';
                  }
              } else {
                  // Handle the case when no packages are found
                  echo '<p>No packages found.</p>';
              }

              // Close the database connection
              $conn->close();
?>

            <!-- <div class="col-md-4">
                <div class="price-plan-subscribe">
                    <img src="./images/priceplans/1.png" width="auto"/>
                    <h2>Basic Seller Package</h2>
                    <p>Monthly</p>
                    <ul class="subscription-list">
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                    </ul>
                    <div class="price">
                        <h4>$ 4.99</h4>
                    </div>
                    <div class="subscribe-button">
                        <a href="#">
                            <button>Subscribed</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="price-plan-subscribe">
                    <img src="./images/priceplans/2.png" width="auto"/>
                    <h2>Pro Seller Package</h2>
                    <p>Monthly</p>
                    <ul class="subscription-list">
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                    </ul>
                    <div class="price">
                        <h4>$ 6.99</h4>
                    </div>
                    <div class="subscribe-button">
                        <a href="#">
                            <button>Subscribed</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="price-plan-subscribe">
                    <img src="./images/priceplans/3.png" width="auto"/>
                    <h2>Business Seller Package</h2>
                    <p>Monthly</p>
                    <ul class="subscription-list">
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                        <li>
                            Lorem Ipsum is simply dummy text of the printing
                        </li>
                    </ul>
                    <div class="price">
                        <h4>$ 9.99</h4>
                    </div>
                    <div class="subscribe-button">
                        <a href="#">
                            <button>Subscribed</button>
                        </a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

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
</body>

</html>
<script>
  $(document).ready(function() {

    
var readURL = function(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-pic').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}


$(".file-upload").on('change', function(){
    readURL(this);
});

$(".upload-button").on('click', function() {
   $(".file-upload").click();
});
});
</script>
<script>
  $(document).ready(function() {
//-------------------------------SELECT CASCADING-------------------------//
var selectedCountry = (selectedRegion = selectedCity = "");
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
    // APPEND OR INSERT DATA TO SELECT ELEMENT.
    $("#country").append(
      '<option value="' + value.code + '">' + value.name + "</option>"
    );
  });
});
// Country selected --> update region list .
$("#country").change(function() {
  selectedCountry = this.options[this.selectedIndex].text;
  countryCode = $("#country").val();
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
  countryCode = $("#country").val();
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
  $("#location").php(
    "Locatation: Country: " +
      selectedCountry +
      ", Region: " +
      selectedRegion +
      ", City: " +
      selectedCity
  );
});
});

</script>