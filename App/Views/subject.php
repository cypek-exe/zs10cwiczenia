<?php

$siteTitle = $data['siteTitle'];

ob_start();
?>
<section class="cards" id="exercises">
<?php foreach($data['exercises'] as $exercise): 
  $exerciseURL = '/' . $exercise['Subject_Alias'] . '/' . $exercise['Alias'];
  $exerciseTitle       = $exercise['Title'];
  $exerciseSubtitle    = $exercise['Subtitle'];
  $exerciseDescription = $exercise['Description'];
?>
  <a href="<?= $exerciseURL ?>" class="panel">
    <article>
      <h2><?= $exerciseTitle ?></h2>
      <h3><?= $exerciseSubtitle ?></h3>
      <p>
        <?= $exerciseDescription ?>
      </p>
    </article>
  </a>
<?php endforeach; ?>
</section>
<?php
$content = ob_get_clean();

include 
  ROOT_DIR            . 'App' . 
  DIRECTORY_SEPARATOR . 'Views' . 
  DIRECTORY_SEPARATOR . 'Layouts' . 
  DIRECTORY_SEPARATOR . 'layout.php';