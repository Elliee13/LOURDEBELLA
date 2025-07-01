<?php
require ('../../../db.php'); // Include database connection

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($service_id > 0) {
    // First, fetch the service details to show what's being deleted
    $sql_fetch = "SELECT tier_name FROM services WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $service_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    
    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        $service_name = $service['tier_name'];
        
        // Delete the service
        $sql_delete = "DELETE FROM services WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $service_id);
        
        if ($stmt_delete->execute()) {
            $message = "Service '{$service_name}' has been deleted successfully.";
            $success = true;
        } else {
            $message = "Error deleting service: " . $conn->error;
            $success = false;
        }
        
        $stmt_delete->close();
    } else {
        $message = "Service not found.";
        $success = false;
    }
    
    $stmt_fetch->close();
} else {
    $message = "Invalid service ID.";
    $success = false;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Service</title>
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
            background-color: #007cba; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 10px; 
        }
        .btn:hover { 
            background-color: #005a85; 
        }
        .countdown {
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>

<h1>Delete Service</h1>

<div class="message <?php echo $success ? 'success' : 'error'; ?>">
    <?php echo htmlspecialchars($message); ?>
</div>

<a href="admin.php" class="btn">Return to Admin Panel</a>

<div class="countdown">
    <p>You will be automatically redirected to the admin panel in <span id="countdown">5</span> seconds.</p>
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

</body>
</html>