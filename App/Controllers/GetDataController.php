<?php

namespace App\Controllers;

use App\Models\GetDataModel;

class GetDataController
{
  private $data;
  private $modelInstance;

  public function __construct() {
    if (!empty($_REQUEST['s']) && !empty($_REQUEST['e'])) {
      $subjectAlias  = $_REQUEST['s'];
      $exerciseAlias = $_REQUEST['e'];
  
      $this->modelInstance = new GetDataModel();
      $exercise = $this->modelInstance->getExercise($subjectAlias, $exerciseAlias);
      $exerciseID   = $exercise['exerciseID'];
      $exerciseType = $exercise['exerciseType'];

      $exerciseData = $this->getExerciseData($exerciseType, $exerciseID);

      $exerciseDataKey = [
        0 => 'translations',
        1 => 'places',
        2 => 'irregular_translations'
      ];

      $this->data = [
        'request_status' => 'found',
        'exercise_type' => $exerciseType,
        'subject_name' => $exercise['subjectName'],
        'exercise_title' => $exercise['exerciseTitle'],
        $exerciseDataKey[$exerciseType] => $exerciseData
      ];
    }
  }

  /**
   * @param int $exerciseType
   * @param int @exerciseID
   * @return array|false
   */
  private function getExerciseData($exerciseType, $exerciseID) {
    switch ($exerciseType) {
      case 0:
        $translations = $this->modelInstance->getTranslationsByID($exerciseID);
        return array_map(function($row) {
          return [
            'phrase'      => $row['Phrase'], 
            'translation' => $row['Translation']
          ];
        }, $translations);

      case 1:
        $places = $this->modelInstance->getPlacesByID($exerciseID);
        $result = [];
        foreach ($places as $row) {
          $result[ $row['Place_Index'] ] = $row['Name'];
        }
        return $result;

      case 2:
        $translations = $this->modelInstance->getIrregularVerbsTranslationsByID($exerciseID);
        return array_map(function($row) {
          return [
            'first_column'  => $row['First_Column'],
            'second_column' => $row['Second_Column'],
            'third_column'  => $row['Third_Column'],
            'translation'   => $row['Translation']
          ];
        }, $translations);
      
      default:
        // TODO Error handling
        return false;
    }
  }

  public function renderJSON() {
    header('Content-Type: application/json');
    echo json_encode($this->data);
  }
}
