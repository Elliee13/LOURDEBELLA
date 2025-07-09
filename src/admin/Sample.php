<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
</head>
<body>
    <h2>Manage Services</h2>
    
    <h3>Add Service</h3>
    <form action="Package_Services/Logic.php" method="POST">
        <input type="text" name="package_title" placeholder="Package Title" required><br>
        <input type="text" name="package_subtitle" placeholder="Package Subtitle"><br>
        <textarea name="package_description" placeholder="Package Description"></textarea><br>
        <textarea name="services" placeholder="Services"></textarea><br>
        <button type="submit" name="add">Add Service</button>
    </form>
    
    <h3>Services List</h3>
    <?php if (!empty($services)): ?>
    <table>
        <thead>
            <tr>
                <th>Package Title</th>
                <th>Package Subtitle</th>
                <th>Package Description</th>
                <th>Services</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo htmlspecialchars($service['package_title']); ?></td>
                    <td><?php echo htmlspecialchars($service['package_subtitle']); ?></td>
                    <td><?php echo htmlspecialchars($service['package_description']); ?></td>
                    <td><?php echo htmlspecialchars($service['services']); ?></td>
                    <td>
                        <button onclick="editService(<?php echo $service['id']; ?>)">Edit</button>
                        <form action="Package_Services/Logic.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No services available.</p>
<?php endif; ?>


    <script>
        function editService(id) {
            // Redirect to a page where you can edit the service
            window.location.href = 'Package_Services/Logic.php' + id;
        }
    </script>
</body>
</html>
