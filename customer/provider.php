<?php
include 'connection.php';
session_start();
// Initialize $servicesArray
$servicesArray = array();

function getProviderServices($conn, $provider_id)
{
    // Sanitize the input to prevent SQL injection
    $provider_id = mysqli_real_escape_string($conn, $provider_id);

    // Retrieve provider services from the database using the provider ID
    $sql = "SELECT * FROM provider_services WHERE provider_id = '$provider_id'";
    $result = $conn->query($sql);

    $services = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }

    return $services;
}

$provider_id = ""; // You need to get the provider ID from somewhere (e.g., query parameter)


function getProviderWorkingImages($conn, $provider_id) {
    $provider_id = mysqli_real_escape_string($conn, $provider_id);
    $sql = "SELECT pi.image_path FROM provider_images AS pi
            JOIN provider_services AS ps ON pi.provider_services_id = ps.id
            WHERE ps.provider_id = '$provider_id'";
    $result = $conn->query($sql);
    $images = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['image_path'];
        }
    }
    return $images;
}
// Function to get provider details by ID
function getProviderDetails($conn, $provider_id)
{
    // Sanitize the input to prevent SQL injection
    $provider_id = mysqli_real_escape_string($conn, $provider_id);

    // Retrieve provider details from the database using the ID
    $sql = "SELECT * FROM provider_registration WHERE id = '$provider_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

$provider_name = "";
$country = "";
$city = "";
$providerAddress = "";
$profile_picture = "";
$working_timings_from = "";
$additional_content = "";
$workingImages = array();
$customerFullName = $_SESSION['customerFullName'];

if (isset($_GET['id'])) {
    $provider_id = $_GET['id'];
    $providerServices = getProviderServices($conn, $provider_id);

    foreach ($providerServices as $service) {
        $working_timings_from = $service['working_timings_from'];
        $working_timings_to = $service['working_timings_to'];
        $shop_working_day_to = $service['shop_working_day_to'];
        $additional_content = $service['additional_content'];

        $individualServices = explode(',', $service['services']);
        $individualServices = array_map('trim', $individualServices);
        $servicesArray = array_merge($servicesArray, $individualServices);

        $commercial_services = $service['commercial_services'];
        $workingImages = getProviderWorkingImages($conn, $service['id']);
    }
}

if (isset($_GET['id'])) {
    $provider_id = $_GET['id'];
    $providerDetails = getProviderDetails($conn, $provider_id);

    if ($providerDetails) {
        $provider_name = $providerDetails['fullname'];
        $country = $providerDetails['country'];
        $city = $providerDetails['city'];
        $providerAddress = $providerDetails['address'];
        $profile_picture = $providerDetails['profile_picture'];
        $workingImages = getProviderWorkingImages($conn, $provider_id);
    }
}
function getServicePricesAndImages($conn, $servicesArray)
{
    $data = array();

    foreach ($servicesArray as $individualService) {
        $serviceName = mysqli_real_escape_string($conn, $individualService);

        $sql = "SELECT id, price, image FROM categories WHERE heading = '$serviceName'";
        $result = $conn->query($sql);

        if (!$result) {
            die("SQL Error: " . mysqli_error($conn));
        }

        $row = $result->fetch_assoc();
        $price = $row['price'];
        $imagePath = $row['image'];
        $Serviceid = $row['id'];

        // If the price is 'N/A', set a default value
        if ($price === 'N/A') {
            $price = 'Price not available';
        }

        // Store the price and image path in the data array
        $data[$individualService] = [
            'price' => $price,
            'image' => $imagePath,
            'id' => $Serviceid,
        ];
    }

    return $data;
}

$serviceData = getServicePricesAndImages($conn, $servicesArray);

// Function to get the service IDs for the given services
function getServiceIds($conn, $servicesArray)
{
    $serviceIds = array();

    foreach ($servicesArray as $individualService) {
        $serviceName = mysqli_real_escape_string($conn, $individualService);

        $sql = "SELECT id FROM categories WHERE heading = '$serviceName'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $serviceIds[$individualService] = $row['id'];
        }
    }

    return $serviceIds;
}

$serviceIds = getServiceIds($conn, $servicesArray);

// The code related to inserting data into the database has been commented out.
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
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet">
  <!--Favicon-->
  <!-- FONT AWESOME -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

