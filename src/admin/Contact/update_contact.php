<?php
require ('../../../db.php'); // Include database connection

// Check if the form is submitted
if (isset($_POST['update_contact'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $cta_url = $_POST['cta_url'];
    $cta_text = $_POST['cta_text'];

    // Update contact information in the database
    $sql_contact_update = "UPDATE contact_info SET email = ?, phone = ?, address = ?, cta_url = ?, cta_text = ? WHERE id = 1";
    $stmt_contact_update = $conn->prepare($sql_contact_update);
    $stmt_contact_update->bind_param("sssss", $email, $phone, $address, $cta_url, $cta_text);
    $stmt_contact_update->execute();
    $stmt_contact_update->close();

    // Redirect to the admin page after successful update
    header("Location: /LOURDEBELLA/src/admin/admin.php");
    exit(); // Ensure no further output after redirect
}

$conn->close();
?>
