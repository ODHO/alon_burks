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
        $sql = "SELECT selected_date, selected_time, selected_time_to FROM customer_proposal WHERE provider_id = ? AND selected_date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $providerId, $selectedDate);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $bookedSlots = [];

            while ($row = $result->fetch_assoc()) {
                // If the selected_date or selected_time is an array, explode it
                $dateArray = is_array($row['selected_date']) ? $row['selected_date'] : explode(',', $row['selected_date']);
                $fromArray = is_array($row['selected_time']) ? $row['selected_time'] : explode(',', $row['selected_time']);
                $toArray = is_array($row['selected_time_to']) ? $row['selected_time_to'] : explode(',', $row['selected_time_to']);
                
                foreach ($dateArray as $key => $date) {
                    $bookedSlots[] = [
                        'date' => $date,
                        'from' => $fromArray[$key],
                        'to' => $toArray[$key],
                    ];
                    // echo json_decode($bookedSlots);
                    // die();
                }
            }

            print_r(json_encode($bookedSlots));
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
