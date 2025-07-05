<?php
require ('../../../db.php'); // Include database connection

// Fetch all services from the services table
$sql_core_services = "SELECT * FROM core_services";
$result_core_services = $conn->query($sql_core_services);

// Initialize variables
$service = null;
$error_message = '';
$success_message = '';

// Check if the service ID is set in the URL
if (isset($_GET['id'])) {
    $service_id = intval($_GET['id']);

    // Fetch the service to be edited
    $sql = "SELECT * FROM core_services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    $stmt->close();
    
    // If service not found, redirect back
    if (!$service) {
        header('Location: /LOURDEBELLA/src/admin/admin.php?error=service_not_found');
        exit();
    }
} else {
    // No ID provided, redirect back
    header('Location: /LOURDEBELLA/src/admin/admin.php?error=no_id');
    exit();
}

// Check if the form has been submitted to update the service
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_service'])) {
    // Validate and sanitize input
    $updated_name = trim($_POST['service_name']);
    
    // Server-side validation
    if (empty($updated_name)) {
        $error_message = 'Service name is required.';
    } elseif (strlen($updated_name) < 2) {
        $error_message = 'Service name must be at least 2 characters long.';
    } elseif (strlen($updated_name) > 100) {
        $error_message = 'Service name must not exceed 100 characters.';
    } else {
        // Check if the service name already exists (excluding current service)
        $check_sql = "SELECT id FROM core_services WHERE service_name = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $updated_name, $service_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error_message = 'A service with this name already exists.';
        } else {
            // Update the service in the database
            $sql = "UPDATE core_services SET service_name = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $updated_name, $service_id);
            
            if ($stmt->execute()) {
                $stmt->close();
                $check_stmt->close();
                // Redirect to admin page after successful update
                header('Location: /LOURDEBELLA/src/admin/admin.php?success=service_updated');
                exit();
            } else {
                $error_message = 'Error updating service. Please try again.';
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_services.css">
    <title>Edit Service - Admin Panel</title>
</head>
<body>
    <div class="form-container">
        <a href="../admin.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
        <div class="form-header">
            <!-- Core Services Section -->
            <div id="core-services" class="section-content">
                
                <div class="card">
                    <div class="card-header">
                        <h2>Manage Core Services</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="services-table">
                                <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result_core_services->fetch_assoc()) { ?>
                                        <tr>
                                            <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                                            <td>
                                                <a href="edit_service.php?id=<?php echo $row['id']; ?>" class="update-button edit">Update</a>
                                                <a href="delete_service.php?id=<?php echo $row['id']; ?>" class="delete-button delete" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="form-title">Edit Service</h1>
            <p class="form-subtitle">Update service information</p>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="edit_service.php?id=<?php echo $service_id; ?>" id="editServiceForm">
            <div class="form-group">
                <label for="service_name" class="form-label">Service Name</label>
                <input 
                    type="text" 
                    id="service_name" 
                    name="service_name" 
                    class="form-input <?php echo !empty($error_message) ? 'error' : ''; ?>"
                    value="<?php echo htmlspecialchars($service['service_name']); ?>" 
                    required
                    maxlength="100"
                    placeholder="Enter service name"
                >
                <div class="char-counter" id="charCounter">
                    <span id="currentCount">0</span> / 100
                </div>
                <div class="validation-message" id="validationMessage">
                    Service name must be between 2 and 100 characters
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="goBack()">
                    Cancel
                </button>
                <button type="submit" name="update_service" class="btn btn-primary" id="submitBtn">
                    Update Service
                </button>
            </div>
        </form>
    </div>

    <script>
        // Form validation and interaction
        const form = document.getElementById('editServiceForm');
        const serviceNameInput = document.getElementById('service_name');
        const charCounter = document.getElementById('charCounter');
        const currentCount = document.getElementById('currentCount');
        const validationMessage = document.getElementById('validationMessage');
        const submitBtn = document.getElementById('submitBtn');

        // Character counter
        function updateCharCounter() {
            const length = serviceNameInput.value.length;
            currentCount.textContent = length;
            
            charCounter.className = 'char-counter';
            if (length > 80) charCounter.classList.add('warning');
            if (length > 95) charCounter.classList.add('danger');
        }

        // Form validation
        function validateForm() {
            const value = serviceNameInput.value.trim();
            const isValid = value.length >= 2 && value.length <= 100;
            
            if (!isValid) {
                validationMessage.classList.add('show');
                submitBtn.disabled = true;
                serviceNameInput.classList.add('error');
            } else {
                validationMessage.classList.remove('show');
                submitBtn.disabled = false;
                serviceNameInput.classList.remove('error');
            }
            
            return isValid;
        }

        // Event listeners
        serviceNameInput.addEventListener('input', function() {
            updateCharCounter();
            validateForm();
        });

        // Go back function
        function goBack() {
            if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                window.location.href = '/LOURDEBELLA/src/admin/admin.php';
            }
        }

        // Initialize
        updateCharCounter();
        validateForm();

        // Auto-focus on input
        serviceNameInput.focus();
        serviceNameInput.setSelectionRange(serviceNameInput.value.length, serviceNameInput.value.length);
    </script>
</body>
</html>