<?php

require_once 'BaseController.php';

class AuthController extends BaseController {

    private string $folder = 'account';

    public function showAuth(): void {
        $this->renderView('auth', 'Compte', $this->folder, 'auth');
    }

    public function register(): void {
        $postData = json_decode(file_get_contents('php://input'), true);
        $this->dbModel->register($postData["username"], $postData["password"], $postData["image"]);
        echo json_encode(["status"=> "success"]);
    }

    public function login(): void {
        $postData = json_decode(file_get_contents('php://input'), true);
        if($this->dbModel->login($postData['username'], $postData['password'])) {
            echo json_encode(['status'=> 'success']);
        } else {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(["status"=> "error"]);
            exit;
        }
        
    }

    public function logout(): void {
        $this->dbModel->logout();
        echo json_encode(['status'=> 'success']);
    }
}