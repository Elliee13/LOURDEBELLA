<?php
require ('../../db.php'); // Include database connection
include 'Core_Services/add_service.php';

// Fetch all services from the services table
$sql_services = "SELECT * FROM services";
$result_services = $conn->query($sql_services);

// Fetch all core services
$sql_core_services = "SELECT * FROM core_services";
$result_core_services = $conn->query($sql_core_services);

// Fetch contact information
$sql_contact_info = "SELECT * FROM contact_info LIMIT 1";
$result_contact_info = $conn->query($sql_contact_info);
$contact_info = $result_contact_info->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

<div class="container">
    <div class="header">
        <h1>Admin Panel</h1>
    </div>

    <!-- Navigation Tabs -->
    <div class="nav-tabs">
        <a href="#services" class="nav-tab active" onclick="showSection('services', this)">
            <i class="fas fa-cog"></i> Services
        </a>
        <a href="#core-services" class="nav-tab" onclick="showSection('core-services', this)">
            <i class="fas fa-list"></i> Core Services
        </a>
        <a href="#contact" class="nav-tab" onclick="showSection('contact', this)">
            <i class="fas fa-phone"></i> Contact Info
        </a>
    </div>

    <!-- Services Section -->
    <div id="services" class="section-content active">
        <div class="card">
            <div class="card-header">
                <h2>Manage Services</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="services-table">
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
                                    <td><strong><?php echo htmlspecialchars($row['tier_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                                    <td><span class="truncate"><?php echo htmlspecialchars($row['description']); ?></span></td>
                                    <td><span class="truncate"><?php echo htmlspecialchars($row['services']); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['icon']); ?></td>
                                    <td><span class="truncate"><?php echo htmlspecialchars($row['cta_url']); ?></span></td>
                                    <td><?php echo htmlspecialchars($row['cta_text']); ?></td>
                                    <td class="actions">
                                        <a href="Pricing/edit_service_2.php?id=<?php echo $row['id']; ?>" class="action-link edit">Edit</a>
                                        <a href="Pricing/delete_service_2.php?id=<?php echo $row['id']; ?>" class="action-link delete" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                                        <a href="Pricing/copy_service.php?id=<?php echo $row['id']; ?>" class="action-link copy">Copy</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="add-service-btn-container">
                    <a href="Core_Services/add_service.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Services Section -->
    <div id="core-services" class="section-content">
        <div class="card">
            <div class="card-header">
                <h2>Add New Core Service</h2>
            </div>
            <div class="card-body">
                <!-- Add New Core Service Form -->
                <form method="POST" action="admin.php">
                    <div class="form-group">
                        <label for="service_name" class="form-label">Service Name</label>
                        <input type="text" id="service_name" name="service_name" class="form-input" required>
                    </div>
                    <button type="submit" name="add_service" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Service
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Manage Core Services</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
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
                                    <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                                    <td>
                                        <a href="Core_Services/edit_service.php?id=<?php echo $row['id']; ?>" class="action-link edit">Edit</a>
                                        <a href="Core_Services/delete_service.php?id=<?php echo $row['id']; ?>" class="action-link delete" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Contact Information Section -->
    <div id="contact" class="section-content">
        <div class="card">
            <div class="card-header">
                <h2>Update Contact Information</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="Contact/update_contact.php">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="<?php echo htmlspecialchars($contact_info['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-input" value="<?php echo htmlspecialchars($contact_info['phone']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Mailing Address</label>
                        <textarea id="address" name="address" class="form-input form-textarea" required><?php echo htmlspecialchars($contact_info['address']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="cta_url" class="form-label">CTA URL</label>
                        <input type="url" id="cta_url" name="cta_url" class="form-input" value="<?php echo htmlspecialchars($contact_info['cta_url']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cta_text" class="form-label">CTA Text</label>
                        <input type="text" id="cta_text" name="cta_text" class="form-input" value="<?php echo htmlspecialchars($contact_info['cta_text']); ?>" required>
                    </div>
                    
                    <button type="submit" name="update_contact" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Contact Information
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showSection(sectionId, tabElement) {
    // Hide all sections
    const sections = document.querySelectorAll('.section-content');
    sections.forEach(section => section.classList.remove('active'));
    
    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.nav-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // Show selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Add active class to clicked tab
    tabElement.classList.add('active');
}
</script>

</body>
</html>