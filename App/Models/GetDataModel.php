<?php

namespace App\Models;

use App\Engine\Database;
use PDO;

class GetDataModel
{
  private $db;

  public function __construct() {
    $this->db = Database::getInstance();
  }

  /**
   * @param string $subjectAlias
   * @param string $exerciseAlias
   * @param int $columns defined by constants
   * @return array returns ID and Type as associative array based on subject and exercise aliases
   */
  public function getExercise($subjectAlias, $exerciseAlias) {
    $query = <<< 'EOQ'
      SELECT 
        E.ID exerciseID, 
        E.Type exerciseType, 
        S.Name subjectName, 
        E.Title exerciseTitle
      FROM Exercises E
      JOIN Subjects S
        ON E.Subject_ID = S.ID
      WHERE S.Alias = :subjectAlias AND E.Alias = :exerciseAlias;
      EOQ;

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':subjectAlias', $subjectAlias, PDO::PARAM_STR);
    $stmt->bindParam(':exerciseAlias', $exerciseAlias, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * @param int $exerciseID
   * @return array 
   */
  public function getTranslationsByID($exerciseID) {
    $query = <<< 'EOQ'
      SELECT Phrase, Translation 
      FROM Translations 
      WHERE Translation_ID = :exerciseID;
      EOQ;
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':exerciseID', $exerciseID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @param int $exerciseID
   * @return array 
   */
  public function getPlacesByID($exerciseID) {
    $query = 'SELECT Place_Index, Name FROM Places WHERE Map_ID = :exerciseID;';

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':exerciseID', $exerciseID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * @param int $exerciseID
   * @return array 
   */
  public function getIrregularVerbsTranslationsByID($exerciseID) {
    $query = <<< 'EOQ'
      SELECT First_Column, Second_Column, Third_Column, Translation
      FROM Translations_Irregular_Verbs
      WHERE Translation_ID = :exerciseID;
      EOQ;

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':exerciseID', $exerciseID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}