<?php

namespace App\Controllers;

use App\Models\HomePageModel;
use PDO;

class HomePageController 
{
  private $subjectsData;

  public function __construct() {
    $modelInstance = new HomePageModel();
    $this->subjectsData = $modelInstance->getAllSubjects()->fetchAll(PDO::FETCH_ASSOC);
  }

  public function renderHTML() {
    $data['siteTitle'] = 'ZS10 Ćwiczenia';
    $data['subjects'] = $this->subjectsData;

    include 
      ROOT_DIR            . 'App' . 
      DIRECTORY_SEPARATOR . 'Views' . 
      DIRECTORY_SEPARATOR . 'index.php';
  }
}