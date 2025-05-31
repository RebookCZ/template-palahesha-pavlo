<?php

require_once __DIR__ . '/database/Database.php';

use database\Database;

class ContactFormHandler extends Database
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = $this->getConnection();
    }

    public function process(array $data): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Invalid request method');
        }

        $name    = trim($data['name'] ?? '');
        $email   = trim($data['email'] ?? '');
        $subject = trim($data['subject'] ?? '');
        $message = trim($data['message'] ?? '');

        if ($name === '' || $email === '' || $subject === '' || $message === '') {
            throw new Exception('All fields are required');
        }

        $stmt = $this->conn->prepare("INSERT INTO kontakt (name, email, subject, message) 
                                      VALUES (:name, :email, :subject, :message)");
        $stmt->execute([
            ':name'    => $name,
            ':email'   => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);

        return "Message sent successfully!";
    }
}

header('Content-Type: text/plain; charset=utf-8');

try {
    $handler = new ContactFormHandler();
    echo $handler->process($_POST);
} catch (Exception $e) {
    http_response_code(400);
    echo "Error: " . $e->getMessage();
}
