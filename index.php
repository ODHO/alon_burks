<?php
include 'connection.php'

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
  <link rel="stylesheet" href="assets/plugins/bootstrap/bootstrap.min.css">
  <!-- slick slider -->
  <link rel="stylesheet" href="assets/plugins/slick/slick.css">
  <!-- themefy-icon -->
  <link rel="stylesheet" href="assets/plugins/themify-icons/themify-icons.css">
  <!-- venobox css -->
  <link rel="stylesheet" href="assets/plugins/venobox/venobox.css">
  <!-- card slider -->
  <link rel="stylesheet" href="assets/plugins/card-slider/css/style.css">

  <!-- Main Stylesheet -->
  <link href="assets/css/style.css" rel="stylesheet">
  <!-- Font Family -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

</head>

<body>
  

<?php 
include 'header.php';
?>

<!-- banner -->
<section id="main-banner" class="banner bg-cover position-relative d-flex justify-content-center align-items-center"
  data-background="assets/images/banner/banner4.png">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h3 style="color: #70BE44; padding-top: 120px;">Quality That is Guatanteed</h3>
        <h1 style="color: white;">To plant a garden is to believe in tomorrow.</h1>
        <p class="banner4text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been 
          the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of 
          type and scrambled it to make a type specimen book. It has survived not only five centuries, but 
          also the leap into electronic typesetting, remaining essentially unchanged.</p>
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


<!-- LAWN MOVING SECTION START -->
<section id="lawnmoving2">
  <div class="row align-items-center">
    <div class="col-lg-6 mb-6 mb-lg-0">
      <img src="assets/images/lawnmoving/lawnmoving2.png" width="100%"/>
    </div>

    <div class="col-lg-6 mb-6 mb-lg-0">
      <div class="lawnmov-info2">
        <h3>About Us</h3>
        <h2>Everyday life made easier</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been 
          the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley 
          of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
          but also the leap into electronic typesetting, remaining essentially unchanged.orem Ipsum is 
          simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's 
          standard dummy text ever since the 1500s, when an unknown printer took a galley of type and 
          scrambled it to make a type specimen book. It has survived not only five centuries, but also 
          the leap into electronic typesetting, remaining essentially unchanged.</p>
             <ul>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> First Class quality service at affordable prices</li>
              <li><i class="fa fa-long-arrow-right" aria-hidden="true"></i> immediate 24/7 Emergency service</li>
             </ul>
             <div class="readbtn">
              <a href='#'><button>Read More</button></a>
             </div>

      </div>
    </div>
  </div>
</section>
<!-- LAWN MOVING SECTION END -->


<!-- service -->
<section id="offer">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <h2>What we offer</h2>
        <h3>Services you can avail</h3>
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
                ?>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="offer-inner-box" style="text-align: center;">
                        <img style="object-fit: cover; width: 40%;" src="./admin/uploads/<?php echo $image; ?>">
                        <h4><?php echo $heading; ?></h4>
                        <p><?php echo $content; ?></p>
                        <a href='#'><button>Explore More</button></a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No services found.";
        }
        ?>
    </div>
        

   
    <!-- SECOND ROW END -->
    <!-- third ROW start -->
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="offerbtn">
          <a href='#'><button>View All</button></a>
        </div>
      </div>
    </div>
    

    <!-- third ROW start -->
  </div>
</section>
<!-- /service -->

