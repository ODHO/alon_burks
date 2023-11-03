<?php
include '../connection.php';
error_reporting(0);
session_start();

// Check if the user is logged in and has a valid session
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'provider') {
    $provider_id = $_SESSION['user_id'];
    $address = $_SESSION['address'];

    // Process the form data and insert/update it into the provider_services table
    if (isset($_POST['submit'])) {
        // Retrieve selected services and commercial services
        $services = isset($_POST['services']) ? implode(', ', $_POST['services']) : '';
        $commercialServices = isset($_POST['commercial_service']) ? implode(', ', $_POST['commercial_service']) : '';
        $selectedPackage = $_POST['selectedPackage'];
        $shop_working_day = $_POST['shop_working_day'];
        $shop_working_day_to = $_POST['shop_working_day_to'];
        $working_timings_from = $_POST['working_timings_from'];
        $working_timings_to = $_POST['working_timings_to'];
        $additionalContent = $_POST['additional_content'];

        // Handle multiple image file uploads
        $image_paths = array();

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $image_path = 'uploads/' . $_FILES['images']['name'][$key];
                move_uploaded_file($_FILES['images']['tmp_name'][$key], $image_path);
                $image_paths[] = $image_path;
            }
        } else {
            $image_paths[] = ''; // Set image_path to empty if no images are uploaded
        }

        // Check if a record for the user already exists in provider_services
        $checkRecordQuery = "SELECT * FROM provider_services WHERE provider_id = '$provider_id'";
        $result = $conn->query($checkRecordQuery);

        if ($result->num_rows > 0) {
            // If a record exists, update it
            $updateQuery = "UPDATE provider_services SET ";
            
            // Check if services were provided, and update accordingly
            if (!empty($services)) {
                $updateQuery .= "services = '$services', ";
            }
            
            // Check if commercial services were provided, and update accordingly
            if (!empty($commercialServices)) {
                $updateQuery .= "commercial_services = '$commercialServices', ";
            }

            $updateQuery .= "shop_working_day = '$shop_working_day', shop_working_day_to = '$shop_working_day_to', 
                            working_timings_from = '$working_timings_from', working_timings_to = '$working_timings_to', 
                            selectedPackage = '$selectedPackage', additional_content = '$additionalContent' WHERE provider_id = '$provider_id'";

            if ($conn->query($updateQuery) === TRUE) {
                // Update was successful, you can also update the images if needed
                // ...

                // Retrieve provider_services_id from the existing record
                $provider_services_id = $result->fetch_assoc()['id'];
                
                // Delete existing images for the provider
                $deleteImagesQuery = "DELETE FROM provider_images WHERE provider_services_id = '$provider_services_id'";
                $conn->query($deleteImagesQuery);

                // Insert the image paths into the new table with provider_services_id
                foreach ($image_paths as $image_path) {
                    $insertImageQuery = "INSERT INTO provider_images (provider_services_id, image_path)
                                        VALUES ('$provider_services_id', '$image_path')";
                    $conn->query($insertImageQuery);
                }

                header("Location: service-settings.php");
                exit;
            } else {
                // Update failed, handle this accordingly
                $error_message = "Error updating record: " . $conn->error;
            }
        } else {
            // If no record exists, insert a new record
            if (!empty($services) || !empty($commercialServices)) {
                $insertQuery = "INSERT INTO provider_services (provider_id, services, commercial_services, shop_working_day, shop_working_day_to, working_timings_from, working_timings_to, selectedPackage, additional_content)
                            VALUES ('$provider_id', '$services', '$commercialServices', '$shop_working_day', '$shop_working_day_to', '$working_timings_from', '$working_timings_to', '$selectedPackage', '$additionalContent')";

                if ($conn->query($insertQuery) === TRUE) {
                    // Insertion was successful
                    $provider_services_id = $conn->insert_id;

                    // Check if there are new images to insert
                    if (!empty($image_paths[0])) {
                        // Insert the image paths into the new table with provider_services_id
                        foreach ($image_paths as $image_path) {
                            $insertImageQuery = "INSERT INTO provider_images (provider_services_id, image_path)
                                                VALUES ('$provider_services_id', '$image_path')";
                            $conn->query($insertImageQuery);
                        }
                    }

                    // You can redirect or display a success message here
                    header("Location: service-settings.php");
                    exit;
                } else {
                    // Insertion failed, handle this accordingly
                    $error_message = "Error inserting record: " . $conn->error;
                }
            }
        }
    }
} else {
    // If the user is not logged in as a provider, you can handle this case (e.g., redirect to a login page)
    header("Location: ../signin.php");
    exit;
}
?>

