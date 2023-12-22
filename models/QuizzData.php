<?php

class QuizzData {
    public array $questions;

    /*
    $data =>
    array (
        0 => 
        array (
            'question_text' => 'Capitale de la France ?',
            'answer_text' => 'Tours',
            'question_id' => '11',
            'answer_id' => '35',
        ),
        1 => 
        array (
            'question_text' => 'Capitale de la France ?',
            'answer_text' => 'Paris',
            'question_id' => '11',
            'answer_id' => '36',
        ),
        2 => 
        array (
            'question_text' => 'Capitale de la France ?',
            'answer_text' => 'Lille',
            'question_id' => '11',
            'answer_id' => '37',
        ),
        3 => 
        array (
            'question_text' => 'Capitale de la France ?',
            'answer_text' => 'Marseille',
            'question_id' => '11',
            'answer_id' => '38',
        ),
        4 => 
        array (
            'question_text' => 'La France comporte 200M d\'habitants',
            'answer_text' => 'Vrai',
            'question_id' => '12',
            'answer_id' => '39',
        ),
        5 => 
        array (
            'question_text' => 'La France comporte 200M d\'habitants',
            'answer_text' => 'Faux',
            'question_id' => '12',
            'answer_id' => '40',
        ),
    )
    */
    public function __construct(array $data) {
        foreach ($data as $question) {
            // Si la question n'a pas encore été initialisée
            // Isset vérifie si la variable existe
            if (!isset($this->questions[$question['question_id']])) {
                // Initialisation du tableau
                $this->questions[$question['question_id']] = [
                    "question" => [
                        "id" => $question["question_id"],
                        "text" => $question['question_text']
                    ],
                    "answers" => []
                ];
            }

            $answer = [
                "id" => $question["answer_id"],
                "text" => $question["answer_text"]
            ];
            // Ajout de chaque réponse dans le tableau précédemment initialisé
            array_push($this->questions[$question["question_id"]]['answers'], $answer);
            // $this->questions[$question['id']]['answers'][] = $question['answer_text'];
        }
        // Permet de réinitialiser les index du tableau
        $this->questions = array_values($this->questions);
    }
}