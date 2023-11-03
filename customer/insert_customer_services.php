<?php
include 'connection.php';
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the data sent from the client
  $data = json_decode(file_get_contents('php://input'), true);

  // Extract data
  $customer_id = $data['customer_id'];
  $provider_id = $data['provider_id'];
  $selected_services = $data['selected_services'];
  $total_amount = $data['total_amount'];

  // Insert the data into the database
  foreach ($selected_services as $service) {
    $service_name = $service['service_name'];
    $price = $service['price'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO customer_services (customer_id, provider_id, service_id, service_name, price, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissd", $customer_id, $provider_id, $service_id, $service_name, $price, $total_amount);

    if ($stmt->execute()) {
       // Roll back the transaction in case of errors
       $conn->rollback();
       echo 'Error inserting services data.';
       exit;
    } else {
       // Roll back the transaction in case of errors
       $conn->rollback();
       echo 'Error moving services file to the server.';
       exit;
    }
  }
} else {
    echo 'Invalid data.';
}
?>
