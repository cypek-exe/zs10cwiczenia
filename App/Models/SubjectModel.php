<?php

namespace App\Models;

use App\Engine\Database;
use PDO;
use PDOStatement;

class SubjectModel
{
  private $db;

  public function __construct() {
    $this->db = Database::getInstance();
  }

  /**
   * @param string $subjectAlias
   * @return PDOStatement|false returns the executed PDOStatement object or false on error
   */
  public function getExercisesBySubjAl($subjectAlias) {
    $query = <<<'EOQ'
      SELECT 
        E.Alias,
        S.Alias Subject_Alias,
        S.Name Subject_Name,
        E.Title, 
        E.Subtitle, 
        E.Description, 
        E.Type
      FROM Exercises E
      JOIN Subjects S 
        ON E.Subject_ID = S.ID
      WHERE S.Alias = :subjectAlias;
      EOQ;
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':subjectAlias', $subjectAlias, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
  }
}