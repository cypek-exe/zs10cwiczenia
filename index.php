<?php

require_once 'conn-data.php';
require_once 'header.php';
require_once 'content.php';
require_once 'exercises.php';
require_once 'footer.php';

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

  $query1 = "SELECT id, alias, name FROM subjects WHERE alias = '$subject'";
  $result1 = $conn -> query($query1);

  if ($result1 -> num_rows) {
    $row1 = $result1 -> fetch_assoc();

    if (isset($path_array[1])) {
      $exercise = $path_array[1];
      $query2 = "SELECT alias, title, subtitle, custom_button_set FROM exercises WHERE alias = '$exercise'";
      $result2 = $conn -> query($query2);

      if ($row2 = $result2 -> fetch_assoc()) {

        get_header('ZS10 Ćwiczenia - '.$row2['title']);

        print_translation(
          $row1['name'],
          $row2['title'],
          $row2['subtitle'],
          $row2['custom_button_set']
        );
      } else {
        header('Location: /'.$row1['alias']);
      }

    } else { 
      $query2 = "SELECT alias, title, subtitle, description FROM exercises WHERE subject_id = {$row1['id']}";
      $result2 = $conn -> query($query2);

      get_header('ZS10 Ćwiczenia - '.$row1['name']);

      echo '<section class="cards" id="exercises">'."\n";

      while ($row2 = $result2 -> fetch_assoc()) {
        print_exercise(
          '/'.$row1['alias'].'/'.$row2['alias'],
          $row2['title'],
          $row2['subtitle'],
          $row2['description']
        );
      }

      echo '</section>'."\n";
    }
  } else {
    header('Location: /');
  }

} else {
  $query = 'SELECT alias, name, description, image FROM subjects';
  $result = $conn -> query($query);
  
  get_header("ZS10 Ćwiczenia");

  echo '<section class="cards">'."\n";

  while ($row = $result -> fetch_assoc()) {
    print_subject(
      '/'.$row['alias'],
      $row['image'],
      $row['name'],
      $row['description']
    );
  }

  echo '</section>';
}

$conn -> close();

get_footer();
