<?php
session_start();
require_once(__DIR__ . '/../database/database.php');

use database\Database;

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');

    if (empty($question) || empty($answer)) {
        echo json_encode(["success" => false, "message" => "Please fill all fields"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO project (question, answer) VALUES (?, ?)");
    if (!$stmt->execute([$question, $answer])) {
        $error = $stmt->errorInfo();
        echo json_encode(["success" => false, "message" => $error[2]]);
        exit;
    }

    echo json_encode(["success" => true]);
}
?>
