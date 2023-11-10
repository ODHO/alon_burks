<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the request is a POST request

    include 'connection.php'; // Include your database connection

    // Parse the JSON data received from the client
    $postData = json_decode(file_get_contents('php://input'), true);
  
    if ($postData && isset($postData['proposalId'], $postData['servicePrices'], $postData['totalAmount'], $postData['counterNote'])) {
        $proposalId = $postData['proposalId'];
        $servicePrices = $postData['servicePrices'];
        $totalAmount = $postData['totalAmount'];
        $counterNote = $postData['counterNote'];
        $providerId = $postData['providerId'];
        $customerId = $postData['customerId'];
        $providerName = $postData['providerName'];
        echo $counterNote;
        // die();
        // Update the service prices in the database
        if (updateServicePrices($proposalId, $servicePrices, $totalAmount, $counterNote) && updateTotalAmount($proposalId, $totalAmount)) {
            $messageContent = "$providerName has made a counter offer.";

            if (insertMessage($proposalId, $providerId, $customerId, $providerName, $messageContent)) {
                $response = ['success' => true, 'message' => 'Counter offer and message have been updated successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to insert the message.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Failed to update the counter offer.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Invalid data received.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

// Send JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);

// Function to update service prices based on proposalId and service data
function updateServicePrices($proposalId, $servicePrices, $totalAmount, $counterNote) {
    global $conn;
    try {
        $stmt = $conn->prepare('UPDATE customer_services SET counter_price = ?, counter_totall = ?, counter_note = ? WHERE proposal_id = ? AND service_name = ?');
        foreach ($servicePrices as $service) {
            $serviceName = $service['name'];
            $price = $service['price'];
            $stmt->bind_param('ddsss', $price, $totalAmount, $counterNote, $proposalId, $serviceName);
            $stmt->execute();
        }
        $stmt->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to update the total amount based on proposalId
function updateTotalAmount($proposalId, $totalAmount) {
    global $conn;
    try {
        $stmt = $conn->prepare('UPDATE customer_proposal SET counter_totall = ?, status = "replied_offer" WHERE id = ?');
        $stmt->bind_param('di', $totalAmount, $proposalId);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Function to insert a new message into the MESSAGES table
// Function to insert a new message into the MESSAGES table and update the status
function insertMessage($proposalId, $providerId, $customerId, $providerName, $messageContent) {
    global $conn;
    try {
        // Start a database transaction to ensure data consistency
        $conn->begin_transaction();

        $stmt = $conn->prepare('INSERT INTO messages (proposal_id, provider_id, customer_id, provider_name, message_content, status) VALUES (?, ?, ?, ?, ?, ?)');
        $status = 'provider_send'; // Set the status here
        $stmt->bind_param('diiiss', $proposalId, $providerId, $customerId, $providerName, $messageContent, $status);

        if ($stmt->execute()) {
            // If the message insertion is successful, commit the transaction
            $conn->commit();
            $stmt->close();
            return true;
        } else {
            // If there's an error, rollback the transaction
            $conn->rollback();
            $stmt->close();
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

?>
