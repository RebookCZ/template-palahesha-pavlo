<?php
session_start();
require_once(__DIR__ . '/../database/database.php');

use database\Database;
use PDO;

class UserAuth extends Database {
    private PDO $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->getConnection(); 
    }

    public function register(string $name, string $username, string $email, string $password): array {
        if (empty($name) || empty($username) || empty($email) || empty($password)) {
            return ["success" => false, "message" => "All fields are needed!"];
        }

        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already in use"];
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, 'user')");
        $stmt->execute([$name, $username, $email, $hashed_password]);

        return ["success" => true, "message" => "Registration successful! You can now log in."];
    }

    public function login(string $email, string $password): array {
        if (empty($email) || empty($password)) {
            return ["success" => false, "message" => "Fill all fields!"];
        }

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            return ["success" => true, "message" => "Login successful!"];
        } else {
            return ["success" => false, "message" => "Incorrect email or password"];
        }
    }

    public function logout(): void {
        session_destroy();
    }
}

$auth = new UserAuth();

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'register':
        $name = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $result = $auth->register($name, $username, $email, $password);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        header("Location: ../index.php");
        exit;

    case 'login':
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $result = $auth->login($email, $password);
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        header("Location: ../index.php");
        exit;

    case 'logout':
        $auth->logout();
        header("Location: ../index.php");
        exit;

    default:
        $_SESSION['error'] = "Invalid action";
        header("Location: ../index.php");
        exit;
}
