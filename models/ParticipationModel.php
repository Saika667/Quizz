<?php

require_once("BaseModel.php");

class ParticipationModel extends BaseModel {
    public function createParticipation(int $quizzId, int $userId = 1): int {
        $date = new DateTime("now", new DateTimeZone('Europe/Paris'));
        $this->db->query(
            "INSERT INTO participations (`user_id`, `quizz_id`, `participation_dt`) VALUES (?, ?, ?)",
            [$userId, $quizzId, $date->format('Y-m-d H:i:s')]
        );
        //$date->format('Y-m-d H:i:s') sert à formater l'objet date et récupérer ce qui nous intéresse
        //retourne l'id de la participation
        return $this->db->lastInsertId();
    }

    public function getScore(int $participationId): array {
        //SUM => sert à faire la somme 
        // (IF(qa.`is_correct`, 1, 0)) =>1er paramètre c'est la condition du if, 2eme paramètre la valeur (retour) si la condition est vrai, 3eme paramètre la valeur (retour) si la condition est fausse
        //AS correct_answers => le nom de la colonne dans laquelle il y aura le résultat de la somme
        //COUNT(qa.`id`) AS total_answers => sert à compter le nombre de ligne différente possèdant un id différent (qa.`id`)
        return $this->db->fetch(
            "SELECT 
                SUM(IF(qa.`is_correct`, 1, 0)) AS correct_answers,
                COUNT(qa.`id`) AS total_answers
            FROM user_question_answers AS uqa
            INNER JOIN question_answers AS qa ON uqa.`answer_id` = qa.`id`
            WHERE uqa.`participation_id` = ?
            ",
            [$participationId]
        );
    }

    public function updateScore(int $participationId, int $score): void {
        $this->db->query(
            "UPDATE `participations` SET `score` = ? WHERE `id` = ?",
            [$score, $participationId]      
        );
    }

    public function getUserScore(int $userId): int {
        return $this->db->fetch(
            "SELECT SUM(`score`) AS `score`
            FROM `participations`
            WHERE
              (quizz_id, participation_dt) IN (
                SELECT
                  quizz_id,
                  MIN(participation_dt) AS first_participation_dt
                FROM `participations`
                WHERE user_id = ?
                GROUP BY quizz_id
              );",
              [$userId] 
        )['score'] ?? 0;
    }

    public function getUserQuestionAnswered(int $userId): int {
        return $this->db->fetch(
            "SELECT COUNT(q.id) AS nb_questions
            FROM `participations` AS p
            INNER JOIN `questions` AS q ON p.`quizz_id` = q.`quizz_id`
            WHERE
             (p.`quizz_id`, `participation_dt`) IN (
              SELECT
                `quizz_id`,
                MIN(`participation_dt`) AS first_participation_dt
              FROM `participations`
              WHERE `user_id` = ?
              GROUP BY `quizz_id`
              );",
              [$userId]
        )['nb_questions'] ?? 0;
    }

    public function getQuizzInfo(int $participationId): array {
        return $this->db->fetch(
            "SELECT q.name
            FROM `quizz` AS q
            INNER JOIN `participations` AS p ON p.quizz_id = q.id
            WHERE p.id = ?;",
            [$participationId]
        );
    }
}