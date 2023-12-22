<div class="list">
    <section class="list-head">
        <div class="list-head-back">
            <i class="fa-solid fa-arrow-left"></i>
        </div>
        <div class="list-head-logo">
            <img src="../../assets/images/<?= $data["theme"]["image"]?>" alt="<?= $data["theme"]["alt"]?>"/>
        </div>
        <h2><?= $data["theme"]["name"]?></h2>
        <h3>Liste des quiz :</h3>
    </section>

    <section class="list-container">
        <?php if(count($data['quizz']) === 0) {?>
        <div class="list-container-empty">
            <h4>Oops ! Il n'y a pas encore de questionnaire créé pour cette catégorie.</h4>
            <p>Voulez-vous créer un questionnaire ?</p>

            <div class="list-container-empty-button">
                <span>Créer un questionnaire</span>
            </div>
        </div>
        <?php } ?>
        <?php foreach($data['quizz'] as $quizz) { ?>
            <div class="list-container-quizz" data-quizz-id="<?= $quizz["id"] ?>">
                <p title="<?= $quizz["name"]?>"><?= $quizz["name"]?></p>
                <div class="list-container-quizz-content">
                    <p>Proposé par : <?= $quizz["username"]?></p>
                    <div class="list-container-quizz-content-number">
                        <p><?= $quizz["questions_number"]?></p>
                        <i class="fa-regular fa-circle-question"></i>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<script type="text/javascript" src="../../views/quizz/js/quizz-list.js"></script>