<?php

use App\Views\Components\TranslationExerciseComponent as TEC;
use App\Views\Components\MapExerciseComponent as MEC;
use App\Views\Components\TranslationIrregularVerbsExerciseComponent as TIVEC;

$siteTitle    = $data['siteTitle'];
$exerciseType = $data['exerciseData']['Type'];

$subjectName      = $data['exerciseData']['Subject_Name'];
$exerciseTitle    = $data['exerciseData']['Title'];
$exerciseSubtitle = $data['exerciseData']['Subtitle'];

$exerciseComponentInstance;

switch ($exerciseType) {
  case 0:
    $customButtonSet = $data['exerciseData']['TE_CBS'];

    $exerciseComponentInstance = new TEC(
      $subjectName,
      $exerciseTitle,
      $exerciseSubtitle,
      $customButtonSet
    );
    break;

  case 1:
    $mapHTMLCode = $data['exerciseData']['Map_HTML_Code'];
    $mapImageDir = $data['exerciseData']['Map_Image_Dir'];

    $exerciseComponentInstance = new MEC(
      $subjectName,
      $exerciseTitle,
      $exerciseSubtitle,
      $mapHTMLCode,
      $mapImageDir
    );
    break;

  case 2:
    $firstColumnName  = $data['exerciseData']['First_Column_Name'];
    $secondColumnName = $data['exerciseData']['Second_Column_Name'];
    $thirdColumnName  = $data['exerciseData']['Third_Column_Name'];
    $customButtonSet  = $data['exerciseData']['TIVE_CBS'];

    $exerciseComponentInstance = new TIVEC(
      $subjectName,
      $exerciseTitle,
      $exerciseSubtitle,
      $firstColumnName,
      $secondColumnName,
      $thirdColumnName,
      $customButtonSet
    );
    break;

  default:
    throw new Exception('Nieznany typ ćwiczenia', 1);
}

$content = $exerciseComponentInstance->getHTML();

include 
  ROOT_DIR            . 'App' . 
  DIRECTORY_SEPARATOR . 'Views' . 
  DIRECTORY_SEPARATOR . 'Layouts' . 
  DIRECTORY_SEPARATOR . 'layout.php';
  