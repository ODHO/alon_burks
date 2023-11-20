<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the request is a POST request

    include 'connection.php'; // Include your database connection

    // Parse the JSON data received from the client
    $postData = json_decode(file_get_contents('php://input'), true);

    if ($postData && isset($postData['proposalId'], $postData['status'], $postData['customerId'], $postData['providerId'], $postData['customerFullName'], $postData['messageContent'], $postData['statusFrom'], $postData['sheduledDate'])) {
        $proposalId = $postData['proposalId'];
        $status = $postData['status'];
        $customerId = $postData['customerId'];
        $providerId = $postData['providerId'];
        $customerFullName = $postData['customerFullName'];
        $messageContent = $postData['messageContent'];
        $statusFrom = $postData['statusFrom'];
        $sheduledDate = $postData['sheduledDate'];

        // Convert the formatted date and time to numeric format
        $dateTime = DateTime::createFromFormat('d-M-Y, D g:i A', $sheduledDate);

        $numericDate = $dateTime->format('Y-m-d');
        $numericTime = $dateTime->format('H:i:s');
        // echo $numericDate;
        // echo $numericTime;
        // die();
        // Update the status in the customer_proposal table
        $sqlCustomerProposal = "UPDATE customer_proposal SET status = ? WHERE id = ?";
        $stmtCustomerProposal = $conn->prepare($sqlCustomerProposal);
        $stmtCustomerProposal->bind_param('ss', $status, $proposalId);

        // Update the status in the advance_proposal table
        $sqlAdvanceProposal = "UPDATE advance_proposal SET status = ? WHERE proposal_id = ? AND selected_date = ?";
        $stmtAdvanceProposal = $conn->prepare($sqlAdvanceProposal);
        $stmtAdvanceProposal->bind_param('sss', $status, $proposalId, $numericDate);
        echo $status, $proposalId, $numericDate;
        // die();
        if ($stmtCustomerProposal->execute() && $stmtAdvanceProposal->execute()) {
            // Insert the message into the MESSAGES table
            if (insertMessage($proposalId, $providerId, $customerId, $customerFullName, $messageContent, $statusFrom)) {
                $response = ['success' => true, 'message' => 'Status updated and message sent successfully.'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to insert the message.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Error updating status: ' . $stmtCustomerProposal->error . ' | ' . $stmtAdvanceProposal->error];
        }

        $stmtCustomerProposal->close();
        $stmtAdvanceProposal->close();
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
function insertMessage($proposalId, $providerId, $customerId, $customerFullName, $messageContent, $statusFrom) {
    global $conn;
    try {
        $stmt = $conn->prepare('INSERT INTO messages (proposal_id, provider_id, customer_id, provider_name, message_content, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('diiiss', $proposalId, $providerId, $customerId, $customerFullName, $messageContent, $statusFrom);
        $stmt->execute();
        $stmt->close();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
