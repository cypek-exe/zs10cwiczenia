<?php

function print_subject(
  $reference_path,
  $icon_dir,
  $subject_name,
  $description
) {
  $lc_subject_name = strtolower($subject_name);

  echo <<< EOD
  <a href="$reference_path" class="panel">
    <article>
      <header>
        <img src="$icon_dir" alt="ikona przedmiotu $lc_subject_name" class="icon">
        <h2>$subject_name</h2>
      </header>
      <p>
        $description
      </p>
    </article>
  </a>\n
  EOD;
}


function print_exercise(
  $reference_path,
  $title,
  $subtitle,
  $description
) {
  echo <<< EOD
  <a href="$reference_path" class="panel">
    <article>
      <h2>$title</h2>
      <h3>$subtitle</h3>
      <p>
        $description
      </p>
    </article>
  </a>\n
  EOD;
}
