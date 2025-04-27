<?php
session_start();
require_once(__DIR__ . '/../database/database.php');

use database\Database;

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["success" => false, "message" => "Access denied"]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');

    if (empty($id) || empty($question) || empty($answer)) {
        echo json_encode(["success" => false, "message" => "Please fill all fields"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE project SET question = ?, answer = ? WHERE ID = ?");
    if ($stmt->execute([$question, $answer, $id])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
}
?>
