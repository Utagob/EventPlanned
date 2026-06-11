<?php
    require_once('include/config_session.inc.php');
    require_once("include/login_view.inc.php");

    if (!isset($_SESSION["user_id"]) || !isset($_GET['id'])) {
        header("Location: profile.php");
        die();
    }

    require_once 'include/dbh.inc.php';
    require_once 'include/events_model.inc.php';

    $eventId = intval($_GET['id']);
    $event = get_single_event($pdo, $eventId);

    // Verify record existence and creator identity matches session
    if (!$event || (int)$event['organiser_id'] !== (int)$_SESSION["user_id"]) {
        header("Location: profile.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - EventPlanned</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/create_event.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include('header.php'); ?>

    <main class="create-event-wrapper">
        <form action="include/edit_event.inc.php" method="POST" enctype="multipart/form-data" class="create-event-form">
            <h2>Modify Event Details</h2>
            <p class="form-subtitle">Update fields below to edit your existing publication rules.</p>

            <?php
                if (isset($_SESSION['edit_event_success'])) {
                    echo '<p style="color: #02c685; background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 8px; border: 1px solid #10b981; text-align: center; width:100%; box-sizing:border-box;">' . $_SESSION['edit_event_success'] . '</p>';
                    unset($_SESSION['edit_event_success']);
                }
                if (isset($_SESSION['edit_event_errors'])) {
                    foreach ($_SESSION['edit_event_errors'] as $error) {
                        echo '<p style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 12px; border-radius: 8px; border: 1px solid #ef4444; text-align: center; width:100%; box-sizing:border-box;">' . $error . '</p>';
                    }
                    unset($_SESSION['edit_event_errors']);
                }
            ?>

            <input type="hidden" name="eventId" value="<?php echo $event['id']; ?>">
            <input type="hidden" name="existingImage" value="<?php echo htmlspecialchars($event['image']); ?>">

            <div class="form-row">
                <div class="form-group flex-2">
                    <label for="eventName">Event Name</label>
                    <input type="text" id="eventName" name="eventName" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
                </div>
                <div class="form-group flex-1">
                    <label for="eventCategory">Category</label>
                    <select id="eventCategory" name="eventCategory" required>
                        <?php $cat = $event['label']; ?>
                        <option value="Concert" <?php echo $cat === 'Concert' ? 'selected' : ''; ?>>Concert</option>
                        <option value="Festival" <?php echo $cat === 'Festival' ? 'selected' : ''; ?>>Festival</option>
                        <option value="Exposition" <?php echo $cat === 'Exposition' ? 'selected' : ''; ?>>Exposition</option>
                        <option value="Theater Act" <?php echo $cat === 'Theater Act' ? 'selected' : ''; ?>>Theater Act</option>
                        <option value="Sport" <?php echo $cat === 'Sport' ? 'selected' : ''; ?>>Sport Event</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group flex-1">
                    <label for="eventTime">Date & Time</label>
                    <?php $formattedTime = date('Y-m-d\TH:i', strtotime($event['event_time'])); ?>
                    <input type="datetime-local" id="eventDate" name="eventTime" value="<?php echo $formattedTime; ?>" required>
                </div>
                <div class="form-group flex-1">
                    <label for="eventPrice">Price (MDL)</label>
                    <input type="number" id="eventPrice" name="eventPrice" value="<?php echo htmlspecialchars((string)$event['price']); ?>" min="0" step="0.01" required>
                </div>
            </div>

            <div class="form-group">
                <label for="eventLocation">Location</label>
                <input type="text" id="eventLocation" name="eventLocation" value="<?php echo htmlspecialchars($event['event_location']); ?>" required>
            </div>

            <div class="form-group">
                <label for="eventImage">Change Event Poster (Leave blank to keep existing)</label>
                <input type="file" id="eventImage" name="eventImage" accept="image/*">
                <p style="font-size:12px; margin:5px 0 0 5px; color:var(--text-2);">Curent: <?php echo htmlspecialchars($event['image']); ?></p>
            </div>

            <div class="form-group">
                <label for="eventDescription">Description</label>
                <textarea id="eventDescription" name="eventDescription" rows="6" required><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>

            <div style="display:flex; gap:15px;">
                <button type="submit" class="create-event-btn" style="flex:3;">Save Modifications</button>
                <button type="button" class="create-event-btn" onclick="window.location.href='profile.php'" style="flex:1; background:#6b7280;">Back</button>
            </div>
        </form>
    </main>

    <?php include('footer.php'); ?>
    <script src="js/theme.js"></script>
</body>
</html>