<!-- FEATURED PROVIDER SECTION START -->
<section id="feature-provider" class="provider-sec" style="background-image: url(assets/images/offer/probg.png);">
<div class="container">
<div class="row">
  <div class="col-lg-12 mx-auto">
    <div class="heading-text" style="padding-bottom: 30px;">
      <h3>Top service Provider</h3>
      <h1>Top Provider</h1>
    </div>
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
$sql = "SELECT * FROM provider_registration WHERE role_id = 2 LIMIT 3";
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
        echo '<a href="./provider/registeration.php">';
        echo '<div class="provider-card">';
        echo '<div style="width:100%; height:200px;">';
        echo '<img style="object-fit:contain; width:100%; height:100%" src="./provider/' . $profile_picture . '" width="100%"/>';
        echo '</div>';
        echo '<div class="feature-info-box">';
        echo '<div style="display:flex; justify-content:space-between; align-items:center">';
        echo '<h4>' . $fullname . '</h4>';
        echo '<h6 style="color:#7A7A7A"><i class="fa fa-comment" aria-hidden="true" style="color:#70be44"></i> Contact for pricing</h6>';
        echo '</div>';
        echo '<p>' . $additionalContent . '</p>'; // Display additional content here
        echo '<ul class="featurelist-2">';
        echo '<li><i class="fa fa-user" aria-hidden="true"></i> Worker</li>';
        echo '<li class="prc2"><b>4.0</b> <span>(10) </span><img src="./assets/images/featured-provider/star.png"/></li>';
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
<!-- FEATURED PROVIDER SECTION END -->


<!-- MAINTENANCE SECTION START -->
<div class="maintain-sec" style="background-image: url(assets/images/maintenance/maintenancebanner.png);">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 mx-auto">
          <h2>Four Seasons <span>Maintenance</span></h2>
          <p>local Business, in Maryland residential and commercial services you can try our services 
            for one time then if your satisfied, we can make arrangements for small contracts weekly 
            or monthly service at your convenience withoutany compromise.
          </p>
          <div class="maintbtn">
            <a href='#'><button>Contact Us</button></a>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- MAINTENANCE SECTION END -->

<!-- become A provider START -->
<section class="bprovider-sec">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mb-6 mb-lg-0">
          <div class="proimg">
            <img src="assets/images/providerselected/sadads.png" width="100%"/>
          </div>
        </div>
        <div class="col-lg-6 mb-6 mb-lg-0">
          <h1>open to work</h1>
          <h2>become A provider</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been 
            the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley 
            of type and scrambled it to make a type specimen book. It has survived not only five centuries
          </p>
          <div class="provibtn">
            <a href='./provider/registeration.php'><button>Sign Up</button><img src="assets/images/providerselected/garden.png"/></a>
           </div>
        </div>
      </div>
    </div>
</section>
<!-- become A provider END -->

<!-- TESTIMONIAL SEC START -->
<section class="section" id="testmonials" style="background-color: #F5F5F5;">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-6 mb-lg-0">
        <div class="test-heading">
          <h1>Testimonials</h1>
          <h2>What people say</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industry's standard dummy text ever since the 
            1500s, when an unknown printer took a galley of type and scrambled it 
            to make a type specimen book. It has survived not only five centuries
          </p>
        </div>
      </div>
      <div class="col-lg-6 mb-6 mb-lg-0">
        <div class="slider">
          <div>
            <li class="swiper-slide">
              <div class="slider-head">
                <div class="testiheading">
                  <div class="cleint-img">
                    <img src="assets/images/testimonial/sliderimg.png" alt="">
                  </div>
                  <div class="cleint-name">
                    <h2>Mike Taylor</h2>
                    <p>houston, texas</p>
                  </div>
                </div>
              </div>
              <div class="cl-testi">
                <p>“On the Windows talking painted pasture yet its express parties use. 
                  Sure last upon he same as knew next. Of believed or diverted no.”
                </p>
              </div>
            </li>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIAL SEC END -->
<!-- footer start -->
<?php
include 'Footer.php'
?>

<!-- footer end -->

<!-- jQuery -->
<script src="assets/plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="assets/plugins/slick/slick.min.js"></script>
<!-- venobox -->
<script src="assets/plugins/venobox/venobox.min.js"></script>
<!-- shuffle -->
<script src="assets/plugins/shuffle/shuffle.min.js"></script>
<!-- apear js -->
<script src="assets/plugins/counto/apear.js"></script>
<!-- counter -->
<script src="assets/plugins/counto/counTo.js"></script>
<!-- card slider -->
<script src="assets/plugins/card-slider/js/card-slider-min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="assets/plugins/google-map/gmap.js"></script>
<script> src="assets/plugins/card-slider/js/slide.js"</script>

<!-- Main Script -->
<script src="assets/js/script.js"></script>

</body>
</html>
