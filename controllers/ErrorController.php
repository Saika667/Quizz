<?php

require_once 'BaseController.php';

class ErrorController extends BaseController {
    private string $folder = '404error';

    public function showError() {
        $cssFileName = '404error';
        $this->renderView('404error', 'Erreur 404', $this->folder, $cssFileName);
    }

}