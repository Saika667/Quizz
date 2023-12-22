//ajouter une question
document.getElementById('add-question-button').addEventListener('click', function() {
    const questionsContainer = document.getElementById('questions-container');
    const questionNumber = questionsContainer.children.length;

    const html = `
        <div class="create-container-form-question-content animate">
            <label class="label-question" for="question-${questionNumber + 1}">Question ${questionNumber + 1}</label>
            <textarea name="questions[${questionNumber}][question]" id="question-${questionNumber + 1}" placeholder="Quelle est la couleur du cheval blanc d'Henry IV ?"></textarea>
            <span class="error" id="question-${questionNumber + 1}-content-error"></span>

            <div id="question-${questionNumber + 1}-answers" class="create-container-form-question-content-answer">
                <h3>Réponses :</h3>
                <div class="create-container-form-question-content-answer-wrapper">
                    <div class="create-container-form-question-content-answer-wrapper-content">
                        <input name="questions[${questionNumber}][validAnswer]" id="question-${questionNumber + 1}-answer-1" type="radio" value="0" class="create-container-form-question-content-answer-wrapper-content-radio"/>
                        <label for="question-${questionNumber + 1}-answer-1">
                            <input class="create-container-form-question-content-answer-wrapper-content-input" name="questions[${questionNumber}][answers][]" type="text"/>
                        </label>
                    </div>
                    <span class="error" id="${questionNumber + 1}-answer-1-error"></span>
                </div>

                <div class="create-container-form-question-content-answer-wrapper">
                    <div class="create-container-form-question-content-answer-wrapper-content">
                        <input name="questions[${questionNumber}][validAnswer]" id="question-${questionNumber + 1}-answer-2" type="radio" value="1" class="create-container-form-question-content-answer-wrapper-content-radio"/>
                        <label for="question-${questionNumber + 1}-answer-2">
                            <input class="create-container-form-question-content-answer-wrapper-content-input" name="questions[${questionNumber}][answers][]" type="text"/>
                        </label>
                    </div>
                    <span class="error" id="${questionNumber + 1}-answer-2-error"></span>
                </div>
            </div>
            <span class="error" id="${questionNumber + 1}-correct-answer-error"></span>
            
            <div class="create-container-form-question-content-add">
                <button class="add-answer-button" type="button">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter une réponse
                </button>
            </div>
            
            <button class="delete-question-button" type="button">
                <i class="fa-solid fa-trash-can"></i>
                Supprimer la question
            </button>
        </div>
    `;

    questionsContainer.insertAdjacentHTML('beforeend' ,html);
    questionsContainer.style.display = "flex";
    // On ajoute l'event listener uniquement sur le dernier bouton ajouter une réponse (inséré par insertAdjacentHTML au dessus)
    const addAnswerButtons = document.getElementsByClassName('add-answer-button');
    // Récupère le dernier élément
    addAnswerButtons[addAnswerButtons.length - 1].addEventListener('click', function() {
        handleAddAnswer(questionNumber)
    });

    const deleteQuestionButton = document.getElementsByClassName('delete-question-button');
    for (let i = 0; i < deleteQuestionButton.length; i++) {
        deleteQuestionButton[i].removeEventListener('click', handleRemoveQuestion);
        deleteQuestionButton[i].addEventListener('click', function() {
            handleRemoveQuestion(this);
        })
    }
});

//ajout d'une réponse
function handleAddAnswer(questionNumber) {
    const answersContainer = document.getElementById(`question-${questionNumber + 1}-answers`);
    const answers = document.querySelectorAll(`#question-${questionNumber + 1}-answers > div`);
    const answersNumber = answers.length + 1;

    const html = `
        <div class="create-container-form-question-content-answer-wrapper">
            <div class="create-container-form-question-content-answer-wrapper-content">
                <input name="questions[${questionNumber}][validAnswer]" id="question-${questionNumber + 1}-answer-${answersNumber}" type="radio" value="0" class="create-container-form-question-content-answer-wrapper-content-radio"/>
                <label for="question-${questionNumber + 1}-answer-${answersNumber}">
                    <input class="create-container-form-question-content-answer-wrapper-content-input" name="questions[${questionNumber}][answers][]" type="text"/>
                </label>
                <button type="button" class="delete-answer-button">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
            <span class="error" id="${questionNumber + 1}-answer-${answersNumber}-error"></span>
        </div>
    `;

    answersContainer.insertAdjacentHTML('beforeend', html);

    const deleteAnswerButtons = document.getElementsByClassName('delete-answer-button');
    for (let i = 0; i < deleteAnswerButtons.length; i++) {
        deleteAnswerButtons[i].removeEventListener('click', handleRemoveAnswer);
        //on utilise une fonction anonyme pour passer un paramètre à la fonction callback (handleRemoveAnswer) sinon ne fonctionne pas
        deleteAnswerButtons[i].addEventListener('click', function() {
            handleRemoveAnswer(this);
        })
    }
}

//supression d'une reponse
function handleRemoveAnswer(element) {
    //parentNode permet de récupérer le parent direct
    element.parentNode.remove();
    reindexQuizz();
}

//suppression d'une question
function handleRemoveQuestion(element) {
    element.parentNode.remove();
    reindexQuizz();
    const questionsContainer = document.getElementById('questions-container');
    const numberOfChild = questionsContainer.childElementCount;
    console.log(numberOfChild);
    if(numberOfChild === 0) {
        questionsContainer.style.display = "none";
    }
}

