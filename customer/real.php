<?php
// Include your database connection script
include 'connection.php';

// Function to get provider services by provider ID
function getProviderServices($conn, $provider_id)
{
    // Sanitize the input to prevent SQL injection
    $provider_id = mysqli_real_escape_string($conn, $provider_id);

    // Retrieve provider services from the database using the provider ID
    $sql = "SELECT * FROM provider_services WHERE provider_id = '$provider_id'";
    $result = $conn->query($sql);

    $services = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }

    return $services;
}

// Initialize variables
$provider_id = ""; // You need to get the provider ID from somewhere (e.g., query parameter)

// Check if 'id' query parameter is set (provider_registration table ID)
if (isset($_GET['id'])) {
    $provider_id = $_GET['id'];
    $providerServices = getProviderServices($conn, $provider_id);

    // Now, $providerServices contains an array of provider services for the given provider ID.
    // You can loop through $providerServices to display the data or use it as needed.
    foreach ($providerServices as $service) {
        $serviceName = $service['service_name'];
        $serviceDescription = $service['service_description'];
        
        // Display or process the service data as needed
        echo "<h2>Service Name: $serviceName</h2>";
        echo "<p>Service Description: $serviceDescription</p>";
    }
}

?>