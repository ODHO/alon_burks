<?php
include 'connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['set_featured'])) {
    $provider_id = $_POST['provider_id'];
    $status = 'feature'; // Set the status to 'feature' as required

    // Update the status for the specific provider
    $sql = "UPDATE provider_registration SET status = '$status' WHERE id = $provider_id";

    if ($conn->query($sql) === TRUE) {
        $error_message = "Provider set as featured successfully.";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
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
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Aaron Burks </title>
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
  <link rel="stylesheet" href="../assets/css/style.css">
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
        <section id="feature-provider">
          <div class="container">
            <div class="row">
              <div class="heading-text" style="padding-bottom: 30px;">
                <h1>Providers</h1>
              </div>
              <?php
// Include your database connection script
include 'connection.php';

// Function to get additional content by provider ID
function getProviderAdditionalContent($conn, $provider_id)
{
    // Sanitize the input to prevent SQL injection
    $provider_id = mysqli_real_escape_string($conn, $provider_id);

    // Retrieve additional content for the provider from the 'provider_services' table
    $sql = "SELECT additional_content FROM provider_services WHERE provider_id = '$provider_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['additional_content'];
    }

    return null;
}

// Retrieve services from the database
$sql = "SELECT * FROM provider_registration where role_id = 2 Limit 3";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullname = $row['fullname'];
        $country = $row['country'];
        $city = $row['city'];
        $profile_picture = $row['profile_picture'];
        $email = $row['email'];
        $provider_id = $row['id']; // Added to get the provider ID

        // Get the additional content for this provider
        $additionalContent = getProviderAdditionalContent($conn, $provider_id);

        // Wrap the provider card with a link to provider.php
        echo '<div class="col-lg-4 mb-4 mb-lg-0">';
        echo '<a href="#" onclick="showProviderDetails(this)" data-fullname="' . $fullname . '" data-email="' . $email . '" data-country="' . $country . '" data-city="' . $city . '" data-profile-picture="../provider/' . $profile_picture . '" data-description="' . $additionalContent . '" data-provider-id="' . $provider_id . '">';
        echo '<div class="provider-card">';
        echo '<div style="width:100%; height:200px;">';
        echo '<img style="object-fit:contain; width:100%; height:100%" src="../provider/' . $profile_picture . '" width="100%"/>';
        echo '</div>';
        echo '<div class="feature-info-box">';
        echo '<div style="display:flex; justify-content:space-between; align-items:center">';
        echo '<h4>' . $fullname . '</h4>';
        echo '<h6 style="color:#7A7A7A"><i class="fa fa-comment" aria-hidden="true" style="color:#70be44"></i> Contact for pricing</h6>';
        echo '</div>';
        echo '<p>' . $additionalContent . '</p>'; // Display additional content here
        echo '<ul class="featurelist-2">';
        echo '<li><i class="fa fa-user" aria-hidden="true"></i> Worker</li>';
        echo '<li class="prc2"><b>4.0</b> <span>(10) </span><img src="../assets/images/featured-provider/star.png"/></li>';
        echo '</ul>';
        echo '<ul class="featurelist-3">';
        echo '<li><i class="fa fa-trophy" aria-hidden="true"></i>Hired 11 Times</li>';
        echo '<li class="prc3"><i class="fa fa-location-arrow" aria-hidden="true"></i> ' . $city . '</li>';
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "No services found.";
}
?>
            </div>
          </div>
          </section>


          <!-- Custom Edit Modal -->
          <!-- Provider Details Modal -->
            <div class="modal" id="providerDetailsModal" tabindex="-1" aria-labelledby="providerDetailsModalLabel"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="providerDetailsModalLabel">Provider Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="height:300px; overflow-x: hidden;">
                    <div class="row">
                      <div class="col-md-12 text-center">
                        <img id="providerImage" src="" alt="Provider Image" class="img-fluid">
                      </div>
                      <div class="col-md-12">
                        <h4>Name:</h4>
                        <p id="providerName"></p>
                        <h4>Location: </h4>
                        <p id="providerLocation"></p>
                        <h4>Email: </h4>
                        <p id="providerEmail"></p>
                        <h4>Description: </h4>
                        <p id="providerDescription"></p>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center pt-4 text-center gap-5">
                  <form method="POST" action="">
        <input type="hidden" name="provider_id" id="providerIdInput" value="featured">
        <button type="submit" class="btn w-auto" name="set_featured">Add To Feature</button>
      </form>

        <button type="button" class="btn w-auto" data-dismiss="modal">Close</button>
      </div>
                </div>
              </div>
            </div>

      </div>
    </div>
  </div>

  
  <script>
  function showProviderDetails(card) {
    var fullname = card.getAttribute('data-fullname');
    var country = card.getAttribute('data-country');
    var city = card.getAttribute('data-city');
    var profilePicture = card.getAttribute('data-profile-picture');
    var description = card.getAttribute('data-description');
    var email = card.getAttribute('data-email');
    var providerId = card.getAttribute('data-provider-id'); // Assuming you have this data

    // Populate modal with provider details
    document.getElementById('providerImage').src = profilePicture;
    document.getElementById('providerName').textContent = fullname;
    document.getElementById('providerLocation').textContent = 'Location: ' + country + ', ' + city;
    document.getElementById('providerDescription').textContent = description;
    document.getElementById('providerEmail').textContent = email;

    // Set the provider_id in the hidden input field
    document.getElementById('providerIdInput').value = providerId;

    // Show the modal
    $('#providerDetailsModal').modal('show');
}


</script>



  <!-- Include Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
    integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+k/e7Jnw2+rpsQ/g5F5n5Xg5fw"
    crossorigin="anonymous"></script>
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
    $(document).ready(function () {


      var readURL = function (input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('.profile-pic').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
      }


      $(".file-upload").on('change', function () {
        readURL(this);
      });

      $(".upload-button").on('click', function () {
        $(".file-upload").click();
      });
    });
  </script>
  <script>
    $(document).ready(function () {
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
      $.getJSON(url, function (data) {
        console.log(data);
        $.each(data, function (index, value) {
          // APPEND OR INSERT DATA TO SELECT ELEMENT.
          $("#country").append(
            '<option value="' + value.code + '">' + value.name + "</option>"
          );
        });
      });
      // Country selected --> update region list .
      $("#country").change(function () {
        selectedCountry = this.options[this.selectedIndex].text;
        countryCode = $("#country").val();
        // Populate country select box from battuta API
        url =
          "https://battuta.medunes.net/api/region/" +
          countryCode +
          "/all/?key=" +
          BATTUTA_KEY +
          "&callback=?";
        $.getJSON(url, function (data) {
          $("#region option").remove();
          $('#region').append('<option value="">Please select your region</option>');
          $.each(data, function (index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $("#region").append(
              '<option value="' + value.region + '">' + value.region + "</option>"
            );
          });
        });
      });
      // Region selected --> updated city list
      $("#region").on("change", function () {
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
        $.getJSON(url, function (data) {
          console.log(data);
          $("#city option").remove();
          $('#city').append('<option value="">Please select your city</option>');
          $.each(data, function (index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $("#city").append(
              '<option value="' + value.city + '">' + value.city + "</option>"
            );
          });
        });
      });
      // city selected --> update location string
      $("#city").on("change", function () {
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