//fonction appelé lors d'une suppression de question pour que les index se suivent
function reindexQuizz() {
    // Récupérer toutes les questions et les parcourir
    const questionsContainer = document.getElementById('questions-container');
    const questionNumber = questionsContainer.children.length;

    for (let i = 0; i < questionNumber; i++) {
        const elements = questionsContainer.children[i].children;
        console.log(i);
        console.log(elements[0]);
        //elements[0] => correspond au label
        elements[0].setAttribute("for", `question-${i + 1}`);
        elements[0].innerHTML = `Question ${i + 1} :`;
        //elements[1] => correspond à l'input
        elements[1].setAttribute("name", `questions[${i}][question]`);
        elements[1].setAttribute("id", `question-${i + 1}`);
        //elements[2] => correspond à la div container des réponses
        elements[2].setAttribute("id", `question-${i + 1}-answers`);

        //récupère les enfants de la div container des réponses (H3 + div correspondant à réponse)
        const childrenDivAnswers = elements[2].children;
        //j = 1 car le premier élément du tableau c'est le titre et il n'y a rien à changer dessus
        for (let j = 1; j < childrenDivAnswers.length; j++) {
            //récupère les éléments de chaque div réponse (input + label)
            const elementsDivAnswer = childrenDivAnswers[j].children;
            //elementsDivAnswer[0] => correspond à l'input
            elementsDivAnswer[0].setAttribute("name", `questions[${i}][validAnswer]`);
            elementsDivAnswer[0].setAttribute("id", `question-${i + 1}-answer-${j}`);
            //elementsDivAnswer[1] => correspond au label
            elementsDivAnswer[1].setAttribute("for", `question-${i + 1}-answer-${j}`);

            //récupère l'input à l'intérieur du label
            elementsDivAnswer[1].children[0].setAttribute("name", `questions[${i}][answers][]`);
        }
    }
}

/* Gestion du bouton de retour au menu */
const backButton = document.getElementsByClassName("create-head-back")[0];
backButton.addEventListener('click', function() {
    window.location.href = `../../../quizz`
});

/* Envoie du formulaire */
const sendButton = document.getElementsByClassName('create-container-form-send')[0];
sendButton.addEventListener('click', function() {
    //récupère toutes les questions
    const questions = document.getElementsByClassName('create-container-form-question-content');
    const quizzName = document.getElementById('quizzName').value;
    const quizzTheme = document.getElementById('theme').value;

    const quizzNameError = document.getElementById('quizz-name-error');
    quizzNameError.textContent = '';

    if(quizzName.trim() === '') {
        quizzNameError.textContent = "Un titre de quiz est requis.";
    }

    let quizzCreationData = {
        quizzName,
        quizzThemeId: quizzTheme,
        questions : []
    };

    for(let i = 0; i < questions.length; i++) {
        //récupère le contenu de la question
        const questionContent = document.getElementById(`question-${i + 1}`).value;
        const questionError = document.getElementById(`question-${i + 1}-content-error`);
        const correctAnswerError = document.getElementById(`${i + 1}-correct-answer-error`);
        correctAnswerError.textContent = '';
        questionError.textContent = '';

        if(questionContent.trim() === '') {
            questionError.textContent = "La question est requise.";
        }

        let questionData = {};
        questionData.question = questionContent;
        questionData.answers = [];
        //récupère toutes les réponses de la question
        const answers = document.querySelectorAll(`#question-${i + 1}-answers .create-container-form-question-content-answer-wrapper-content`);
        
        for(let j = 0; j < answers.length; j++) {
            console.log(`question-${i + 1}-answer-${j + 1}`);
            const isCorrectAnswer = document.getElementById(`question-${i + 1}-answer-${j + 1}`).checked;

            if(isCorrectAnswer) {
                questionData.validAnswer = j;
            }

            const contentAnswerError = document.getElementById(`${i + 1}-answer-${j + 1}-error`);
            contentAnswerError.textContent = '';
            const contentAnswer = answers[j].querySelector('.create-container-form-question-content-answer-wrapper-content-input').value;
            if(contentAnswer.trim() === '') {
                contentAnswerError.textContent = 'La réponse est requise.';
            }
            questionData.answers.push(contentAnswer);
        }
        if(!questionData.hasOwnProperty('validAnswer')) {
            correctAnswerError.textContent = 'Sélectionner la réponse correcte.';
        }
        quizzCreationData.questions.push(questionData);
    }

    fetch("/quizz/quizz", {
        method: "POST",
        body: JSON.stringify(quizzCreationData),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        window.location.href = `../quizz/list/${quizzTheme}`;
    });
});

/* Nous donne un tableau comme suit :
array (
  'quizzName' => 'Nom du quizz',
  'quizzTheme' => 'général',
  'questions' => 
  array (
    0 => 
    array (
      'question' => 'Question 1',
      'answers' => 
      array (
        0 => 'Réponse 1',
        1 => 'Réponse 2',
      ),
      'validAnswer' => '1',
    ),
    1 => 
    array (
      'question' => 'Question 2',
      'answers' => 
      array (
        0 => 'Réponse 1',
        1 => 'Réponse 2',
        2 => 'Réponse 3',
        3 => 'Réponse 4',
      ),
      'validAnswer' => '0',
    ),
  ),
)
*/