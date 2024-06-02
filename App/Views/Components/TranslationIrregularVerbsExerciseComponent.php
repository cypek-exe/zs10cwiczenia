<?php

namespace App\Views\Components;

class TranslationIrregularVerbsExerciseComponent extends ExerciseComponent
{
  use CustomButtonSetTrait;

  /**
   * @param string $subjectName
   * @param string $exerciseTitle
   * @param string $exerciseSubtitle
   * @param string $firstColumnName
   * @param string $secondColumnName
   * @param string $thirdColumnName
   * @param int|null $customButtonSet
   */
  public function __construct(
    private $subjectName,
    private $exerciseTitle,
    private $exerciseSubtitle,
    private $firstColumnName,
    private $secondColumnName,
    private $thirdColumnName,
    private $customButtonSet = null
  ) {}

  public function getHTML() {
    ob_start();
    ?>
    <link rel="stylesheet" href="/styles/translations.css">
    <section id="exercise" class="panel fetching-data">
      <h2><?= $this->subjectName . ' - ' . $this->exerciseTitle; ?></h2>
      <p id="question"></p>
      <?= $this->getCustomButtonSet(); ?>
      <form onsubmit="return false;" autocomplete="off" spellcheck="false">
        <div id="answer-container">      
          <input type="text" placeholder="<?= $this->firstColumnName ?>" id="first_column_answer">
          <input type="text" placeholder="<?= $this->secondColumnName ?>" id="second_column_answer">
          <input type="text" placeholder="<?= $this->thirdColumnName ?>" id="third_column_answer">
        </div>
        <div id="buttons">
          <input type="submit" value="SPRAWDŹ" id="check_button">
          <input type="button" value="NIE WIEM" id="hint_button">
          <input type="reset" value="POMIŃ" id="skip_button">
        </div>
      </form>
      <div id="result"></div>
      <div id="options">
        <h3>Opcje</h3>
        <div>
          <input type="checkbox" id="random_order">
          <label for="random_order">Losowa kolejność</label>
        </div>
      </div>
      <div id="stats">
        <div>✅
          <span id="correct">0</span>
        </div>
        <div>❌
          <span id="incorrect">0</span>
        </div>
        <div>🔥
          <span id="streak">0</span>
        </div>    
      </div>
      <div id="other-info">
        <p id="subtitle"><?= $this->exerciseSubtitle ?></p>
      </div>
    </section>
    <script type="module" src="/js/fetch_data.js"></script>
    <script type="module" src="/js/exercise-utils.js"></script>
    <script type="module" src="/js/translation_irregular-model.js"></script>
    <script type="module" src="/js/translation_irregular-app.js"></script>
    <?php
    return ob_get_clean();
  }
}
