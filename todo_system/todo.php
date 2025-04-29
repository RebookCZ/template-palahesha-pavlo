<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once(__DIR__ . '/../database/database.php');
use database\Database;

$db = new Database();
$conn = $db->getConnection();

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM todos WHERE user_id = ?");
$stmt->execute([$user_id]);
$todos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/templatemo-training-studio.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">📝 My Tasks</h2>

    <!-- Task creation form -->
    <form action="add_todo.php" method="POST" class="form-inline justify-content-center mb-4">
        <input type="text" name="task" class="form-control mr-2" placeholder="New task" required style="min-width: 250px;">
        <button type="submit" class="btn btn-success">Add</button>
    </form>

    <!-- Task list -->
    <?php if (count($todos) > 0): ?>
        <ul class="list-group">
            <?php foreach ($todos as $todo): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($todo['task']) ?></span>
                    <div>
                        <a href="edit_todo.php?id=<?= $todo['id'] ?>" class="btn btn-sm btn-warning mr-1">✏️</a>
                        <a href="delete_todo.php?id=<?= $todo['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this task?')">🗑️</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-center text-muted">You don't have any tasks yet.</p>
    <?php endif; ?>

    <!-- Back to homepage -->
    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-outline-secondary">⬅ Back to Home</a>
    </div>
</div>

</body>
</html>
