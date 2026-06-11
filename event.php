<?php
require_once("include/config_session.inc.php");
require_once("include/dbh.inc.php");
require_once("include/events_model.inc.php");

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit;
}

$eventId = (int)$_GET['id'];
$event = get_single_event($pdo, $eventId);

if (!$event) {
    header("Location: index.php");
    exit;
}

$referer  = isset($_GET['from']) ? $_GET['from'] : 'index';
$backUrl  = ($referer === 'profile') ? 'profile.php' : 'index.php';
$backLabel = ($referer === 'profile') ? 'Înapoi la profil' : 'Înapoi la pagina principală';

$userId  = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
$isLiked = false;
if ($userId !== null && !empty($event['liked'])) {
    $likedUsers = array_map('trim', explode(',', $event['liked']));
    $isLiked = in_array((string)$userId, $likedUsers);
}

if (empty($event['event_time']) || $event['event_time'] === '0000-00-00 00:00:00' || $event['event_time'] === '0000-00-00') {
    $displayDate = 'TBA';
    $displayTime = '';
} else {
    $dateObj     = new DateTime($event['event_time']);
    $displayDate = $dateObj->format('d.m.Y');
    $displayTime = $dateObj->format('H:i');
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['event_name']); ?> — EventPlanned</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/event.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:wght@0,400;0,600;0,700&display=swap" rel="stylesheet">
</head>
<body>

<?php include('header.php'); ?>

<main class="event-page">

    <!-- Back link (header level) -->
    <a href="<?php echo htmlspecialchars($backUrl); ?>" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        <?php echo htmlspecialchars($backLabel); ?>
    </a>

    <div class="event-detail-card">

        <!-- TOP: poster full width -->
        <div class="event-poster-wrap">
            <img
                src="<?php echo htmlspecialchars($event['image']); ?>"
                alt="<?php echo htmlspecialchars($event['event_name']); ?>"
                class="event-poster"
            >
        </div>

        <!-- BOTTOM: info panel -->
        <div class="event-info-panel">

            <div class="event-info-main">

                <!-- LEFT column: badge, title, meta -->
                <div class="event-info-left">
                    <?php if (!empty($event['label'])): ?>
                        <span class="event-badge"><?php echo htmlspecialchars($event['label']); ?></span>
                    <?php endif; ?>

                    <h1 class="event-title"><?php echo htmlspecialchars($event['event_name']); ?></h1>

                    <div class="event-meta">
                        <div class="meta-item">
                            <svg width="16" height="16" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.4 6.6H8.4V9.6H5.4V6.6ZM9.6 1.2H9V0H7.8V1.2H3V0H1.8V1.2H1.2C0.54 1.2 0 1.74 0 2.4V10.8C0 11.46 0.54 12 1.2 12H9.6C10.26 12 10.8 11.46 10.8 10.8V2.4C10.8 1.74 10.26 1.2 9.6 1.2ZM9.6 2.4V3.6H1.2V2.4H9.6ZM1.2 10.8V4.8H9.6V10.8H1.2Z" fill="currentColor"/>
                            </svg>
                            <span><?php echo htmlspecialchars($displayDate); ?></span>
                            <?php if ($displayTime): ?>
                                <span class="meta-time"><?php echo htmlspecialchars($displayTime); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="meta-item">
                            <svg width="16" height="16" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.80032 6.12519C9.80032 4.77152 8.70391 3.67511 7.35024 3.67511C5.99657 3.67511 4.90016 4.77152 4.90016 6.12519C4.90016 7.47886 5.99657 8.57527 7.35024 8.57527C8.70391 8.57527 9.80032 7.47886 9.80032 6.12519ZM6.1252 6.12519C6.1252 5.45142 6.67647 4.90015 7.35024 4.90015C8.02401 4.90015 8.57528 5.45142 8.57528 6.12519C8.57528 6.79896 8.02401 7.35023 7.35024 7.35023C6.67647 7.35023 6.1252 6.79896 6.1252 6.12519Z" fill="currentColor"/>
                                <path d="M6.99497 13.3591C7.0991 13.4326 7.22773 13.4755 7.35024 13.4755C7.47274 13.4755 7.60137 13.4387 7.7055 13.3591C7.88925 13.2243 12.2688 10.0698 12.2504 6.11909C12.2504 3.41788 10.0514 1.21893 7.35024 1.21893C4.64902 1.21893 2.45008 3.41788 2.45008 6.11909C2.4317 10.0637 6.81122 13.2243 6.99497 13.3591ZM7.35024 2.4501C9.37768 2.4501 11.0254 4.09778 11.0254 6.12522C11.0376 8.8448 8.33639 11.2888 7.35024 12.0912C6.36408 11.2888 3.66287 8.85093 3.67512 6.12522C3.67512 4.09778 5.3228 2.4501 7.35024 2.4501Z" fill="currentColor"/>
                            </svg>
                            <span><?php echo htmlspecialchars($event['event_location']); ?></span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT column: price + like button -->
                <div class="event-info-right">
                    <span class="event-price"><?php echo htmlspecialchars((string)$event['price']); ?> MDL</span>

                    <button
                        class="like-btn <?php echo $isLiked ? 'liked' : ''; ?>"
                        id="likeBtn"
                        data-event-id="<?php echo $event['id']; ?>"
                        data-logged-in="<?php echo $userId ? 'true' : 'false'; ?>"
                    >
                        <svg class="heart-svg" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.1 16.9482L10 17.0572L9.89 16.9482C5.14 12.2507 2 9.14441 2 5.99455C2 3.81471 3.5 2.17984 5.5 2.17984C7.04 2.17984 8.54 3.26975 9.07 4.75204H10.93C11.46 3.26975 12.96 2.17984 14.5 2.17984C16.5 2.17984 18 3.81471 18 5.99455C18 9.14441 14.86 12.2507 10.1 16.9482ZM14.5 0C12.76 0 11.09 0.882834 10 2.26703C8.91 0.882834 7.24 0 5.5 0C2.42 0 0 2.6267 0 5.99455C0 10.1035 3.4 13.4714 8.55 18.5613L10 20L11.45 18.5613C16.6 13.4714 20 10.1035 20 5.99455C20 2.6267 17.58 0 14.5 0Z"/>
                        </svg>
                        <span class="like-label"><?php echo $isLiked ? 'Salvat' : 'Adaugă în favorite'; ?></span>
                    </button>
                </div>

            </div>

            <!-- Divider -->
            <hr class="event-divider">

            <!-- Description -->
            <?php if (!empty($event['description'])): ?>
                <div class="event-description">
                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php include('footer.php'); ?>

