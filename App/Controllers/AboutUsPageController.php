<?php

namespace App\Controllers;

class AboutUsPageController
{
  public function renderHTML() {
    $data['siteTitle'] = 'ZS10 Ćwiczenia - O nas';

    include 
      ROOT_DIR            . 'App' . 
      DIRECTORY_SEPARATOR . 'Views' . 
      DIRECTORY_SEPARATOR . 'about-us.php';
  }
}