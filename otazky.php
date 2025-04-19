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
                    echo '</div>';
                }
                
            } else {
                echo "<p>Žiadne otázky zatiaľ neboli pridané.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Chyba pri načítaní otázok: " . $e->getMessage() . "</p>";
        }
    }
}