<body class="services-page">


  <?php include('header.php'); ?>

  <!-- banner -->
  <section id="main-banner" class="banner bg-cover position-relative d-flex justify-content-center align-items-center"
    data-background="images/banner/banner.png" style="text-align: center;     min-height: 50vh;">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 style="color: #FFF; padding-top: 120px;">Provider</h2>
          <h5 style="color: white;">Here are your daily updates Notifications</h5>
        </div>
      </div>


    </div>
  </section>
  <!-- /banner -->

  <!-- PROVIDER SEC START -->
  <section id="provider-booking-payment">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card px-0 pt-4 pb-0 mt-3 mb-3">

            <form method="post" action="" id="msform" enctype="multipart/form-data">
              <!-- progressbar -->
              <ul id="progressbar">
                <li class="active" id="account"><strong>Provider Selected</strong></li>
                <li id="personal"><strong>Set Booking</strong></li>
                <li id="payment"><strong>Your Offer</strong></li>
              </ul>
              <br>

              <!-- fieldsets -->

              <fieldset class="my-first-field">
                <!-- ROW PROVIDER selected START -->
                <div class="provider-selected-main">

                  <div class="row provider-gradedetails">
                    <div class="col-lg-3 col-sm-12 align-self-center">
                      <div class="provider-name">
                        <img src="../provider/<?php echo $profile_picture ?>" />
                        <h4>
                          <?php echo $provider_name; ?>
                        </h4>
                      </div>
                    </div>
                    <div class="col-lg-5 col-sm-12 align-self-center">
                      <ul class="grade" style="width: 100%;">
                        <li><i style="color: #FFC400;" class="fa fa-star" aria-hidden="true"></i> 4.9</li>
                        <li>100%</li>
                        <li>Job Success</li>
                      </ul>
                    </div>
                    <div class="col-lg-1 col-sm-12 align-self-center">

                    </div>
                    <div class="col-lg-3 col-sm-12 align-self-center">
                      <h6 style="color: #70BE44;" class="price">$30/hr</h6>
                    </div>
                    <ul class="detaillist" style="width: 100%;">
                      <li><i style="color: #70BE44" class="fa fa-check" aria-hidden="true"></i> 50+ Completed task</li>
                      <li><i style="color: #70BE44" class="fa fa-map-marker" aria-hidden="true"></i>
                        <?php echo $providerAddress ?>
                      </li>
                      <li><i style="color: #70BE44;" class="fa fa-clock" aria-hidden="true"></i> Available hour
                        <?php echo $working_timings_from ?> -
                        <?php echo $working_timings_to ?>
                      </li>
                    </ul>
                    <div class="about-provider">
                      <h4 style="width: 100%;">About me</h4>
                      <p style="width: 100%;">
                        <?php echo $additional_content ?>
                      </p>
                      <h4 style="width: 100%;"><a href="#">Read More</a></h4>
                    </div>
                  </div>

                  <div class="row" style="padding: 40px 0px;">
                    <div class="col-lg-5 col-sm-12">
                      <div class="gallerinfo">
                        <h5>Work Done Gallery</h5>
                        <ul style="width: 100%;">
                          <?php
                          // $imageHtml = '';
                              foreach ($workingImages as $imagePath) {
                                  echo  "<li><a href='../provider/$imagePath'><img src='../provider/$imagePath' /></a></li>";
                              }
                          ?>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-7 col-sm-12">
                      <div class="speciality-info">
                        <h5>Specialities</h5>
                        <!-- <ul class="specialitylist" style="width: 100%;">
                                            <li><img src="./images/providerselected/Snow Plow.png"/> Removal</li>
                                            <li><img src="./images/providerselected/Grass.png"/> Grass Cutting</li>
                                            <li><img src="./images/providerselected/Cover Up.png"/> Spring Cleanup</li>
                                        </ul> -->
                        <!-- <div class="row"> -->
                        <ul style='width: 100%;'>
                          <div class="row">
                            <?php
                              foreach ($servicesArray as $individualService) {
                                  $serviceInfo = $serviceData[$individualService];
                                  $price = $serviceInfo['price'];
                                  $Serviceid = $serviceInfo['id'];
                                  $imagePath = $serviceInfo['image'];
                                  // $serviceId = isset($serviceIds[$individualService]) ? $serviceIds[$individualService] : 'N/A';
                                  echo "<div class='col-lg-6'><li><img src='../admin/uploads/$imagePath' /> $individualService</li></div>";
                              }
                            ?>
                          </div>
                        </ul>

                        <!-- </div> -->

                        <ul class="specialitylist" style="width: 100%;">

                          <!-- <li><img src="./images/providerselected/Grass.png" /> Grass Cutting</li> -->
                          <!-- <li><img src="./images/providerselected/Cover Up.png" /> Spring Cleanup</li> -->
                        </ul>
                      </div>
                    </div>

                  </div>

                  <div class="row" style="width: 100%;">
                    <div class="col-lg-6 col-sm-12">
                      <div class="recent-jobs-inner">
                        <div class="row">
                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent">
                              <h3><img src="./images/providerselected/recent1.png" /> Alexendar Leo</h3>
                            </div>
                          </div>

                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent-grades">
                              <ul>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="font-size: 14px;
                                                line-height: 19px; color: #BEBEBE;">Sep 4, 2021 </li>
                              </ul>
                            </div>
                          </div>

                        </div>

                        <p>Had an amazing experience and problem solver this men is...Thumbs up.</p>
                        <div class="services-provided">
                          <h6><em>SERVICE PROVIDED</em> <span>grass cutting , lawn mowing , snow cleanup.</span></h6>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                      <div class="recent-jobs-inner">
                        <div class="row">
                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent">
                              <h3><img src="./images/providerselected/recent1.png" /> Alexendar Leo</h3>
                            </div>
                          </div>

                          <div class="col-lg-6 col-sm-12">
                            <div class="data-recent-grades">
                              <ul>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="color: #FFC400;"><i class="fa fa-star" aria-hidden="true"></i></li>
                                <li style="font-size: 14px;
                                            line-height: 19px; color: #BEBEBE;">Sep 4, 2021 </li>
                              </ul>
                            </div>
                          </div>

                        </div>

                        <p>Had an amazing experience and problem solver this men is...Thumbs up.</p>
                        <div class="services-provided">
                          <h6><em>SERVICE PROVIDED</em> <span>grass cutting , lawn mowing , snow cleanup.</span></h6>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>
                <input type="button" name="next" class="next action-button" value="Book now" />
                <!-- ROW PROVIDER selected end -->

              </fieldset>

              <!-- PROVIDER END -->

              <!-- second FIELDSET START -->

              <fieldset>
                <div class="row booking-section" style="width: 100%;">
                  <h3 style="width: 100%;">Select Services & Set Your Booking</h3>
                  <div class="select-service-booking">
                    <h4>Select Services you need</h4>
                    <div class="row">
                    <?php
