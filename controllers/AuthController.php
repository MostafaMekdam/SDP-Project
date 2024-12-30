<?php
require_once 'models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];
    
            $result = $this->userModel->register($username, $password, $role);
            if ($result) {
                header("Location: index.php?controller=auth&action=login");
                exit;
            } else {
                echo "Registration failed.";
            }
        } else {
            echo "Serving registration form..."; // Debugging line
            require 'views/auth/register.php';
        }
    }
    
    

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit;
            } else {
                echo "Invalid credentials.";
            }
        } else {
            require 'views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
}
?>
