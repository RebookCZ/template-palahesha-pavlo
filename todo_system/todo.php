<?php
session_start();
require_once(__DIR__ . '/../database/database.php');
use database\Database;

class TodoSystem {
    private $conn;
    private $user_id;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../index.php");
            exit();
        }

        $db = new Database();
        $this->conn = $db->getConnection();
        $this->user_id = $_SESSION['user_id'];
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'add':
                        $this->addTodo();
                        break;
                    case 'edit':
                        $this->editTodo();
                        break;
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
            $this->deleteTodo();
        }

        $this->renderPage();
    }

    private function addTodo() {
        $task = trim($_POST['task'] ?? '');
        if ($task === '') return;

        $stmt = $this->conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
        $stmt->execute([$this->user_id, $task]);

        header("Location: todo.php");
        exit();
    }

    private function deleteTodo() {
        $id = $_GET['delete'] ?? 0;

        $stmt = $this->conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $this->user_id]);

        header("Location: todo.php");
        exit();
    }

    private function editTodo() {
        $id = $_POST['id'] ?? 0;
        $task = trim($_POST['task'] ?? '');

        if ($task === '') return;

        $stmt = $this->conn->prepare("UPDATE todos SET task = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$task, $id, $this->user_id]);

        header("Location: todo.php");
        exit();
    }

    private function getTodos() {
        $stmt = $this->conn->prepare("SELECT * FROM todos WHERE user_id = ?");
        $stmt->execute([$this->user_id]);
        return $stmt->fetchAll();
    }

    private function getTodoById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM todos WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $this->user_id]);
        return $stmt->fetch();
    }

    private function renderPage() {
        $todos = $this->getTodos();
        $editing = false;
        $todo = null;

        if (isset($_GET['edit'])) {
            $editing = true;
            $todo = $this->getTodoById($_GET['edit']);
            if (!$todo) {
                die("Task not found or access denied.");
            }
        }

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
            <h2 class="text-center mb-4"><?= $editing ? '✏️ Edit Task' : '📝 My Tasks' ?></h2>

            <!-- Task form -->
            <form method="POST" class="form-inline justify-content-center mb-4">
                <input type="text" name="task" class="form-control mr-2" 
                       placeholder="New task" 
                       value="<?= $editing ? htmlspecialchars($todo['task']) : '' ?>"
                       required style="min-width: 250px;">
                <?php if ($editing): ?>
                    <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                    <input type="hidden" name="action" value="edit">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="todo.php" class="btn btn-secondary ml-2">Cancel</a>
                <?php else: ?>
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="btn btn-success">Add</button>
                <?php endif; ?>
            </form>

            <!-- Task list -->
            <?php if (count($todos) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($todos as $t): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= htmlspecialchars($t['task']) ?></span>
                            <div>
                                <a href="todo.php?edit=<?= $t['id'] ?>" class="btn btn-sm btn-warning mr-1">✏️</a>
                                <a href="todo.php?delete=<?= $t['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this task?')">🗑️</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center text-muted">You don't have any tasks yet.</p>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="../index.php" class="btn btn-outline-secondary">⬅ Back to Home</a>
            </div>
        </div>
        </body>
        </html>
        <?php
    }
}

$todoApp = new TodoSystem();
$todoApp->handleRequest();
