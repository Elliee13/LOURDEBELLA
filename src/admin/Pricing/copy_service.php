<?php
require ('../../../db.php'); // Include database connection

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($service_id > 0) {
    // Fetch the service to be copied
    $sql_fetch = "SELECT * FROM services WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $service_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    
    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        
        // Create a copy with modified tier name
        $new_tier_name = $service['tier_name'] . ' (Copy)';
        
        $sql_copy = "INSERT INTO services (tier_name, price, description, services, icon, cta_url, cta_text) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_copy = $conn->prepare($sql_copy);
        $stmt_copy->bind_param("sssssss", 
            $new_tier_name, 
            $service['price'], 
            $service['description'], 
            $service['services'], 
            $service['icon'], 
            $service['cta_url'], 
            $service['cta_text']
        );
        
        if ($stmt_copy->execute()) {
            $new_service_id = $conn->insert_id;
            $message = "Service '{$service['tier_name']}' has been copied successfully as '{$new_tier_name}'.";
            $success = true;
        } else {
            $message = "Error copying service: " . $conn->error;
            $success = false;
            $new_service_id = null;
        }
        
        $stmt_copy->close();
    } else {
        $message = "Service not found.";
        $success = false;
        $new_service_id = null;
    }
    
    $stmt_fetch->close();
} else {
    $message = "Invalid service ID.";
    $success = false;
    $new_service_id = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy Service</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            max-width: 600px; 
            margin: 50px auto; 
            text-align: center; 
        }
        .message { 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 5px; 
            font-size: 18px; 
        }
        .success { 
            background-color: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .error { 
            background-color: #f8d7da; 
            color: #721c24; 
            border: 1px solid #f5c6cb; 
        }
        .btn { 
            display: inline-block; 
            padding: 12px 20px; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 10px; 
        }
        .btn-primary { 
            background-color: #007cba; 
        }
        .btn-primary:hover { 
            background-color: #005a85; 
        }
        .btn-secondary { 
            background-color: #6c757d; 
        }
        .btn-secondary:hover { 
            background-color: #545b62; 
        }
        .countdown {
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }
        .actions {
            margin: 30px 0;
        }
    </style>
</head>
<body>

<h1>Copy Service</h1>

<div class="message <?php echo $success ? 'success' : 'error'; ?>">
    <?php echo htmlspecialchars($message); ?>
</div>

<div class="actions">
    <?php if ($success && $new_service_id): ?>
        <a href="edit_service.php?id=<?php echo $new_service_id; ?>" class="btn btn-primary">Edit Copied Service</a>
    <?php endif; ?>
    <a href="admin.php" class="btn btn-secondary">Return to Admin Panel</a>
</div>

<?php if ($success): ?>
<div class="countdown">
    <p>You will be automatically redirected to the admin panel in <span id="countdown">5</span> seconds.</p>
    <p><small>Click "Edit Copied Service" above to modify the copied service immediately.</small></p>
</div>

<script>
// Auto-redirect after 5 seconds
let countdown = 5;
const countdownElement = document.getElementById('countdown');

const timer = setInterval(function() {
    countdown--;
    countdownElement.textContent = countdown;
    
    if (countdown <= 0) {
        clearInterval(timer);
        window.location.href = 'admin.php';
    }
}, 1000);
</script>
<?php endif; ?>

</body>
</html>