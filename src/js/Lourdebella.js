document.addEventListener('DOMContentLoaded', function() {
    // Set current year in footer copyright
    document.getElementById('year').textContent = new Date().getFullYear();
    
    // Mobile Navigation Toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const header = document.getElementById('header');
    
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            const icon = navToggle.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }
    
    // Header scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.style.background = 'rgba(15, 23, 42, 0.98)';
            header.style.backdropFilter = 'blur(25px)';
            header.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.1)';
        } else {
            header.style.background = 'rgba(15, 23, 42, 0.95)';
            header.style.backdropFilter = 'blur(20px)';
            header.style.boxShadow = 'none';
        }
    });
    
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Close mobile menu if open
            if (navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                navToggle.querySelector('i').classList.remove('fa-times');
                navToggle.querySelector('i').classList.add('fa-bars');
            }
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Calculate header height for offset
                const headerHeight = document.getElementById('header').offsetHeight;
                
                window.scrollTo({
                    top: targetElement.offsetTop - headerHeight,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Handle active nav link based on scroll position
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-menu a');
        
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            const headerHeight = document.getElementById('header').offsetHeight;
            
            if (window.pageYOffset >= sectionTop - headerHeight - 100) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
    
    // Testimonial card hover effects
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    testimonialCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.boxShadow = '0 40px 80px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
    });
    
    // Calendly Event Scheduling Handler
    function initializeCalendlyHandler() {
        // Listen for Calendly events
        window.addEventListener('message', function(e) {
            if (e.data.event && e.data.event.indexOf('calendly') === 0) {
                if (e.data.event === 'calendly.event_scheduled') {
                    // Handle event scheduling
                    const eventData = e.data.event_details || {};
                    sendCalendlyNotification(eventData);
                }
            }
        });
    }
    
    // Send Calendly event notification to contact email
    function sendCalendlyNotification(eventData) {
        const emailData = {
            to: 'contact@LourdeBella.com',
            subject: 'New Event Scheduled - LourdeBella',
            body: `
                New event has been scheduled on LourdeBella website.
                
                Event Details:
                - Event Type: ${eventData.event_type_name || 'N/A'}
                - Scheduled Time: ${eventData.scheduled_event_start_time || 'N/A'}
                - Invitee Name: ${eventData.invitee_name || 'N/A'}
                - Invitee Email: ${eventData.invitee_email || 'N/A'}
                - Event URI: ${eventData.event_type_uri || 'N/A'}
                
                Please check your Calendly dashboard for complete details.
            `
        };
        
        // Send email notification (you would integrate with your email service here)
        sendEmailNotification(emailData);
    }
    
    // Contact Form Handling with enhanced validation
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        // Real-time validation
        const inputs = contactForm.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                // Remove error styling as user types
                if (this.classList.contains('error')) {
                    this.classList.remove('error');
                    removeError(this.id);
                }
            });
        });
        
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            // Form validation
            let valid = true;
            let errors = [];
            
            if (!name.trim()) {
                valid = false;
                errors.push('Name is required');
                addError('name', 'Name is required');
            } else if (name.trim().length < 2) {
                valid = false;
                errors.push('Name must be at least 2 characters');
                addError('name', 'Name must be at least 2 characters');
            } else {
                removeError('name');
            }
            
            if (!email.trim()) {
                valid = false;
                errors.push('Email is required');
                addError('email', 'Email is required');
            } else if (!isValidEmail(email)) {
                valid = false;
                errors.push('Please enter a valid email address');
                addError('email', 'Please enter a valid email address');
            } else {
                removeError('email');
            }
            
            if (!message.trim()) {
                valid = false;
                errors.push('Message is required');
                addError('message', 'Message is required');
            } else if (message.trim().length < 10) {
                valid = false;
                errors.push('Message must be at least 10 characters');
                addError('message', 'Message must be at least 10 characters');
            } else {
                removeError('message');
            }
            
            // If form is valid, process submission
            if (valid) {
                // Show loading state
                const submitBtn = contactForm.querySelector('.btn-submit');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Sending...';
                submitBtn.disabled = true;
                
                // Prepare email data for contact form
                const contactEmailData = {
                    to: 'contact@LourdeBella.com',
                    subject: 'New Contact Form Message - LourdeBella',
                    body: `
                        New message received from LourdeBella website contact form.
                        
                        Contact Details:
                        - Name: ${name}
                        - Email: ${email}
                        - Message: ${message}
                        
                        Please respond to the client at their provided email address.
                    `,
                    replyTo: email
                };
                
                // Send contact form email
                sendEmailNotification(contactEmailData);
                
                // Simulate form submission processing
                setTimeout(() => {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'form-success';
                    successMessage.innerHTML = `
                        <i class="fas fa-check-circle"></i> 
                        <div>
                            <strong>Thank you for your message!</strong><br>
                            We'll get back to you within 24 hours.
                        </div>
                    `;
                    
                    // Insert success message
                    contactForm.appendChild(successMessage);
                    
                    // Reset form and button
                    contactForm.reset();
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    
                    // Animate success message
                    setTimeout(() => {
                        successMessage.style.opacity = '1';
                        successMessage.style.transform = 'translateY(0)';
                    }, 100);
                    
                    // Remove success message after 6 seconds
                    setTimeout(() => {
                        successMessage.style.opacity = '0';
                        successMessage.style.transform = 'translateY(-20px)';
                        setTimeout(() => {
                            if (contactForm.contains(successMessage)) {
                                contactForm.removeChild(successMessage);
                            }
                        }, 300);
                    }, 6000);
                }, 1500);
            }
        });
    }
    
    // Email notification function (integrate with your email service)
    function sendEmailNotification(emailData) {
        // This is where you would integrate with your email service
        // Examples: EmailJS, Formspree, Netlify Forms, or your own backend
        
        // For EmailJS integration example:
        /*
        emailjs.send('YOUR_SERVICE_ID', 'YOUR_TEMPLATE_ID', {
            to_email: emailData.to,
            subject: emailData.subject,
            message: emailData.body,
            reply_to: emailData.replyTo || emailData.to
        }).then(function(response) {
            console.log('Email sent successfully!', response.status, response.text);
        }, function(error) {
            console.error('Email sending failed:', error);
        });
        */
        
        // For now, log the email data (replace with actual email service integration)
        console.log('Email notification:', emailData);
        
        // You can also create a mailto link as a fallback
        const mailtoLink = `mailto:${emailData.to}?subject=${encodeURIComponent(emailData.subject)}&body=${encodeURIComponent(emailData.body)}`;
        
        // Optionally open default email client (uncomment if needed)
        // window.open(mailtoLink);
    }
    
    // Initialize Calendly handler
    initializeCalendlyHandler();
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.testimonial-card, .service-box, .about-text, .about-image');
    animateElements.forEach(el => {
        observer.observe(el);
    });
    
    // Helper Functions
    function validateField(field) {
        const value = field.value.trim();
        const fieldId = field.id;
        
        switch(fieldId) {
            case 'name':
                if (!value) {
                    addError(fieldId, 'Name is required');
                    return false;
                } else if (value.length < 2) {
                    addError(fieldId, 'Name must be at least 2 characters');
                    return false;
                }
                break;
            
            case 'email':
                if (!value) {
                    addError(fieldId, 'Email is required');
                    return false;
                } else if (!isValidEmail(value)) {
                    addError(fieldId, 'Please enter a valid email address');
                    return false;
                }
                break;
            
            case 'message':
                if (!value) {
                    addError(fieldId, 'Message is required');
                    return false;
                } else if (value.length < 10) {
                    addError(fieldId, 'Message must be at least 10 characters');
                    return false;
                }
                break;
        }
        
        removeError(fieldId);
        return true;
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function addError(fieldId, message) {
        const field = document.getElementById(fieldId);
        // Remove existing error message if any
        removeError(fieldId);
        
        // Add error styling to the input
        field.classList.add('error');
        field.style.borderColor = '#EF4444';
        field.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.2)';
        
        // Create and append error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'form-error';
        errorDiv.textContent = message;
        errorDiv.id = `${fieldId}-error`;
        
        field.parentNode.appendChild(errorDiv);
    }
    
    function removeError(fieldId) {
        const field = document.getElementById(fieldId);
        field.classList.remove('error');
        field.style.borderColor = '';
        field.style.boxShadow = '';
        
        const errorElement = document.getElementById(`${fieldId}-error`);
        if (errorElement) {
            errorElement.parentNode.removeChild(errorElement);
        }
    }
    
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
        background: var(--gradient-primary);
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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
});