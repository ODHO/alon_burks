<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the request is a POST request

    include 'connection.php'; // Include your database connection

    // Parse the JSON data received from the client
    $postData = json_decode(file_get_contents('php://input'), true);

    if ($postData && isset($postData['proposalId'], $postData['status'], $postData['customerId'], $postData['providerId'], $postData['providerName'], $postData['messageContent'], $postData['statusFrom'])) {
        $proposalId = $postData['proposalId'];
        $status = $postData['status'];
        $customerId = $postData['customerId'];
        $providerId = $postData['providerId'];
        $providerName = $postData['providerName'];
        $messageContent = $postData['messageContent'];
        $statusFrom = $postData['statusFrom'];

        // Update the status in the customer_proposal table
        $sql = "UPDATE customer_proposal SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $status, $proposalId);

        if ($stmt->execute()) {
            // Insert the message into the MESSAGES table
            if (insertMessage($proposalId, $providerId, $customerId, $providerName, $messageContent, $statusFrom)) {
                $response = ['success' => true, 'message' => 'Status updated and message sent successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to insert the message.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Error updating status: ' . $stmt->error];
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

// Function to insert a new message into the MESSAGES table
function insertMessage($proposalId, $providerId, $customerId, $providerName, $messageContent, $statusFrom) {
    global $conn;
    try {
        $stmt = $conn->prepare('INSERT INTO messages (proposal_id, provider_id, customer_id, provider_name, message_content, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('diiiss', $proposalId, $providerId, $customerId, $providerName, $messageContent, $statusFrom);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
