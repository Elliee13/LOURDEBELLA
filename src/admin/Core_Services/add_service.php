<?php
// Include database connection
require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_service'])) {
    // Sanitize and validate the input data
    $service_name = trim($_POST['service_name']);
    $note_description = trim($_POST['note_description']);

    // Basic validation
    if (empty($service_name) || empty($note_description)) {
        echo "Service name and description are required!";
        exit();
    }

    // Insert the new service into the database
    $sql = "INSERT INTO core_services (service_name, note_description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $service_name, $note_description);
    
    if ($stmt->execute()) {
        // Redirect back to the admin page with success message
        header("Location: /LOURDEBELLA/src/admin/admin.php?success=service_added");
        exit();
    } else {
        echo "Error adding service: " . $stmt->error;
    }

    $stmt->close();
}
?>
