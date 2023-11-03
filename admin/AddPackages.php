
<?php
include 'connection.php'; // Include your database connection script


$error_message = ""; // Initialize error message variable
if (isset($_POST['delete_service'])) {
    foreach ($_POST['delete_service'] as $packageId => $deleteButton) {
        // Delete the package with the corresponding package ID
        $deleteQuery = "DELETE FROM packages WHERE id = '$packageId'";
        
        if ($conn->query($deleteQuery) === TRUE) {
            $error_message = '<p class="alert alert-success">Package deleted successfully!</p>';
        } else {
            $error_message = '<p class="alert alert-danger">Error deleting package: ' . $conn->error . '</p>';
        }
    }
}

 // Check if the form for updating packages is submitted
 if (isset($_POST['update_services'])) {
    // Get the data from the form for updating packages
    $id = $_POST['id'];
    $edit_package_name = $_POST['edit_package_name'];
    $edit_package_limit = $_POST['edit_package_limit'];
    $edit_package_description = $_POST['edit_package_description'];
    $edit_package_price = $_POST['edit_package_price'];
    $edit_package_status = $_POST['edit_package_status'];

    // Update the package in the database
    $updateQuery = "UPDATE packages SET
                    package_name = '$edit_package_name',
                    package_limit = '$edit_package_limit',
                    package_description = '$edit_package_description',
                    package_price = '$edit_package_price',
                    package_status = '$edit_package_status'
                    WHERE id = '$id'";

    if ($conn->query($updateQuery) === TRUE) {
        $error_message = '<p class="alert alert-success">Package updated successfully!</p>';
    } else {
        $error_message = '<p class="alert alert-danger">Error updating package: ' . $conn->error . '</p>';
    }
}

if (isset($_POST['add_Package'])) {
    // Retrieve form data
    $package_name = $_POST['package_name'];
    $package_limit = $_POST['package_limit'];
    $package_description = $_POST['package_description'];
    $package_price = $_POST['package_price'];
    $package_status = $_POST['package_status'];

    // Prepare an SQL statement to insert the data
    $insertQuery = "INSERT INTO packages (package_name, package_limit, package_description, package_price, package_status) 
                    VALUES (?, ?, ?, ?, ?)";
    
    // Create a prepared statement
    $stmt = $conn->prepare($insertQuery);
    
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("sssss", $package_name, $package_limit, $package_description, $package_price, $package_status);
        
        if ($stmt->execute()) {
            // Insertion was successful
            $error_message = "Package added successfully.";
        } else {
            // Insertion failed
            $error_message = "Error: " . $stmt->error;
        }
        
        // Close the prepared statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        $error_message = "Error in preparing statement: " . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
}
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

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
<?php include 'header.php'; ?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">

    <?php include 'SideMenu.php'; ?>

  <div class="main-panel">
    <h1 class="mt-5 mb-1">Add Packages</h1>
    <div class="row">
      <div class="col-lg-12 services-edit">
        <form method="post" action="">
                <div class="row align-items-center pack">
                <!-- Radio buttons for enabling and disabling packages -->
               
                    <div class="col-lg-6">
                    <div class="mb-3">
                    <label for="package_name" class="form-label">Package Name:</label>
                    <input type="text" class="form-control" name="package_name" required>
                </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="mb-3 setting-shoping-days">
                    <label for="package_limit" class="form-label">Days Limit:</label><br>
                    <select name="package_limit">
                        <option value="Month">Month</option>
                        <option value="Year">Year</option>
                        <option value="24 months">24 months</option>
                        <option value="48 months">48 months</option>
                    </select>
                </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="mb-3">
                    <label for="package_description" class="form-label">Description :</label>
                    <textarea class="form-control" name="package_description" rows="4" required></textarea>
                </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="mb-3">
                    <label for="package_price" class="form-label">Package Price:</label>
                    <input type="text" class="form-control" name="package_price" required>
                </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="mb-3">
                    <label for="package_status" class="form-label">Status:</label><br>
                    <div class="radio-package">
                    
                    <label for="enabled">Enable <input type="radio" id="enabled" name="package_status" value="Enabled" checked></label>
                    
                    <label for="disabled">Disable <input type="radio" id="disabled" name="package_status" value="Disabled"></label>
                    </div>
                </div>
                    </div>
                </div>
                <div class="readbtn">
                    <button type="submit" name="add_Package" class="btn btn-primary">Add Service</button>
                </div>
        </form>

      </div>
    </div>

    <!-- Edit Packages Section -->
<!-- ... Your existing HTML code ... -->

