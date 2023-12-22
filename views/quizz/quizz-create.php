<div class="create">
    <section class="create-head">
        <div class="create-head-back">
            <i class="fa-solid fa-arrow-left"></i>
        </div>
        <div class="create-head-logo">
            <img src="../assets/images/quizz-white.svg" />
        </div>
        <h2>Création d'un Quiz</h2>
    </section>

    <section class="create-container">
        <form class="create-container-form">
            <section class="create-container-form-general">
                <div class="create-container-form-general-name">
                    <label for="quizzName">Nom du Quiz :</label>
                    <input name="quizzName" type="text" id="quizzName"/>
                </div>
                <span class="error" id="quizz-name-error"></span>
                
                <div class="create-container-form-general-select">
                    <label for="theme">Choisir le thème du quiz:</label>
                    <select name="quizzThemeId" id="theme">
                        <?php foreach($data["themes"] as $theme) { ?>
                            <option value="<?= $theme['id'] ?>"><?= $theme['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </section>

            <section class="create-container-form-question" id="questions-container"></section>

            <div class="create-container-form-add">
                <button id="add-question-button" type="button">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter une question
                </button>
            </div>

            <div class="create-container-form-send">
                <button type="button">
                    <i class="fa-solid fa-paper-plane"></i>
                    Envoyer
                </button>
            </div>
        </form>
    </section>
</div>

<script type="text/javascript" src="../views/quizz/js/quizz-create.js"></script>