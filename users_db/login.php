<?php
session_start();
require_once(__DIR__ . '/../database/database.php');

use database\Database;

$db = new Database();
$conn = $db->getConnection();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Fill all fields!"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        echo json_encode(["success" => true, "role" => $_SESSION['role']]);
    } else {
        echo json_encode(["success" => false, "message" => "Incorrect email or password"]);
    }
}
?>
