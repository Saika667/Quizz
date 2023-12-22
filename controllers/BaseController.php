<?php
require_once(dirname(__DIR__) ."../models/UserModel.php");

/*
cette classe est la classe qui servira de base aux autres classes
protected : permet de fermer à l'extéreur mais ouvre à l'héritage alors que private fermé à tous 
*/
abstract class BaseController {
    protected $dbModel;

    public function __construct($model = null) {
        $this->dbModel = $model;
    }
    /**
     * permet d'afficher une vue du front
    */
    protected function renderView(
            string $view,
            string $title,
            string $folder,
            string $css = '',
            array $data = []
        ): void {
        include 'views/layout/skeleton.php';
        ob_start();
        include 'views/' . $folder . '/' . $view . '.php';
        // il existe aussi cette annotation => include "views/$view.php";
        $viewContent = ob_get_contents();
    }

    protected function getLoggedUser(): array {
        $token = $_SESSION["session_token"];
        $model = new UserModel();
        return $model->getUserBySessionToken($token);
    }
}