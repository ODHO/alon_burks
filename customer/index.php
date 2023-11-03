<?php
session_start();

?>
<!DOCTYPE html>
<html lang="zxx">

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

<body>
  

<?php
include 'header.php'
?>
<!-- banner -->
<section id="main-banner" class="banner bg-cover position-relative d-flex justify-content-center align-items-center"
  data-background="images/banner/banner.png">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 style="color: #70BE44; padding-top: 120px;">Quality That is Guatanteed</h3>
        <h1 style="color: white;">To plant a garden is to believe in tomorrow.</h1>
      </div>
    </div>
    <div class="row" style="padding-top: 30px;">
      <div class="wrap">
        <div class="search">
           <input  type="text" class="searchTerm" placeholder="Write Service what you need?" ><i class="fa fa-search" aria-hidden="true"></i>
           <button type="submit" class="searchButton">
             Find Your Best Gardener
          </button>
        </div>
     </div>
    </div>
    <div class="row" style="padding-top: 30px;">
      <h4 style="padding-bottom: 20px;">Frequently Searched Services</h4>
      <ul class="main-banner-buttons" style="width: 100%;">
        <li><a href="#">Lawn mowing</a></li>
        <li><a href="#">Spring Clean Up</a></li>
        <li><a href="#">Aeration</a></li>
      </ul>
    </div>
  </div>
</section>
<!-- /banner -->

<!-- service -->
<section id="services" class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <h2 class="section-title">Popular services</h2>
        <p class="lead">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to 
          demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
      </div>
    </div>
    <div class="row">
    <?php
         // Include your database connection script
        include 'connection.php';

        // Retrieve services from the database
        $sql = "SELECT * FROM categories LIMIT 6";
        $result = $conn->query($sql);
         if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image = $row['image'];
                $heading = $row['heading'];
                $content = $row['content'];
                $price = $row['price'];
                ?>
                <div class="col-lg-3 mb-3 mb-lg-0">
                  <a href="services.php">
                    <div class="services-inner-box" style="text-align: center;">
                        <img style="object-fit: cover; width: 40%;" src="../admin/uploads/<?php echo $image; ?>">
                        <h3><?php echo $heading; ?></h3>
                        <h4>Avg. Project: $<?php echo $price; ?></h4>
                        <!-- <a href='#'><button>Explore More</button></a> -->
                    </div>
                    </a>
                </div>
                <?php
            }
        } else {
            echo "No services found.";
        }
        ?>
      <!-- <div class="col-lg-3 mb-3 mb-lg-0">
       <div class="services-inner-box" style="text-align: center;">
        <img src="./images/services/serv1.png" width="100%"/>
        <h3>Lawn mowing</h3>
        <h4>Avg. Project: $54 – $124</h4>
       </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="services-inner-box" style="text-align: center;">
          <img src="./images/services/serv2.png" width="100%"/>
          <h3>Spring Clean Up</h3>
          <h4>Avg. Project: $54 – $124</h4>
         </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="services-inner-box" style="text-align: center;">
          <img src="./images/services/serv3.png" width="100%"/>
          <h3>Seeding / Aeration</h3>
          <h4>Avg. Project: $54 – $124</h4>
         </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="services-inner-box" style="text-align: center;">
          <img src="./images/services/serv4.png" width="100%"/>
          <h3>Grass Cutting</h3>
          <h4>Avg. Project: $54 – $124</h4>
         </div>
      </div> -->
    </div>

    <!-- SECOND ROW START -->
    <!-- <div class="row" style="padding-top: 20px;">
      <div class="col-lg-3 mb-3 mb-lg-0">
       <div class="services-inner-box" style="text-align: center;">
        <img src="./images/services/serv1.png" width="100%"/>
        <h3>Lawn mowing</h3>
        <h4>Avg. Project: $54 – $124</h4>
       </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="services-inner-box" style="text-align: center;">
          <img src="./images/services/serv2.png" width="100%"/>
          <h3>Spring Clean Up</h3>
          <h4>Avg. Project: $54 – $124</h4>
         </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="services-inner-box" style="text-align: center;">
          <img src="./images/services/serv3.png" width="100%"/>
          <h3>Seeding / Aeration</h3>
          <h4>Avg. Project: $54 – $124</h4>
         </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <div class="services-inner-box" style="text-align: center;">
          <img src="./images/services/serv4.png" width="100%"/>
          <h3>Grass Cutting</h3>
          <h4>Avg. Project: $54 – $124</h4>
         </div>
      </div>
    </div> -->
    <!-- SECOND ROW END -->
  </div>
