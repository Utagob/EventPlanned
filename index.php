<!DOCTYPE html>
<html lang="ro">

<head>
    <title>EventPlanned</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div id="logo">LOGO</div>
        <div id="center">
            <form class="form">
                <button>
                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                <input class="input" placeholder="Caută" required="" type="text">
                <button class="reset" type="reset">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>
            <div id="language">
                <select name="languageSelect">
                    <option value="RO">RO</option>
                    <option value="RU">RU</option>
                    <option value="EN">EN</option>
                </select>
            </div>
        </div>
        <div id="right">
            <div id="account">
                <img src="image/account.svg" id="accountImg">
            </div>
            <div id="themeButton">
                <img src="image/moon.svg" id="themeButtonImg">
            </div>
        </div>
        <div id="categories">
            <button class="categoriesButton">Concerte</button>
            <button class="categoriesButton">Festivaluri</button>
            <button class="categoriesButton">Expoziții</button>
            <button class="categoriesButton">Spectacole</button>
            <button class="categoriesButton">Sport</button>
            <select name="categorySelect" >
                <option value="">Mai multe</option>
                <option value="Training">Training</option>
                <option value="PentruCopii">Pentru Copii</option>
            </select>
        </div>
    </header>

    <div class="showcase">
        <img src="image/eveniment2.webp" id="img1"></img>
        <img src="image/eveniment1.webp" id="img2"></img>
        <img src="image/eveniment3.jpg" id="img3"></img>
    </div>

    <?php
    
    $contents = file_get_contents("data/items.json");

    try{

        $data = json_decode($contents, flags: JSON_THROW_ON_ERROR);

    }catch(JsonException $e){

        exit($e->getMessage());

    }

    echo "<pre>";
    print_r($data);
    echo "</pre>";
    
    ?>

</body>
</html>