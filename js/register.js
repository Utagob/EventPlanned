const modal = document.getElementById('accountModal');
const closeModalBtn = document.getElementById('closeModalBtn');
const accountIcon = document.querySelector('.accountBtn');
const ctaBtn = document.querySelector('.cta-btn');

const signupBtn = document.getElementsByName('signup')[0];
const signupSection = document.querySelector('.signup');
const loginBtn = document.getElementsByName('login')[0];
const loginSection = document.querySelector('.login');

function resetModalToDefaultView() {
    if (signupSection && loginSection && signupBtn && loginBtn) {

        signupSection.style.display = "none";
        loginSection.style.display = "none";

        signupBtn.style.display = "block";
        signupBtn.classList.remove('inactive');
        
        loginBtn.style.display = "block";
        loginBtn.classList.remove('inactive');
    }
}

if (modal) {
    if (accountIcon || ctaBtn) {
        accountIcon.addEventListener('click', (e) => {
            e.preventDefault(); 
            
            resetModalToDefaultView();
            
            modal.style.display = 'block';
        });
        ctaBtn.addEventListener('click', (e) => {
            e.preventDefault(); 
            
            resetModalToDefaultView();
            
            modal.style.display = 'block';
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
}

if (signupBtn && loginBtn) {
    signupBtn.addEventListener("click", (e) => {
        if (!signupBtn.classList.contains('inactive')) {
            signupSection.style.display = "block";
            loginSection.style.display = "none";
            
            loginBtn.classList.add('inactive');
            loginBtn.style.display = "block";
            signupBtn.style.display = "none";
        } else {
            signupSection.style.display = "block";
            loginSection.style.display = "none";
            
            signupBtn.classList.remove('inactive');
            signupBtn.style.display = "none";
            
            loginBtn.classList.add('inactive');
            loginBtn.style.display = "block";
        }
    });

    loginBtn.addEventListener("click", (e) => {
        if (!loginBtn.classList.contains('inactive')) {
            loginSection.style.display = "block";
            signupSection.style.display = "none";

            signupBtn.classList.add('inactive');
            signupBtn.style.display = "block";
            loginBtn.style.display = "none";
        } else {
            loginSection.style.display = "block";
            signupSection.style.display = "none";
            
            loginBtn.classList.remove('inactive');
            loginBtn.style.display = "none";
            
            signupBtn.classList.add('inactive');
            signupBtn.style.display = "block";
        }
    });
}