foreach ($servicesArray as $individualService) {
    $serviceInfo = $serviceData[$individualService];
    $serviceId = $serviceInfo['id'];
    // print_r($individualService);
    echo "<div class='col-lg-3 mb-3 mb-lg-0'>";
    echo "<label><input type='checkbox' name='selected_services[]' value='$individualService' data-service-id='$serviceId'>$individualService</label>";
    echo "</div>";
}
?>

                    </div>
                  </div>

                  <div class="upload-field-booking">
                    <h2>Upload Images of your Place</h2>
                    <label style="background-image: url(./images/providerselected/upload.PNG);">
                    <input type="file" class="form-control" id="images" name="images[]" onchange="preview_images();" multiple accept="image/*" />
                    </label>
                    <p style="text-align: left;">
                    Minimum 5 images of Of your service area , make sure image should beclear
                  </p>
                      <div class="row" id="image_preview"></div>
                  </div>

                  <div class="advancebook-bookingtab">
                    <div class="col-lg-9 mb-9 mb-lg-0">
                      <h2>Want Advance Booking for this Services</h2>
                    </div>
                    <div class="col-lg-3 mb-3 mb-lg-0">
                      <div class="toggle-button-cover">
                        <div class="button-cover">
                          <div class="button r" id="button-1">
                            <input type="checkbox" class="checkbox" id="toggle-switch" />
                            <div class="knobs"></div>
                            <div class="layer"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



                  <div id='main'>
                    <h3>Choose Your Time & Date</h3>
                    <input type="hidden" value="<?php echo $userId?>" id="customer-id" placeholder="Enter Customer ID">
                    <input type="hidden" value="<?php echo $provider_id?>" id="provider-id" placeholder="Enter Provider ID">
                    <div id='app'></div>
                  </div>
                  <div id="content-on" style="display: none;width:100%">
                    <div class="row advnce" style="padding: 60px 0px;">
                      <div class="advancebooking-calender">
                        <h2>Set Your Advance Booking</h2>
                        <div class="innerrow">
                          <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                            <h1> <img src="./images/calender.png" />29-June-2023 , MON</h1>
                          </div>
                          <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                            <h5>Hours Require <span>02</span></h5>
                            <ul class="time-advance">
                              <li>10 am -12 am</li>
                              <li>10 am -12 am</li>
                            </ul>
                            <ul class="time-advance1">
                              <li>10 am -12 am</li>
                              <li>10 am -12 am</li>
                            </ul>
                          </div>

                        </div>
                        <div class="innerrow" style="margin-top: 30px; background-color: #E7212121;">
                          <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                            <h1> <img src="./images/calender.png" />29-June-2023 , MON</h1>
                          </div>
                          <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                            <h5>Hours Require <span>02</span></h5>
                            <ul class="time-advance">
                              <li>10 am -12 am</li>
                              <li>10 am -12 am</li>
                            </ul>
                            <ul class="time-advance1">
                              <li>10 am -12 am</li>
                              <li>10 am -12 am</li>
                            </ul>
                          </div>

                        </div>

                        <div class="innerrow"
                          style="margin-top: 30px; background-color: #ffc4006e                                          ;">
                          <div class="col-lg-6 mb-6 mb-lg-0 align-items-center">
                            <h1> <img src="./images/calender.png" />29-June-2023 , MON</h1>
                          </div>
                          <div class="col-lg-6 mb-6 mb-lg-0" style="text-align:right;">
                            <h5>Hours Require <span>02</span></h5>
                            <ul class="time-advance">
                              <li>10 am -12 am</li>
                              <li>10 am -12 am</li>
                            </ul>
                            <ul class="time-advance1">
                              <li>10 am -12 am</li>
                              <li>10 am -12 am</li>
                            </ul>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="shortmessage">
                      <h4 style="text-align: center;">Describe your task</h4>
                      <textarea placeholder="Give your Note to the worker"></textarea>
                    </div>
                  </div>
                  <div id="content-off" style="display: block;width:100%">
                      <div class="booked-hours">
                        <h4>Already Booked hours</h4>
                        <div class="row">
                          <div class="col-lg-4 mb-4 mb-lg-0">
                            <button type="button" class="green">6PM -9 PM</button>
                          </div>
                          <div class="col-lg-4 mb-4 mb-lg-0">
                            <button type="button" class="orange">10 AM -12 PM</button>
                          </div>
                          <div class="col-lg-4 mb-4 mb-lg-0">
                            <button type="button" class="blue">2PM-4PM</button>

                          </div>
                        </div>
                      </div>
                      <div class="text-header">
                        <h4>Set Time</h4>
                      </div>
                      <div class="time-selection">
                        <div class="hours-slots">
                          <ul id="custom-timeslot">
                            <li>
                              <p>01</p>
                            </li>
                            <li>
                              <p oncha>02</p>
                            </li>
                            <li>
                              <p>03</p>
                            </li>
                            <li>
                              <p>04</p>
                            </li>
                            <li>
                              <p>05</p>
                            </li>
                            <li>
                              <p>06</p>
                            </li>
                            <li>
                              <p>07</p>
                            </li>
                            <li>
                              <p>08</p>
                            </li>
                            <li>
                              <p>09</p>
                            </li>
                            <li>
                              <p>10</p>
                            </li>
                            <li>
                              <p>11</p>
                            </li>
                            <li>
                              <p>12</p>
                            </li>
                          </ul>
                        </div>

                        <div class="ratio-time">:</div>
                        <div class="hours-slots">

                          <ul id="custom-timeslot1">
                            <li>
                              <p>00</p>
                            </li>
                            <li>
                              <p>01</p>
                            </li>
                            <li>
                              <p>02</p>
                            </li>
                            <li>
                              <p>03</p>
                            </li>
                            <li>
                              <p>04</p>
                            </li>
                            <li>
                              <p>05</p>
                            </li>
                            <li>
                              <p>06</p>
                            </li>
                            <li>
                              <p>07</p>
                            </li>
                            <li>
                              <p>08</p>
                            </li>
                            <li>
                              <p>09</p>
                            </li>
                            <li>
                              <p>10</p>
                            </li>
                            <li>
                              <p>11</p>
                            </li>
                            <li>
                              <p>12</p>
                            </li>
                            <li>
                              <p>13</p>
                            </li>
                            <li>
                              <p>14</p>
                            </li>
                            <li>
                              <p>15</p>
                            </li>
                            <li>
                              <p>16</p>
                            </li>
                            <li>
                              <p>17</p>
                            </li>
                            <li>
                              <p>18</p>
                            </li>
                            <li>
                              <p>19</p>
                            </li>
                            <li>
                              <p>20</p>
                            </li>
                            <li>
                              <p>21</p>
                            </li>
                            <li>
                              <p>22</p>
                            </li>
                            <li>
                              <p>23</p>
                            </li>
                            <li>
                              <p>24</p>
                            </li>
                            <li>
                              <p>25</p>
                            </li>
                            <li>
                              <p>26</p>
                            </li>
                            <li>
                              <p>27</p>
                            </li>
                            <li>
                              <p>28</p>
                            </li>
                            <li>
                              <p>29</p>
                            </li>
                            <li>
                              <p>30</p>
                            </li>
                            <li>
                              <p>31</p>
                            </li>
                            <li>
                              <p>32</p>
                            </li>
                            <li>
                              <p>33</p>
                            </li>
                            <li>
                              <p>34</p>
                            </li>
                            <li>
                              <p>35</p>
                            </li>
                            <li>
                              <p>36</p>
                            </li>
                            <li>
                              <p>37</p>
                            </li>
                            <li>
                              <p>38</p>
                            </li>
                            <li>
                              <p>39</p>
                            </li>
                            <li>
                              <p>40</p>
                            </li>
                            <li>
                              <p>41</p>
                            </li>
                            <li>
                              <p>42</p>
                            </li>
                            <li>
                              <p>43</p>
                            </li>
                            <li>
                              <p>44</p>
                            </li>
                            <li>
                              <p>45</p>
                            </li>
                            <li>
                              <p>46</p>
                            </li>
                            <li>
                              <p>47</p>
                            </li>
                            <li>
                              <p>48</p>
                            </li>
                            <li>
                              <p>49</p>
                            </li>
                            <li>
                              <p>50</p>
                            </li>
                            <li>
                              <p>51</p>
                            </li>
                            <li>
                              <p>52</p>
                            </li>
                            <li>
                              <p>53</p>
                            </li>
                            <li>
                              <p>54</p>
                            </li>
                            <li>
                              <p>55</p>
                            </li>
                            <li>
                              <p>56</p>
                            </li>
                            <li>
                              <p>57</p>
                            </li>
                            <li>
                              <p>58</p>
                            </li>
                            <li>
                              <p>59</p>
                            </li>
                          </ul>
                        </div>

                        <div class="hours-slots">
                          <ul id="custom-timeslot2">
                            <li>
                              <p>AM</p>
                            </li>
                            <li>
                              <p>PM</p>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="shortmessage">
                        <h4>Task Description</h4>
                        <textarea id="task-description" placeholder="Give your Note to the worker"></textarea>
                      </div>
                  </div>
                </div>
                <input type="button" name="next" class="next action-button" value="Continue" />
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
              </fieldset>
              <!-- THIRD FEILD END -->

              <fieldset>
                <div class="your-offer-selected">
                  <div class="row">
                  <div class="col-lg-6 mb-3 mb-lg-0">
                      <h2>Your offers for services selected</h2>
                      <div class="unorderlist-selected" id="selected-services-list">
                          <?php
                          foreach ($servicesArray as $individualService) {
                            $serviceInfo = $serviceData[$individualService];
                            $price = $serviceInfo['price'];
                            $imagePath = $serviceInfo['image'];
                            echo "<li>
                              <em><img src='../admin/uploads/$imagePath' />$individualService</em>
                              <span>$<em contenteditable='true' onBlur='updateTotalAmount(this)'>$price</em></span>
                            </li>";
                          }
                          ?>
                        </div>

                        <div class="totalselected">
                          <li>
                            <em><img src="./images/providerselected/total.png" />Total Charges</em>
                            <span id="total-amount">$0</span>
                          </li>
                        </div>
                      </div>


                    <div class="col-lg-6 mb-3 mb-lg-0">
                      <div class="selected-prfle-detl">
                        <div class="order-details-checkout">
                          <div class="text-order-image">
                            <img src="../provider/<?php echo $profile_picture ?>" />
                            <h2>
                              <?php echo $provider_name; ?><br> <span>Lawn Mower</span>
                            </h2>

                          </div>
                          <ul class="order-details-minor" style="width: 100%;">
                            <h4>Booking Timing</h4>
                            <li>
                                <i style="color: #70BE44;" class="fa fa-clock" aria-hidden="true"></i>
                                <span id="selected-booking-time"></span>
                            </li>
                        </ul>

                          <div class="pricedetails1">
                            <h4>Services Selected</h4>
                            <ul id="selected-services-list2">
                              
                            </ul>
                            <!-- <ul >
                              <li><em>Lawn mowing</em> <span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em>Snow Removal</em> <span style="color: #70BE44;">$ 100.00</span></li>
                              <li><em>Grass Cutting</em> <span style="color: #70BE44;">$ 100.00</span></li>
                            </ul> -->
                          </div>
                          <div class="taskdes-checkout">
                            <h4>Task Description</h4>
                            <p id="display-task-description"></p>
                            <input type="hidden" id="customerFullName" name="customerFullName" value="<?php echo $customerFullName?>" />

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <input type="button" id="submit-date" name="next" class="submit next action-button"
                  value="Proceed & Send Request to Provider" />
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
              </fieldset>
              <fieldset>
                <div class="your-offer-selected popup-selected" id="popupMessage">
                  <div class="popup-selected-modal">
                    <div class="popupsucessfully">
                      <img src="./images/checktick.png" />
                      <p>Your Offer Has been successfully sent to service provider</p>
                    </div>
                  </div>

                </div>

              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROVIDER SEC END -->

  <!-- footer start -->
  <footer id="footer-section">
    <div class="container">
      <div class="footer-widgets">
        <div class="row" style="padding: 60px 0px 30px 0px;">
          <div class="col-lg-3 mb-3 mb-lg-0">
            <img class="footerlogo" src="./images/footerlogo.png" width="100%" />
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
 
