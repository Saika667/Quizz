<?php

require_once 'BaseController.php';
require_once 'models/QuizzData.php';
require_once 'models/ParticipationModel.php';

class PlayController extends BaseController {
    private string $folder = 'play';

    public function showQuestions(string $quizzId) {
        $questions = $this->dbModel->getQuestions($quizzId);
        $formattedQuestionsData = new QuizzData($questions);
        $cssFileName = 'play';
        $data = ['questions' => $formattedQuestionsData->questions, 'quizz-id' => $quizzId];
        $this->renderView('play', 'Jouer', $this->folder, $cssFileName, $data);
    }

    public function saveAnswer() {
        // json_decode(file_get_contents('php://input'), true) sert à récupérer les données via le body de la requête POST du js
        $postData = json_decode(file_get_contents('php://input'), true);
        $validAnswer = $this->dbModel->getValidAnswer($postData['questionId']);
        echo json_encode(['valid_answer_id' => $validAnswer['id']]);
    }

    public function saveAnswers() {
        $user = $this->getLoggedUser();
        // json_decode(file_get_contents('php://input'), true) sert à récupérer les données via le body de la requête POST du js
        $postData = json_decode(file_get_contents('php://input'), true);
        $participationModel = new ParticipationModel();
        $participationId = $participationModel->createParticipation($postData['quizzId']);
        foreach($postData['quizzAnswers'] as $answer) {
            $this->dbModel->saveAnswer($answer, $participationId, $user['id']);
        }
        $score = $participationModel->getScore($participationId);
        $validAnswers = $this->dbModel->getValidAnswers($postData['quizzId']);
        $participationModel->updateScore($participationId, $score['correct_answers']);
        echo json_encode(['participationId' => $participationId]);
    }
    
    public function showQuizzResult(int $participationId): void {
        $cssFileName = 'quizz-result';
        $participationModel = new ParticipationModel();
        $score = $participationModel->getScore($participationId);
        $quizzInfos = $participationModel->getQuizzInfo($participationId);

        $this->renderView("quizz-result", "Résultat du quizz", $this->folder, $cssFileName, ["quizzName" => $quizzInfos["name"], "nbQuestions" => $score['total_answers'], "validAnswers" => $score['correct_answers']]);
    }
}