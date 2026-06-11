<?php
    require_once("include/config_session.inc.php");
    require_once("include/login_view.inc.php");
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['submit'])) {
            header("Location: index.php");
        }
    }

    require_once("include/dbh.inc.php");
    require_once("include/events_model.inc.php");

    $myEventsList = get_user_created_events($pdo, $_SESSION['user_id']);
    $myLikedList = get_user_liked_events($pdo, $_SESSION['user_id']);

    if(isset($_POST['return'])){
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - EventPlanned</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    
<main>
<div class="profile">
    <?php
        echo '<img class="avatar" src ="' . make_avatar($_SESSION['user_username'][0]) . '">';
    ?>

    <div class="text">
        <?php echo '<p class="username">' . $_SESSION['user_username'] . "</p>"; ?>
        <div class="info">
            <?php
                echo '<p>Email: ' . $_SESSION['user_email'] . '</p>';
                $date = new DateTime($_SESSION['user_date']);
                echo '<p>Date: ' . $date->format('d m Y') . '</p>';
            ?>
        </div>
    </div>

    <div class="profile-actions-sidebar">
        <form method="POST" name="return" class="return">
            <button name="return">Return to home page</button>
        </form>
        <form action="include/logout.inc.php" method="POST" class="Logout">
            <button>Logout</button>
        </form>
    </div>
</div>

<div class="myEvents">
    <p class="myEventsText">My Events:</p>
    <button class="myEventsAdd" onclick="window.location.href='createEvent.php'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 12H20M12 4V20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div class="profile-cards-container">
        <?php if (!empty($myEventsList)): ?>
            <?php foreach ($myEventsList as $event): ?>
                <div class="event-mini-card">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="Poster" class="mini-card-img">
                    <div class="mini-card-details">
                        <h4><?php echo htmlspecialchars($event['event_name']); ?></h4>
                        <p><?php echo htmlspecialchars($event['event_location']); ?></p>
                        <span><?php echo htmlspecialchars((string)$event['price']); ?> MDL</span>
                    </div>
                    
                    <div class="profile-card-actions">
                        <button class="action-btn edit-btn" onclick="window.location.href='editEvent.php?id=<?php echo $event['id']; ?>'" title="Edit Event">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        <button class="action-btn delete-btn" onclick="deleteProfileEvent(<?php echo $event['id']; ?>, this)" title="Delete Event">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-section-text">Nu ai creat niciun eveniment încă.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteProfileEvent(eventId, buttonElement) {
    if (confirm("Sigur dorești să ștergi definitiv acest eveniment?")) {
        fetch('include/delete_event.inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'event_id=' + eventId
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const card = buttonElement.closest('.event-mini-card');
                if (card) {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        card.remove();
                        const container = document.querySelector('.myEvents .profile-cards-container');
                        if (container && container.querySelectorAll('.event-mini-card').length === 0) {
                            container.innerHTML = '<p class="empty-section-text">Nu ai creat niciun eveniment încă.</p>';
                        }
                    }, 300);
                }
            } else {
                alert(data.message || "A apărut o eroare.");
            }
        })
        .catch(error => console.error('Error executing event drop sequence:', error));
    }
}
</script>

<div class="myLikedEvents">
    <p class="myLikedEventsText">My Liked Events:</p>
    
    <div class="profile-cards-container">
        <?php if (!empty($myLikedList)): ?>
            <?php foreach ($myLikedList as $event): ?>
                <div class="event-mini-card">
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="Poster" class="mini-card-img">
                    <div class="mini-card-details">
                        <h4><?php echo htmlspecialchars($event['event_name']); ?></h4>
                        <p><?php echo htmlspecialchars($event['event_location']); ?></p>
                        <span><?php echo htmlspecialchars((string)$event['price']); ?> MDL</span>
                    </div>
                    
                    <div class="eventHeart profileHeart" onclick="toggleLikeProfile(<?php echo $event['id']; ?>, this)">
                        <svg class="heart-icon active" width="22" height="22" viewBox="0 0 24 24" fill="#ef4444" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="empty-section-text">Nu ai apreciat niciun eveniment încă.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleLikeProfile(eventId, heartElement) {
    fetch('include/like_toggle.inc.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'event_id=' + eventId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success' && data.action === 'unliked') {
            const card = heartElement.closest('.event-mini-card');
            if (card) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    card.remove();
                    
                    const container = document.querySelector('.myLikedEvents .profile-cards-container');
                    if (container && container.querySelectorAll('.event-mini-card').length === 0) {
                        container.innerHTML = '<p class="empty-section-text">Nu ai apreciat niciun eveniment încă.</p>';
                    }
                }, 300);
            }
        }
    })
    .catch(error => console.error('Error matching heart toggle action:', error));
}
</script>
</main>

<?php include('footer.php'); ?>

<script src="js/theme.js"></script>
</body>
</html>