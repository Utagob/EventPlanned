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

function showSignupView() {
    if (signupSection && loginSection && signupBtn && loginBtn) {
        signupSection.style.display = "block";
        loginSection.style.display = "none";
        
        signupBtn.style.display = "none";
        signupBtn.classList.remove('inactive');
        
        loginBtn.style.display = "block";
        loginBtn.classList.add('inactive');
    }
}

function showLoginView() {
    if (signupSection && loginSection && signupBtn && loginBtn) {
        loginSection.style.display = "block";
        signupSection.style.display = "none";
        
        loginBtn.style.display = "none";
        loginBtn.classList.remove('inactive');
        
        signupBtn.style.display = "block";
        signupBtn.classList.add('inactive');
    }
}

if (modal) {
    if (accountIcon) {
        accountIcon.addEventListener('click', (e) => {
            e.preventDefault(); 
            resetModalToDefaultView();
            modal.style.display = 'block';
        });
    }
    if (ctaBtn) {
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
    signupBtn.addEventListener("click", () => {
        showSignupView();
    });

    loginBtn.addEventListener("click", () => {
        showLoginView();
    });
}

// Open and layout configuration initialization on DOM Ready
document.addEventListener("DOMContentLoaded", () => {
    const modalContainer = document.getElementById('accountModal');
    if (!modalContainer) return;

    const autoOpen = modalContainer.getAttribute('data-auto-open') === 'true';
    const initialView = modalContainer.getAttribute('data-initial-view');

    if (autoOpen) {
        modalContainer.style.display = 'block'; 
        
        if (initialView === 'signup') {
            showSignupView();
        } else if (initialView === 'login') {
            showLoginView();
        }
    }
});