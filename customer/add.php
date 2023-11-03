<?php
session_start();
// Include your database connection script
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the `customerId`, `providerId`, and `images` are provided
    if (isset($_POST['customerId']) && isset($_POST['providerId']) && isset($_FILES['images'])) {
        // Extract `customerId` and `providerId`
        $customerId = $_POST['customerId'];
        $providerId = $_POST['providerId'];
        $proposalId = $_SESSION['proposal_id'];
        // Start a transaction
        $conn->begin_transaction();

        // Loop through the uploaded images
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $imagePath = 'uploads/' . $_FILES['images']['name'][$key];

            // Move the image to a directory on the server
            if (move_uploaded_file($tmp_name, $imagePath)) {
                // Insert image information into the customer_images table
                $imageSql = "INSERT INTO customer_images (customer_id, provider_id, proposal_id, image_path) VALUES (?, ?, ?, ?)";
                $imageStmt = $conn->prepare($imageSql);
                $imageStmt->bind_param('ssss', $customerId, $providerId, $proposalId,  $imagePath);
                
                // Execute the image statement
                if (!$imageStmt->execute()) {
                    // Roll back the transaction in case of errors
                    $conn->rollback();
                    echo 'Error inserting image data.';
                    exit;
                }
            } else {
                // Roll back the transaction in case of errors
                $conn->rollback();
                echo 'Error moving image file to the server.';
                exit;
            }
        }

        // Commit the transaction if all operations succeed
        $conn->commit();
        echo 'Images inserted successfully.';
        $_SESSION['proposal_id'] = NULL;
    } else {
        echo 'Invalid data.';
    }
} else {
    echo 'Invalid request method.';
}
?>
