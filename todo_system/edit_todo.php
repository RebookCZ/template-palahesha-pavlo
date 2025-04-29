<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once(__DIR__ . '/../database/Database.php');
use database\Database;

$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

// Get task
$stmt = $conn->prepare("SELECT * FROM todos WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$todo = $stmt->fetch();

if (!$todo) {
    die("Task not found or access denied.");
}

// Update task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = trim($_POST['task']);
    $update = $conn->prepare("UPDATE todos SET task = ? WHERE id = ? AND user_id = ?");
    $update->execute([$task, $id, $user_id]);
    header("Location: todo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/templatemo-training-studio.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">✏️ Edit Task</h2>

    <form method="POST" class="d-flex justify-content-center">
        <input type="text" name="task" value="<?= htmlspecialchars($todo['task']) ?>" class="form-control mr-2" style="min-width: 300px;" required>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <div class="text-center mt-4">
        <a href="todo.php" class="btn btn-outline-secondary">⬅ Back to My Tasks</a>
    </div>
</div>

</body>
</html>
