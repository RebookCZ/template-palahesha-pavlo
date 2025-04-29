<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: todo.php");
    exit();
}

require_once(__DIR__ . '/../database/database.php');
use database\Database;

$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);

header("Location: todo.php");
exit();
