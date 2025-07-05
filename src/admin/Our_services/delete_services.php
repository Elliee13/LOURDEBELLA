a<?php
require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/db.php');

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];

    // Prepare the delete SQL statement
    $sql = "DELETE FROM our_services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);

    // Execute the statement
    if ($stmt->execute()) {
        // If deletion is successful, redirect with a success message
        echo "<script>alert('Service deleted successfully!'); window.location.href='../admin.php';</script>";
    } else {
        // If there's an error, display an error message
        echo "<script>alert('Error deleting service: " . $conn->error . "'); window.location.href='../admin.php';</script>";
    }

    // Close the statement
    $stmt->close();
} else {
    // If no ID is provided, redirect back with an error
    echo "<script>alert('No service ID provided.'); window.location.href='../admin.php';</script>";
}

$conn->close();
?>
