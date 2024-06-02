<?php

namespace App\Views\Components;

abstract class ExerciseComponent
{
  /**
   * @param string $subjectName
   * @param string $exerciseTitle
   * @param string $exerciseSubtitle
   */
  public function __construct(
    private $subjectName, 
    private $exerciseTitle, 
    private $exerciseSubtitle
  ) {}

  /**
   * @return string returns HTML of exercise panel
   */
  abstract public function getHTML();
}