<script>
  const totalAmountElement = document.getElementById('total-amount');

  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const selectedServicesList2 = document.getElementById('selected-services-list2');

  function updateTotalAmount() {
    let totalAmount = 0;

    // Clear the existing list
    selectedServicesList2.innerHTML = '';

    checkboxes.forEach((checkbox, index) => {
      if (checkbox.checked) {
        const priceElement = document.querySelectorAll('em[contenteditable="true"]')[index];
        const price = parseFloat(priceElement.textContent) || 0;
        totalAmount += price;

        // Display the edited price in the selected services list
        const serviceName = checkbox.value;
        const listItem = document.createElement('li');
        listItem.innerHTML = `<em>${serviceName}</em><span style='color: #70BE44;'>$<em>${price.toFixed(2)}</em></span>`;
        selectedServicesList2.appendChild(listItem);
      }
    });

    totalAmountElement.textContent = `$${totalAmount.toFixed(2)}`;
  }

  checkboxes.forEach((checkbox, index) => {
    checkbox.addEventListener('change', function () {
      updateTotalAmount();
    });
  });
</script>
<script>
    // Get all the time slot elements
    const timeSlots = document.querySelectorAll('#custom-timeslot li');
    const timeSlotMinutes = document.querySelectorAll('#custom-timeslot1 li');
    const amPmElements = document.querySelectorAll('#custom-timeslot2 li');

    // Initialize selected time variables
    let selectedHour = '01'; // Default selected hour
    let selectedMinute = '00'; // Default selected minute
    let selectedAmPm = 'AM'; // Default selected AM/PM

    // Function to update the selected time
    function updateSelectedTime() {
        // Find the selected hour and minute
        timeSlots.forEach((slot, index) => {
            if (slot.classList.contains('selected')) {
                selectedHour = ('0' + (index + 1)).slice(-2); // Format to two digits
            }
        });

        timeSlotMinutes.forEach((minuteSlot, index) => {
            if (minuteSlot.classList.contains('selected')) {
                selectedMinute = ('0' + index).slice(-2); // Format to two digits
            }
        });

        // Find the selected AM/PM
        amPmElements.forEach((element) => {
            if (element.classList.contains('selected')) {
                selectedAmPm = element.textContent;
            }
        });

        // Update the <span> with the selected time
        const selectedTimeElement = document.getElementById('selected-booking-time');
        selectedTimeElement.textContent = `${selectedHour}:${selectedMinute} ${selectedAmPm}`;
    }

      // Add event listeners to time slots for click events
      timeSlots.forEach((slot) => {
          slot.addEventListener('click', () => {
              // Toggle the 'selected' class on click
              timeSlots.forEach((s) => s.classList.remove('selected'));
              slot.classList.add('selected');

              // Update the selected time
              updateSelectedTime();
          });
      });

      // Add event listeners to time slot minutes for click events
      timeSlotMinutes.forEach((minuteSlot) => {
          minuteSlot.addEventListener('click', () => {
              // Toggle the 'selected' class on click
              timeSlotMinutes.forEach((s) => s.classList.remove('selected'));
              minuteSlot.classList.add('selected');

              // Update the selected time
              updateSelectedTime();
          });
      });

      // Add event listeners to AM/PM elements for click events
      amPmElements.forEach((element) => {
          element.addEventListener('click', () => {
              // Toggle the 'selected' class on click
              amPmElements.forEach((el) => el.classList.remove('selected'));
              element.classList.add('selected');

              // Update the selected time
              updateSelectedTime();
          });
      });

      // Initial update when the page loads
      updateSelectedTime();

  </script>
  <script>
  const toggleSwitch = document.getElementById("toggle-switch");
  const contentOn = document.getElementById("content-on");
  const contentOff = document.getElementById("content-off");

  toggleSwitch.addEventListener("change", function () {
    if (toggleSwitch.checked) {
      contentOn.style.display = "block"; // Show the "on" content
      contentOff.style.display = "none"; // Hide the "off" content
    } else {
      contentOn.style.display = "none"; // Hide the "on" content
      contentOff.style.display = "block"; // Show the "off" content
    }
  });
