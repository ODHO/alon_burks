<?php
// Include your database connection script
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data as JSON from the request body
    $postData = json_decode(file_get_contents('php://input'));

    if (isset($postData->providerId) && isset($postData->selectedDate)) {
        $providerId = $postData->providerId;
        $selectedDate = $postData->selectedDate;

        // Fetch already booked hours from customer_proposal table
        $customerSql = "SELECT selected_time, selected_time_to FROM customer_proposal WHERE provider_id = ? AND selected_date = ?";
        $customerStmt = $conn->prepare($customerSql);
        $customerStmt->bind_param('ss', $providerId, $selectedDate);

        // Fetch already booked hours from advance_proposal table
        $advanceSql = "SELECT selected_time, selected_time_to FROM advance_proposal WHERE provider_id = ? AND selected_date = ?";
        $advanceStmt = $conn->prepare($advanceSql);
        $advanceStmt->bind_param('ss', $providerId, $selectedDate);

        // Initialize result arrays
        $bookedSlots = [];

        // Execute the queries
        if ($customerStmt->execute()) {
            $customerResult = $customerStmt->get_result();

            while ($row = $customerResult->fetch_assoc()) {
                $bookedSlots[] = [
                    'from' => $row['selected_time'],
                    'to' => $row['selected_time_to'],
                ];
            }
        }

        if ($advanceStmt->execute()) {
            $advanceResult = $advanceStmt->get_result();

            while ($row = $advanceResult->fetch_assoc()) {
                $bookedSlots[] = [
                    'from' => $row['selected_time'],
                    'to' => $row['selected_time_to'],
                ];
            }
        }

        // Respond with JSON
        echo json_encode($bookedSlots);
    } else {
        // Respond with an error message
        echo json_encode(['error' => 'Invalid data.']);
    }
} else {
    // Respond with an error message
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
