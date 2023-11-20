<?php
session_start();
// Include your connection and functions here
include 'connection.php'; // Include your database connection file

// Function to get chat messages for a specific customer and proposal
function getChatMessages($providerId, $proposalId) {
    global $conn;

    // Prepare a SQL query to fetch chat messages
    $sql = "SELECT * FROM chat WHERE customer_id = ? AND proposal_id = ? ORDER BY created_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $providerId, $proposalId);

    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Create an array to store the chat messages
        $chatMessages = array();

        // Fetch chat messages and add them to the array
        while ($row = $result->fetch_assoc()) {
            $chatMessages[] = array(
                'message' => $row['message'],
                'created_at' => $row['created_at']
            );
        }

        // Return the array of chat messages
        return $chatMessages;
    } else {
        // Handle any errors in executing the query
        return array(); // Return an empty array on error
    }
}

// Check if a message is submitted
if (isset($_POST['message']) && isset($_POST['customerId']) && isset($_POST['proposalId'])) {
    // Get the message content, customer ID, proposal ID, and provider ID
    $message = $_POST['message'];
    $userId = $_POST['customerId'];
    $proposalId = $_POST['proposalId'];
    $userId = $_SESSION['user_id']; // Provider's ID

    // Insert the message into the chat table
    $sql = "INSERT INTO chat (customer_id, provider_id, proposal_id, message, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $userId, $userId, $proposalId, $message);

    if ($stmt->execute()) {
        // Message inserted successfully
        // You can provide a success message or redirect back to the chat page
    } else {
        // Handle the case where the message insertion fails
        echo 'Error inserting the message.';
    }
}

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
// Function to get the price of a service from the categories table
function getCustomerServicesAndPrices($providerId, $proposalId) {
  global $conn;
  $sql = "SELECT service_name, price, counter_price FROM customer_services WHERE provider_id = ? AND proposal_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $providerId, $proposalId);

  if ($stmt->execute()) {
      $result = $stmt->get_result();
      $servicesAndPrices = array();

      while ($row = $result->fetch_assoc()) {
          $serviceCustomers = $row['service_name'];
          $priceService = $row['price'];
          $counterPrice = $row['counter_price'];
          $servicesAndPrices[] = array('service_name' => $serviceCustomers, 'price' => $priceService, 'counter_price' => $counterPrice);
          // print_r($servicesAndPrices);
      }

      return $servicesAndPrices;
  }

  return array();
}
function getServicePrice($service) {
    global $conn;
    $sql = "SELECT price FROM customer_services WHERE service_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $service);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['price'];
        }
    }
    return 'N/A'; // Provide a default value if service price not found
  }
  function getCustomerImagesForProvider($userId, $providerId, $proposalId) {
    global $conn;
    $sql = "SELECT image_path FROM customer_images WHERE customer_id = ? AND provider_id = ? AND proposal_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $userId, $providerId, $proposalId);
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      $images = array();
      while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_path'];
      }
      return $images;
    }
    return array();
  }


function getServiceImages($service) {
  global $conn;
  $servicesImages = array();

  // Create a prepared statement to select servicesImages based on service names
  $sql = "SELECT image FROM categories WHERE heading IN (?)";
  $stmt = $conn->prepare($sql);

  if ($stmt) {
      $categories = implode("', '", $service); // Assuming service names are in an array
      $stmt->bind_param('s', $categories);

      if ($stmt->execute()) {
          $result = $stmt->get_result();

          while ($row = $result->fetch_assoc()) {
              $servicesImages[] = $row['image'];
          }
      }
  }

  return $servicesImages;
}

?>
<!DOCTYPE html>
<html lang="zxx" class="my-offer">

