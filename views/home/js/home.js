/* Gestion du bouton création de quiz */
document.getElementById('add-button').addEventListener('click', function() {
    window.location.href = "quizz/creation";
});

/* Gestion des boutons de sélection de thème de quiz */
const themeButtons = document.getElementsByClassName('quizz-container-theme');
for (let i = 0; i < themeButtons.length; i++) {
    themeButtons[i].addEventListener('click', function() {
        window.location.href = `quizz/list/${themeButtons[i].dataset.themeId}`;
    });
};

/* Gestion du bouton de déconnexion */
const logoutButton = document.getElementsByClassName('player-content-image-logout')[0];
const imageContainer = document.getElementsByClassName('player-content-image')[0];
imageContainer.addEventListener('click', function() {
    logoutButton.classList.toggle('active');
});

logoutButton.addEventListener('click', function() {
    fetch("/quizz/auth/logout", {
        method: "POST",
        body: {},
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(function(response) {
        return response.json()
    }).then(function() {
        window.location.href = "../quizz/auth/account";
    });
})