<?php

function print_translation(
  $subject_name,
  $exercise_title,
  $exercise_subtitle
) {
?>
<link rel="stylesheet" href="/styles/translations.css">
<section id="exercise" class="panel fetching-data">
  <h2><?php echo $subject_name.' - '.$exercise_title ?></h2>
  <p id="question"></p>
  <form onsubmit="return false;">
    <input type="text" placeholder="Wpisz odpowiedź tutaj" id="answer">
    <div id="buttons">
      <input type="submit" value="Sprawdź" id="check_button">
      <input type="button" value="Nie wiem" id="hint_button">
      <input type="reset" value="Pomiń" id="skip_button">
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
    <p id="subtitle"><?php echo $exercise_subtitle ?></p>
  </div>
</section>
<script src="/js/translation.js"></script>
<script src="/js/fetch_data.js"></script>
<?php
}