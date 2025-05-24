<?php
session_start();
require_once(__DIR__ . '/../database/database.php');

use database\Database;

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM qna");
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Control panel</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Control panel</h2>

    <div class="mb-3">
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> (<?php echo $_SESSION['role']; ?>)</p>

        <form action="../users_db/logout.php" method="POST" style="display:inline;">
            <button type="submit" class="btn btn-danger">Log out</button>
        </form>

        <a href="../todo_system/todo.php" class="btn btn-primary ms-2">📝 My tasks</a>
    </div>

    <?php if ($_SESSION['role'] == 'admin'): ?>
        <h3>Questions and answers</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question (otazka)</th>
                    <th>Answer (odpoved)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $q): ?>
                    <tr>
                        <td><?php echo $q['ID']; ?></td>
                        <td><?php echo htmlspecialchars($q['otazka']); ?></td>
                        <td><?php echo htmlspecialchars($q['odpoved']); ?></td>
                        <td>
                            <a href="edit_question.php?id=<?php echo $q['ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_question.php?id=<?php echo $q['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    <?php else: ?>
        <p>You are not allowed to do it!</p>
    <?php endif; ?>
</div>

</body>
</html>