<div class="edit-packages-section">
    <h1 class="mt-5 mb-1">Edit & Delete Packages</h1>
    <div class="text-center"><h2 id="error-messages" style="color:#70be44; font-weight:700"></h2></div>
    <form method="post" class="services-edit" action="">
        <div class="row pack">
            <!-- <div class="col-lg-6"> -->
                    <?php
                // Include your database connection script
                include 'connection.php';
                // Retrieve and display existing packages
                $selectQuery = "SELECT * FROM packages";
                $result = $conn->query($selectQuery);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $package_name = $row['package_name'];
                        $package_limit = $row['package_limit'];
                        $package_description = $row['package_description'];
                        $package_price = $row['package_price'];
                        $package_status = $row['package_status'];
                        echo '<div class="col-lg-6 mt-5 p-2">';
                        echo '<div class="border border-black p-4 rounded-2">';
                        // Display the package details in a form for editing
                        echo '<input type="hidden" name="id" value="' . $id . '">';
                        echo '<div class="mb-3 mt-5">';
                        echo '<label for="edit_package_name" class="form-label">Package Name:</label>';
                        echo '<input type="text" class="form-control" name="edit_package_name" value="' . $package_name . '" required>';
                        echo '</div>';
                        echo '<div class="mb-3 setting-shoping-days d-flex flex-column gap-2">';
                        echo '<label for="edit_package_limit" class="form-label">Days Limit:</label>';
                        echo '<select name="edit_package_limit" required>';
                        echo '<option value="Month" ' . ($package_limit == 'Month' ? 'selected' : '') . '>Month</option>';
                        echo '<option value="Year" ' . ($package_limit == 'Year' ? 'selected' : '') . '>Year</option>';
                        echo '<option value="24 months" ' . ($package_limit == '24 months' ? 'selected' : '') . '>24 months</option>';
                        echo '<option value="48 months" ' . ($package_limit == '48 months' ? 'selected' : '') . '>48 months</option>';
                        echo '</select>';
                        echo '</div>';
                        echo '<div class="mb-3 mt-5">';
                        echo '<label for="edit_package_description" class="form-label">Description :</label>';
                        echo '<textarea class="form-control" name="edit_package_description" rows="4" required>' . $package_description . '</textarea>';
                        echo '</div>';
                        echo '<div class="mb-3 mt-5">';
                        echo '<label for="edit_package_price" class="form-label">Package Price:</label>';
                        echo '<input type="text" class="form-control" name="edit_package_price" value="' . $package_price . '" required>';
                        echo '</div>';
                        echo '<div class="mb-3 mt-5">';
                        echo '<label>Status:</label><br>';
                        echo '<div class="radio-package">';
                        echo '<label>Enabled<input type="radio" name="edit_package_status" value="Enabled" ' . ($package_status == 'Enabled' ? 'checked' : '') . '>  </label>';
                        echo '<label>Disabled<input type="radio" name="edit_package_status" value="Disabled" ' . ($package_status == 'Disabled' ? 'checked' : '') . '>  </label>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div style="display:flex;gap:10px;justify-content:right;">';
                        echo '<button type="submit" name="delete_service[' . $id . ']" class="btn text-white">Delete</button>'; // Include the package ID in the button name
                        echo '<button type="submit" name="update_services" class="btn text-white">Update Package</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                    }
                } else {
                    echo '<p>No packages found.</p>';
                }
                ?>
            <!-- </div> -->
        </div>
    </form>

</div>

<!-- Your Edit Package Modal Goes Here -->
<!-- Update Package Modal -->

<!-- <div class="modal fade" id="updatePackageModal" tabindex="-1" role="dialog" aria-labelledby="updatePackageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatePackageModalLabel">Update Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="package_id" id="update_package_id">
          <div class="mb-3">
            <label for="edit_package_name" class="form-label">Package Name:</label>
            <input type="text" class="form-control" name="edit_package_name" id="edit_package_name" required>
          </div>
          <div class="mb-3 setting-shoping-days">
            <select name="edit_package_limit" id="edit_package_limit">
              <option value="Month">Month</option>
              <option value="Year">Year</option>
              <option value="24 months">24 months</option>
              <option value="48 months">48 months</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_package_description" class="form-label">Description:</label>
            <textarea class="form-control" name="edit_package_description" id="edit_package_description" rows="4" required></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_package_price" class="form-label">Package Price:</label>
            <input type="text" class="form-control" name="edit_package_price" id="edit_package_price" required>
          </div>
          <div class="mb-3">
            <label>Status:</label><br>
            <input type="radio" name="edit_package_status" value="Enabled" id="edit_enable"> Enabled
            <input type="radio" name="edit_package_status" value="Disabled" id="edit_disable"> Disabled
          </div>
          <button type="submit" name="update_services" class="btn btn-primary">Update Package</button>
        </form>
      </div>
    </div>
  </div>
</div> -->


<!-- ... Your existing HTML code ... -->

   <!-- delete and update service -->
    
  </div>
</div>

<script>
    // JavaScript functions for custom modal
    function openEditModal(serviceId) {
        var modal = document.getElementById("customEditModal");
        modal.style.display = "block";
        
        // Use AJAX to fetch service data based on serviceId and populate the form fields
        // Replace the following lines with your AJAX logic to populate the fields
        document.getElementById("serviceId").value = serviceId;
        // document.getElementById("headingField").value = "Service Heading"; // Replace with actual data
        // document.getElementById("contentField").value = "Service Content"; // Replace with actual data
    }

    function closeEditModal() {
        var modal = document.getElementById("customEditModal");
        modal.style.display = "none";
    }
</script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+k/e7Jnw2+rpsQ/g5F5n5Xg5fw" crossorigin="anonymous"></script>
<script>
    // Enable inline editing of fields
    document.querySelectorAll('.editable').forEach(function (element) {
        element.addEventListener('click', function () {
            var field = this.dataset.field;
            var id = this.dataset.id;
            var newValue = prompt('Edit ' + field, this.textContent);
            if (newValue !== null) {
                this.textContent = newValue;
                // You can also update the field in the database using AJAX
                // Example: send a POST request to update the field
                // $.post('update_field.php', { id: id, field: field, value: newValue });
            }
        });
    });
</script>
<script>
    // Check if the error message variable is not empty
    var errorMessage = "<?php echo $error_message; ?>";
    if (errorMessage !== "") {
      // Display the error message in the error <div>
      document.getElementById("error-messages").textContent = errorMessage;
    }
  </script>
<script>
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

</script>

</body>
</html>
