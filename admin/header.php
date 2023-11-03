<?php
// Include your database connection script
include 'connection.php';
?>

<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
            <span class="icon-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="dashboard.html">
            <img src="images/sitelogo-singup.png" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="dashboard.html">
            <img src="images/sitelogo-singup.png" alt="logo" />
          </a>
        </div>
      </div>
      <div style="padding: 20px 20px;" class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h4 style="color: #70BE44; padding-top: 30px;">Hey!</h4>
            <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">Admin!</span></h1>
          </li>
        </ul>
        <!-- <ul class="navbar-nav ms-auto">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
           <a href="dashboard.html"><img class="hmesec" src="./images/home.PNG"/></a>
          </li>
          <li><a class="location-buton" href="#"><button><i class="menu-icon mdi mdi-map-marker"></i> Texas, USA Street 2416 A-216</button></a></li>
        </ul> -->
        <!-- <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <div class="text-profile">
                    <div class="profiletext-imagesec">
                    <h2>Dwayne Johnson</h2>
                    <p>ID#214</p>
                </div>
                    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="Profile image"> </a>
                </div>
                    </li>
        </ul> -->
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>