<?php
require_once "include/config_session.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EventPlanned</title>
    <link rel="stylesheet" href="css/style.css"> <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <?php include_once 'header.php'; ?>

    <main class="contact-page">
        <div class="contact-box">
            <h1 class="category-title" data-key="contact_heading" style="margin: 0 0 10px 0; text-align: center;">Contact Developers</h1>
            <p data-key="contact_desc" style="text-align: center; color: var(--text-2); margin-bottom: 30px;">
                Have a question or found a bug? Send us a message!
            </p>
            
            <form action="include/contact.inc.php" method="POST" class="contact-form">
                <div class="contact-input-section">
                    <input type="text" name="name" placeholder="Your Name" data-key="contact_name_ph" required autocomplete="off">
                </div>
                
                <div class="contact-input-section">
                    <input type="email" name="email" placeholder="Your Email" data-key="contact_email_ph" required autocomplete="off">
                </div>

                <div class="contact-input-section">
                    <input type="text" name="subject" placeholder="Subject" data-key="contact_subject_ph" required autocomplete="off">
                </div>
                
                <div class="contact-input-section">
                    <textarea name="message" rows="6" placeholder="Your Message..." data-key="contact_msg_ph" required></textarea>
                </div>
                
                <button type="submit" name="submit-contact" class="cta-btn contact-btn" data-key="contact_btn_send">Send Message</button>
            </form>
        </div>
    </main>

    <?php include_once 'footer.php'; ?>

<script src="js/theme.js"></script>
<script src="js/script.js"></script>
</body>
</html>