<script src="js/theme.js"></script>
<script>
(function () {
    const btn = document.getElementById('likeBtn');
    if (!btn) return;

    btn.addEventListener('click', function () {
        // If not logged in — open the register/login modal
        if (btn.dataset.loggedIn === 'false') {
            const modal = document.getElementById('accountModal');
            if (modal) modal.style.display = 'block';
            return;
        }

        const eventId = btn.dataset.eventId;
        fetch('include/like_event.inc.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ event_id: parseInt(eventId) })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const liked = data.status === 'liked';
                btn.classList.toggle('liked', liked);
                btn.querySelector('.like-label').textContent = liked ? 'Salvat' : 'Adaugă în favorite';
            }
        })
        .catch(console.error);
    });
})();
</script>
<?php if (!isset($_SESSION['user_id'])): ?>
    <?php
        $showModal   = false;
        $initialView = '';
        if (isset($_SESSION['errors_signup']))        { $showModal = true; $initialView = 'signup'; }
        elseif (isset($_SESSION['errors_login']))     { $showModal = true; $initialView = 'login';  }
        elseif (isset($_GET['signup']) && $_GET['signup'] === 'success') { $showModal = true; $initialView = 'signup'; }
    ?>
    <div id="accountModal" class="modal-overlay"
         style="display: <?php echo $showModal ? 'block' : 'none'; ?>;"
         data-auto-open="<?php echo $showModal ? 'true' : 'false'; ?>"
         data-initial-view="<?php echo $initialView; ?>">
        <div class="access-form">
            <div class="signup">
                <form action="include/signup.inc.php" method="POST" class="Form-input-section">
                    <?php if (isset($_SESSION['errors_signup'])): ?>
                        <div class="errors-box-container"><?php check_signup_errors(); ?></div>
                    <?php endif; ?>
                    <?php signup_inputs(); ?>
                    <button>Sign Up</button>
                </form>
            </div>
            <div class="login">
                <form action="include/login.inc.php" method="POST" class="Form-input-section">
                    <?php if (isset($_SESSION['errors_login'])): ?>
                        <div class="errors-box-container"><?php check_login_errors(); ?></div>
                    <?php endif; ?>
                    <input type="text"     name="username" placeholder="Username">
                    <input type="password" name="pwd"      placeholder="Password">
                    <button>Log In</button>
                </form>
            </div>
            <button class="open-form" name="signup">Sign Up</button>
            <button class="open-form" name="login">Log In</button>
        </div>
    </div>
<?php endif; ?>

<script src="js/script.js"></script>
<script src="js/register.js"></script>
</body>
</html>