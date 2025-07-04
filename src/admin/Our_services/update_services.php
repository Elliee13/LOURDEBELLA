<?php
session_start();  // Start the session

require ($_SERVER['DOCUMENT_ROOT'] . '/LOURDEBELLA/db.php');

// Fetching service details for the service ID
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    $sql = "SELECT * FROM our_services WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
    } else {
        echo "<script>alert('Service not found.'); window.location.href='../admin.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Service ID is missing.'); window.location.href='../admin.php';</script>";
}

// Update Service Logic
if (isset($_POST['update_service'])) {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    
    // Decode the existing service list
    $service_list = json_decode($service['service_list'], true);

    // Add new services from the input
    if (isset($_POST['new_service']) && !empty($_POST['new_service'])) {
        $new_services = explode(",", $_POST['new_service']); // Split new services by commas
        $new_services = array_map('trim', $new_services); // Clean up spaces around items
        $service_list = array_merge($service_list, $new_services); // Add to the existing list
    }

    // Remove selected services
    if (isset($_POST['remove_service']) && !empty($_POST['remove_service'])) {
        $service_list = array_diff($service_list, $_POST['remove_service']); // Remove selected services
    }

    // Avoid null or empty service list
    if (empty($service_list)) {
        $service_list = [];  // Ensure the list is empty if no services remain
    }

    $service_list = json_encode(array_values($service_list));  // Re-encode the updated service list

    $custom_note = $_POST['custom_note'];
    $book_call_link = $_POST['book_call_link'];

    // Update the service in the database
    $sql = "UPDATE our_services SET service_name=?, description=?, service_list=?, custom_note=?, book_call_link=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $service_name, $description, $service_list, $custom_note, $book_call_link, $service_id);

    if ($stmt->execute()) {
        // Set session variable to indicate success
        $_SESSION['update_success'] = true;
    } else {
        // Set session variable to indicate error
        $_SESSION['update_success'] = false;
    }
    $stmt->close();
}

// Delete Service Logic
if (isset($_POST['delete_service'])) {
    $sql = "DELETE FROM our_services WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);

    if ($stmt->execute()) {
        echo "<script>alert('Service deleted successfully!'); window.location.href='../admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting service: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Service</title>
    <link rel="stylesheet" href="update_services.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="../admin.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Go Back
                </a>
                <h2><i class="fas fa-edit"></i> Update Service</h2>
            </div>
            <div class="card-body">
                <!-- Display Success or Error Message -->
                <?php if (isset($_SESSION['update_success'])): ?>
                    <?php if ($_SESSION['update_success']): ?>
                        <div class="alert alert-success" id="success-message">
                            <i class="fas fa-check-circle"></i> Service updated successfully!
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger" id="error-message">
                            <i class="fas fa-exclamation-circle"></i> Error updating service!
                        </div>
                    <?php endif; ?>
                    <?php unset($_SESSION['update_success']); ?>
                <?php endif; ?>

                <form method="POST" action="update_services.php?id=<?php echo $service['id']; ?>">
                    <div class="form-group">
                        <label for="service_name" class="form-label">
                            <i class="fas fa-tag"></i> Service Name
                        </label>
                        <input type="text" id="service_name" name="service_name" class="form-control" 
                               value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left"></i> Description
                        </label>
                        <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <div class="section-title">
                            <i class="fas fa-list"></i> Current Services
                        </div>
                        <div class="service-list">
                            <?php
                                $service_list = json_decode($service['service_list']);
                                if (!empty($service_list)) {
                                    foreach ($service_list as $service_item) {
                                        echo '<div class="service-item">
                                                <span class="service-text">' . htmlspecialchars($service_item) . '</span>
                                                <div class="remove-section">
                                                    <input type="checkbox" id="remove_' . md5($service_item) . '" 
                                                           name="remove_service[]" value="' . htmlspecialchars($service_item) . '" 
                                                           class="remove-checkbox">
                                                    <label for="remove_' . md5($service_item) . '" class="remove-label">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </label>
                                                </div>
                                              </div>';
                                    }
                                } else {
                                    echo '<div class="empty-state">
                                            <i class="fas fa-inbox"></i><br>
                                            No services available
                                          </div>';
                                }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_service" class="form-label">
                            <i class="fas fa-plus"></i> Add New Services
                        </label>
                        <input type="text" id="new_service" name="new_service" class="form-control" 
                               placeholder="Enter new services separated by commas">
                    </div>

                    <div class="form-group">
                        <label for="custom_note" class="form-label">
                            <i class="fas fa-sticky-note"></i> Custom Note
                        </label>
                        <input type="text" id="custom_note" name="custom_note" class="form-control" 
                               value="<?php echo htmlspecialchars($service['custom_note']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="book_call_link" class="form-label">
                            <i class="fas fa-link"></i> Book Call Link
                        </label>
                        <input type="url" id="book_call_link" name="book_call_link" class="form-control" 
                               value="<?php echo htmlspecialchars($service['book_call_link']); ?>" required>
                    </div>

                    <div class="btn-group">
                        <button type="submit" name="update_service" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Service
                        </button>
                    </div>
                </form>

                <div class="delete-section">
                    <div class="section-title">
                        <i class="fas fa-exclamation-triangle"></i> Danger Zone
                    </div>
                    <form method="POST" action="update_services.php?id=<?php echo $service['id']; ?>" 
                          onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                        <button type="submit" name="delete_service" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide the success/error message after 4 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            
            if (successMessage) {
                successMessage.style.opacity = '0';
                successMessage.style.transition = 'opacity 0.5s ease';
                setTimeout(() => successMessage.style.display = 'none', 500);
            }
            
            if (errorMessage) {
                errorMessage.style.opacity = '0';
                errorMessage.style.transition = 'opacity 0.5s ease';
                setTimeout(() => errorMessage.style.display = 'none', 500);
            }
        }, 4000);

        // Smooth page reload after successful update
        <?php if (isset($_SESSION['update_success']) && $_SESSION['update_success'] === true): ?>
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        <?php endif; ?>

        // Add visual feedback for checkbox interactions
        document.querySelectorAll('.remove-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const serviceItem = this.closest('.service-item');
                if (this.checked) {
                    serviceItem.style.opacity = '0.6';
                    serviceItem.style.background = '#fef2f2';
                } else {
                    serviceItem.style.opacity = '1';
                    serviceItem.style.background = 'white';
                }
            });
        });
    </script>
</body>
</html>