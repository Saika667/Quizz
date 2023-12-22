<?php
require_once "BaseModel.php";

class QuizzModel extends BaseModel{
    public function getAll(): array {
        return $this->db->fetchAll("SELECT * FROM quizz");
    }
    public function getAllByTheme(int $themeId): array {
        return $this->db->fetchAll(
            "SELECT quizz.*, users.username ,COUNT(questions.id) AS questions_number 
            FROM quizz 
            INNER JOIN users ON users.id = quizz.creator_id
            INNER JOIN questions ON questions.quizz_id = quizz.id
            WHERE theme_id = ?
            GROUP BY quizz.id", 
            [$themeId]
        );
    }
    // récupère les informations général du  quizz (nom du quizz, créateur et thème)
    //INNER JOIN permet de faire une jointure entre 2 tables (ici la table users et quizz)
    public function getById($id): array {
        return $this->db->fetch(
            "SELECT u.username, qu.name, qu.theme
            FROM quizz AS qu
            INNER JOIN users AS u ON u.id = qu.creator_id
            WHERE qu.id = :id",
            [":id" => $id]
        );
    }

    //récupère toutes les questions d'un quizz
    public function getQuestions($quizzId): array {
        return $this->db->fetchAll(
            "SELECT
                q.text AS question_text,
                qa.text AS answer_text,
                q.id AS question_id,
                qa.id AS answer_id
            FROM quizz AS qu
            INNER JOIN questions AS q ON q.quizz_id = qu.id
            INNER JOIN question_answers AS qa ON qa.question_id = q.id
            WHERE qu.id = ?",
            [$quizzId]
        );
    }

    //permet de créer un quizz
    public function create(array $data): void {
        // On récupère le nom du quizz et le thème, data = $_POST, passé depuis le QuizzController
        $quizzName = $data['quizzName'];
        $quizzTheme = $data['quizzThemeId'];
        // On insère les données générales du quizz en base (table quizz)
        //INSERT INTO permet d'insérer des données en base, cette instruction est suivie du nom de la table concerné ainsi que des noms de colonne
        $this->db->query(
            "INSERT INTO quizz (`name`, `creator_id`, `theme_id`) VALUES(?, ?, ?)",
            [$quizzName, 1, $quizzTheme]
        );
        /* autre possibilité pour noter les arguments :
        "INSERT INTO quizz (`name`, `creator_id`, `theme`) VALUES(:name, :creatorId, :theme)",
            [":name" => $quizzName, ":creatorId" => 1, ":theme" => $quizzTheme]
        */
        
        // On récupère l'id du quizz (auto increment) pour s'en servir en clé étrangère pour les questions
        $quizzId = $this->db->lastInsertId();
        // On parcourt le tableau questions des données passées via POST
        // La clé questions provient du formulaire de la vue (quizz-create)
        foreach ($data['questions'] as $question) {
            // On insère en base chaque question (table quesions)
            $this->db->query(
                "INSERT INTO questions (`text`, `quizz_id`) VALUES(?, ?)", 
                [$question['question'], $quizzId]
            );
            // On récupère l'id de la question que l'on vient d'insérer pour s'en servir pour les réponses
            $questionId = $this->db->lastInsertId();
            // On sauvegarde l'id de la réponse valide (validAnswer = radio button selectionné)
            // C'est une string, pour la comparaison on cast (change le type) en entier (int)
            $validAnswer = (int)$question['validAnswer'];
            // On parcourt les réponses cette fois-ci en récupérer l'index de la réponse
            // $index => $answer permet de récupérer la clé (index) et la valeur (answer) d'un tableau
            foreach ($question['answers'] as $index => $answer) {
                // On insère les réponses aux questions
                // (int)($index === $validAnswer) => La base attend un booléen mais en mysql c'est en réalité 0 ou 1
                // On cast donc true false en entier (0 = false, 1 = true)
                $this->db->query(
                    "INSERT INTO question_answers (`question_id`, `text`, `is_correct`) VALUES(?, ?, ?)",
                    [$questionId, $answer, (int)($index === $validAnswer)]
                );
            }
        }
    }

    public function saveAnswer(array $answer, int $participationId, int $userId): void {
        $this->db->query(
            "INSERT INTO user_question_answers (`answer_id`, `user_id`, `participation_id`) VALUES (?, ?, ?)",
            [$answer['answer'], $userId, $participationId]
        );
    }

    public function getValidAnswers(int $quizzId): array {
        return $this->db->fetchAll(
            "SELECT q.`id` AS question_id, qa.`id` AS answer_id
            FROM questions AS q
            INNER JOIN question_answers AS qa ON q.`id` = qa.`question_id`
            WHERE q.quizz_id = ?
            AND qa.`is_correct` = 1
            ",
            [$quizzId]
        );
    }

    public function getValidAnswer(int $questionId): array {
        return $this->db->fetch(
            "SELECT `id` 
            FROM question_answers 
            WHERE `question_id` = ?
            AND `is_correct` = 1",
            [$questionId]
        );
    }
}