<!-- Your HTML form here -->



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
      <div class="notify-profile">
        <p>Service <span style="color: #70BE44;">Settings</span></p>
      </div>

      <div class="your-service-radius">
        <div class="row">
          <div class="col-md-4 d-flex align-items-center">
            <h2>Your Service Radius</h2>
          </div>
          <div class="col-md-8 d-flex align-items-center">
            <p>Company Address:&nbsp;</p>
            <p><?php echo $address?></p>
          </div>
          <!-- <div class="col-md-5 d-flex align-items-center">
            
          </div> -->
        </div>

        
       
      </div>

      <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="space row your-service-radius">
              <div class="col-md-12">
                  <div class="steps-2">
                      <div class="progress" id="progress1">
                          <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:6%"></div>
                      </div>
                      <div class="step">
                          <span class="point activestep" onclick="javascript: resetActive(event, 5, 'step-1'); selectPackage('Basic Package');" >
                              <span class="price">Basic Package</span>
                          </span>
                          <span class="point" onclick="javascript: resetActive(event, 51, 'step-1'); selectPackage('Pro Package');">
                              <span class="price">Pro Package</span>
                            </span>
                            <span class="point" onclick="javascript: resetActive(event, 98, 'step-1'); selectPackage('Business Package');">
                              <span class="price">Business Package</span>
                          </span>              
                      </div>
                  </div>
              </div>
            </div>
        </div>
        
        <input type="hidden" id="selectedPackage" name="selectedPackage" value="Basic Package">

        <div class="service-provideselec">
          <div class="heading">
            <h2>Select the service You Provide</h2>
          </div>
          <div class="row" style="padding: 20px 0px;">
            
          <?php
// Include your database connection script
include 'connection.php';

// Retrieve the selected services for the current provider
$selectedServices = [];

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'provider') {
    $provider_id = $_SESSION['user_id'];

    // Retrieve the selected services for the provider
    $sql = "SELECT services FROM provider_services WHERE provider_id = '$provider_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $selectedServices = explode(', ', $row['services']);
    }
}

// Retrieve services from the database
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $service_id = $row['id'];
        $service_name = $row['heading'];
        echo '<div class="col-md-3">';
        $checked = in_array($service_name, $selectedServices) ? 'checked' : '';
        echo '<input type="checkbox" id="service' . $service_id . '" name="services[]" value="' . $service_name . '" ' . $checked . '>';
        echo '<label for="service' . $service_id . '"> ' . $service_name . '</label><br>';
        echo '</div>';
    }
}
?>


          </div>


          <div class="heading">
            <h2>Select the Commercial service You Provide</h2>
          </div>
          <div class="row" style="padding: 20px 0px;">            
                    <?php
                  // Include your database connection script
                  include 'connection.php';

                  // Retrieve services from the database
                  $sql = "SELECT * FROM categories";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          $service_id = $row['id'];
                          $service_name = $row['heading'];
                          echo '<div class="col-md-3">';
                          // <input type="checkbox" id="commercialService1" name="commercial_service[]" value="Gardening">

                          echo '<input type="checkbox" id="commercialService' . $service_id . '" name="commercial_service[]" value="' . $service_name . '">';
                          echo '<label for="commercialService' . $service_id . '"> ' . $service_name . '</label><br>';
                          echo '</div>';
                      }
                  }
                  ?>
           
          </div>
      </div>


                <div class="setting-shoping-days">
                 <!-- Your HTML form here -->