<head>
  <meta charset="utf-8">
  <title>Aaron Burks</title>

  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  

  <!-- MESSAGE CHAT BOX CDNS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- theme meta -->
  <meta name="theme-name" content="agen" />
  <!-- HORIZONTAL COLUMN ALIGN LINKS -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
  

    <?php include 'Black_logo_header.php'; ?>

      <!-- MESSAGE BOX START  -->
      <!-- char-area -->
      <section class="message-area">
      <div class="container">
          <h2 style="color: #000; font-weight: bold;">Messages</h2>
          <p style="color: #70BE44; padding-bottom: 20px;">Here are your Service Providers Chats </p>
        <div class="row">
          <div class="col-12">
            <div class="chat-area">
              <!-- chatlist -->

              <div class="chatlist">
                <div class="modal-dialog-scrollable">
                  <div class="modal-content" style="padding:2px;">
                    <div class="chat-header">
                      <div class="msg-search">
                        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" aria-label="search">
                        <a class="add" href="#"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/add.svg" alt="add"></a>
                      </div>
    
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab" aria-controls="Open" aria-selected="true">Open</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="Closed-tab" data-bs-toggle="tab" data-bs-target="#Closed" type="button" role="tab" aria-controls="Closed" aria-selected="false">Closed</button>
                        </li>
                      </ul>
                    </div>
    
                    <div class="modal-body">
                      <!-- chat-list -->
                      <div class="chat-lists">
                        <div class="tab-content p-0" id="myTabContent">
                          <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                            <!-- chat-list -->
              <?php
                $userId = $_SESSION['user_id'];

                // Query to fetch the list of customers for the provider
                $sql = "SELECT DISTINCT provider_id, id FROM customer_proposal WHERE customer_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $userId);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                
                while ($row = $result->fetch_assoc()) {
                  $proposalId = $row['id'];
                  $providerId = $row['provider_id'];
                  
                    // Retrieve customer information
                    $customerInfo = getCustomerInfo($providerId);
                    $providerName = $customerInfo['fullname'];
                    $profile_picture = $customerInfo['profile_picture'];
              ?>

                            <div class="chat-list tab">

                              <!-- chatlist tabs -->
                              <a class="tablinks<?php echo $proposalId?> py-3 px-1 taber" onclick="openCity(event, '<?php echo $proposalId?>')" style="display: flex;align-items: center;">
                                  <div style="display: contents;">
                                    <img class="img-fluid profile" src="../provider/<?php echo $profile_picture ?>" alt="user img">
                                  </div>
                                  <div class="flex-grow-1 ms-3">
                                    <h3><?php echo $providerName?></h3>
                                    <p>front end developer</p>
                                  </div>
                              
                              </a>

                            </div>
                            <?php }
                            } else {
                              echo '<p>No customers available.</p>';
                          }
                      } else {
                          echo 'Error executing the query.';
                      }
                      ?>
                            <!-- chat-list -->
                          </div>
                          <div class="tab-pane fade" id="Closed" role="tabpanel" aria-labelledby="Closed-tab">
    
                            <div class="chat-list">
                              
                              <a href="#" class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                  <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h3>Mehedi Hasan</h3>
                                  <p>front end developer</p>
                                </div>
                              </a>

                              <a href="#" class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                  <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h3>Mehedi Hasan</h3>
                                  <p>front end developer</p>
                                </div>
                              </a>
    
                            </div>
                          </div>
                        </div>
    
                      </div>
                      <!-- chat-list -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- chatlist -->
    
              <!-- chatbox first -->
              <?php

