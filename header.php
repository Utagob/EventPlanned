<?php
require_once "include/config_session.inc.php";
require_once "include/login_view.inc.php";
require_once "include/signup_view.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_SESSION['user_id'])){
        if (isset($_POST['submit'])) {
            header('Location: profile.php');
        }
        if (isset($_POST['cta-btn'])) {   
            header('Location: createEvent.php');
        }
    }
}
?>

<header>
    <div class="logo" style="cursor: pointer;">EventPlanned</div>
    
    <div class="center" style="position: relative;">
        <form class="form" onsubmit="event.preventDefault();">
            <button type="submit">
                <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                   <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                        stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
            </button>
            <input class="input" placeholder="Caută" data-key="search_placeholder" required="" type="text" autocomplete="off" id="liveSearchInput">
            <button class="reset" type="reset" id="liveSearchReset">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </form>
        
        <div id="searchSuggestionsDropdown" class="search-autocomplete-dropdown" style="display: none;"></div>
    </div>

    <div class="right">
        <div class="language">
            <button type="button" id="langToggleBtn" data-current-lang="RO">
                <svg class="lang" width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg"></svg>
                <span id="langLabel">RO</span>
            </button>
        </div>
        <form class="account" method="POST">
            <button class="accountBtn" type="submit" name="submit" style="padding: 0; border: none; background: transparent">
                <img <?php output_avatar(); ?>>
            </button>
        </form>
        <div class="themeButton">
            <button type="submit" name="theme" style="padding: 0; border: none; background: transparent">
                <img src="image/moon.svg" class="themeButtonImg">
            </button>
        </div>
    </div>
    
    <div class="categories">
        <button class="categoriesButton" data-key="cat_concerts" data-category="Concert">Concertes</button>
        <button class="categoriesButton" data-key="cat_festivals" data-category="Festival">Festivals</button>
        <button class="categoriesButton" data-key="cat_expositions" data-category="Exposition">Expositions</button>
        <button class="categoriesButton" data-key="cat_acts" data-category="Theater Act">Acts</button>
        <button class="categoriesButton" data-key="cat_sports" data-category="Sport">Sports</button>
    </div>
</header>