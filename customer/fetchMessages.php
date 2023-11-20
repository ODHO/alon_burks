<?php
// fetchMessages.php
include_once 'connection.php';
// Retrieve the data sent from the AJAX request
$customerId = $_GET['customerId'];
$providerId = $_GET['providerId'];
$proposalId = $_GET['proposalId'];

// Function to get messages for a specific customer, provider, and proposal
$messages = getMessages($customerId, $providerId, $proposalId);

foreach ($messages as $message) {
    echo '<li class="' . ($message['sender'] === 'customer' ? 'repaly' : 'sender') . '">';
    echo '<p>' . $message['message'] . '</p>';
    echo '<span class="time">' . $message['created_at'] . '</span>';
    echo '</li>';
}

// Function to get messages
function getMessages($customerId, $providerId, $proposalId)
{
    global $conn;

    $sql = "SELECT * FROM chat WHERE customer_id = ? AND provider_id = ? AND proposal_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $customerId, $providerId, $proposalId);

    $messages = [];

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'message' => $row['message'],
                'sender' => $row['sender'], // 'provider' or 'customer'
                'created_at' => $row['created_at'],
            ];
        }
    }

    return $messages;
}
?>
