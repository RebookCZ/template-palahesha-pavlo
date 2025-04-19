<?php
require_once 'db/config.php';

$host = DATABASE['HOST'];
$dbname = DATABASE['DBNAME'];
$user = DATABASE['USER_NAME'];
$password = DATABASE['PASSWORD'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("database connection error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // If the form was submitted, it would be a POST request. After this we get input from name,email,subject,message
    $name    = $_POST['name'] ?? ''; // if the input be empty the form will sent empty input by ?? '' method
    $email   = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO kontakt (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message
    ]);

    echo "OK";
    exit;
}
