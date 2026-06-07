<?php
require_once "include/config_session.inc.php";
require_once "include/login_view.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        if($_SESSION !== ""){
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
    <title>EventPlanned</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="logo">LOGO</div>
        <div class="center">
            <form class="form">
                <button>
                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                        aria-labelledby="search">
                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                            stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </button>
                <input class="input" placeholder="Caută" required="" type="text">
                <button class="reset" type="reset">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>
            <div class="language">
                <select name="languageSelect">
                    <option value="En">En</option>
                    <option value="RU">Ru</option>
                    <option value="RO">Ro</option>
                </select>
            </div>
        </div>
        <div class="right">
            <form class="account" method="POST">
                <button type="submit" name="submit" style="padding: 0; border: none; background: transparent">
                    <img <?php output_avatar();?>>
                </button>
            </form>
            <form class="themeButton">
                <img src="image/moon.svg" class="themeButtonImg">
            </form>
        </div>
        <div class="categories">
            <button class="categoriesButton">Concertes</button>
            <button class="categoriesButton">Festivals</button>
            <button class="categoriesButton">Expositions</button>
            <button class="categoriesButton">Acts</button>
            <button class="categoriesButton">Sports</button>
            <select name="categorySelect">
                <option value="">More</option>
                <option value="Training">Training</option>
                <option value="PentruCopii">For kids</option>
            </select>
        </div>
    </header>

    <div class="showcase">
        <img src="image/eveniment2.webp" class="img1">
        <img src="image/eveniment1.webp" class="img2">
        <img src="image/eveniment3.jpg" class="img3">
    </div>

    <!-- <?php

    $contents = file_get_contents("data/items.json");

    try {

        $data = json_decode($contents, flags: JSON_THROW_ON_ERROR);

    } catch (JsonException $e) {

        exit($e->getMessage());

    }

    echo "<pre>";
    print_r($data);
    echo "</pre>";

    ?> -->

<script src="js/script.js"></script>
</body>
</html>