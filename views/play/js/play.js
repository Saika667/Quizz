// validateButton.addEventListener("click", function() {
//     const radioButtons = document.querySelectorAll("input[type='radio']");
//     console.log(radioButtons);
//     let quizzAnswers = [];

//     radioButtons.forEach(function(radio) {
//         if (radio.checked) {
//             console.log(radio.id, radio.name);
//             quizzAnswers.push({question: radio.name.replace('question-', ''), answer: radio.id});
//         }
//     });
//     const quizzId = document.getElementById("quizz-id").value;

//     fetch("/quizz/play/saveAnswer", {
//         method: "POST",
//         body: JSON.stringify({
//             quizzId: quizzId,
//             quizzAnswers: quizzAnswers
//         }),
//         headers: {
//             "Content-type": "application/json; charset=UTF-8"
//         }
//     });
    
//     console.log(quizzAnswers);
// });

let userAnswers = [];
/* Gestion du bouton valider la réponse du formulaire de jeu */
const validateButtons = document.getElementsByClassName("validate-button");
for (let i = 0; i < validateButtons.length; i++) {
    validateButtons[i].addEventListener('click', function() {
        //vérifier la réponse avec méthode controller

        //récupère le parent
        const parent = validateButtons[i].parentNode;
        //récupère la réponse sélectionné par l'utilisateur
        const selectedAnswer = parent.querySelector('.play-question-container-wrapper-answers .active');
        const answerId = selectedAnswer.id.replace('answer-', '');
        const questionId = parent.id.replace('question-', '');

        const selectedAnswerFullCircle = selectedAnswer.querySelector('.full-circle');
        const selectedAnswerCheck = selectedAnswer.querySelector('.check');
        const selectedAnswerXmark = selectedAnswer.querySelector('.xmark');
        fetch("/quizz/play/saveAnswer", {
            method: "POST",
            body: JSON.stringify({
                questionId,
                answerId
            }),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        }).then(function(response) {
            return response.json();
        }).then(function(data) {
            if (data["valid_answer_id"] === answerId) {
                selectedAnswer.classList.add('correct');
                selectedAnswerCheck.classList.remove('hide');
                selectedAnswerFullCircle.classList.add('hide');
                userAnswers.push({question : questionId, answer : answerId});
            } else {
                selectedAnswer.classList.add('incorrect');
                selectedAnswerXmark.classList.remove('hide');
                selectedAnswerFullCircle.classList.add('hide');
                const valid = parent.querySelector('.play-question-container-wrapper-answers #answer-' + data["valid_answer_id"]);
                valid.classList.add('correct');
                valid.querySelector('.check').classList.remove('hide');
                valid.querySelector('.circle').classList.add('hide');
                userAnswers.push({question : questionId, answer : answerId});
            }
        });

        this.classList.add('hide');
        this.nextElementSibling.classList.remove('hide');
    })
}

/* Gestion du bouton suivant du formulaire de jeu */
const nextButtons = document.getElementsByClassName("next-button");
for (let i = 0; i < nextButtons.length; i++) {
    nextButtons[i].addEventListener('click', function() {
        const allQuestionsContainer = document.getElementsByClassName('play-question-container');
        const activeIndex = document.querySelector('.play-wrapper-head-index.active').innerText;
        if(parseInt(activeIndex) === allQuestionsContainer.length) {
            
        } else {
            for (let j = 0; j < allQuestionsContainer.length; j++) {
                allQuestionsContainer[j].style.transform = `translateX(-${activeIndex * 100}vw)`;
            }
    
            const parent = this.parentNode;
            const nextQuestion = parseInt(parent.id.replace('question-', '')) + 1;
            parent.classList.remove('shown');
            const nextQuestionContainer = document.getElementById('question-' + nextQuestion);
            nextQuestionContainer.classList.add('shown');
            nextQuestionContainer.style.opacity = '1';
            setActiveBubble();
        }
    });
}

/* Envoi des réponses */
document.querySelector('.send-quizz').addEventListener('click', function() {
    fetch("/quizz/play/saveAnswers", {
        method: "POST",
        body: JSON.stringify({
            quizzId: document.getElementById("quizz-id").value,
            quizzAnswers: userAnswers
        }),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        console.log(data);
        window.location.href = `../show-results/${data.participationId}`;
    });
});

/* Affichage dynamique sélection de réponse */
const answers = document.getElementsByClassName("play-question-container-wrapper-answers-container");
for (let i = 0; i < answers.length; i++) {
    answers[i].addEventListener('click', function() {
        
        const nextButton = this.parentNode.parentNode.parentNode.querySelector('.next-button'); 
        if(nextButton && !nextButton.classList.contains("hide")) {
            return;
        }
        const emptyCircle = answers[i].children[1];
        const fullCircle = answers[i].children[2];

        for (let j = 0; j < answers.length; j++) {
            answers[j].classList.remove('active');
            const emptyCircleJ = answers[j].children[1];
            const fullCircleJ = answers[j].children[2];
            emptyCircleJ.classList.remove('hide');
            fullCircleJ.classList.add('hide');
        }
        answers[i].classList.add('active');
        emptyCircle.classList.add('hide');
        fullCircle.classList.remove('hide');
    });
}

/* affichage dynamique de l'entête */
function setActiveBubble() {
    const activeQuestion = document.querySelector(".shown");
    const activeQuestionId = activeQuestion.id.replace("question-", "");
    const bubblesHeader = document.getElementsByClassName("play-wrapper-head-index");
    const wrapper = document.querySelector('.play-wrapper');
    const wrapperWidth = wrapper.offsetWidth;
    const headContainer = document.querySelector('.play-wrapper-head');
    let isChecked = true;
    if (wrapperWidth > headContainer.offsetWidth) {
        wrapper.style.display = 'flex';
        wrapper.style.justifyContent = 'center';
    }

    for (let i = 0; i < bubblesHeader.length; i++) {
        const bubbleQuestionId = bubblesHeader[i].id.replace("header-", "");
        if (bubbleQuestionId === activeQuestionId) {
            isChecked = false;
            bubblesHeader[i].classList.add('active');
        } else {
            if(isChecked) {
                bubblesHeader[i].innerHTML = "<i class='fa-solid fa-check'></i>";
            }

            bubblesHeader[i].classList.remove('active');
        }
    }
    const activeIndex = document.querySelector('.play-wrapper-head-index.active').innerText;
    const bubble = document.querySelector('.play-wrapper-head-index');
    const bubbleWidth = bubble.offsetWidth;
    //getComputedStyle sert à récupère le style calculé d'un élément (1er arg element html, 2eme arg pseudo élément)
    const bubbleLineWidth = parseInt(window.getComputedStyle(bubble, ':before').width.replace('px', ''));
    

    if ((bubbleWidth + bubbleLineWidth) * (activeIndex - 2) + wrapperWidth < headContainer.offsetWidth) {
        headContainer.style.left = - (bubbleWidth + bubbleLineWidth) * (activeIndex - 1) + 1 + 'px';
    } else if (parseInt(activeIndex) === 1) {
        headContainer.style.left = 0;
        headContainer.style.right = 0;
    }
};
setActiveBubble();