</script>
<script>
   // JavaScript
   document.getElementById('task-description').addEventListener('input', function () {
        // Get the input from the textarea
        const userContent = this.value;

        // Display the input in the <p> element
        document.getElementById('display-task-description').textContent = userContent;
    });
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

            // Add the base64-encoded image data to the data array
            data.images.push(e.target.result);
        };

        reader.readAsDataURL(file);
    }
  }
  // function uploadImages(customerId, providerId) {
  //   const files = document.getElementById("images").files;

  //   if (files.length !== 5) {
  //       alert("Please select exactly 5 images.");
  //       return;
  //   }

  //   const formData = new FormData();

  //   for (let i = 0; i < files.length; i++) {
  //       formData.append("images[]", files[i]);
  //   }

  //   // Include both customerId and providerId in the form data
  //   formData.append("customerId", customerId);
  //   formData.append("providerId", providerId);

  //   // Send the image data to the server using a new AJAX request
  //   const xhr = new XMLHttpRequest();
  //   xhr.open('POST', 'add.php'); // Create a new PHP file to handle image uploads
  //   xhr.send(formData);

  //   xhr.onreadystatechange = function () {
  //       if (xhr.readyState === 4 && xhr.status === 200) {
  //           // Handle the server's response here, if needed
  //           console.log(xhr.responseText);
  //       }
  //   };
  // }
  function getSelectedServicesWithPrices() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const selectedServices = [];

    checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
            const serviceId = checkbox.getAttribute('data-service-id');
            const serviceName = checkbox.value;
            const priceElement = document.querySelectorAll('em[contenteditable="true"]')[index];
            const price = parseFloat(priceElement.textContent) || 0;
            selectedServices.push({ serviceId, serviceName, price });
        }
    });

    return selectedServices;
}
function uploadImages(customerId, providerId, files) {
    const formData = new FormData();

    for (let i = 0; i < files.length; i++) {
        formData.append("images[]", files[i]);
    }

    // Include both customerId and providerId in the form data
    formData.append("customerId", customerId);
    formData.append("providerId", providerId);
    // Send the image data to the server using a new AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add.php'); // Create a new PHP file to handle image uploads
    xhr.send(formData);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the server's response here, if needed
            console.log(xhr.responseText);
        }
    };
}

