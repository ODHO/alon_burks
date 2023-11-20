<?php
include_once 'connection.php';
// Retrieve the data sent from the AJAX request
$customerId = $_POST['customerId'];
$providerId = $_POST['providerId'];
$proposalId = $_POST['proposalId'];
$content = $_POST['content'];

// Perform database insert operation to store the message
$sql = "INSERT INTO chat (customer_id, provider_id, proposal_id, message, sender) VALUES (?, ?, ?, ?, 'provider')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssss', $customerId, $providerId, $proposalId, $content);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = [
        'message' => $content,
        'sender' => 'provider',
        'created_at' => date('Y-m-d H:i:s'),
    ];
} else {
    $response['success'] = false;
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

// Output only JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