<div class="row">
    <h2>Shop Working Days</h2>
    <div class="col-md-4">
        <?php
        include 'connection.php';
        
        // Retrieve the selected services for the current provider
        $shop_working_day = [];
        
        if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'provider') {
            $provider_id = $_SESSION['user_id'];
        
            // Retrieve the selected services for the provider
            $sql = "SELECT shop_working_day, shop_working_day_to, working_timings_from, working_timings_to, additional_content FROM provider_services WHERE provider_id = '$provider_id'";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $shop_working_day = explode(', ', $row['shop_working_day']);
                $shop_working_day_to = explode(', ', $row['shop_working_day_to']);
                $working_timings_from =  $row['working_timings_from'];
                $working_timings_to = $row['working_timings_to'];
                $additional_content = $row['additional_content'];
                // echo $working_timings_from;
                // die;
            }
        }
        // print_r($shop_working_day);
        // die;
        // Retrieve services from the database
        $sql = "SELECT * FROM provider_services";
        $result = $conn->query($sql);
        
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        echo '<select name="shop_working_day">';
        foreach ($days as $day) {
            $selected = (in_array($day, $shop_working_day)) ? 'selected' : '';
            echo '<option value="' . $day . '" ' . $selected . '>' . $day . '</option>';
        }
        echo '</select>';
        ?>
    </div>
    <div class="col-md-2">
        <h3>To</h3>
    </div>
    <div class="col-md-4">
        <?php
        echo '<select name="shop_working_day_to">';
        foreach ($days as $day) {
            $selected = (in_array($day, $shop_working_day_to)) ? 'selected' : '';
            echo '<option value="' . $day . '" ' . $selected . '>' . $day . '</option>';
        }
        echo '</select>';
        ?>
    </div>
    <div class="col-md-2">
    </div>
</div>

<div class="row">
    <h2>Working Timings</h2>
    <div class="col-md-4">
        <input type="time" id="appt" name="working_timings_from" value="<?= $working_timings_from ?>">
    </div>
    <div class="col-md-2">
        <h3>From</h3>
    </div>
    <div class="col-md-4">
        <input type="time" id="appt" name="working_timings_to" value="<?= $working_timings_to ?>">
    </div>
    <div class="col-md-2">
    </div>
</div>

                  <div class="setting-shoping-days">
                    <h2 for="additional_content">About Your Self</h2>
                    <textarea name="additional_content" id="additional_content" class="txt-add" rows="4" cols="50"><?php echo $additional_content?></textarea>
                  </div>
                <div class="gallery-section-service" style="padding: 40px 0px 30px 0px;">
                  <h2>Your Past work Images</h2>
                  <div class="container">
                      <div class="row">
                          <div class="my-2" style="background-image: url(./images/upload.PNG);">
                              <input type="file" class="form-control" id="images" name="images[]" onchange="preview_images();" multiple accept="image/*" />
                          </div>
                      </div>
                      <div class="row" id="image_preview"></div>
                  </div>
                </div>



        <div class="next-previouss">
          <div class="row">
            <div class="col-md-6">
            <a class="finish" href="#"><button type="submit" name="submit">Save</button></a>
            </div>
            <div class="col-md-6">
              
            </div>
          </div>
        </div>

      </div>
      </form>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <script>
    function preview_images() {
        var preview = document.getElementById("image_preview");
        var files = document.getElementById("images").files;

        if (files.length !== 5) {
            alert("Please select exactly 5 images.");
            return;
        }

        preview.innerHTML = ""; // Clear previous preview

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var image = document.createElement("img");
                image.src = e.target.result;
                image.className = "preview-image";
                preview.appendChild(image);
            };

            reader.readAsDataURL(file);
        }
    }
</script>
  <script>
function selectPackage(packageName) {
    // Set the selected package in the hidden input field
    document.getElementById('selectedPackage').value = packageName;
    
    // You can also highlight the selected package visually if needed
    // For example, by adding a CSS class to the selected package element
    // and removing it from others
}
</script>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
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

<script>   function resetActive(event, percent, step) {
  $(".progress-bar").css("width", percent + "%").attr("aria-valuenow", percent);
  $(".progress-completed").text(percent + "%");

  $("span").each(function () {
      if ($(this).hasClass("activestep")) {
          $(this).removeClass("activestep");
      }
  });

  if (event.target.className == "point") {
      $(event.target).addClass("activestep");
  }
  else {
      $(event.target.parentNode).addClass("activestep");
  }
}

</script>

<!-- <script>
  function preview_images() {
var total_file = document.getElementById("images").files.length;
for(var i=0;i<total_file;i++){
  $('#image_preview').append(`
              <div class='col-md-2'>
                  <img style='width:100%' class='img-responsive' src='${URL.createObjectURL(event.target.files[i])}'>
              </div>`);
}
}
function resetForm(){
$("#image_preview").php("");
return true;
}
</script> -->