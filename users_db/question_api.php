<?php
namespace users_db;

require_once __DIR__ . '/../db/Database.php';  // Путь к твоему классу Database

use database\Database;

class QuestionAPI extends Database {
    private $conn;

    public function __construct() {
        parent::__construct();
        $this->conn = $this->getConnection();
    }

    public function listQuestions() {
        $stmt = $this->conn->query("SELECT ID, otazka, odpoved FROM otazky ORDER BY ID DESC");
        $questions = $stmt->fetchAll();
        return ['success' => true, 'questions' => $questions];
    }

    public function addQuestion($question, $answer) {
        if (empty($question) || empty($answer)) {
            return ['success' => false, 'message' => 'Все поля обязательны'];
        }
        $stmt = $this->conn->prepare("INSERT INTO otazky (otazka, odpoved) VALUES (?, ?)");
        if ($stmt->execute([$question, $answer])) {
            return ['success' => true, 'message' => 'Вопрос добавлен'];
        }
        return ['success' => false, 'message' => 'Ошибка при добавлении'];
    }

    public function editQuestion($id, $question, $answer) {
        if (empty($id) || empty($question) || empty($answer)) {
            return ['success' => false, 'message' => 'Все поля обязательны'];
        }
        $stmt = $this->conn->prepare("UPDATE otazky SET otazka = ?, odpoved = ? WHERE ID = ?");
        if ($stmt->execute([$question, $answer, $id])) {
            return ['success' => true, 'message' => 'Вопрос обновлен'];
        }
        return ['success' => false, 'message' => 'Ошибка при обновлении'];
    }

    public function deleteQuestion($id) {
        if (empty($id)) {
            return ['success' => false, 'message' => 'ID не указан'];
        }
        $stmt = $this->conn->prepare("DELETE FROM otazky WHERE ID = ?");
        if ($stmt->execute([$id])) {
            return ['success' => true, 'message' => 'Вопрос удален'];
        }
        return ['success' => false, 'message' => 'Ошибка при удалении'];
    }
}

// --- обработка запросов ---
header('Content-Type: application/json');

$api = new QuestionAPI();

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        echo json_encode($api->listQuestions());
        break;

    case 'add':
        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        echo json_encode($api->addQuestion($question, $answer));
        break;

    case 'edit':
        $id = $_POST['id'] ?? '';
        $question = $_POST['question'] ?? '';
        $answer = $_POST['answer'] ?? '';
        echo json_encode($api->editQuestion($id, $question, $answer));
        break;

    case 'delete':
        $id = $_GET['id'] ?? '';
        echo json_encode($api->deleteQuestion($id));
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Неверное действие']);
        break;
}
