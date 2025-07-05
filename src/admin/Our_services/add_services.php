<?php
require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/db.php');

// Check if form is submitted to add service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_service'])) {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    
    // Check if service_list is provided and process it as a comma-separated string
    if (isset($_POST['service_list']) && !empty($_POST['service_list'])) {
        $service_list = $_POST['service_list'];
        $service_list_array = explode(",", $service_list);
        $service_list_array = array_map('trim', $service_list_array);
        $service_list = json_encode($service_list_array);
    } else {
        $service_list = json_encode([]); // Default to an empty array if no services are provided
    }

    $custom_note = $_POST['custom_note'];
    $book_call_link = $_POST['book_call_link'];

    // Validate that service name is not empty
    if (!empty($service_name)) {
        // Insert the new service into the database
        $sql = "INSERT INTO our_services (service_name, description, service_list, custom_note, book_call_link) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $service_name, $description, $service_list, $custom_note, $book_call_link);

        if ($stmt->execute()) {
            echo "<script>alert('New service added successfully!'); window.location.href='../admin.php';</script>";
        } else {
            echo "<script>alert('Error adding service: " . $conn->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Service name cannot be empty.');</script>";
    }
}
?>
