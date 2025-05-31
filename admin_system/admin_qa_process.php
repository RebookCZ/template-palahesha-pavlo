<?php
require_once __DIR__ . '/../database/Database.php';
require_once __DIR__ . '/../admin_system/AdminQAController.php';

use admin_system\AdminQAController;

header('Content-Type: application/json');

session_start();

try {
    $controller = new AdminQAController();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $action = $_POST['action'] ?? '';
    if (!$action) {
        throw new Exception('Action not specified');
    }

    switch ($action) {
        case 'add':
            $question = trim($_POST['question'] ?? '');
            $answer = trim($_POST['answer'] ?? '');
            if ($question === '' || $answer === '') {
                throw new Exception('Both question and answer are required');
            }
            $success = $controller->addQuestion($question, $answer);
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Question added']);
            } else {
                throw new Exception('Failed to add question');
            }
            break;

        case 'edit':
            $id = (int)($_POST['id'] ?? 0);
            $question = trim($_POST['question'] ?? '');
            $answer = trim($_POST['answer'] ?? '');
            if ($id <= 0 || $question === '' || $answer === '') {
                throw new Exception('ID, question and answer are required');
            }
            $success = $controller->editQuestion($id, $question, $answer);
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Question updated']);
            } else {
                throw new Exception('Failed to update question');
            }
            break;

        case 'delete':
            $id = (int)($_POST['id'] ?? 0);
            if ($id <= 0) {
                throw new Exception('ID is required');
            }
            $success = $controller->deleteQuestion($id);
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Question deleted']);
            } else {
                throw new Exception('Failed to delete question');
            }
            break;

        default:
            throw new Exception('Unknown action');
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
