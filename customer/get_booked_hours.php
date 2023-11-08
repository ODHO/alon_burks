<?php
// Include your database connection script
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data as JSON from the request body
    $postData = json_decode(file_get_contents('php://input'));

    if (isset($postData->providerId) && isset($postData->selectedDate)) {
        $providerId = $postData->providerId;
        $selectedDate = $postData->selectedDate;

        // Fetch already booked hours for the selected date
        $sql = "SELECT selected_time, selected_time_to FROM customer_proposal WHERE provider_id = ? AND selected_date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $providerId, $selectedDate);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $bookedHours = [];

            while ($row = $result->fetch_assoc()) {
                // Add the booked hours to the result array
                $bookedHours[] = [
                    'from' => $row['selected_time'],
                    'to' => $row['selected_time_to'],
                ];
            }

            echo json_encode($bookedHours);
        } else {
            echo 'Error executing the query.';
        }
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
