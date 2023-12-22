<?php
require_once "BaseModel.php";

class UserModel extends BaseModel{
    public function register(string $username, string $password, string $image): void {
        //password_hash est une fonction prévue par php pour crypté le mdp
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query(
            "INSERT INTO `users` (`username`, `password`, `image`)
            VALUES (?, ?, ?)",
            [$username, $hashedPassword, $image]
        );
    }

    public function login(string $username, string $password): bool {
        $dbPassword = $this->db->fetch("SELECT `password` FROM `users` WHERE `username` = ?", [$username]);
        $hashedPassword = $dbPassword["password"];
        //password_verify est une fonction prévue par php et qui permet de vérifier le mdp
        if (password_verify($password, $hashedPassword)) {
            //génère un token de session 
            //bin2hex est une fonction prévue par php et permet de transformer une string binaire en string hexadécimal
            $sessionToken = bin2hex(random_bytes(32));
            //Enregistrement du token de session dans la base de données
            $this->db->query("UPDATE `users` SET `session_token` = ? WHERE username = ?", [$sessionToken, $username]);
            //définit le token de session dans la super variable de php $_SESSION
            $_SESSION['session_token'] = $sessionToken;
            return true;
        }
        return false;
    }

    public function logout(): void {
        $this->db->query(
            "UPDATE `users` SET `session_token` = NULL WHERE session_token = ?",
            [$_SESSION["session_token"]]
        );
        unset($_SESSION['session_token']);
    }

    public function getUserBySessionToken(string $sessionToken): array {
        return $this->db->fetch(
            "SELECT `id`, `username`, `image` FROM `users` WHERE `session_token` = ?",
            [$sessionToken]
        );
    }
}