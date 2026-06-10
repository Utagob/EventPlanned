<?php
    require_once("include/config_session.inc.php");
    require_once("include/login_view.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    
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

    <form action="include/logout.inc.php" method="POST" class="Logout">
        <button>Logout</button>
    </form>
</div>

<div class="myEvents">
    <p class="myEventsText">My Events:</p>
    <button class="myEventsAdd">
        <svg width="20" height="20" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M30 17.1429H17.1429V30H12.8571V17.1429H0V12.8571H12.8571V0H17.1429V12.8571H30V17.1429Z" fill="black"/>
        </svg>
    </button>
</div>

<div class="myLikedEvents">
    <p class="myLikedEventsText">My Liked Events:</p>
</div>

<script src="js/theme.js"></script>
</body>
</html>