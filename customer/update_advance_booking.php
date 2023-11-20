<?php
session_start();

// Include your database connection file
include_once 'connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the POST request
    $proposalId = $_POST['proposalId'];
    $selectedDate = $_POST['selectedDate'];
    $selectedDateRef = $_POST['selectedDateRef'];
    $selectedTimeFrom = $_POST['selectedTimeFrom'];
    $selectedTimeFromRef = $_POST['selectedTimeFromRef'];
    $selectedTimeTo = $_POST['selectedTimeTo'];
    $selectedTimeToRef = $_POST['selectedTimeToRef'];
    $customerId = $_POST['customerId'];
    $providerId = $_POST['providerId'];

    // Validate and sanitize the data (you should perform more thorough validation)
    $selectedDate = mysqli_real_escape_string($conn, $selectedDate);
    $selectedDateRef = mysqli_real_escape_string($conn, $selectedDateRef);
    $selectedTimeFrom = mysqli_real_escape_string($conn, $selectedTimeFrom);
    $selectedTimeFromRef = mysqli_real_escape_string($conn, $selectedTimeFromRef);
    $selectedTimeTo = mysqli_real_escape_string($conn, $selectedTimeTo);
    $selectedTimeToRef = mysqli_real_escape_string($conn, $selectedTimeToRef);
    $customerId = mysqli_real_escape_string($conn, $customerId);
    $providerId = mysqli_real_escape_string($conn, $providerId);

    // Update the database with the new advance booking timings
    $query = "UPDATE advance_proposal SET selected_date='$selectedDate', selected_time='$selectedTimeFrom', selected_time_to='$selectedTimeTo' WHERE proposal_id='$proposalId' AND selected_date='$selectedDateRef'";

    if (mysqli_query($conn, $query)) {
        // The update was successful
        echo json_encode(['status' => 'success', 'message' => 'Advance booking timings updated successfully']);
    } else {
        // The update failed
        echo json_encode(['status' => 'error', 'message' => 'Failed to update advance booking timings']);
    }
} else {
    // Handle cases where the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the database connection
mysqli_close($conn);
?>