document.getElementById('submit-date').addEventListener('click', function () {

    // Find the selected date from the calendar
    const selectedDateElement = document.querySelector('.calendar-day.active');
    if (selectedDateElement) {

        const dateYear = selectedDateElement.getAttribute('date-year');
        const dateMonth = selectedDateElement.getAttribute('date-month');
        const dateDay = selectedDateElement.getAttribute('date-day');

        // Get the selected time
        const selectedTime = getSelectedTime();

        // Get the customer ID from the input field
        const customerId = document.getElementById('customer-id').value;
        const providerId = document.getElementById('provider-id').value;
    // console.log('check', selectedDateElement);
    // return;
    const customerFullName = document.getElementById('customerFullName').value;
        // const serviceId = document.getElementById('service-id').value;
        const messageContent = `You recive a new order from ${customerFullName}`;
        // Get the task description from the <p> element
        const userContent = document.getElementById('display-task-description').textContent;

        // Get the selected services and total amount
        const selectedServices = getSelectedServices();
        const serviceIds = selectedServices.map(service => service.serviceId); // Extract service IDs

        const totalAmount = totalAmountElement.textContent.replace('$', '');
        
        // Create an array to store the selected image files
        const imageFiles = document.getElementById('images').files;

        // Create a JavaScript object with all the non-image data
        const data = {
            customerId: customerId,
            providerId: providerId,
            statusFrom: 'customer_send',
            messageContent: messageContent,
            selectedDate: {
                year: dateYear,
                month: dateMonth,
                day: dateDay,
            },
            selectedTime: selectedTime,
            userContent: userContent,
            selectedServices: getSelectedServicesWithPrices(),
            totalAmount: totalAmount,
        };
        console.log(data);
        // return;
        // Send the non-image data to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'php.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(data));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the server's response here, if needed
                console.log(xhr.responseText);
            }
        };

        // After sending non-image data, upload images separately
        uploadImages(customerId, providerId, imageFiles);
    } else {
        alert('Please select a date from the calendar.');
    }
});


    // Implement a function to get the selected time from your time selection elements
    function getSelectedTime() {
        const amPmElement = document.querySelector('#custom-timeslot2 li.selected p');
        const hourElement = document.querySelector('#custom-timeslot li.selected p');
        const minuteElement = document.querySelector('#custom-timeslot1 li.selected p');

        const amPm = amPmElement ? amPmElement.textContent : '';
        const hour = hourElement ? hourElement.textContent : '';
        const minute = minuteElement ? minuteElement.textContent : '00';

        return `${hour}:${minute} ${amPm}`;
    }

    // Function to get the selected services
    function getSelectedServices() {
      const checkboxes = document.querySelectorAll('input[type="checkbox"]');
      const selectedServices = [];

      checkboxes.forEach((checkbox) => {
          if (checkbox.checked) {
              const serviceId = checkbox.getAttribute('data-service-id');
              const serviceName = checkbox.value;
              selectedServices.push({ serviceId, serviceName });
          }
      });

      return selectedServices;
}


    // Function to calculate the total amount based on selected services
    function calculateTotalAmount() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let totalAmount = 0;

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const serviceInfo = <?php echo json_encode($serviceData); ?>; // Provided by PHP
                const price = serviceInfo[checkbox.value].price;
                totalAmount += parseFloat(price);
            }
        });

        return totalAmount.toFixed(2);
    }
    // After preview_images() is called, you can add the base64-encoded images to the data array
