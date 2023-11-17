<?php
// Include your database connection script
session_start();
include 'connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data as JSON from the request body
    $postData = json_decode(file_get_contents('php://input'));

    // Validate the data
    if (
        isset($postData->customerId) &&
        isset($postData->providerId) &&
        isset($postData->selectedDate) &&
        isset($postData->selectedTime) &&
        isset($postData->userContent) &&
        isset($postData->selectedServices) &&
        isset($postData->totalAmount) &&
        isset($postData->statusFrom) &&
        isset($postData->selectedTimeTo) &&
        isset($postData->proposal_status) &&
        !empty($postData->messageContent) 
    ) {
        // Extract customer ID, provider ID, selected date, selected time, user content, selected services, and total amount
        $customerId = $postData->customerId;
        $providerId = $postData->providerId;
        $selectedDate = $postData->selectedDate;
        $selectedTime = $postData->selectedTime;
        $userContent = $postData->userContent;
        $selectedServices = $postData->selectedServices;//implode(', ',$postData->selectedServices);
        $totalAmount = $postData->totalAmount;
        $statusFrom = $postData->statusFrom;
        $selectedTimeTo = $postData->selectedTimeTo;
        $proposal_status = $postData->proposal_status;
        $messageContent = $postData->messageContent;
        // echo $selectedTimeTo;
        // die();
        // Start a database transaction
        $conn->begin_transaction();

        // Insert data into your customer_proposal table
        $sql = "INSERT INTO customer_proposal (customer_id, provider_id, selected_date, selected_time, user_content, selected_services, total_amount, selected_time_to, proposal_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $servicename = array();
        foreach($selectedServices as $val) {
            $servicename[] = $val->serviceName;
        }
        print_r($selectedServices);
        // die();
        $serviceNames  = implode(', ',$servicename);
        $stmt->bind_param('ssssssdss', $customerId, $providerId, $selectedDate, $selectedTime, $userContent, $serviceNames, $totalAmount, $selectedTimeTo, $proposal_status);
        // $abc = $sql = "INSERT INTO customer_proposal (customer_id, provider_id, selected_date, selected_time, user_content, selected_services, total_amount, selected_time_to) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        // print_r($selectedTimeTo);
        // die();
        if ($stmt->execute()) {
            $proposalId = $stmt->insert_id; // Get the generated proposal_id

            // Now, you can insert data into customer_services using the generated proposalId
            foreach ($selectedServices as $service) {
                $serviceId = json_encode($service->serviceId);
                $serviceName = json_decode(json_encode($service->serviceName));
                $price = json_decode(json_encode($service->price));

                // Insert data into customer_services with the proposal_id from customer_proposal
                $sql = "INSERT INTO customer_services (customer_id, provider_id, proposal_id, service_id, service_name, price, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssssssd', $customerId, $providerId, $proposalId, $serviceId, $serviceName, $price, $totalAmount);

                if ($stmt->execute()) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                $_SESSION['proposal_id'] = $proposalId;
            }

            // Insert data into the messages table
            $sql = "INSERT INTO messages (proposal_id, provider_id, customer_id, message_content, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('diiss', $proposalId, $providerId, $customerId, $messageContent, $statusFrom);

            if ($stmt->execute()) {
                echo "Message inserted into messages table successfully";
            } else {
                echo "Error inserting message: " . $stmt->error;
            }
            $conn->commit();
            echo 'Data inserted successfully.';
            echo $proposalId;
        } else {
            $conn->rollback();
            echo 'Error inserting data into customer_proposal: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
