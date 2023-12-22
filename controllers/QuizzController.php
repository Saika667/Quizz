<?php

require_once 'BaseController.php';
require_once 'models/ThemeModel.php';

class QuizzController extends BaseController {
    private string $folder = 'quizz';

    public function showQuizzList(int $themeId): void {
        $quizz = $this->dbModel->getAllByTheme($themeId);
        $theme = new ThemeModel();
        $themeData = $theme->getTheme($themeId);
        $cssFileName = 'quizz-list';
        $this->renderView("quizz-list", "Liste des quiz", $this->folder, $cssFileName, ["quizz" => $quizz, "theme" => $themeData]);
    }

    public function showQuizz(int $id): void {
        $quizz = $this->dbModel->getById($id);
        $cssFileName = 'quizz';
        $this->renderView("quizz", "Questionnaire", $this->folder, $cssFileName, ["quizz" => $quizz]);
    }

    public function showCreateQuizz(): void {
        $cssFileName = 'quizz-create';
        $themeModel = new ThemeModel();
        $themesData = $themeModel->getThemes();
        $this->renderView("quizz-create", "Création de quiz", $this->folder, $cssFileName, [ "themes" => $themesData]);
    }

    public function createQuizz() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $this->dbModel->create($postData);
        echo json_encode(['result' => 'success']);
        // $cssFileName = 'quizz-list';
        // // $_POST contient les données du formulaire passées via la méthode POST
        // // On utilise la méthode create du modèle QuizzModel pour insérer les données du quizz en base
        // $this->renderView("quizz-create", "Résultat du quizz", $this->folder, $cssFileName);
    }
}