</section>
<!-- /service -->

<!-- FEATURED PROVIDER SECTION START -->
<section id="feature-provider" style="padding: 60px 0px;">
<div class="container">
<div class="row">
  <div class="heading-text" style="padding-bottom: 30px;">
    <h1>Featured Provider</h1>
    <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
      demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
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

// Retrieve services from the database for featured providers
$sql = "SELECT * FROM provider_registration WHERE role_id = 2 AND status = 'feature' LIMIT 3";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullname = $row['fullname'];
        $country = $row['country'];
        $city = $row['city'];
        $profile_picture = $row['profile_picture'];
        $provider_id = $row['id']; // Added to get the provider ID

        // Get the additional content for this provider
        $additionalContent = getProviderAdditionalContent($conn, $provider_id);

        // Wrap the provider card with a link to provider.php
        echo '<div class="col-lg-4 mb-4 mb-lg-0">';
        echo '<a href="provider.php?id=' . $provider_id . '">';
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
        echo '<li class="prc2"><b>4.0</b> <span>(10) </span><img src="./images/featured-provider/star.png"/></li>';
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
    echo "No featured services found.";
}
?>



</div>
</div>
</section>
<!-- FEATURED PROVIDER SECTION END -->

<!-- LAWN MOVING SECTION START -->
<section id="lawnmoving">
  <div class="row">
    <div class="col-lg-6 mb-6 mb-lg-0">
      <div class="lawnmov-info">
        <h3>Lawn Mowing</h3>
        <h2>Made your life easy</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
           Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type
             specimen book. It has survived not only five centuries, but also the leap into 
             electronic typesetting, remaining essentially unchanged.orem Ipsum is simply 
             dummy text of the printing and</p>
             <ul>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> First Class quality service at affordable prices</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> immediate 24/7 Emergency service</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> First Class quality service at affordable prices</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> immediate 24/7 Emergency service</li>
             </ul>
      </div>
    </div>
    <div class="col-lg-6 mb-6 mb-lg-0">
      <img src="./images/lawnmoving/lawnmoving.png" width="100%"/>
    </div>

  </div>
</section>
<!-- LAWN MOVING SECTION END -->


<!-- commercial services start -->
<section id="commercial-sec" style="padding: 60px 0px;">
  <div class="container">
    <div class="row">
      <h2>top Commercial Services</h2>
      <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to 
        demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
        <?php
                  // Include your database connection script
                  include 'connection.php';

                  // Retrieve services from the database
                  $sql = "SELECT * FROM categories LIMIT 8";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          $service_id = $row['id'];
                          $service_name = $row['heading'];
                          echo '<div class="col-md-3">';
                          // <input type="checkbox" id="commercialService1" name="commercial_service[]" value="Gardening">

                          // echo '<input type="checkbox" id="commercialService' . $service_id . '" name="commercial_service[]" value="' . $service_name . '">';
                          echo '<button for="commercialService' . $service_id . '"> ' . $service_name . '</button><br>';
                          echo '</div>';
                      }
                  }
                  ?>
        <!-- <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Lawn mowing</button></a>
        </div>
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Seeding</button></a>
        </div>
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Gardening</button></a>
        </div>
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Spring Clean Up</button></a>
        </div> -->
    </div>

    <!-- <div class="row" style="padding-top: 20px;">
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Lawn mowing</button></a>
        </div>
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Seeding</button></a>
        </div>
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Gardening</button></a>
        </div>
        <div class="col-lg-3 mb-3 mb-lg-0">
          <a href='#'><button>Spring Clean Up</button></a>
        </div>
    </div> -->
  </div>
</section>
<!-- commercial services end -->


