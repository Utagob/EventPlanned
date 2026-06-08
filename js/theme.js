const style = document.querySelector('#theme');
const themeBtn = document.getElementsByName('theme')[0];

themeBtn.addEventListener("click", () => {
    if(style.getAttribute('href') === 'css/style.css'){
        style.setAttribute('href', 'css/dark-style.css');
        localStorage.setItem('theme', 'dark');
    } else {
        style.setAttribute('href', 'css/style.css');
        localStorage.setItem('theme', 'light');
    }
});

window.addEventListener("load", ()=> {
    const themeStored = localStorage.getItem('theme');
    if(themeStored === 'dark'){
            style.setAttribute('href', 'css/dark-style.css');
        } else {
            style.setAttribute('href', 'css/style.css');
        }
    const User = localStorage.getItem('User');
})