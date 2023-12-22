<section class="player">
    <div class="player-content">
        <div class="player-content-text">
            <h2>Bonjour, <?= $data['user']['username'] ?></h2>
            <p>Rendons cette journée productive</p>
        </div>
        <div class="player-content-image">
            <img src="assets/images/<?= $data['user']['image'] ?>" alt="image d'un joueur."/>
            <div class="player-content-image-logout">
                <i class="fa-solid fa-power-off"></i>
                <span>Déconnexion</span>
            </div>
        </div>
    </div>

    <div class="player-information">
        <div class="player-information-content">
            <div class="player-information-content-image">
                <img src="assets/images/question.png" alt="image d'un point d'intérogation">
            </div>
            <div class="player-information-content-text">
                <h4>Question répondu</h4>
                <span><?= $data["questionAnswered"] ?></span>
            </div>
        </div>
        
        <div class="player-information-content">
            <div class="player-information-content-image">
                <img src="assets/images/answer.png" alt="image d'une bulle avec un point d'intérogation et une autre bulle avec un check">
            </div>
            <div class="player-information-content-text">
                <h4>Réponse correcte</h4>
                <span><?= $data["score"] ?></span>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="container-button" id="add-button">
        <i class="fa-solid fa-plus"></i>
        <span>Ajouter un quiz</span>
    </div>
</div>

<section class="quizz">
    <h3>Thème des quiz</h3>
    
    <div class="quizz-container">
        <?php foreach($data['themes'] as $theme) { ?>
            <div class="quizz-container-theme" data-theme-id="<?= $theme['id']?>">
                <div class="quizz-container-theme-image">
                    <img src="assets/images/<?= $theme['image'] ?>" alt="<?= $theme['alt'] ?>"/>
                </div>
                <h4><?= $theme['name'] ?></h4>
                <p>
                    <?= $theme['quizz_number']?> questionnaire<?= $theme['quizz_number'] > 1 ? 's' : '' ?>
                </p>
            </div>
        <?php } ?>
    </div>
</section>

<script type="text/javascript" src="views/home/js/home.js"></script>
