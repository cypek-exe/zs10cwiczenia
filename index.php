<?php

function print_header($title) {
  echo <<< EOD
  <!DOCTYPE html>
  <html lang="pl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/style.css">
    <link rel="stylesheet" href="/styles/header.css">
    <title>$title</title>
  </head>
  <body>
    <header id="main_header">
      <div class="container">
        <a href="/">
          <h1>ZS10 Ćwiczenia</h1>
        </a>
        <nav>
          <ul>
            <li>
              <a href="/">Strona główna</a>
            </li>
            <li>
              <a href="/o-nas">O nas</a>
            </li>
            <li>
              <a href="https://github.com/KarixD2137/zs10cwiczenia" target="_blank">GitHub</a>
            </li>
          </ul>
          <div id="menu-icon" tabindex="0">
            <div class="menu-icon-line"></div>
            <div class="menu-icon-line"></div>
            <div class="menu-icon-line"></div>
          </div>
        </nav>
      </div>
    </header>\n
  EOD;
}

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

function print_translation($subject_name, $exercise_title, $exercise_subtitle) {
  echo <<< EOD
  <h2>$subject_name - $exercise_title</h2>
  <h3>$exercise_subtitle</h3>
  <p id="question"></p>
  <input type="text" placeholder="Wpisz odpowiedź tutaj" id="answer">
  <div id="buttons">
    <input type="button" value="Sprawdź" id="check_button">
    <input type="button" value="Nie wiem" id="hint_button">
    <input type="button" value="Pomiń" id="skip_button">
  </div>
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
  </div>\n
  EOD;
}

require_once 'conn-data.php';

$conn = new mysqli(
  $cd['host'],
  $cd['user'],
  $cd['pass'],
  $cd['dbname']
);

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO']) {
  
  $path = trim($_SERVER['PATH_INFO'], '/');
  $path_array = explode('/', $path);

  $subject = $path_array[0];

  $query1 = "SELECT id, alias, name FROM subjects WHERE alias = '{$subject}'";
  $result1 = $conn -> query($query1);

  if ($result1 -> num_rows) {
    $row1 = $result1 -> fetch_assoc();

    if (isset($path_array[1])) {
      $exercise = $path_array[1];
      $query2 = "SELECT id, alias, title, subtitle FROM exercises WHERE alias = '{$exercise}'";
      $result2 = $conn -> query($query2);

      if ($row2 = $result2 -> fetch_assoc()) {
        print_header("ZS10 Ćwiczenia - {$row2['title']}");
        echo "<link rel=\"stylesheet\" href=\"/styles/translations.css\">\n";
        echo "<section id=\"exercise\" class=\"panel\">\n";        
        print_translation($row1['name'], $row2['title'], $row2['subtitle']);
        echo "</section>\n";
        echo "<script src=\"/js/translation.js\"></script>\n";
        echo "<script src=\"/js/fetch_data.js\"></script>\n";
      } else {
        header("Location: /{$row1['alias']}");
      }

    } else { 
      $query2 = "SELECT alias, title, subtitle, description FROM exercises WHERE subject_id = {$row1['id']}";
      $result2 = $conn -> query($query2);

      print_header("ZS10 Ćwiczenia - {$row1['name']}");
      echo "<section class=\"cards\" id=\"exercises\">\n";
      while ($row2 = $result2 -> fetch_assoc()) {
        print_exercise(
          "/{$row1['alias']}/{$row2['alias']}",
          $row2['title'],
          $row2['subtitle'],
          $row2['description']
        );
      }
      echo "</section>\n";
    }
  } else {
    header("Location: /");
  }

} else {
  $query = 'SELECT alias, name, description, image FROM subjects';
  $result = $conn -> query($query);
  
  print_header("ZS10 Ćwiczenia");
  echo "<section class=\"cards\">\n";
  while ($row = $result -> fetch_assoc()) {
    print_subject(
      "/{$row['alias']}",
      $row['image'],
      $row['name'],
      $row['description']
    );
  }
  echo '</section>';
}

$conn -> close();

?>
  <section id="discord_info" class="panel">
    <p>
      Chcesz dać własną propozycje działu lub chciałbyś/chcaiłabyś żeby jakiś materiał znalazł się na stronie?
    </p>
    <p>
      <a href="https://discord.gg/bDKD9GrTuX" target="_blank">Wbijaj na discorda</a>
      projektu i zaproponuj własny pomysł.
    </p>
  </section>
  <footer>
    <div class="container">
      <p>Wersja strony: 2.0.0-beta.2</p>
      <p>Copyright© <?php echo date('Y') ?> ZS10 Ćwiczenia</p>
    </div>
  </footer>
  <script src="/js/reveal_sticky_header.js" type="module"></script>
</body>
</html>