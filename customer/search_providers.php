<?php
session_start();
// Include your database connection file
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    // SQL query to fetch provider suggestions based on the search term
    $sql = "SELECT DISTINCT pr.*
            FROM provider_registration pr
            JOIN provider_services ps ON pr.id = ps.provider_id
            WHERE ps.services LIKE ? OR pr.fullname LIKE ?";

    $stmt = $conn->prepare($sql);
    $searchPattern = "%$searchTerm%";
    $stmt->bind_param("ss", $searchPattern, $searchPattern);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            // Output or store the information as needed
            echo '<div class="provider-result">';
            echo "Provider ID: {$row['id']}, Fullname: {$row['fullname']}, Profile Picture: {$row['profile_picture']}, Address: {$row['address']}";
            echo '</div>';
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    $stmt->close();
}
?>
<style>
    .provider-result {
    margin-bottom: 10px;
    /* Add other styles as needed */
}

</style>