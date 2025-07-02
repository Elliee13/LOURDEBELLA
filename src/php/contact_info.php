<?php
// Absolute path to db.php
require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/src/admin/db.php');


// Fetch the current contact information from the database
function get_contact_info() {
    global $conn;
    $sql = "SELECT * FROM contact_info LIMIT 1";  // Assuming only one entry in the table
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();  // Return the contact info as an associative array
    } else {
        return null;  // Return null if no data found
    }
}

// Get contact information
$contact_info = get_contact_info();

// If no data is returned, show an error message (optional)
// You can also choose to handle this differently in your frontend (e.g., show a default message or redirect)
if (!$contact_info) {
    // Optionally, you can log or handle this scenario
    error_log("Error: Contact information not found.");
    $contact_info = [
        'email' => 'default@example.com',
        'phone' => '000-000-0000',
        'address' => 'Default Address',
        'cta_url' => 'https://defaultlink.com',
        'cta_text' => 'Default CTA'
    ];
}

// Close the connection
$conn->close();
?>
