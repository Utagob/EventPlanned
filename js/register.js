const signupBtn = document.getElementsByName('signup')[0];
const signupSection = document.querySelector('.signup');

const loginBtn = document.getElementsByName('login')[0];
const loginSection = document.querySelector('.login');

signupBtn.addEventListener("click", (e) => {
    if(signupSection.style.display !== "block"){
        signupSection.style.display = "block";
        loginSection.style.display = "none";
        
        loginBtn.classList.add('inactive');
        loginBtn.style.display = "block";
        signupBtn.style.display = "none";
    }
});

loginBtn.addEventListener("click", (e) => {
    if(loginSection.style.display !== "block"){
        loginSection.style.display = "block";
        signupSection.style.display = "none";

        signupBtn.classList.add('inactive');
        signupBtn.style.display = "block";
        loginBtn.style.display = "none";
    }
});