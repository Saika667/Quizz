/* Gestion du menu login / register */
const menuLoginButton = document.getElementById('login');
const menuRegisterButton = document.getElementById('register');
const loginForm = document.getElementsByClassName('auth-container-form-login')[0];
const registerForm = document.getElementsByClassName('auth-container-form-register')[0];
const menuCursor = document.getElementsByClassName('auth-container-menu-cursor')[0];

menuLoginButton.addEventListener('click', function() {
    if(registerForm.classList.contains("hide") || menuLoginButton.classList.contains("active")) {
        return;
    } else {
        menuCursor.style.left = 0;
        menuRegisterButton.classList.remove("active");
        menuLoginButton.classList.add("active");
        registerForm.classList.add("hide");
        loginForm.classList.remove("hide");
    }
});

menuRegisterButton.addEventListener('click', function() {
    if(loginForm.classList.contains("hide") || menuRegisterButton.classList.contains("active")) {
        return;
    } else {
        menuCursor.style.left = `50%`;
        menuLoginButton.classList.remove("active");
        menuRegisterButton.classList.add("active");
        loginForm.classList.add("hide");
        registerForm.classList.remove("hide");
    }
});

/* Gestion de l'affichage de l'avatar */
const optionsContainer = document.getElementsByClassName('auth-container-form-register-select-options')[0];
const preview = document.getElementsByClassName('auth-container-form-register-select-preview')[0];
const previewImage = document.getElementsByClassName('auth-container-form-register-select-preview')[0].children[0];
const images = document.getElementsByClassName('auth-container-form-register-select-options-option');
let selectedImage = document.querySelector('.auth-container-form-register-select-options-option.active');

for (let i = 0; i < images.length; i++) {
    images[i].addEventListener('click', function() {
        if(this.classList.contains('active')) {
            optionsContainer.classList.add('hide');
            return;
        }
        selectedImage.classList.remove('active');
        selectedImage = this;
        this.classList.add('active');
        optionsContainer.classList.add('hide');
        const newImgSrc = this.querySelector('img').getAttribute('src');
        previewImage.setAttribute('src', newImgSrc);
    })
}

preview.addEventListener('click', function() {
    optionsContainer.classList.toggle('hide');
});

/* Création d'un compte */
const registerButton = document.getElementsByClassName('auth-container-form-register-button-content')[0];
registerButton.addEventListener('click', function() {
    let selectedAvatar = document.querySelector('.auth-container-form-register-select-preview img').src.split('/');
    selectedAvatar = selectedAvatar[selectedAvatar.length-1];
    const username = document.getElementById('register-username').value;
    const password = document.getElementById('register-password').value;
    const confirmationPassword = document.getElementById('confirmation-password').value;
    let hasError = false;
    /* Validation de données */
    const registerPseudoError = document.getElementById('register-pseudo-error');
    const registerPasswordError = document.getElementById('register-password-error');
    const registerConfPasswordError = document.getElementById('register-conf-password-error');
    //Réinitialise les erreurs
    registerPseudoError.textContent = "";
    registerPasswordError.textContent = "";
    registerConfPasswordError.textContent = "";

    const pseudoRegex = new RegExp(/^[a-zA-Z0-9-' ]{1,50}$/);
    const passwordRegex = new RegExp(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_\-+]).{8,}$/);

    if (username.trim() === '') {
        registerPseudoError.textContent = "Le nom d'utilisateur est requis.";
        hasError = true;
    } else if (username.length > 50) {
        registerPseudoError.textContent = "Le nom d'utilisateur est trop long (50 charactères maximum).";
        hasError = true;
    } else if (!pseudoRegex.test(username)) {
        registerPseudoError.textContent = "Le nom d'utilisateur est incorrect, les charactères spéciaux ne sont pas acceptés sauf le '-'.";
        hasError = true;
    }

    if (password.trim() === '') {
        registerPasswordError.textContent = "Le mot de passe est requis.";
        hasError = true;
    } else if (password.length < 8) {
        registerPasswordError.textContent = "Le mot de passe doit contenir au moins 8 charactères.";
        hasError = true;
    } else if (!passwordRegex.test(password)) {
        registerPasswordError.textContent = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un charactère spécial (sauf '=').";
        hasError = true;
    }

    if (confirmationPassword.trim() === '') {
        registerConfPasswordError.textContent= "La confirmation du mot de passe est requise.";
        hasError = true;
    } else if (password !== confirmationPassword) {
        registerConfPasswordError.textContent = "Le mot de passe ne correspond pas.";
        hasError = true;
    }
    /* Fin de validation de données */
    if (hasError) {
        return;
    }

    fetch("/quizz/auth/register", {
        method: "POST",
        body: JSON.stringify({
            username,
            password,
            image: selectedAvatar
        }),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        if (data.status === 'error') {
            registerPseudoError.textContent = data.message;
            return;
        }
        menuCursor.style.left = 0;
        menuRegisterButton.classList.remove("active");
        menuLoginButton.classList.add("active");
        registerForm.classList.add("hide");
        loginForm.classList.remove("hide");
    });
});

/* Connexion d'un utilisateur */
const loginButton = document.getElementById('login-button');
loginButton.addEventListener('click', function() {
    const loginUsername = document.getElementById('login-username').value;
    const loginPassword = document.getElementById('login-password').value;
    let hasError = false;
    /* Validation de données */
    const loginPseudoError = document.getElementById('login-pseudo-error');
    const loginPasswordError = document.getElementById('login-password-error');
    const loginError = document.getElementById('login-error');
    //Réinitialise les erreurs
    loginPseudoError.textContent = "";
    loginPasswordError.textContent = "";
    loginError.textContent = "";

    if (loginUsername.trim() === '') {
        loginPseudoError.textContent = "Le nom d'utilisateur est requis.";
        hasError = true;
    }

    if (loginPassword.trim() === '') {
        loginPasswordError.textContent = "Le mot de passe est requis.";
        hasError = true;
    }

    if (hasError) {
        return;
    }
    /* Fin de validation de données */

    fetch("/quizz/auth/login", {
        method: "POST",
        body: JSON.stringify({
            username: loginUsername,
            password: loginPassword
        }),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(async function(response) {
        if (!response.ok) {
            loginError.textContent = "Couple nom d'utilisateur / mot de passe incorrect.";
        }
        return response.json()
    }).then(function(data) {
        if(data.status === 'success') {
            window.location.href = '../';
        }
    });
});

/* Connexion invité */
const guestLoginButton = document.getElementById('guest-login-button');
guestLoginButton.addEventListener('click', function() {
    fetch("/quizz/auth/login", {
        method: "POST",
        body: JSON.stringify({
            username: 'Invite'
        }),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(async function(response) {
        if (!response.ok) {
            loginError.textContent = "Couple nom d'utilisateur / mot de passe incorrect.";
        }
        return response.json()
    }).then(function(data) {
        if(data.status === 'success') {
            window.location.href = '../';
        }
    });
});