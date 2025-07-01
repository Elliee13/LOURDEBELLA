<?php
require ('../../../db.php'); // Include database connection
// delete_service.php

if (isset($_GET['id'])) {
    $service_id = $_GET['id'];

    $sql = "DELETE FROM core_services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: admin.php'); // Redirect back to admin page
}
?>
