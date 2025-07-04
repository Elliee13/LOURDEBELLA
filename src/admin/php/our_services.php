<?php
// Include database connection
require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/db.php');

// Fetch all services from the services table
$sql_services = "SELECT * FROM our_services";
$result_services = $conn->query($sql_services);

if ($result_services->num_rows > 0) {
    while ($row = $result_services->fetch_assoc()) {

        // Decode the service list if it's stored as JSON
        $service_list = json_decode($row['service_list'], true);
        if ($service_list && is_array($service_list)) {
        } else {
            echo "<p>Service list is not in a valid JSON format or is empty.</p>";
        }
    }
}

// Close the database connection
$conn->close();
?>
