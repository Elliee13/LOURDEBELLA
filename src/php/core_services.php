<?php
require ('../../db.php');

// Fetch Core Services
$sql_core_services = "SELECT * FROM core_services"; // Assuming you have a table for core services
$result_core_services = $conn->query($sql_core_services);

// Fetch 'Why Lourdebella' text
$sql_why_lourdebella = "SELECT * FROM why_lourdebella WHERE id = 1"; // Assuming one record for the 'Why' section
$result_why_lourdebella = $conn->query($sql_why_lourdebella);

// Check if core services are found
if ($result_core_services->num_rows > 0) {
    // Output the core services dynamically
    echo '<div class="core-services">
            <h3 style="color: white; font-size: 22px; font-weight: 700; margin-bottom: 20px;">Our Core Services</h3>
            <div style="display: grid; gap: 12px; font-size: 16px;">';

    while ($row = $result_core_services->fetch_assoc()) {
        echo '<div class="service-item">
                <span class="icon">✔️</span>
                <span>' . htmlspecialchars($row['service_name']) . '</span>
              </div>';
    }

    echo '</div></div>';
} else {
    echo "<p>No core services found.</p>";
}

// Check if 'Why Lourdebella' content is available
if ($result_why_lourdebella->num_rows > 0) {
    $why_row = $result_why_lourdebella->fetch_assoc();
    echo '<div class="why-lourdebella">
            <h2>' . htmlspecialchars($why_row['title']) . '</h2>
            <p>' . nl2br(htmlspecialchars($why_row['content'])) . '</p>
          </div>';
} else {
    echo "<p>Why Lourdebella content not available.</p>";
}

$conn->close();
?>
