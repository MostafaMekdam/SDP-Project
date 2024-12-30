<?php
require_once 'config/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function register($username, $password, $role) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        return $this->db->execute($query, [
            ':username' => $username,
            ':password' => $hashedPassword,
            ':role' => $role
        ]);
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username";
        $user = $this->db->query($query, [':username' => $username]);
        if ($user && password_verify($password, $user[0]['password'])) {
            return $user[0];
        }
        return false;
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        return $this->db->query($query, [':user_id' => $userId])[0] ?? null;
    }
}
?>
