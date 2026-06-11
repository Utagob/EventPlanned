<?php
    require_once('include/config_session.inc.php');
    require_once("include/login_view.inc.php");

    if (!isset($_SESSION["user_id"])) {
        header("Location: index.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - EventPlanned</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/create_event.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/create_event.css">
    <link href="https://fonts.googleapis.com/css2?family=Intel+One+Mono:ital,wght@0,300..700;1,300..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include('header.php'); ?>

    <main class="create-event-wrapper">

        <?php
            if (isset($_SESSION['create_event_success'])) {
                echo '<p style="color: #02c685; background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 8px; border: 1px solid #10b981; text-align: center; justify-self: center; align-self: center">' . $_SESSION['create_event_success'] . '</p>';
                unset($_SESSION['create_event_success']);
            }
            if (isset($_SESSION['create_event_errors'])) {
                foreach ($_SESSION['create_event_errors'] as $error) {
                    echo '<p style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 12px; border-radius: 8px; border: 1px solid #ef4444; text-align: center; justify-self: center; align-self: center"">' . $error . '</p>';
                }
                unset($_SESSION['create_event_errors']);
            }
        ?>

        <form action="include/create_event.inc.php" method="POST" enctype="multipart/form-data" class="create-event-form">
            <h2 data-key="create_title">Create a New Event</h2>
            <p class="form-subtitle" data-key="create_subtitle">Fill in the details below to publish your event.</p>

            <div class="form-row">
                <div class="form-group flex-2">
                    <label for="eventName" data-key="create_label_name">Event Name</label>
                    <input type="text" id="eventName" name="eventName" placeholder="e.g., Summer Music Festival" data-key="create_placeholder_name" required>
                </div>
                <div class="form-group flex-1">
                    <label for="eventCategory" data-key="create_label_category">Category</label>
                    <select id="eventCategory" name="eventCategory" required>
                        <option value="" disabled selected data-key="create_select_category">Select a category</option>
                        <option value="Concert">Concert</option>
                        <option value="Festival">Festival</option>
                        <option value="Exposition">Exposition</option>
                        <option value="Theater Act">Theater Act</option>
                        <option value="Sport">Sport Event</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group flex-1">
                    <label for="eventTime" data-key="create_label_datetime">Date & Time</label>
                    <input type="datetime-local" id="eventDate" name="eventTime" required>
                </div>
                <div class="form-group flex-1">
                    <label for="eventPrice" data-key="create_label_price">Price (MDL)</label>
                    <input type="number" id="eventPrice" name="eventPrice" placeholder="0.00" min="0" step="0.01" required>
                </div>
            </div>

            <div class="form-group">
                <label for="eventLocation" data-key="create_label_location">Location</label>
                <input type="text" id="eventLocation" name="eventLocation" placeholder="e.g., Piata Marii Adunari Nationale" data-key="create_placeholder_location" required>
            </div>

            <div class="form-group">
                <label for="eventImage" data-key="create_label_image">Event Poster / Image</label>
                <input type="file" id="eventImage" name="eventImage" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="eventDescription" data-key="create_label_desc">Description</label>
                <textarea id="eventDescription" name="eventDescription" rows="6" placeholder="Tell people what your event is about..." data-key="create_placeholder_desc" required></textarea>
            </div>

            <button type="submit" class="create-event-btn" data-key="create_btn">Publish Event</button>
        </form>
    </main>

    <?php include('footer.php'); ?>

    <script src="js/theme.js"></script>
    <script src="js/script.js"></script>
</body>
</html>