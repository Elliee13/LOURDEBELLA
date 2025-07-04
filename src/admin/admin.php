<?php
require ('../../db.php'); // Include database connection
include 'Core_Services/add_service.php';
include 'Our_services/add_services.php';


// Fetch all services from the services table
$sql_services = "SELECT * FROM services";
$result_services = $conn->query($sql_services);

$sql_our_services = "SELECT * FROM our_services";
$result_our_services = $conn->query($sql_our_services);

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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS (must come after jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Admin Panel</h1>
        <form action="../.././login.php" method="POST">
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
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

    <!-- Our Services Section -->
    <div id="services" class="section-content active">
        <div class="card">
            <div class="card-header">
                <h2>Our Services</h2>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="services-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Service List</th>
                                <th>Custom Note</th>
                                <th>Book Call Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_our_services->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_list']); ?></td>
                                    <td><?php echo htmlspecialchars($row['custom_note']); ?></td>
                                    <td><a href="<?php echo htmlspecialchars($row['book_call_link']); ?>" target="_blank">Book Your Discovery Call</a></td>
                                    <td class="actions">
                                        <!-- Triggering Update and Delete Modals -->
                                        <a href="Our_services/update_services.php?id=<?php echo $row['id']; ?>" class="update-button-add edit">Update</a>
                                        <a href="Our_services/delete_services.php?id=<?php echo $row['id']; ?>" class="delete-button-add delete" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="add-service-btn-container">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                        <i class="fas fa-plus"></i> Add New Service
                    </button>
                </div>
            </div>
        </div>
    </div>

        <!-- Add New Service Modal -->
        <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Add New Service Form -->
                        <form method="POST" action="Our_services/add_services.php">
                            <div class="form-group">
                                <!-- Correct usage of label and input -->
                                <label for="service_name">Service Name</label>
                                <input type="text" id="service_name" name="service_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="service_list">Service List (Comma Separated)</label>
                                <input type="text" id="service_list" name="service_list" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="custom_note">Custom Note</label>
                                <input type="text" id="custom_note" name="custom_note" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="book_call_link">Book Call Link</label>
                                <input type="url" id="book_call_link" name="book_call_link" class="form-control" required>
                            </div>
                            <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                                        <a href="Core_Services/edit_service.php?id=<?php echo $row['id']; ?>" class="update-button edit">Update</a>
                                        <a href="Core_Services/delete_service.php?id=<?php echo $row['id']; ?>" class="delete-button delete" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
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
<script>
    // Scroll to top functionality
    let scrollTopBtn = document.createElement('button');
    scrollTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    scrollTopBtn.className = 'scroll-top-btn';
    scrollTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #0F172A;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 10px 30px #F59E0B;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    `;
    
    document.body.appendChild(scrollTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 500) {
            scrollTopBtn.style.opacity = '1';
            scrollTopBtn.style.visibility = 'visible';} else {
           scrollTopBtn.style.opacity = '0';
           scrollTopBtn.style.visibility = 'hidden';
       }
   });
   
   scrollTopBtn.addEventListener('click', function() {
       window.scrollTo({
           top: 0,
           behavior: 'smooth'
       });
   });
   
   scrollTopBtn.addEventListener('mouseenter', function() {
       this.style.transform = 'scale(1.1)';
   });
   
   scrollTopBtn.addEventListener('mouseleave', function() {
       this.style.transform = 'scale(1)';
   });
   
   // Loading animation
   window.addEventListener('load', function() {
       const loader = document.querySelector('.loader');
       if (loader) {
           loader.style.opacity = '0';
           setTimeout(() => {
               loader.style.display = 'none';
           }, 500);
       }
   });

</script>

</body>
</html>
