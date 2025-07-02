<?php
require ('../../../db.php'); // Include database connection

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = '';

// Handle form submission for updating service
if (isset($_POST['update_service'])) {
    $tier_name = $_POST['tier_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $services = $_POST['services'];
    $icon = $_POST['icon'];
    $cta_url = $_POST['cta_url'];
    $cta_text = $_POST['cta_text'];

    $sql = "UPDATE services SET tier_name=?, price=?, description=?, services=?, icon=?, cta_url=?, cta_text=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $tier_name, $price, $description, $services, $icon, $cta_url, $cta_text, $service_id);
    
    if ($stmt->execute()) {
        $message = "<p class='message success'>Service updated successfully!</p>";
    } else {
        $message = "<p class='message error'>Error updating service: " . $conn->error . "</p>";
    }
    
    $stmt->close();
}

// Fetch service data for editing
if ($service_id > 0) {
    $sql = "SELECT * FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
    } else {
        die("Service not found.");
    }
    
    $stmt->close();
} else {
    die("Invalid service ID.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 20px;
            max-width: 900px;
            margin: auto;
        }
        h1 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 10px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #007cba;
            font-weight: bold;
            font-size: 1rem;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .message {
            padding: 8px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .message.success {
            background-color: #e0f9e0;
            color: #4CAF50;
        }
        .message.error {
            background-color: #f9e0e0;
            color: #f44336;
        }
        .form-group {
            margin-bottom: 12px;
        }
        label {
            display: block;
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 90px;
        }
        input[type="url"] {
            padding-right: 30px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }
        button {
            padding: 10px 18px;
            font-size: 1rem;
            background-color: #007cba;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #005a85;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        @media (max-width: 600px) {
            .form-group {
                margin-bottom: 10px;
            }
            button {
                width: 100%;
                padding: 12px;
                font-size: 1.1rem;
            }
            .btn-group {
                flex-direction: column;
                width: 100%;
            }
            .btn-group button {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

<a href="/LOURDEBELLA/src/admin/admin.php" class="back-link">← Back to Admin Panel</a>

<h1>Edit Service</h1>

<!-- Display success or error message -->
<?php if ($message) { ?>
    <?php echo $message; ?>
<?php } ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="tier_name">Tier Name:</label>
        <input type="text" id="tier_name" name="tier_name" value="<?php echo htmlspecialchars($service['tier_name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($service['price']); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="services">Services:</label>
        <textarea id="services" name="services" required><?php echo htmlspecialchars($service['services']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="icon">Icon:</label>
        <input type="text" id="icon" name="icon" value="<?php echo htmlspecialchars($service['icon']); ?>">
    </div>

    <div class="form-group">
        <label for="cta_url">CTA URL:</label>
        <input type="url" id="cta_url" name="cta_url" value="<?php echo htmlspecialchars($service['cta_url']); ?>">
    </div>

    <div class="form-group">
        <label for="cta_text">CTA Text:</label>
        <input type="text" id="cta_text" name="cta_text" value="<?php echo htmlspecialchars($service['cta_text']); ?>">
    </div>

    <div class="btn-group">
        <button type="submit" name="update_service">Update Service</button>
        <button type="button" class="btn-secondary" onclick="window.location.href='/LOURDEBELLA/src/admin/admin.php'">Cancel</button>
    </div>
</form>

</body>
</html>
