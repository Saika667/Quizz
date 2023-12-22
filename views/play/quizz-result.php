<div class="result">
    <section class="result-head">
        <div class="result-head-logo">
            <img src="../../assets/images/quizz-white.svg" />
        </div>
        <h1>Résultat du quiz</h1>
    </section>

    <section class="result-container">
        <div class="result-container-quizz">
            <h2><?= $data["quizzName"] ?></h2>

            <div class="result-container-quizz-answer">
                <span class="result-container-quizz-answer-correct"><?= $data["validAnswers"]?></span>
                <span class="result-container-quizz-answer-total">/ <?= $data["nbQuestions"]?></span>
            </div>
        </div>

        <div class="result-container-button">
            <div class="result-container-button-content">
                <span>Accueil</span>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" src="../../views/play/js/quizz-result.js"></script>