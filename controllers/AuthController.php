<?php

require_once 'BaseController.php';

class AuthController extends BaseController {

    private string $folder = 'account';

    public function showAuth(): void {
        $this->renderView('auth', 'Compte', $this->folder, 'auth');
    }

    public function register(): void {
        $postData = json_decode(file_get_contents('php://input'), true);
        try {
            $this->dbModel->register($postData["username"], $postData["password"], $postData["image"]);
        } catch (PDOException $e) {
            if ((int)$e->getCode() === 23000) {
                http_response_code(409);
                echo json_encode(['status' => 'error', 'message' => 'Le pseudo existe déjà.']);
                return;
            }
        }
        echo json_encode(["status"=> "success"]);
    }

    public function login(): void {
        $postData = json_decode(file_get_contents('php://input'), true);
        $password = $postData['username'] === 'Invite' ? 'Invité16!' : $postData['password'];
        if($this->dbModel->login($postData['username'], $password)) {
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