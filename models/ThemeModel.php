<?php
require_once "BaseModel.php";

class ThemeModel extends BaseModel{

    public function getThemes(): array {
        return $this->db->fetchAll(
            "SELECT `theme`.*, COUNT(`quizz`.`id`) AS quizz_number FROM `theme`
            LEFT JOIN `quizz` ON `theme_id` = `theme`.`id`
            GROUP BY `theme`.`id`"
        );
    }
    public function getTheme(int $themeId): array {
        return $this->db->fetch("SELECT * FROM theme WHERE id = ?", [$themeId]);
    }
}