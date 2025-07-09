<?php
require ('../../../db.php'); // Include database connection

// Debugging: Start session to collect errors and debug messages
session_start();
$_SESSION['debug'] = [];

// Function to log debug messages
function debug($message) {
    $_SESSION['debug'][] = $message;
}

// Add Service
if (isset($_POST['add'])) {
    $package_title = $_POST['package_title'];
    $package_subtitle = $_POST['package_subtitle'];
    $package_description = $_POST['package_description'];   
    $services = $_POST['services'];

    $sql = "INSERT INTO package_services (package_title, package_subtitle, package_description, services)
            VALUES ('$package_title', '$package_subtitle', '$package_description', '$services')";

    debug("Insert SQL: " . $sql);  // Debugging: Output the insert SQL query

    if ($conn->query($sql) === TRUE) {
        debug("New record created successfully");
        echo "New record created successfully";
    } else {
        debug("Error: " . $conn->error);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Service
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $package_title = $_POST['package_title'];
    $package_subtitle = $_POST['package_subtitle'];
    $package_description = $_POST['package_description'];
    $services = $_POST['services'];

    $sql = "UPDATE package_services SET package_title='$package_title', package_subtitle='$package_subtitle', 
            package_description='$package_description', services='$services' WHERE id=$id";

    debug("Update SQL: " . $sql);  // Debugging: Output the update SQL query

    if ($conn->query($sql) === TRUE) {
        debug("Record updated successfully");
        echo "Record updated successfully";
    } else {
        debug("Error: " . $conn->error);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Service
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM package_services WHERE id=$id";

    debug("Delete SQL: " . $sql);  // Debugging: Output the delete SQL query

    if ($conn->query($sql) === TRUE) {
        debug("Record deleted successfully");
        echo "Record deleted successfully";
    } else {
        debug("Error: " . $conn->error);
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Initialize the $services variable as an empty array
$services = [];

// Query to fetch services
$sql = "SELECT * FROM package_services"; // Replace 'your_table_name' with your actual table name

debug("Select SQL: " . $sql);  // Debugging: Output the select SQL query

$result = $conn->query($sql);

// Check if rows are returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row; // Populate the $services array
    }
    debug("Fetched " . count($services) . " rows");  // Debugging: How many rows were fetched
} else {
    debug("No data found.");  // Debugging: No rows returned
    echo "No data found.";  // Debugging output
}

// Output all debugging messages
echo "<pre>";
print_r($_SESSION['debug']);  // Debugging: Display all debug messages
echo "</pre>";

// Close the database connection
$conn->close();
?>
