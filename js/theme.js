const style = document.querySelector('#theme');
const themeBtn = document.getElementsByName('theme')[0];

const themeBtnImg = document.createElement('img');
themeBtnImg.className = "themeButtonImg";
themeBtn.appendChild(themeBtnImg);

const lang = document.querySelector('.lang');
const account = document.querySelector('.loggedOutAvatar'); 

themeBtn.addEventListener("click", () => {
    if(style.getAttribute('href') === 'css/style.css'){
        style.setAttribute('href', 'css/dark-style.css');
        themeBtnImg.setAttribute('src', 'image/sun.svg');
        account?.setAttribute('src', 'image/account-d.svg');
        lang.setAttribute('src', 'image/globe-d.svg');
        localStorage.setItem('theme', 'dark');
    } else {
        style.setAttribute('href', 'css/style.css');
        themeBtnImg.setAttribute('src', 'image/moon.svg');
        account?.setAttribute('src', 'image/account.svg');
        lang.setAttribute('src', 'image/globe.svg');
        localStorage.setItem('theme', 'light');
    }
});

window.addEventListener("load", ()=> {
    const themeStored = localStorage.getItem('theme');
    if(themeStored === 'dark'){
        style.setAttribute('href', 'css/dark-style.css');
        themeBtnImg.setAttribute('src', 'image/sun.svg');
        account?.setAttribute('src', 'image/account-d.svg');
        lang.setAttribute('src', 'image/globe-d.svg');
    } else {
        style.setAttribute('href', 'css/style.css');
        themeBtnImg.setAttribute('src', 'image/moon.svg');
        account?.setAttribute('src', 'image/account.svg');
        lang.setAttribute('src', 'image/globe.svg');
        if (!themeStored) localStorage.setItem('theme', 'light');
    }
});