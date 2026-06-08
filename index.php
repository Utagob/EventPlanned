<?php
require_once "include/config_session.inc.php";
require_once "include/login_view.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        if(isset($_SESSION['user_id'])){
            header('Location: profile.php');
        } else {
            header('Location: register.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPlanned</title>
    <link id="theme" rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
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

    <div class="events">
        <div class="eventsSection">
            <h3>Popular events</h3>
            <div class="event">
                <p class="eventInfo">
                    <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.4 6.6H8.4V9.6H5.4V6.6ZM9.6 1.2H9V0H7.8V1.2H3V0H1.8V1.2H1.2C0.54 1.2 0 1.74 0 2.4V10.8C0 11.46 0.54 12 1.2 12H9.6C10.26 12 10.8 11.46 10.8 10.8V2.4C10.8 1.74 10.26 1.2 9.6 1.2ZM9.6 2.4V3.6H1.2V2.4H9.6ZM1.2 10.8V4.8H9.6V10.8H1.2Z" fill="black"/>
                    </svg>
                    5-6 Octombrie
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.80032 6.12519C9.80032 4.77152 8.70391 3.67511 7.35024 3.67511C5.99657 3.67511 4.90016 4.77152 4.90016 6.12519C4.90016 7.47886 5.99657 8.57527 7.35024 8.57527C8.70391 8.57527 9.80032 7.47886 9.80032 6.12519ZM6.1252 6.12519C6.1252 5.45142 6.67647 4.90015 7.35024 4.90015C8.02401 4.90015 8.57528 5.45142 8.57528 6.12519C8.57528 6.79896 8.02401 7.35023 7.35024 7.35023C6.67647 7.35023 6.1252 6.79896 6.1252 6.12519Z" fill="black"/>
                        <path d="M6.99497 13.3591C7.0991 13.4326 7.22773 13.4755 7.35024 13.4755C7.47274 13.4755 7.60137 13.4387 7.7055 13.3591C7.88925 13.2243 12.2688 10.0698 12.2504 6.11909C12.2504 3.41788 10.0514 1.21893 7.35024 1.21893C4.64902 1.21893 2.45008 3.41788 2.45008 6.11909C2.4317 10.0637 6.81122 13.2243 6.99497 13.3591ZM7.35024 2.4501C9.37768 2.4501 11.0254 4.09778 11.0254 6.12522C11.0376 8.8448 8.33639 11.2888 7.35024 12.0912C6.36408 11.2888 3.66287 8.85093 3.67512 6.12522C3.67512 4.09778 5.3228 2.4501 7.35024 2.4501Z" fill="black"/>
                    </svg>
                    Chisinau
                </p>
                <p class="eventTitle">Ziua Vinului</p>
                <div class="eventIlustration">
                    <p class="price">135MDL</p>
                    <svg class="eventHeart" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.1 16.9482L10 17.0572L9.89 16.9482C5.14 12.2507 2 9.14441 2 5.99455C2 3.81471 3.5 2.17984 5.5 2.17984C7.04 2.17984 8.54 3.26975 9.07 4.75204H10.93C11.46 3.26975 12.96 2.17984 14.5 2.17984C16.5 2.17984 18 3.81471 18 5.99455C18 9.14441 14.86 12.2507 10.1 16.9482ZM14.5 0C12.76 0 11.09 0.882834 10 2.26703C8.91 0.882834 7.24 0 5.5 0C2.42 0 0 2.6267 0 5.99455C0 10.1035 3.4 13.4714 8.55 18.5613L10 20L11.45 18.5613C16.6 13.4714 20 10.1035 20 5.99455C20 2.6267 17.58 0 14.5 0Z" fill="black"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <?php
        include('footer.php');
    ?>

<script src="js/theme.js"></script>
<script src="js/script.js"></script>
</body>
</html>