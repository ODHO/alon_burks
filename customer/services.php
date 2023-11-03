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

<body class="services-page">
  

<?php include 'header.php'; ?>

<!-- banner -->
<section id="main-banner" class="banner bg-cover position-relative d-flex justify-content-center align-items-center"
  data-background="images/banner/banner.png" style="text-align: center;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 style="color: #FFF; padding-top: 120px;">Quality That is Guatanteed</h3>
        <h1 style="color: white;">Lawn Mowing</h1>
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
 
  </div>
</section>
<!-- /banner -->

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
        echo '<div style="width:100%;">';
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



  
    

<!-- 
  <div class="col-lg-4 mb-4 mb-lg-0">
    <div class="provider-card">
      <img src="./images/featured-provider/feature.png" width="100%"/>
      <div class="feature-info-box">
        <ul class="featurelist" style="padding: 0px; margin: 0px;">
          <li><h2>John Doe</h2></li>
          <li class="prc"><i class="fa fa-comment" aria-hidden="true"></i> Contact for pricing</li>
        </ul>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting 
          industry. Lorem Ipsum has been the industry's standard dummy text 
          ever since the 1500s</p>
          <ul class="featurelist-2">
            <li><i class="fa fa-user" aria-hidden="true"></i> Worker</li>
            <li class="prc2"><b>4.0</b> <span>(10) </span><img src="./images/featured-provider/star.png"/></li>
          </ul>
          <ul class="featurelist-3">
            <li><i class="fa fa-trophy" aria-hidden="true"></i>Hired 11 Times</li>
            <li class="prc3"><i class="fa fa-location-arrow" aria-hidden="true"></i> Houston, Texas</li>
          </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-4 mb-4 mb-lg-0">
    <div class="provider-card">
      <img src="./images/featured-provider/feature.png" width="100%"/>
      <div class="feature-info-box">
        <ul class="featurelist" style="padding: 0px; margin: 0px;">
          <li><h2>John Doe</h2></li>
          <li class="prc"><i class="fa fa-comment" aria-hidden="true"></i> Contact for pricing</li>
        </ul>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting 
          industry. Lorem Ipsum has been the industry's standard dummy text 
          ever since the 1500s</p>
          <ul class="featurelist-2">
            <li><i class="fa fa-user" aria-hidden="true"></i> Worker</li>
            <li class="prc2"><b>4.0</b> <span>(10) </span><img src="./images/featured-provider/star.png"/></li>
          </ul>
          <ul class="featurelist-3">
            <li><i class="fa fa-trophy" aria-hidden="true"></i>Hired 11 Times</li>
            <li class="prc3"><i class="fa fa-location-arrow" aria-hidden="true"></i> Houston, Texas</li>
          </ul>
      </div>
    </div>
  </div> -->

</div>
</div>
</section>
<!-- FEATURED PROVIDER SECTION END -->


<!-- ALL LAWN MOWERS PROVIDER SECTION START -->
<section id="feature-provider" style="padding: 60px 0px;">
  <div class="container">
  <div class="row">
    <div class="heading-text" style="padding-bottom: 30px;">
      <h1>All lawn mowers</h1>
      <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
        demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
    </div>
    
  <?php

  // Retrieve services from the database
$sql = "SELECT * FROM provider_registration WHERE role_id = 2 ";
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

  <!-- FIRST ROW END -->

  
  </div>
  </section>
  <!-- FEATURED PROVIDER SECTION END -->

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
