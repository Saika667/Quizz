// onload execute la fonction anonyme lorsque la page est chargée
window.onload = function() {

    const backButton = document.getElementsByClassName("list-head-back")[0];
    backButton.addEventListener('click', function() {
        window.location.href = `../../../quizz`
    });

    /* Gestion de l'apparition des quiz */
    const quizzContainers = document.getElementsByClassName('list-container-quizz');
    for (let i = 0; i < quizzContainers.length; i++) {
        quizzContainers[i].style.opacity = '1';
        quizzContainers[i].style.transitionDelay = `${(i + 1) * 250}ms`;
        quizzContainers[i].addEventListener('click', function() {
            const quizzId = this.dataset.quizzId;
            window.location.href = `../../../quizz/play/show/${quizzId}`;
        })
    }
}

const createQuizzButton = document.getElementsByClassName('list-container-empty-button')[0];
createQuizzButton.addEventListener('click', function() {
    window.location.href = `../../../quizz/quizz/creation`
});