<?php
// Include your database connection script
include 'connection.php';

$error_message = "";
// Check if the delete button is clicked
if (isset($_POST['delete_service'])) {
    $service_id = $_POST['service_id'];

    // Delete the service from the database
    $delete_sql = "DELETE FROM categories WHERE id = $service_id";
    if ($conn->query($delete_sql) === TRUE) {
        $error_message = "Service deleted successfully.";
    } else {
        $error_message = "Error deleting service: " . $conn->error;
    }
}

// Check if the update button is clicked
if (isset($_POST['update_service'])) {
    $service_id = $_POST['service_id'];
    $heading = $_POST['heading'];
    $content = $_POST['content'];
    $price = $_POST['price'];

    // Upload image and get its path (if a new image is selected)
    $new_image = $_FILES['new_image']['name'];
    $target_dir = "uploads/"; // Create a directory for image uploads
    $target_file = $target_dir . basename($_FILES['new_image']['name']);

    // Check if the image file is a valid image (if a new image is selected)
    if ($new_image != '') {
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (getimagesize($_FILES['new_image']['tmp_name']) === false) {
            $error_message = "Invalid image file.";
            exit;
        } elseif (move_uploaded_file($_FILES['new_image']['tmp_name'], $target_file)) {
            // Update the service in the database with the new image
            $update_sql = "UPDATE categories SET image = '$new_image', heading = '$heading', content = '$content', price = '$price' WHERE id = $service_id";
        } else {
            $error_message = "Error uploading image.";
            exit;
        }
    } else {
        // Update the service in the database without changing the image
        $update_sql = "UPDATE categories SET heading = '$heading', content = '$content', price = '$price' WHERE id = $service_id";
    }

    if ($conn->query($update_sql) === TRUE) {
        $error_message = "Service updated successfully.";
    } else {
        $error_message = "Error updating service: " . $conn->error;
    }
}

// Check if the add services form is submitted
if (isset($_POST['add_services'])) {
    $heading = $_POST['heading'];
    $content = $_POST['content'];
    $price = $_POST['price'];

    // Upload image and get its path
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/"; // Create a directory for image uploads
    $target_file = $target_dir . basename($_FILES['image']['name']);

    // Check if the image file is a valid image
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (getimagesize($_FILES['image']['tmp_name']) === false) {
        $error_message = "Invalid image file.";
    } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert data into the services table
        $sql = "INSERT INTO categories (image, heading, content, price ) VALUES ('$image', '$heading', '$content', '$price')";
        if ($conn->query($sql) === TRUE) {
            $error_message = "Service added successfully.";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error_message = "Error uploading image.";
    }
}

// Retrieve and display services in a Bootstrap table
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
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
    <h1 class="mt-5 mb-1">Add Service</h1>
    <div class="row">
      <div class="col-lg-12 services-edit">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" name="image" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="heading" class="form-label">Heading:</label>
                <input type="text" class="form-control" name="heading" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" name="content" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input class="form-control" name="price" rows="4" required>
            </div>
            <button type="submit" name="add_services" class="btn btn-primary">Add Service</button>
        </form>
      </div>
    </div>


   <!-- delete and update service -->
    <div class="text-center"><h2 id="error-messages" style="color:#70be44; font-weight:700"></h2></div>
    <div class="delete-update">
        <h1 class="mt-5 mb-1">Services</h1>
        <div class="container">
          <?php
            if ($result->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr><th>Image</th><th>Heading</th><th>Content</th><th>Price</th><th>Actions</th></tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                  echo '<tr data-service-id="' . $row['id'] . '">';
                  echo "<td><img src='uploads/{$row['image']}' alt='{$row['heading']}' width='100'></td>";
                  echo '<td class="editable" data-field="heading">' . $row['heading'] . '</td>';
                  echo '<td class="editable" data-field="content">' . $row['content'] . '</td>';
                  echo '<td class="editable" data-field="price">' . $row['price'] . '</td>';
                  echo '<td class="btn-td">';
                  echo '<button type="button" class="btn btn-primary" onclick="openEditModal(' . $row['id'] . ')">Edit</button>';
                  echo '<form method="post" action="">';
                  echo '<input type="hidden" name="service_id" value="' . $row['id'] . '">';
                  echo '<button type="submit" name="delete_service" class="btn btn-danger">Delete</button>';
                  echo '</form>';
                  echo '</td>';
                  echo '</tr>';
              }
              
                echo '</tbody>';
                echo '</table>';
            } else {
                echo "No services found.";
            }
          ?>
        </div>
    </div>

<!-- Custom Edit Modal -->
    <div class="custom-modal" id="customEditModal">
        <div class="modal-content services-edit">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <!-- Your Edit Service Form Goes Here -->
            <form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="service_id" id="serviceId">
    <div class="mb-3">
        <label for="new_image" class="form-label">New Image:</label>
        <input type="file" class="form-control" name="new_image" accept="image/*">
    </div>
    <div class="mb-3">
        <label for="heading" class="form-label">Heading:</label>
        <input type="text" class="form-control" name="heading" id="headingField" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content:</label>
        <textarea class="form-control" name="content" id="contentField" rows="4" required></textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input class="form-control" name="price" id="priceField" required>
    </div>
    <button type="submit" name="update_service" class="btn btn-primary">Update Service</button>
</form>

        </div>
    </div>

    </div>
  </div>
</div>

<script>
    // JavaScript functions for custom modal
    var selectedService = null;

    function openEditModal(serviceId) {
        selectedService = serviceId;
        var modal = document.getElementById("customEditModal");
        modal.style.display = "block";

        // Find the corresponding service row
        var serviceRow = document.querySelector('tr[data-service-id="' + serviceId + '"]');

        // Populate the form fields with data from the service row
        document.getElementById("serviceId").value = serviceRow.dataset.serviceId;
        document.getElementById("headingField").value = serviceRow.querySelector('.editable[data-field="heading"]').textContent;
        document.getElementById("contentField").value = serviceRow.querySelector('.editable[data-field="content"]').textContent;
        document.getElementById("priceField").value = serviceRow.querySelector('.editable[data-field="price"]').textContent;
    }

    function closeEditModal() {
        var modal = document.getElementById("customEditModal");
        modal.style.display = "none";
    }

    function updateService() {
        if (selectedService !== null) {
            // Retrieve updated data from the form fields
            var heading = document.getElementById("headingField").value;
            var content = document.getElementById("contentField").value;
            var price = document.getElementById("priceField").value;

            // Update the service data in the corresponding row
            var serviceRow = document.querySelector('tr[data-service-id="' + selectedService + '"]');
            serviceRow.querySelector('.editable[data-field="heading"]').textContent = heading;
            serviceRow.querySelector('.editable[data-field="content"]').textContent = content;
            serviceRow.querySelector('.editable[data-field="price"]').textContent = price;

            // Close the modal
            closeEditModal();
        }
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
