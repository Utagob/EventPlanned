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
                echo '<p>Date: ' . date('d m Y', $_SESSION['user_date']) . '</p>';
            ?>
        </div>
    </div>

    <form action="include/logout.inc.php" method="POST" class="Logout">
        <button>Logout</button>
    </form>
</div>

</body>
</html>