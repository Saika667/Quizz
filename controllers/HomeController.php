<?php

require_once 'BaseController.php';
require_once 'models/ThemeModel.php';
require_once 'models/ParticipationModel.php';

class HomeController extends BaseController {
    private string $folder = "home";

    public function showHome() {
        $cssFileName = "home";
        $themeModel = new ThemeModel();
        $theme = $themeModel->getThemes();
        $user = $this->getLoggedUser();
        $participationModel = new ParticipationModel();
        $score = $participationModel->getUserScore((int)$user["id"]);
        $questionAnswered = $participationModel->getUserQuestionAnswered((int)$user["id"]);
        $this->renderView("home", "Accueil", $this->folder, $cssFileName, ["themes" => $theme, "user" => $user, "score" => $score, "questionAnswered" => $questionAnswered]);
    }
}