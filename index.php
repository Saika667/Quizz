<?php
//session_start est une fonction prévue par php et sert à démarrer une nouvelle session
session_start();
$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$quizzPos = strpos($url,'/quizz');
if ($quizzPos !== false) {
    $url = substr_replace($url, '', $quizzPos, strlen('/quizz'));
}
$splittedUrl = explode('/', $url);
$controller = $splittedUrl[1];
// $splittedUrl[2] ?? null = $splittedUrl[2] ? $splittedUrl[2] : null;
$action = $splittedUrl[2] ?? null;
$resourceId = $splittedUrl[3] ?? null;
require_once 'controllers/ErrorController.php';
$errorController = new ErrorController();
//check utilisateur connecté
$token = $_SESSION["session_token"] ?? null;

if($token === null && $controller !== 'auth' && $action !== 'account') {
    header('Location: /quizz/auth/account');
    return;
}
switch($controller) {
    case '':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        $controller->showHome();
        break;
    case 'quizz':
        require_once 'controllers/QuizzController.php';
        require_once 'models/QuizzModel.php';
        $model = new QuizzModel();
        $controller = new QuizzController($model);

        if ($method === "POST") {
            $controller->createQuizz();
            return;
        }

        switch($action) {
            case 'list':
                $controller->showQuizzList($resourceId);
                break;
            case 'view':
                $controller->showQuizz($resourceId);
                break;
            case 'creation':
                $controller->showCreateQuizz();
                break;
            default:
                $errorController->showError();
                break;
        }
        break;
    case 'play':
        require_once 'controllers/PlayController.php';
        require_once 'models/QuizzModel.php';
        $model = new QuizzModel();
        $controller = new PlayController($model);

        switch($action) {
            case 'show':
                $controller->showQuestions($resourceId);
                break;
            case 'show-results':
                $controller->showQuizzResult($resourceId);
                break;
            case 'saveAnswer':
                $controller->saveAnswer();
                break;
            case 'saveAnswers':
                $controller->saveAnswers();
                break;
            default:
                $errorController->showError();
                break;
        }
        break;
    case 'auth':
        require_once 'controllers/AuthController.php';
        require_once 'models/UserModel.php';
        $model = new UserModel();
        $controller = new AuthController($model);

        switch($action) {
            case 'account':
                $controller->showAuth();
                break;
            case 'register':
                $controller->register();
                break;
            case 'login':
                $controller->login();
                break;
            case 'logout':
                $controller->logout();
                break;
            default:
                $errorController->showError();
                break;
        }
        break;
    default:
        http_response_code(404);
        $errorController->showError();
        break;
}