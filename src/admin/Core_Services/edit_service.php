<?php
require ('../../../db.php'); // Include database connection

// Check if the service ID is set in the URL
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];

    // Fetch the service to be edited
    $sql = "SELECT * FROM core_services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    $stmt->close();
}

// Check if the form has been submitted to update the service
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_service'])) {
    // Get the updated service name
    $updated_name = $_POST['service_name'];

    // Update the service in the database
    $sql = "UPDATE core_services SET service_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $updated_name, $service_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to admin page after update
    header('Location: /LOURDEBELLA/src/admin/admin.php');
    exit();
}

?>

<h3>Edit Service</h3>
<form method="POST" action="edit_service.php?id=<?php echo $service_id; ?>">
    <label for="service_name">Service Name</label>
    <input type="text" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
    <button type="submit" name="update_service">Update Service</button>
</form>