// Assuming you have a session with the provider's user_id
    $userId = $_SESSION['user_id'];

    // Query to fetch the list of customers for the provider
    $sql = "SELECT DISTINCT provider_id, id FROM customer_proposal WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
       
        while ($row = $result->fetch_assoc()) {
          $providerId = $row['provider_id'];
          $proposalId = $row['id'];
            // Retrieve customer information
            $customerInfo = getCustomerInfo($providerId);
            $providerName = $customerInfo['fullname'];
            $profile_picture = $customerInfo['profile_picture'];
            $messages = getMessages($userId, $providerId, $proposalId);
          ?>
              <div class="chatbox showbox tabcontent<?php echo $proposalId ?>" id="<?php echo $proposalId?>">
                <div class="modal-dialog-scrollable">
                  <div class="modal-content accordion-body" style="padding:2px;">
                    <div class="msg-head">
                      <div class="row">
                        <div class="col-8">
                          <div class="d-flex align-items-center">
                            <span class="chat-icon"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg" alt="image title"></span>
                            <div style="display: contents;">
                              <img class="img-fluid profile" src="../provider/<?php echo $profile_picture ?>" alt="user img">
                            </div>
                            <div class="flex-grow-1 ms-3">
                              <h3><?php echo $providerName?></h3>
                              <p>front end developer</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-4">
                          <ul class="moreoption">
                            <li class="navbar nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                  <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                              </ul>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
    
                    <div class="modal-body">
                    <div class="msg-body">
                        <ul>
                            <?php foreach ($messages as $message) : ?>
                                <li class="<?php echo $message['sender'] === 'provider' ? 'sender' : 'repaly'; ?>">
                                    <p><?php echo $message['message']; ?></p>
                                    <span class="time"><?php echo $message['created_at	']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                  </div>
                  <div class="send-box">
                     <!-- Add an id attribute to the form for easier identification -->
                    <form action="" id="messageForm<?php echo $proposalId; ?>">
                        <input type="text" class="form-control" aria-label="message…" placeholder="Write message…">
                        <button type="button" onclick="sendMessage(<?php echo $userId; ?>, <?php echo $providerId; ?>, <?php echo $proposalId; ?>)">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i> Send
                        </button>
                    </form>
                    <script>
                      function sendMessage(userId, providerId, proposalId) {
                          var messageContent = document.querySelector(`#messageForm${proposalId} input`).value;

                          // Check if the message content is not empty
                          if (messageContent.trim() !== "") {
                              // Use AJAX to send the message to the server
                              var xhr = new XMLHttpRequest();
                              xhr.open("POST", "sendMessage.php", true);
                              xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                              xhr.onreadystatechange = function () {
                                  if (xhr.readyState === 4 && xhr.status === 200) {
                                      // Handle the response
                                      var response = JSON.parse(xhr.responseText);

                                      if (response.success) {
                                          // Update the chat in real-time
                                          var message = response.message;
                                          var chatContainer = document.querySelector(`.tabcontent${proposalId} .msg-body ul`);
                                          var newMessage = document.createElement('li');
                                          newMessage.className = message.sender === 'customer' ? 'repaly' : 'sender';
                                          newMessage.innerHTML = `
                                              <p>${message.message}</p>
                                              <span class="time">${message.created_at}</span>
                                          `;
                                          chatContainer.appendChild(newMessage);

                                          // Clear the input field
                                          document.querySelector(`#messageForm${proposalId} input`).value = '';
                                      } else {
                                          // Handle the error if needed
                                          console.error(response.error);
                                      }
                                  }
                              };

                              // Send the data to the server
                              xhr.send(`customerId=${userId}&providerId=${providerId}&proposalId=${proposalId}&content=${messageContent}`);
                          }
                      }
                    </script>

                  </div>
                  </div>
                </div>
              </div>
              <?php }
                            } else {
                              echo '<p>No customers available.</p>';
                          }
                      } else {
                          echo 'Error executing the query.';
                      }

                      // Function to get messages for a specific customer, provider, and proposal
                        function getMessages($userId, $providerId, $proposalId)
                        {
                            global $conn;

                            $sql = "SELECT * FROM chat WHERE customer_id = ? AND provider_id = ? AND proposal_id = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('sss', $userId, $providerId, $proposalId);

                            $messages = [];

                            if ($stmt->execute()) {
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $messages[] = [
                                        'message' => $row['message'],
                                        'sender' => $row['sender'], // 'provider' or 'customer'
                                        'created_at	' => $row['created_at'],
                                    ];
                                }
                            }

                            return $messages;
                        }
                      ?>
              <!-- chatbox-1 -->
            </div>
            <!-- chatbox -->
    
          </div>
        </div>
      </div>
    </section>
  <!-- char-area -->
      <!-- MESSAGE BOX END -->

<!-- footer start -->
<?php include 'footer.php'; ?>
<script>
    function openCity(event, proposalId) {
        // Hide all elements with class name 'chatbox'
        var chatboxes = document.querySelectorAll('.chatbox');
        chatboxes.forEach(function (element) {
            element.style.display = 'none';
        });

        // Show the specific chatbox with the given proposalId
        var selectedChatbox = document.getElementById(proposalId);
        if (selectedChatbox) {
            selectedChatbox.style.display = 'block';
        }

        // Remove the 'active' class from all tabs
        var tablinks = document.querySelectorAll('.tablinks');
        tablinks.forEach(function (element) {
            element.classList.remove('active');
        });

        // Add the 'active' class to the clicked tab
        event.currentTarget.classList.add('active');
    }
</script>

  <!-- plugins:js -->
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
</body>
</html>
