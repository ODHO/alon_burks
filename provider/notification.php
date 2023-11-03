<?php
session_start();
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
    <!-- Modal popup -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
        <!-- partial:partials/_navbar.php -->
        <?php 
     include 'header.php'
    ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
        
            <?php
      include 'SideMenu.php'
      ?>
            <!-- partial -->
            <div class="main-panel">
                
                <!-- START ROW MAIN-PANEL -->
                <div class="row">

<section id="notifications-main">
                    <div class="order-in-progress notifications-inner">
                        <h1 style="width:fit-content"><b style="color: #70BE44;">All </b>Notifications</h1>
                        <!-- <div class="onetime-advancebokingbutton">
                            <ul>
                                <li><a href="new-offers.php"><button style="color: #fff; background-color: #70BE44;">One
                                            Time Service</button></a></li>
                                <li><a href="new-offers-advancebooking.php"><button
                                            style="color: #959595; background-color: #E6E6E6;">Advance
                                            Bookings</button></a></li>
                            </ul>
                        </div> -->
                        <!-- FIRST NEW OFFER -->
                        <?php
                        function getNotifications($userId) {
    global $conn;
    $sql = "SELECT messages.message_content, messages.customer_id, messages.proposal_id, provider_registration.fullname, provider_registration.profile_picture FROM messages
            INNER JOIN provider_registration ON messages.customer_id = provider_registration.id
            WHERE messages.provider_id = ? AND messages.status = 'customer_send' ORDER BY messages.time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $notifications = array();

        while ($row = $result->fetch_assoc()) {
            $messageContent = $row['message_content'];
            $providerName = $row['fullname'];
            $profilePicture = $row['profile_picture'];
            $proposalId = $row['proposal_id'];
            $notifications[] = array('message_content' => $messageContent, 'provider_name' => $providerName, 'profile_picture' => $profilePicture, 'proposal_id' => $proposalId);
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
        $providerName = $notification['provider_name'];
        $providerProfilePicture = $notification['profile_picture'];
        $proposalId = $notification['proposal_id'];

        print_r($proposalId);
        echo "<div class='notify-text' style='padding: 15px 0px;'>";
        echo "<img src='../customer/$providerProfilePicture' />";
        echo "<div>";
        echo "<h4>Provider: $providerName</h4>";
        echo "<p>Message: $messageContent</p>";
        echo "</div>";
        echo "</div>";
    }
}
        ?>

                        <!-- END ROW MAIN-PANEL -->
                    </div>
                    </section>
                    <!-- main-panel ends -->
                </div>
                <!-- page-body-wrapper ends -->
            </div>
            <!-- container-scroller -->

            <!-- plugins:js -->
           
             <script>
  // Function to calculate the updated total amount based on edited service prices
  function updateTotalAmount(modal) {
    const editablePrices = modal.querySelectorAll('[contenteditable="true"]');
    let updatedTotalAmount = 0;

    editablePrices.forEach((priceElement) => {
      // Parse the edited price (default to 0 if not a valid number)
      const editedPrice = parseFloat(priceElement.textContent) || 0;
      updatedTotalAmount += editedPrice;
    });

    // Calculate platform charges (10%)
    const platformChargesPercentage = 10;
    const platformCharges = (updatedTotalAmount * platformChargesPercentage) / 100;

    // Calculate the amount you'll earn
    const amountYouWillEarn = updatedTotalAmount - platformCharges;

    // Display the updated total amount and "Your will Earn"
    const totalAmountElement = modal.querySelector('.totalcharges span');
    const amountYouWillEarnElement = modal.querySelector('.percent-counter li:last-child span');

    if (totalAmountElement) {
      totalAmountElement.textContent = '$' + updatedTotalAmount.toFixed(2);
    }

    if (amountYouWillEarnElement) {
      amountYouWillEarnElement.textContent = '$' + amountYouWillEarn.toFixed(2);
    }
  }

  // Add input and blur event listeners to each editable price element for all modals
  const modals = document.querySelectorAll('.modal');
  modals.forEach((modal) => {
    const editablePrices = modal.querySelectorAll('[contenteditable="true"]');
    editablePrices.forEach((priceElement) => {
      priceElement.addEventListener('input', () => updateTotalAmount(modal));
      priceElement.addEventListener('blur', () => updateTotalAmount(modal));
    });

    // Initialize total amount and "Your will Earn" when the page loads
    updateTotalAmount(modal);
  });
</script>
<script>
function updateServicePrice(proposalId) {
    // Get the modal element
    const modal = document.getElementById(`new${proposalId}`);
    
    // Get the total amount from the modal
   // Calculate the total amount
   const totalAmountElement = modal.querySelector('.totalcharges span');
    const totalAmount = parseFloat(totalAmountElement.textContent.replace('$', '')) || 0;
    const counterNote = document.getElementById('counterNote').value;
    const providerId = document.getElementById('providerId').value;
    const customerId = document.getElementById('customerId').value;
    const providerName = document.getElementById('providerName').value;


    // Collect the updated service prices and their names
    const updatedServicePrices = [];
    const editablePrices = modal.querySelectorAll('[contenteditable="true"]');
    
    editablePrices.forEach((priceElement) => {
        const editedPrice = parseFloat(priceElement.textContent) || 0;
        const serviceName = priceElement.dataset.id; // Service name
        updatedServicePrices.push({ name: serviceName, price: editedPrice });
    });

    // Calculate the platform charges
    const platformChargesPercentage = 10;
    const platformCharges = (totalAmount * platformChargesPercentage) / 100;

    // Calculate the amount the user will earn
    const amountYouWillEarn = totalAmount - platformCharges;

    // Create an object with the updated service prices and the total amount
    const data = {
        proposalId: proposalId,
        providerId: providerId,
        customerId: customerId,
        providerName: providerName,
        servicePrices: updatedServicePrices,
        totalAmount: totalAmount,
        platformCharges: platformCharges,
        amountYouWillEarn: amountYouWillEarn,
        counterNote: counterNote,

    };

    console.log('data', data);
    // return;
    // Send the data to the server using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update-service-price.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server (e.g., display a success message).
            const response = JSON.parse(xhr.responseText);
            
            if (response.success) {
                location.reload(); // This will refresh the current page    
                // Optionally, close the modal or redirect to another page.
            } else {
                alert('Counter offer could not be sent. Please try again.');
            }
        }
    };

    xhr.send(JSON.stringify(data));
}

// Add a click event listener to each "Send" button
const modalFooterButtons = document.querySelectorAll('[id^="sendButton_"]');
modalFooterButtons.forEach((button) => {
    const proposalId = button.id.split('_')[1];
    button.addEventListener('click', () => updateServicePrice(proposalId));
});
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
            <!-- End custom js for this page-->
</body>

</html>