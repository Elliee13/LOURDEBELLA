<?php
// Include the contact info logic
include('contact_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LourdeBella - Precision. Power. Brilliance.</title>
    <link rel="icon" type="image/jpeg" href="../img/LourdebellaLogo.jpeg">
    <link rel="stylesheet" href="../styles/Packages.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <!-- Add FontAwesome CDN to your HTML head -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
.services-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    font-size: 16px;
}

.service-item {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.service-item .service-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: bold;
}

.service-item p {
    margin-left: 26px;
    margin-top: 4px;
    margin-bottom: 0;
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .services-grid {
        grid-template-columns: 1fr;
    }
}

.note {
  font-style: italic;                /* Italicize the text */
  font-size: 16px;                   /* Adjust font size for readability */
  color: white;                       /* Light gray color for text */
  margin-top: 15px;                  /* Space above the note */
  padding: 10px;                     /* Add some padding for better spacing */
}

/* Optional: Add some additional styling */
.description-two {
    text-align: left;
    margin-bottom: 5px; /* Reduced from 15px */
    font-style: italic;
    color: #666;
}

.service-box {
    display: flex;
    flex-direction: column;
}

.service-content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.description-bottom {
    margin-top: auto;
    text-align: center;
    font-size: 12px;
    color: #888;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

/* Package Services Styling */
.package-service-box {
    background:rgba(26, 26, 26, 0);
    padding: 30px;
    margin: 20px 0;
    color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.package-header {
    text-align: center;
    margin-bottom: 25px;
    border-bottom: 2px solid #F59E0B;
    padding-bottom: 20px;
}

.package-title {
    color:rgb(247, 239, 239);
    font-size: 35px;
    font-weight: 700;
    margin: 0 0 10px 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.package-subtitle {
    color: #F59E0B;
    font-size: 18px;
    font-weight: 500;
    margin: 0;
    opacity: 0.8;
    font-style: italic;
}

.package-content {
    margin-top: 20px;
}

.package-description {
    font-size: 16px;
    line-height: 1.6;
    color: #e0e0e0;
    margin-bottom: 25px;
    text-align: center;
}

.package-includes {
    background: rgba(245, 159, 11, 0);
    border-radius: 8px;
    padding: 20px;
}

.package-includes h4 {
    color: #F59E0B;
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 15px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.package-services-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.package-services-list li {
    padding: 10px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    padding-left: 25px;
    font-size: 15px;
    line-height: 1.4;
    color: #f0f0f0;
}

.package-services-list li:last-child {
    border-bottom: none;
}

.package-services-list li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #F59E0B;
    font-weight: bold;
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .package-service-box {
        padding: 20px;
        margin: 15px 0;
    }
    
    .package-title {
        font-size: 22px;
    }
    
    .package-subtitle {
        font-size: 16px;
    }
    
    .package-description {
        font-size: 14px;
    }
    
    .package-includes {
        padding: 15px;
    }
}

/* Add-on Services Styling - Package Design */
.addon-services-container {
    background:rgba(26, 26, 26, 0);
    width: 100%;
    padding: 40px;
    color: #fff;
}

.addon-services-header {
    text-align: center;
    margin-bottom: 35px;
    border-bottom: 2px solid #F59E0B;
    padding-bottom: 25px;
}

.addon-services-title {
    color: #fff;
    font-size: 35px;
    font-weight: 700;
    margin: 0 0 15px 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.addon-services-subtitle {
    color: #F59E0B;
    font-size: 19px;
    font-weight: 500;
    margin: 0;
    opacity: 0.9;
    font-style: italic;
}

.addon-services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
}

.addon-service-item {
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 8px;
    padding: 25px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.addon-service-item:hover {
    background: rgba(245, 158, 11, 0.15);
    border-color: #F59E0B;
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(245, 158, 11, 0.2);
}

.addon-service-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}


.addon-service-name {
    color:rgb(255, 255, 255);
    text-align: left;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    flex: 1;
}

.addon-service-content {
    margin-top: 10px;
}

.addon-service-description {
    font-size: 15px;
    line-height: 1.6;
    color: #e0e0e0;
    margin: 0;
    text-align: left;
}

/* Alternative grid layout for 2 columns */
.addon-services-grid.two-columns {
    grid-template-columns: repeat(2, 1fr);
}

/* Alternative grid layout for 3 columns */
.addon-services-grid.three-columns {
    grid-template-columns: repeat(3, 1fr);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .addon-services-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .addon-services-container {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .addon-services-container {
        padding: 25px;
        margin: 15px 0;
    }
    
    .addon-services-title {
        font-size: 28px;
    }
    
    .addon-services-subtitle {
        font-size: 16px;
    }
    
    .addon-services-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .addon-service-item {
        padding: 20px;
    }
    
    .addon-service-name {
        font-size: 16px;
    }
    
    .addon-service-description {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .addon-services-container {
        padding: 20px;
    }
    
    .addon-services-title {
        font-size: 24px;
    }
    
    .addon-services-subtitle {
        font-size: 14px;
    }
    
    .addon-service-item {
        padding: 15px;
    }
    
    .addon-icon {
        width: 30px;
        height: 30px;
        font-size: 16px;
    }
    
    .addon-service-name {
        font-size: 14px;
    }
}



    </style>

</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php">
                        <img src="../img/LourdebellaLogo.jpeg" alt="LourdeBella Logo" id="logo">
                    </a>
                    <div class="logo-text">LOURDEBELLA</div>
                </div>
                <div class="nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="../../index.php" class="active">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="services" class="services section">
        <div class="container">
            <div class="section-header">
                <h2>Pricing That Fits Your Goals and Budget</h2>
                <p>We help founders transition from scattered to streamlined with branded documents, clean workflows, and reliable backend coordination.</p>
            </div>

            <!-- Service Boxes Container -->
            <div class="service-boxes">
                <!-- Dynamic Service Box Content is Included -->
                <?php include('services.php'); ?>
            </div>

            <div class="bottom-box">
                <div class="bottom-box-content">
                    <!-- Dynamically load package Services  -->
                    <?php include('package_services.php'); ?>
                </div>
            </div>

            <!-- New Bottom Box with Introduction Text and Core Services -->
            <div class="bottom-box">
                <div class="bottom-box-content">
                    <!-- Dynamically load Core Services and Why Lourdebella -->
                    <?php include('core_services.php'); ?>
                </div>
                <p class="note">📝 Note: Add-ons are individually scoped based on the business size, file condition, and workflow complexity. For larger teams, legacy systems, or custom integrations, pricing may adjust accordingly.</p>
                <!-- Claim Offer Button -->
                <div class="bottom-box-actions">
                    <a href="https://calendly.com/lourdebella/30min" target="_blank" class="btn btn-outline">Claim Your Offer</a>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <div class="container">
            <div class="section-header">
                <h2>Let's Work Together</h2>
                <p class="contact-lead">Have questions or ready to build your backend brilliance?</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <h3>Email</h3>
                        <p><a href="mailto:<?php echo htmlspecialchars($contact_info['email']); ?>"><?php echo htmlspecialchars($contact_info['email']); ?></a></p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <h3>Phone</h3>
                        <p><a href="tel:<?php echo htmlspecialchars($contact_info['phone']); ?>"><?php echo htmlspecialchars($contact_info['phone']); ?></a></p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Mailing Address</h3>
                        <p><?php echo nl2br(htmlspecialchars($contact_info['address'])); ?></p>
                    </div>
                    <div class="info-cta">
                        <a href="<?php echo htmlspecialchars($contact_info['cta_url']); ?>" target="_blank" class="btn btn-primary"><?php echo htmlspecialchars($contact_info['cta_text']); ?></a>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="your@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Tell us about your project..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="../img/LourdebellaLogo.jpeg" alt="LourdeBella Logo" class="footer-logo-img">
                </div>
                <div class="footer-tagline">
                    LourdeBella | Precision. Power. Brilliance.
                </div>
                <div class="social-links" style="margin: 20px 0; display: flex; justify-content: center; gap: 20px;">
                    <a href="https://www.youtube.com/@lourdebella" target="_blank" style="color: #fff; font-size: 24px; transition: color 0.3s ease;">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/lourdebella/" target="_blank" style="color: #fff; font-size: 24px; transition: color 0.3s ease;">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://www.facebook.com/share/1AisG3ived/" target="_blank" style="color: #fff; font-size: 24px; transition: color 0.3s ease;">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/lourdebella_co?igsh=MWhlbXBpbTlqejZleQ==" target="_blank" style="color: #fff; font-size: 24px; transition: color 0.3s ease;">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                <div class="copyright">
                    &copy; <span id="year"></span> LourdeBella LLC. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="../js/Lourdebella.js"></script>
    <script>
    // Fetch contact information dynamically
    fetch('contact_info.php')
        .then(response => response.json())
        .then(data => {
            // Update the HTML elements with the fetched contact information
            document.getElementById('contact-email').innerHTML = `<a href="mailto:${data.email}">${data.email}</a>`;
            document.getElementById('contact-phone').innerHTML = `<a href="tel:${data.phone}">${data.phone}</a>`;
            document.getElementById('contact-address').innerHTML = data.address.replace(/\n/g, "<br>");
        })
        .catch(error => {
            console.error('Error fetching contact info:', error);
            // Handle errors (e.g., show a fallback message)
            document.getElementById('contact-email').innerText = 'Error loading email';
            document.getElementById('contact-phone').innerText = 'Error loading phone';
            document.getElementById('contact-address').innerText = 'Error loading address';
        });
    </script>
</body>
</html>