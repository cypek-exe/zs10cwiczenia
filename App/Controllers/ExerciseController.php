<?php

namespace App\Controllers;

use App\Models\ExerciseModel;
use PDO;

class ExerciseController
{
  const
    FOUND = 0,
    EXERCISE_NOT_FOUND = 1,
    SUBJECT_NOT_FOUND = 2;

  private $routeInfo;
  private $exerciseData;

  /**
   * @param array $urlAsArray array of url elements
   */
  public function __construct($urlAsArray) {
    $subjectAlias  = $urlAsArray[0];
    $exerciseAlias = $urlAsArray[1];

    $modelInstance = new ExerciseModel();
    $this->exerciseData = $modelInstance
      ->getExerciseData($subjectAlias, $exerciseAlias)
      ->fetch(PDO::FETCH_ASSOC);
  }

  public function getRouteInfo() {
    return $this->routeInfo;
  }

  public function renderHTML() {
    $data['siteTitle'] = 'ZS10 Ćwiczenia - ' . $this->exerciseData['Title'];
    $data['exerciseData'] = $this->exerciseData;

    include 
      ROOT_DIR            . 'App' . 
      DIRECTORY_SEPARATOR . 'Views' . 
      DIRECTORY_SEPARATOR . 'exercise.php';
  }
}