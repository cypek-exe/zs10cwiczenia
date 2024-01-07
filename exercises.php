<?php

function print_translation(
  $subject_name,
  $exercise_title,
  $exercise_subtitle,
  $custom_button_set
) {
?>
<link rel="stylesheet" href="/styles/translations.css">
<section id="exercise" class="panel fetching-data">
  <h2><?= $subject_name.' - '.$exercise_title ?></h2>
  <p id="question"></p>
<?php

if (!is_null($custom_button_set)) {
  switch ($custom_button_set) {
    case 0:
  ?>
  <div id="special-signs">
    <input type="button" value="ä" class="special-sign case-changeable">
    <input type="button" value="ö" class="special-sign case-changeable">
    <input type="button" value="ü" class="special-sign case-changeable">
    <input type="button" value="ß" class="special-sign">
  </div>
  <script type="module" src="/js/special_signs.js"></script>
  <?php
  }
}

?>
  <form onsubmit="return false;">
    <input type="text" placeholder="Wpisz odpowiedź tutaj" id="answer">
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
      <input type="radio" name="mode" id="mode_to_foreign" checked="true">
      <label for="mode_to_foreign">Na obcy język</label>
    </div>
    <div>
      <input type="radio" name="mode" id="mode_to_primary">
      <label for="mode_to_primary">Na polski język</label>
    </div>
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
    <p id="subtitle"><?= $exercise_subtitle ?></p>
  </div>
</section>
<script type="module" src="/js/fetch_data.js"></script>
<script type="module" src="/js/exercise-utils.js"></script>
<script type="module" src="/js/translation-model.js"></script>
<script type="module" src="/js/translation-app.js"></script>
<?php
}


function print_map(
  $subject_name,
  $exercise_title,
  $exercise_subtitle,
  $map_image,
  $map_html_code
) {

?>
<link rel="stylesheet" href="/styles/map.css">
<main id="exercise">
  <section>
    <img src="<?= $map_image ?>" alt="mapa" id="map" usemap="#map-el">
    <?= $map_html_code ?> 
  </section>
  <section id="exercise" class="panel fetching-data">
    <h2><?= $subject_name ?></h2>
    <h3><?= $exercise_title.' - '.$exercise_subtitle ?></h3>
    <p id="question"></p>
    <div id="result"></div>
    <div id="options">
      <h3>Opcje</h3>
      <div>
        <input type="button" value="POMIŃ" id="skip_button">
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
  </section>
</main>
<script type="module" src="/js/fetch_data.js"></script>
<script type="module" src="/js/exercise-utils.js"></script>
<script type="module" src="/js/map-model.js"></script>
<script type="module" src="/js/map-app.js"></script>
<?php

}