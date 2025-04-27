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

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM project WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid question ID"]);
}
?>
