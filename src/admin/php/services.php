<?php
require ('../../db.php');

// Query to fetch service details
$sql = "SELECT * FROM services";
$result = $conn->query($sql);

// Check if there are services in the database
if ($result->num_rows > 0) {
    // Fetch and display service boxes dynamically
    while($row = $result->fetch_assoc()) {
        // Dynamically display each service box with intact HTML structure
        echo '
            <div class="service-box ' . ($row['tier_name'] == 3 ? 'third-service-box' : '') . '">
                <h3>' . $row['icon'] . ' ' . $row['tier_name'] . ' – ' . $row['price'] . '  </h3>
                <div class="service-content">
                    <p>' . $row['description'] . '</p>
                    <p class="description-two">' . $row['description_two'] . '</p>
                    <ul class="service-list">';
                    
                    // Split and display services dynamically
                    $services = explode(",", $row['services']); // assuming services are stored as comma-separated list
                    foreach ($services as $service) {
                        echo '<li>' . $service . '</li>';
                    }
                    
                    echo '
                    <p class="description-bottom">' . $row['description_bottom'] . '</p>
                    </ul>
                    <div class="service-actions">
                        <a href="' . $row['cta_url'] . '" target="_blank" class="btn btn-outline">' . $row['cta_text'] . '</a>
                    </div>
                </div>
            </div>';
    }
} else {
    echo "<p>No services available</p>";
}

$conn->close();
?>
