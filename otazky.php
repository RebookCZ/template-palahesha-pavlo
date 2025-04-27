<?php
namespace otazkyodpovede;

require_once "database/database.php";

use database\Database;
use PDO;
use PDOException;

class QnA extends Database
{
    public function readQnA()
    {
        try {
            $stmt = $this->getConnection()->prepare("SELECT * FROM `project`");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($data) {
                foreach ($data as $item) {
                    echo '<div class="accordion">';
                    echo '<div class="question">' . htmlspecialchars($item['question']) . '</div>';
                    echo '<div class="answer">' . htmlspecialchars($item['answer']) . '</div>';

                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                        echo '<div class="admin-actions" style="margin-top:10px;">';
                        echo '<button class="edit-btn" style="background-color: #ffc107; color: black; padding: 5px 10px; border: none; margin-right:5px; cursor: pointer;" onclick="openEditModal(' . (int)$item['ID'] . ', \'' . addslashes($item['question']) . '\', \'' . addslashes($item['answer']) . '\')">Edit</button>';
                        echo '<button class="delete-btn" style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; cursor: pointer;" onclick="deleteQuestion(' . (int)$item['ID'] . ')">Delete</button>';
                        echo '</div>';
                    }

                    echo '</div>';
                }
            } else {
                echo "<p>No questions available yet.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error loading questions: " . $e->getMessage() . "</p>";
        }
    }
}
?>
