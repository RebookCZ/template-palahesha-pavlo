<?php
session_start();

if (!isset($_SESSION['user_id']) || empty($_POST['task'])) {
    header("Location: todo.php");
    exit();
}

require_once(__DIR__ . '/../database/database.php');
use database\Database;

$db = new Database();
$conn = $db->getConnection();

$task = trim($_POST['task']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
$stmt->execute([$user_id, $task]);

header("Location: todo.php");
exit();
