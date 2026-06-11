<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPlanned</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Intel+One+Mono:ital,wght@0,300..700;1,300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div class="showcase">
        <img src="image/eveniment2.webp" class="img1">
        <img src="image/eveniment1.webp" class="img2">
        <img src="image/eveniment3.jpg" class="img3">
    </div>

    <div class="event-items">
        <?php
            include('include/events.inc.php');
        ?>
    </div>

    <section class="cta-banner">
        <div class="cta-content">
            <h2 data-key="cta_title">Fă-ți evenimentul cunoscut!</h2>
            <p data-key="cta_subtitle">Adaugă evenimentul tău pe platformă și ajungi la mii de oameni interesați.</p>
        </div>
        <form method="POST">
            <button href="createEvent.php" class="cta-btn" name="cta-btn" data-key="cta_btn">+ Începe acum</button>
        </form>
    </section>

    <?php
        include('footer.php');
    ?>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <?php 
            $showModal = false;
            $initialView = ''; 

            if (isset($_SESSION['errors_signup'])) {
                $showModal = true;
                $initialView = 'signup';
            } elseif (isset($_SESSION['errors_login'])) {
                $showModal = true;
                $initialView = 'login';
            } elseif (isset($_GET['signup']) && $_GET['signup'] === 'success') {
                $showModal = true;
                $initialView = 'signup';
            }
        ?>
        <div id="accountModal" class="modal-overlay" 
             style="display: <?php echo $showModal ? 'block' : 'none'; ?>;"
             data-auto-open="<?php echo $showModal ? 'true' : 'false'; ?>"
             data-initial-view="<?php echo $initialView; ?>">
            <div class="access-form">
                <div class="signup">
                    <form action="include/signup.inc.php" method="POST" class="Form-input-section">
                        <?php if (isset($_SESSION['errors_signup'])): ?>
                            <div class="errors-box-container">
                                <?php check_signup_errors(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php signup_inputs(); ?>
                        <button>Sign Up</button>
                    </form>
                </div>
                <div class="login">
                    <form action="include/login.inc.php" method="POST" class="Form-input-section">
                        <?php if (isset($_SESSION['errors_login'])): ?>
                            <div class="errors-box-container">
                                <?php check_login_errors(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <input type="text" name="username" placeholder="Username">
                        <input type="password" name="pwd" placeholder="Password">
                        <button>Log In</button>
                    </form>
                </div>
                <button class="open-form" name="signup">Sign Up</button>
                <button class="open-form" name="login">Log In</button>
            </div>
        </div>
    <?php endif; ?>

    <script src="js/theme.js"></script>
    <script src="js/script.js"></script>
    <script src="js/register.js"></script>
</body>
</html>

    <script src="js/theme.js"></script>
    <script src="js/script.js"></script>
    <script src="js/register.js"></script>
</body>
</html>