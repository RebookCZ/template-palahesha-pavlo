<?php
session_start();
require_once(__DIR__ . '/../database/database.php');

use database\Database;

$db = new Database();
$conn = $db->getConnection();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are needed!"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Email already in use"]);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, 'user')");
    $stmt->execute([$name, $username, $email, $hashed_password]);

    echo json_encode(["success" => true]);
}
?>
