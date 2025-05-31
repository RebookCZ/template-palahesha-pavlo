<?php
namespace admin_system;

use database\Database;
use Exception;

class AdminQAController extends Database
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = $this->getConnection();
        $this->checkAdmin();
    }

    private function checkAdmin()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            throw new Exception('Access denied: Admins only.');
        }
    }

    public function getAllQuestions(): array
    {
        $stmt = $this->conn->query("SELECT id, question, answer FROM project ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function addQuestion(string $questionText, string $answerText): bool
    {
        $sql = "INSERT INTO project (question, answer) VALUES (:question, :answer)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['question' => $questionText, 'answer' => $answerText]);
    }

    public function editQuestion(int $id, string $newQuestion, string $newAnswer): bool
    {
        $sql = "UPDATE project SET question = :question, answer = :answer WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['question' => $newQuestion, 'answer' => $newAnswer, 'id' => $id]);
    }

    public function deleteQuestion(int $id): bool
    {
        $sql = "DELETE FROM project WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
