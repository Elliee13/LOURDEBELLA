<?php
require ('../../db.php');

// Fetch Core Services
$sql_core_services = "SELECT * FROM core_services";
$result_core_services = $conn->query($sql_core_services);

// Check if core services are found
if ($result_core_services->num_rows > 0) {
    echo '<div class="addon-services-container">
            <div class="addon-services-header">
                <h3 class="addon-services-title">Add-on Services</h3>
                <h5 class="addon-services-subtitle">(Starting at $100 and up — based on scope)</h5>
            </div>
            <div class="addon-services-grid">';

    while ($row = $result_core_services->fetch_assoc()) {
        echo '<div class="addon-service-item">
                <div class="addon-service-header">
                    <span class="addon-icon">🔸</span>
                    <span class="addon-service-name">' . htmlspecialchars($row['service_name']) . '</span>
                </div>
                <div class="addon-service-content">
                    <p class="addon-service-description">' . htmlspecialchars($row['note_description']) . '</p>
                </div>
              </div>';
    }

    echo '</div></div>';
} else {
    echo "<p>No core services found.</p>";
}

$conn->close();
?>