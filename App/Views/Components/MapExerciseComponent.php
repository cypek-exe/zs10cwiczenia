<?php

namespace App\Views\Components;

class MapExerciseComponent extends ExerciseComponent
{
  /**
   * @param string $subjectName
   * @param string $exerciseTitle
   * @param string $exerciseSubtitle
   * @param string $mapHTMLCode
   * @param string $mapImageDir
   */
  public function __construct(
    private $subjectName, 
    private $exerciseTitle, 
    private $exerciseSubtitle,
    private $mapHTMLCode,
    private $mapImageDir
  ) {}

  public function getHTML() {
    ob_start()
    ?>
    <link rel="stylesheet" href="/styles/map.css">
    <main id="exercise">
      <section id="map-container">
        <img src="<?= $this->mapImageDir; ?>" alt="mapa" id="map" usemap="#map-el">
        <?= $this->mapHTMLCode; ?> 
      </section>
      <section id="exercise-aside-panel" class="panel fetching-data">
        <h2><?= $this->subjectName; ?></h2>
        <h3><?= $this->exerciseTitle . ' - ' . $this->exerciseSubtitle; ?></h3>
        <p id="question"></p>
        <div id="result"></div>
        <input type="button" value="POMIŃ" id="skip_button">
        <div id="options">
          <h3>Opcje</h3>
          <div>
            <input type="checkbox" id="random_order">
            <label for="random_order">Losowa kolejność</label>
          </div>
        </div>
        <div id="stats">
          <div>
            ✅&nbsp;<span id="correct">0</span>
          </div>
          <div>
            ❌&nbsp;<span id="incorrect">0</span>
          </div>
          <div>
            🔥&nbsp;<span id="streak">0</span>
          </div>
        </div>
      </section>
    </main>
    <script type="module" src="/js/fetch_data.js"></script>
    <script type="module" src="/js/exercise-utils.js"></script>
    <script type="module" src="/js/map-model.js"></script>
    <script type="module" src="/js/map-app.js"></script>
    <?php
    return ob_get_clean();
  }
}
