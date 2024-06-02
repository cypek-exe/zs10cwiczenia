<?php

namespace App\Models;

use App\Engine\Database;
use PDO;
use PDOStatement;

class ExerciseModel
{
  private $db;

  public function __construct() {
    $this->db = Database::getInstance();
  }

  /**
   * @param string $subjectAlias
   * @param string $exerciseAlias
   * @return PDOStatement|false returns the executed PDOStatement object or false on error
   */
  public function getExerciseData($subjectAlias, $exerciseAlias) {
    $query = <<<'EOQ'
      SELECT
        S.Name Subject_Name,
        E.Title,
        E.Subtitle,
        E.Type,
        TE.Custom_Button_Set TE_CBS,
        ME.Map_HTML_Code,
        IoM.Directory Map_Image_Dir,
        TIVE.Custom_Button_Set TIVE_CBS,
        TIVE.First_Column_Name,
        TIVE.Second_Column_Name,
        TIVE.Third_Column_Name
      FROM Exercises E
      INNER JOIN Subjects S
        ON E.Subject_ID = S.ID
      LEFT JOIN Translations_Exercises TE 
        ON E.ID = TE.Exercise_ID
      LEFT JOIN Maps_Exercises ME
        ON E.ID = ME.Exercise_ID
      LEFT JOIN Images_of_Maps IoM 
        ON ME.Map_Image_ID = IoM.ID
      LEFT JOIN Translations_Irregular_Verbs_Exercises TIVE
        ON E.ID = TIVE.Exercise_ID
      WHERE S.Alias = :subjectAlias AND E.Alias = :exerciseAlias;
      EOQ;
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':subjectAlias', $subjectAlias, PDO::PARAM_STR);
    $stmt->bindParam(':exerciseAlias', $exerciseAlias, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt;
  }
}