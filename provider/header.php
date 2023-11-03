<?php
// session_start();
include '../connection.php';
?>

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="dashboard.php">
        <img src="images/sitelogo-singup.png" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="dashboard.php">
        <img src="images/sitelogo-singup.png" alt="logo" />
      </a>
    </div>
  </div>
  <?php
                if (isset($_SESSION['user_id'])) {
                ?>
  <div style="padding: 20px 20px;" class="navbar-menu-wrapper d-flex align-items-top">
  <?php
                    if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'provider') {
                        $userId = $_SESSION['user_id'];
                        $userDataQuery = "SELECT fullname, city, profile_picture, address, country FROM provider_registration WHERE id = $userId";
                        $result = $conn->query($userDataQuery);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $ProviderName = $row['fullname'];
                            $_SESSION['providerName'] = $row['fullname'];
                            $city = $row['city'];
                            $address = $row['address'];
                            $_SESSION['address'] = $row['address'];
                            $country = $row['country'];
                            $profileImage = $row['profile_picture'];
                            // $user_id = $_SESSION['id'];
                            ?>  
  <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h4 style="color: #70BE44;margin: 0px !important;">Hey!</h4>
        <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">
            <?php echo $ProviderName; ?>
          </span></h1>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <a href="dashboard.php"><img class="hmesec" src="./images/home.PNG" /></a>
      </li>
      
      <li><a class="location-buton" href="#"><button><i class="menu-icon mdi mdi-map-marker"></i>
            
           
            <!-- <?php echo $address; ?>, -->
            <?php echo $country; ?>,
            <?php echo $city; ?>
          </button></a></li>
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0 p-2">
        <a href="notification.php"><i style="
    font-size: 30px;
    color: #57a13c;
" class="menu-icon mdi mdi-bell-ring"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <div class="text-profile">
          <div class="profiletext-imagesec">
            <span style="color: #232323;font-size: 18px;">
              <?php echo $ProviderName; ?>
            </span>
            <span style="color: #227A4E;font-size: 16px;">
              <?php echo $userId; ?>
            </span>
            
          </div>

          <div class="dropdown">
            <!-- profile image -->
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="./<?php echo $profileImage; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded-circle" src="./<?php echo $profileImage; ?>"
                alt="Profile image">
            </a>
            <!-- profile image end -->
            <ul class="dropdown-menu dropdown-menu-right" style="position: absolute;left: -43px;"
              aria-labelledby="UserDropdown">
              <li><a class="dropdown-item" href="profilesetting.php">Profile</a></li>
              <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </li>
    </ul>

    <?php
                        } else {
                            echo "User Not Found";
                        }
                    }
                ?>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
  <?php
                } else {
                ?>
            <?php
              }
            ?>
</nav>
<script>
  function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
      // User confirmed, perform logout and redirect
      window.location.href = "logout.php";
    }
  }
</script>