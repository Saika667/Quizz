<div class="play">
    <input id="quizz-id" type="hidden" value="<?= $data['quizz-id']; ?>" />
    <div class="play-wrapper">
        <section class="play-wrapper-head">
            <?php foreach ($data["questions"] as $index => $question) { ?>
                <div class="play-wrapper-head-index" id="header-<?= $question["question"]["id"]?>"><?= $index + 1?></div>
            <?php } ?>
    </section>
    </div>
    <section class="play-question">
        <?php foreach ($data["questions"] as $index => $question) { ?>
            <div class="play-question-container<?= $index === 0 ? ' shown' : '' ?>" id="question-<?= $question["question"]["id"]?>">
                <div class="play-question-container-wrapper">
                    <div class="play-question-container-wrapper-content">
                        <div class="play-question-container-wrapper-content-logo">
                            <img src="../../assets/images/quizz.svg" />
                        </div>

                        <p><?= $question["question"]["text"]; ?></p>
                    </div>

                    <div class="play-question-container-wrapper-answers">
                        <?php foreach ($question["answers"] as $answer) { ?>
                            <div id="answer-<?= $answer["id"]?>" class="play-question-container-wrapper-answers-container">
                                <p><?= $answer["text"]; ?></p>
                                <i class="fa-regular fa-circle circle"></i>
                                <i class="fa-solid fa-circle full-circle hide"></i>
                                <i class="fa-solid fa-circle-check check hide"></i>
                                <i class="fa-solid fa-circle-xmark xmark hide"></i>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="play-question-container-button validate-button">
                    <div class="play-question-container-button-valid">Valider</div>
                </div>
                <?php if($index === count($data["questions"]) - 1) { ?>
                    <div class="play-question-container-button send-quizz hide">
                        <div class="play-question-container-button-send">Envoyer</div>
                    </div>
                <?php } else { ?>
                <div class="play-question-container-button next-button hide">
                    <div class="play-question-container-button-next">Prochaine question</div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    </section>
</div>
<script type="text/javascript" src="../../views/play/js/play.js"></script>