
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
  

<?php
include 'header.php'
?>

<!-- banner -->
<section id="main-banner" class="banner bg-cover position-relative d-flex justify-content-center align-items-center"
  data-background="images/banner/banner.png" style="text-align: center;     min-height: 50vh;">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 style="color: #FFF; padding-top: 120px;">Notifications</h2>
        <h5 style="color: white;">Here are your daily updates Notifications</h5>
      </div>
    </div>
    
 
  </div>
</section>
<!-- /banner -->

<!-- NOTIFICATIONS SECTION START -->
<section id="notifications-main" style="padding: 60px 0px;">
<div class="container">
    <div class="row">
        <div class="notifications-inner" >
        <?php
include 'connection.php';

// Function to get customer information from the provider_registration table
function getCustomerInfo($providerId) {
    global $conn;
    $sql = "SELECT fullname, profile_picture, address FROM provider_registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $providerId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
    }
    return array('fullname' => 'N/A', 'address' => 'N/A', 'profile_picture' => 'N/A'); // Provide default values if customer info not found
}

function getNotifications($userId) {
    global $conn;
    $sql = "SELECT messages.message_content, messages.provider_id, provider_registration.fullname, provider_registration.profile_picture 
            FROM messages
            INNER JOIN provider_registration ON messages.provider_id = provider_registration.id
            WHERE messages.customer_id = ? AND messages.status = 'provider_send'
            ORDER BY messages.time DESC"; // Replace 'timestamp_column' with your actual column name
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $notifications = array();

        while ($row = $result->fetch_assoc()) {
            $messageContent = $row['message_content'];
            $providerName = $row['fullname'];
            $profilePicture = $row['profile_picture'];
            $notifications[] = array('message_content' => $messageContent, 'provider_name' => $providerName, 'profile_picture' => $profilePicture);
        }

        return $notifications;
    }

    return array();
}


$userId = $_SESSION['user_id'];

$notificationsArray = getNotifications($userId);

if (count($notificationsArray) === 0) {
    echo '<h2 class="text-center texter">No messages with status "provider_send" available.</h2>';
} else {
    foreach ($notificationsArray as $notification) {
        $messageContent = $notification['message_content'];
        $providerName = $notification['provider_name'];
        $providerProfilePicture = $notification['profile_picture'];

        echo "<div class='notify-text' style='padding: 15px 0px;'>";
        echo "<img src='../provider/$providerProfilePicture' />";
        echo "<h4>Provider: $providerName</h4>";
        echo "<p>Message: $messageContent</p>";
        echo "</div>";
    }
}
?>






        </div>
    </div>
</div>
</section>

<!-- NOTIFICATIONS END -->


<!-- footer start -->
<?php
include 'footer.php'
?>

<!-- footer end -->

<!-- jQuery -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<!-- slick slider -->
<script src="plugins/slick/slick.min.js"></script>
<!-- venobox -->

<!-- Main Script -->
<script src="js/script.js"></script>

</body>
</html>
