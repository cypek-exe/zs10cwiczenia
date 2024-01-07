<?php

function not_found() {
  http_response_code(404);
  $message = 'Nie znaleziono elementu! (błędny adres URL)';
  echo json_encode(array('message' => $message), JSON_UNESCAPED_UNICODE);
}

if (
  $_SERVER['REQUEST_METHOD'] === 'GET' &&
  isset($_GET['s'])                    &&
  isset($_GET['e'])
) {
  $subject  = $_GET['s'];
  $exercise = $_GET['e'];

  $cd = require_once 'conn-data.php';

  $conn = new mysqli(
    $cd['host'],
    $cd['user'],
    $cd['pass'],
    $cd['dbname']
  );

  $query = <<< EOD
    SELECT
      S.Name  AS subject_name,
      E.ID    AS exercise_id,
      E.Type  AS exercise_type,
      E.Title As exercise_title
    FROM       Subjects  S
    INNER JOIN Exercises E
      ON  E.Alias      = '$exercise'
      AND E.Subject_ID = S.ID
    WHERE S.Alias      = '$subject';
    EOD;

  $result = $conn -> query($query);

  if ($data = $result -> fetch_assoc()) {

    $exercise_type = $data['exercise_type'];

    switch ($exercise_type) {
      case 0: // translation exercise
        $exercise_id = $data['exercise_id'];

        $translations_query = <<< EOD
          SELECT T.Phrase, T.Translation
          FROM
            Translations           T,
            Translations_Exercises TE
          WHERE 
            TE.Exercise_ID   = $exercise_id AND 
            T.Translation_ID = TE.Exercise_ID;
          EOD;

        $translations_result = $conn -> query($translations_query);

        $translations = $translations_result -> fetch_all(MYSQLI_NUM);

        header('Content-Type: application/json');

        echo json_encode(array(
          'subject_name'   => $data['subject_name'],
          'exercise_title' => $data['exercise_title'],
          'translations'   => $translations
        ), JSON_UNESCAPED_UNICODE);

        break;

      case 1: // map exercises
        $exercise_id = $data['exercise_id'];

        $places_query = <<< EOD
          SELECT P.Place_Index, P.Name
          FROM
            Places         P,
            Maps_Exercises ME
          WHERE 
            ME.Exercise_ID = $exercise_id AND 
            P.Map_ID       = ME.Exercise_ID;
          EOD;

        $places_result = $conn -> query($places_query);

        $places = $places_result -> fetch_all(MYSQLI_ASSOC);

        $places_assoc = array();

        foreach ($places as $place) {
          $place_index = $place['Place_Index'];
          $place_name  = $place['Name'];
          $places_assoc[$place_index] = $place_name;
        }

        header('Content-Type: application/json');

        echo json_encode(array(
          'subject_name'   => $data['subject_name'],
          'exercise_title' => $data['exercise_title'],
          'places'         => $places_assoc
        ), JSON_UNESCAPED_UNICODE);

        break;
      
      default:
        echo 'Unknown exercise type :(';
        break;
    }

  } else {
    not_found();
  }
  $conn -> close();
}
