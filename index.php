<?php

require_once 'header.php';
require_once 'content.php';
require_once 'exercises.php';
require_once 'footer.php';

$cd = require_once 'conn-data.php';

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

  $subject_query = <<< EOD
    SELECT ID, Alias, Name 
    FROM Subjects 
    WHERE Alias = '$subject';
    EOD;

  $subject_result = $conn -> query($subject_query);

  if ($subject_row = $subject_result -> fetch_assoc()) {

    $subject_id    = $subject_row['ID'];
    $subject_alias = $subject_row['Alias'];
    $subject_name  = $subject_row['Name'];

    if (isset($path_array[1])) {
      $exercise = $path_array[1];

      $exercise_query = <<< EOD
        SELECT ID, Alias, Title, Subtitle, Type
        FROM Exercises
        WHERE Subject_ID = $subject_id AND Alias = '$exercise';
        EOD;

      $exercise_result = $conn -> query($exercise_query);

      if ($exercise_row = $exercise_result -> fetch_assoc()) {
        
        $exercise_id       = $exercise_row['ID'];
        $exercise_title    = $exercise_row['Title'];
        $exercise_subtitle = $exercise_row['Subtitle'];
        $exercise_type     = $exercise_row['Type'];

        get_header("ZS10 Ćwiczenia - $exercise_title");

        switch ($exercise_type) {
          case 0:
            $translation_exercise_query = <<< EOD
              SELECT Custom_Button_Set
              FROM Translations_Exercises
              WHERE Exercise_ID = $exercise_id;
              EOD;

            $translation_exercise_result = $conn -> query($translation_exercise_query);

            if ($translation_exercise_row = $translation_exercise_result -> fetch_assoc())
              print_translation(
                $subject_name,
                $exercise_title,
                $exercise_subtitle,
                $translation_exercise_row['Custom_Button_Set']
              );
            break;

          case 1:
            $map_exercise_query = <<< EOD
              SELECT
                IoM.Directory AS Map_Image_Dir,
                ME.Map_HTML_Code
              FROM Maps_Exercises      ME
              LEFT JOIN Images_of_Maps IoM
                ON ME.Map_Image_ID = IoM.ID
              WHERE ME.Exercise_ID = $exercise_id;
              EOD;

            $map_exercise_result = $conn -> query($map_exercise_query);

            if ($map_exercise_row = $map_exercise_result -> fetch_assoc())
              print_map(
                $subject_name,
                $exercise_title,
                $exercise_subtitle,
                $map_exercise_row['Map_Image_Dir'],
                $map_exercise_row['Map_HTML_Code']
              );
            break;

          default:
            echo 'Nieznane ćwiczenie';
            break;
        }

      } else {
        header("Location: /$subject_alias");
      }

    } else { 
      $exercises_query = <<< EOD
        SELECT Alias, Title, Subtitle, Description 
        FROM Exercises
        WHERE Subject_ID = $subject_id;
        EOD;

      $exercises_result = $conn -> query($exercises_query);

      get_header("ZS10 Ćwiczenia - $subject_name");

      echo '<section class="cards" id="exercises">'."\n";

      while ($exercises_row = $exercises_result -> fetch_assoc()) {
        $exercises_alias       = $exercises_row['Alias'];
        $exercises_title       = $exercises_row['Title'];
        $exercises_subtitle    = $exercises_row['Subtitle'];
        $exercises_description = $exercises_row['Description'];

        print_exercise(
          "/$subject_alias/$exercises_alias",
          $exercises_title,
          $exercises_subtitle,
          $exercises_description
        );
      }

      echo '</section>'."\n";
    }
  } else {
    header('Location: /');
  }

} else {
  $subjects_query = <<< EOD
    SELECT Alias, Name, Description, Image 
    FROM Subjects;
    EOD;

  $subjects_result = $conn -> query($subjects_query);
  
  get_header('ZS10 Ćwiczenia');

  echo '<section class="cards">'."\n";

  while ($subjects_row = $subjects_result -> fetch_assoc()) {
    $subjects_alias       = $subjects_row['Alias'];
    $subjects_name        = $subjects_row['Name'];
    $subjects_description = $subjects_row['Description'];
    $subjects_image       = $subjects_row['Image'];

    print_subject(
      "/$subjects_alias",
      $subjects_image,
      $subjects_name,
      $subjects_description
    );
  }

  echo '</section>';
}

$conn -> close();

get_footer();
