<?php
// Include database connection
require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/db.php');

// Insert the new service if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $service_name = $_POST['service_name'];

    // Check if the service name is not empty
    if (!empty($service_name)) {
        // Prepare SQL statement to insert the new service
        $sql = "INSERT INTO core_services (service_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $service_name);
        
        if ($stmt->execute()) {
            // Success message (optional, can be removed)
            echo "<script>alert('New core service added successfully!');</script>";
            
            // Redirect after success to prevent resubmission
            header("Location: admin.php"); // Redirect to the same page
            exit; // Make sure no further code is executed
        } else {
            // Error message (optional, can be removed)
            echo "<script>alert('Error adding service: " . $conn->error . "');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Service name cannot be empty.');</script>";
    }
}

// Fetch the list of core services from the database
$sql_core_services = "SELECT * FROM core_services";
$result_core_services = $conn->query($sql_core_services);

?>
