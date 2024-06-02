<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use PDO;

class SubjectController
{
  const
    FOUND = 0,
    NOT_FOUND = 1;

  private $routeInfo;
  private $exercisesData;

  /**
   * @param array $urlAsArray array of url elements
   */
  public function __construct($urlAsArray) {
    $exerciseAlias = $urlAsArray[0];

    $modelInstance = new SubjectModel();
    $e_stmt = $modelInstance->getExercisesBySubjAl($exerciseAlias);

    if ($e_stmt) {
      $this->exercisesData = $e_stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($e_stmt->rowCount() >= 1) {
        $this->routeInfo = self::FOUND;
      } else {
        $this->routeInfo = self::NOT_FOUND;
      }
    }// TODO ELSE ERROR
  }

  public function getRouteInfo() {
    return $this->routeInfo;
  }

  public function renderHTML() {
    $data['siteTitle'] = 'ZS10 Ćwiczenia - ' . $this->exercisesData[0]['Subject_Name'];
    $data['exercises'] = $this->exercisesData;

    include 
      ROOT_DIR            . 'App' . 
      DIRECTORY_SEPARATOR . 'Views' . 
      DIRECTORY_SEPARATOR . 'subject.php';
  }

  
}