<!-- LAWN MOVING SECTION START -->
<section id="lawnmoving">
  <div class="row">
    <div class="col-lg-6 mb-6 mb-lg-0">
      <img src="./images/lawnmoving/lawnmoving.png" width="100%"/>
    </div>
    <div class="col-lg-6 mb-6 mb-lg-0">
      <div class="lawnmov-info" style="padding-left: 70px;">
        <h3>Lawn Mowing</h3>
        <h2>Made your life easy</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
           Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type
             specimen book. It has survived not only five centuries, but also the leap into 
             electronic typesetting, remaining essentially unchanged.orem Ipsum is simply 
             dummy text of the printing and</p>
             <ul>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> First Class quality service at affordable prices</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> immediate 24/7 Emergency service</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> First Class quality service at affordable prices</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> immediate 24/7 Emergency service</li>
             </ul>
      </div>
    </div>
    

  </div>
</section>
<!-- LAWN MOVING SECTION END -->

<!-- MAINTENANCE SECTION START -->
<section id="maintenancesec" style="background-image: url(./images/maintenance/maintenancebanner.png);">
<div class="container">
  <div class="row" style="padding: 70px 0px; text-align: center;">
    <h2>Four Seasons<b> Maintenance</b></h2>
    <p style="padding: 40px 0px;">local Business, in Maryland residential and commercial services you can try our services
      for one time then if your satisfied, we can make arrangements for small contracts weekly
       or monthly service at your convenience withoutany compromise.</p>
       <a href='#'><button>Contact Us</button></a>
  </div>
</div>
</section>
<!-- MAINTENANCE SECTION END -->

<!-- footer start -->
<footer id="footer-section">
<div class="container">
  <div class="footer-widgets">
    <div class="row" style="padding: 60px 0px 30px 0px;">
      <div class="col-lg-3 mb-3 mb-lg-0">
        <img class="footerlogo" src="./images/footerlogo.png" width="100%"/>
        <div class="social-links">
          <ul>
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Company</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Commericals</a></li>
            <li><a href="#">Exclusive</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">residential individuals</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Contact</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">Help/FAQs</a></li>
            <li><a href="#">Press</a></li>
            <li><a href="#">Affilates</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 mb-3 mb-lg-0">
        <h4>Services</h4>
        <div class="nav-links-footer">
          <ul>
            <li><a href="#">Lawn Mowing</a></li>
            <li><a href="#">Grass cutting</a></li>
            <li><a href="#">Spring Clean up</a></li>
            <li><a href="#">Lawn Maintenance</a></li>
            <li><a href="#">Seeding/ Aeration</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<hr>
<div class="footer-copyright">
  <div class="container">
<p>Copyright are Reserved@Apexcreativedesign.com</p>
  </div>
</div>
</footer>

<!-- Loading indicator -->
<div id="loading">Loading...</div>

<!-- Table to display data -->
<!-- <table id="employees">
</table>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      // API URL
      const api_url =
          "https://script.google.com/macros/s/AKfycbyDqgi-IBEMQ0eqdMe4TdD8ZsCodSBF8L0nNy0uUF_PhYn57EdXB4LnGjAnQun2gNu6_A/exec";

      // Defining async function to fetch API data
      async function getapi(url) {
          // Storing response
          const response = await fetch(url);

          // Storing data in JSON format
          const data = await response.json();
          console.log(data);

          if (response.ok) {
              hideloader();
              show(data.data); // Assuming "data" is the key for your data
          }
      }

      // Calling the async function to fetch data
      getapi(api_url);

      // Function to hide the loader
      function hideloader() {
          document.getElementById('loading').style.display = 'none';
      }

      // Function to define innerHTML for HTML table
      function show(data) {
          let tab =
              `<tr>
              <th>Schedule Date</th>
              <th>Movoji</th>
              <th>Answer</th>
              <th>Poopy Tuesday</th>
              </tr>`;

          // Loop to access all rows in the data
          data.forEach(r => {
              tab += `<tr>
              <td>${r.SCHEDULEDATE}</td>
              <td>${r.MOVOJI}</td>
              <td>${r.ANSWER}</td>
              <td>${r.POOPYTUESDAY}</td>
              </tr>`;
          });

          // Setting innerHTML for the table
          document.getElementById("employees").innerHTML = tab;
      }
  });
</script> -->
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
