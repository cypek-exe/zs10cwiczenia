<?php

$siteTitle = $data['siteTitle'];

ob_start();
?>
<section class="cards">
<?php foreach($data['subjects'] as $subject):
  $subjectName        = $subject['Name'];
  $subjectDescription = $subject['Description'];
  $subjectUrl         = '/' . $subject['Alias'];
  $subjectImageUrl    = $subject['Image'];
  $subjectImageAlt    = 'ikona przedmiotu ' . strtolower($subject['Name']);
?>
  <a href="<?= $subjectUrl ?>" class="panel">
    <article>
      <header>
        <img src="<?= $subjectImageUrl ?>" alt="<?= $subjectImageAlt ?>" class="icon">
        <h2><?= $subjectName ?></h2>
      </header>
      <p>
        <?= $subjectDescription ?>
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
