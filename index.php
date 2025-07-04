<?php
// Include the contact info logic
include('src/php/contact_info.php');
include ('src/php/our_services.php');
?>

<?php
// Include database connection
require ('db.php'); 

// Fetch services from the database
$sql_services = "SELECT * FROM our_services";
$result_services = $conn->query($sql_services);

// Close the database connection after fetching the data
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LourdeBella - Precision. Power. Brilliance.</title>
    <link rel="icon" type="image/jpeg" href="src/img/LourdebellaLogo.jpeg">
    <link rel="stylesheet" href="src/styles/Lourdebella.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php">
                        <img src="src/img/LourdebellaLogo.jpeg" alt="LourdeBella Logo" id="logo">
                    </a>
                    <div class="logo-text">LOURDEBELLA</div>
                </div>
                <div class="nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#what-we-do">What We Do</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section / Home -->
    <section id="home" class="hero">
        <div class="container"> 
            <div class="hero-content">
                <div class="logo-hero">
                    <img src="src/img/LourdebellaLogo.jpeg" alt="LourdeBella Logo" class="hero-logo">
                </div>
                <div class="tagline">PRECISION. POWER. BRILLIANCE.</div>
                <h1>A powerhouse consultancy specializing in business infrastructure, automation, and scalable systems.</h1>
                <h3>Done-for-you systems so you can focus on growth, not guesswork.</h3>
                <a href="https://calendly.com/lourdebella/30min" target="_blank" class="btn btn-primary">Book a Discovery Call</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="section-header">
                <h2>About Us</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p class="lead">LourdeBella is a powerhouse consultancy built for founders who are ready to stop winging it and start scaling with structure. We specialize in building the backend of your business — from legal setup and systems to automation and brand infrastructure.</p>
                    
                    <div class="mission">
                        <h3>Our Mission</h3>
                        <div class="mission-statement">Structure. Strategy. Sustainability.</div>
                        <p>We serve visionaries, creatives, and go-getters who want clarity, control, and confidence as they grow. Whether you're starting fresh or rebuilding better, LourdeBella gives you the foundation to scale on purpose.</p>
                    </div>
                    
                    <div class="founder">
                        <h3>From Our Founder</h3>
                        <p>With over a decade of experience in business systems development, our founder created LourdeBella to bridge the gap between visionary entrepreneurs and the operational excellence they need. Combining strategic insight with practical implementation, we transform ideas into scalable, sustainable enterprises.</p>
                    </div>
                </div>
                <div class="about-image">
                    <img src="src/img/about us.jpg" alt="About LourdeBella" class="about-img" style="width: 80%; height: auto;">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services section">
        <div class="container">
            <div class="section-header">
                <h2>Our Services</h2>
            </div>

            <?php while ($row = $result_services->fetch_assoc()) { ?>
                <div class="service-box">
                    <h3><?php echo htmlspecialchars($row['service_name']); ?></h3>
                    <div class="service-content">
                        <p><?php echo htmlspecialchars($row['description']); ?></p>

                        <?php 
                        // Decode the service list (if stored as JSON in the database)
                        $service_list = json_decode($row['service_list'], true);

                        if ($service_list && is_array($service_list)) { // Ensure the decoded list is an array
                        ?>
                            <ul class="service-list">
                                <?php foreach ($service_list as $service_item) { ?>
                                    <li><?php echo htmlspecialchars($service_item); ?></li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p>No services listed or invalid JSON format in service_list.</p>
                        <?php } ?>

                        <p class="custom-note"><?php echo htmlspecialchars($row['custom_note']); ?></p>

                        <div class="service-actions">
                            <a href="<?php echo htmlspecialchars($row['view_package_link']); ?>" class="btn btn-glass">View Full Package</a>
                            <a href="<?php echo htmlspecialchars($row['book_call_link']); ?>" target="_blank" class="btn btn-outline">Book Your Discovery Call</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>


    <!-- What We Do Section -->
    <section id="what-we-do" class="what-we-do section">
        <div class="container">
            <div class="section-header">
                <h2>What We Do</h2>
                <p class="lead">See how we transform businesses with precision-built systems</p>
            </div>
            <div class="what-we-do-content" style="display: flex; gap: 2rem; align-items: flex-start;">
                <!-- Quick Overview -->
                <div class="process-overview" style="flex: 2;">
                    <h3>Our 3-Step Process</h3>
                    <div class="process-steps">
                        <div class="step">
                            <div class="step-number">1</div>
                            <h4>Discovery & Strategy</h4>
                            <p>We analyze your current systems and identify gaps</p>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <h4>Build & Implement</h4>
                            <p>Custom SOPs, CRM setup, and automated workflows</p>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <h4>Support & Scale</h4>
                            <p>30-day support to ensure everything runs smoothly</p>
                        </div>
                    </div>
                </div>
                
                <!-- Video Container -->
                <div class="media-container" style="flex: 1; max-width: 350px;">
                    <div class="video-container">
                        <video controls poster="" class="service-video" style="width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <source src="src/img/What We Do in LOURDEBELLA.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
        <div class="container">
            <div class="section-header">
                <h2>What Our Clients Say</h2>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="company-info">
                        <div class="company-emoji">📦</div>
                        <div class="company-name">Affordable Eats Co.</div>
                    </div>
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">LourdeBella helped us go from scattered Google Drive chaos to a fully branded backend with SOPs, client folders, and a smooth delivery system. Now everything runs on autopilot — and I can focus on creating, not chasing down files.</p>
                    <div class="author-info">
                        <div class="author-name">— Founder, Affordable Eats Co.</div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="company-info">
                        <div class="company-emoji">🚚</div>
                        <div class="company-name">Belle Deliveries</div>
                    </div>
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">Our backend was holding us back. LourdeBella stepped in and built out custom folders, team onboarding, and branded documentation that made it easy to grow. We now run logistics and contract fulfillment with way less stress.</p>
                    <div class="author-info">
                        <div class="author-name">— Director, Belle Deliveries</div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="company-info">
                        <div class="company-emoji">🌱</div>
                        <div class="company-name">SAYCare</div>
                    </div>
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">We were a new company trying to build fast, and LourdeBella gave us structure. From intake forms to branded SOPs and CRM setup — their system saved us hours and helped us present like pros.</p>
                    <div class="author-info">
                        <div class="author-name">— Co-Founder, SAYCare</div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="company-info">
                        <div class="company-emoji">🏗️</div>
                        <div class="company-name">JM Construction Group</div>
                    </div>
                    <div class="quote-icon">"</div>
                    <p class="testimonial-text">As a construction business, our ops were all over the place. LourdeBella helped us set up simple folders, client templates, and automated updates that made the entire process easier for us and our clients.</p>
                    <div class="author-info">
                        <div class="author-name">— Owner, JM Construction Group</div>
                    </div>
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
                    <img src="src/img/LourdebellaLogo.jpeg" alt="LourdeBella Logo" class="footer-logo-img">
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

    <script src="src/js/Lourdebella.js"></script>
    <script>
    // Fetch contact information dynamically
    fetch('src/php/contact_info.php')
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