// Get the submit button
const submitButton = document.getElementById('submit-date');

// Get the popup message element
const popupMessage = document.getElementById('popupMessage');

// Add a click event listener to the submit button
submitButton.addEventListener('click', function () {
    // Show the popup message
    popupMessage.style.display = 'block';

    // Automatically hide the popup message after 5 seconds
    setTimeout(function () {
        popupMessage.style.display = 'none';

        // Redirect to the service page after 5 seconds
        setTimeout(function () {
            window.location.href = 'services.php'; // Replace with the actual URL
        }, 100); // 5000 milliseconds (5 seconds)
    }, 4000); // 5000 milliseconds (5 seconds)
});

</script>
<script>
  const selectedServicesList = document.getElementById('selected-services-list');
  const totalAmountElement = document.getElementById('total-amount');
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');

  function updateSelectedServices() {
    selectedServicesList.innerHTML = ''; // Clear the selected services list
    let totalAmount = 0;

    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        const serviceName = checkbox.value;
        const price = parseFloat(checkbox.getAttribute('data-price')) || 0;

        // Add selected service to the list
        selectedServicesList.innerHTML += `
          <li>
            <em>${serviceName}</em>
            <span>$<em contenteditable="true">${price}</em></span>
          </li>
        `;

        totalAmount += price;
      }
    });

    totalAmountElement.textContent = `$${totalAmount.toFixed(2)}`;
  }

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', updateSelectedServices);
  });

  // Initial update when the page loads
  updateSelectedServices();
</script>



  <!-- jQuery -->
  <script src="plugins/jQuery/jquery.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="plugins/bootstrap/bootstrap.min.js"></script>
  <!-- slick slider -->
  <script src="plugins/slick/slick.min.js"></script>

  <!-- Main Script -->
  <script src="js/script.js"></script>
</body>

</html>

<script>
  $(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function () {

      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //Add Class Active
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate({ opacity: 0 }, {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          next_fs.css({ 'opacity': opacity });
        },
        duration: 500
      });
      setProgressBar(++current);
    });

    $(".previous").click(function () {

      current_fs = $(this).parent();
      previous_fs = $(this).parent().prev();

      //Remove class active
      $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

      //show the previous fieldset
      previous_fs.show();

      //hide the current fieldset with style
      current_fs.animate({ opacity: 0 }, {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          previous_fs.css({ 'opacity': opacity });
        },
        duration: 500
      });
      setProgressBar(--current);
    });

    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar")
        .css("width", percent + "%")
    }

    $(".submit").click(function () {
      return false;
    })

  });
</script>