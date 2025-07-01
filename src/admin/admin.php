<?php
require ('../../db.php'); // Include database connection

// Handle Add Core Service functionality
if (isset($_POST['add_service'])) {
    $service_name = $_POST['service_name']; 

    $sql = "INSERT INTO core_services (service_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $service_name);
    $stmt->execute();
    $stmt->close();

    echo "<p>Service added successfully!</p>";
}

// Fetch all services from the services table
$sql_services = "SELECT * FROM services";
$result_services = $conn->query($sql_services);

// Fetch all core services
$sql_core_services = "SELECT * FROM core_services";
$result_core_services = $conn->query($sql_core_services);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { display: inline-block; padding: 10px 15px; margin: 10px 0; text-decoration: none; background-color: #007cba; color: white; border-radius: 5px; }
        .btn-outline { background-color: transparent; border: 2px solid #007cba; color: #007cba; }
        .section { margin: 40px 0; }
        form { margin: 20px 0; }
        form label { display: block; margin: 10px 0 5px; }
        form input { padding: 8px; margin: 5px 0; width: 300px; }
        form button { padding: 10px 15px; background-color: #007cba; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

<h1>Admin Panel</h1>

<!-- Services Management Section -->
<div class="section">
    <h2>Manage Services</h2>
    <!-- Table to display the services -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tier</th>
                <th>Price</th>
                <th>Description</th>
                <th>Services</th>
                <th>Icon</th>
                <th>CTA URL</th>
                <th>CTA Text</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_services->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['tier_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['services']); ?></td>
                    <td><?php echo htmlspecialchars($row['icon']); ?></td>
                    <td><?php echo htmlspecialchars($row['cta_url']); ?></td>
                    <td><?php echo htmlspecialchars($row['cta_text']); ?></td>
                    <td>
                        <a href="Pricing/edit_service_2.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="Pricing/delete_service_2.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a> |
                        <a href="Pricing/copy_service.php?id=<?php echo $row['id']; ?>">Copy</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- Button to Add New Service -->
    <a href="add_service.php" class="btn btn-outline">Add New Service</a>
</div>

<!-- Core Services Management Section -->
<div class="section">
    <h3>Add New Core Service</h3>
    <form method="POST" action="admin.php">
        <label for="service_name">Service Name</label>
        <input type="text" id="service_name" name="service_name" required>
        <button type="submit" name="add_service">Add Service</button>
    </form>

    <h3>Manage Core Services</h3>
    <table>
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_core_services->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td>
                        <a href="Core_Services/edit_service.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="Core_Services/delete_service.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>

</body>
</html>