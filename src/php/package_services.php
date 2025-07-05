<?php
require ('../../db.php');

// Query to fetch package services
$sql = "SELECT * FROM package_services";
$result = $conn->query($sql);

// Check if there are package services in the database
if ($result->num_rows > 0) {
    // Fetch and display package services dynamically
    while($row = $result->fetch_assoc()) {
        // Split services to determine layout
        $services = explode(",", $row['services']);
        $serviceCount = count($services);
        
        // Add class based on number of services for optimal spacing
        $boxClass = 'package-service-box';
        if ($serviceCount > 8) {
            $boxClass .= ' many-services';
        }
        
        echo '
            <div class="' . $boxClass . '">
                <div class="package-header">
                    <h3 class="package-title">' . htmlspecialchars($row['package_title']) . '</h3>
                    <h5 class="package-subtitle">' . htmlspecialchars($row['package_subtitle']) . '</h5>
                </div>
                <div class="package-content">
                    <p class="package-description">' . htmlspecialchars($row['package_description']) . '</p>
                    <div class="package-includes">
                        <h4>Includes:</h4>
                        <ul class="package-services-list' . ($serviceCount > 6 ? ' compact' : '') . '">';
                        
                        // Display services dynamically
                        foreach ($services as $service) {
                            $trimmedService = trim($service);
                            if (!empty($trimmedService)) {
                                echo '<li>' . htmlspecialchars($trimmedService) . '</li>';
                            }
                        }
                        
                        echo '
                        </ul>
                    </div>
                </div>
            </div>';
    }
} else {
    echo "<p>No package services available</p>";
}

$conn->close();
?>