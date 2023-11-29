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

  require_once 'conn-data.php';

  $conn = new mysqli(
    $cd['host'],
    $cd['user'],
    $cd['pass'],
    $cd['dbname']
  );

  $query = <<< EOD
  SELECT
    s.name AS subject_name,
    e.id AS exercise_id,
    e.title As exercise_title
  FROM subjects s
  INNER JOIN exercises e
    ON e.alias = '$exercise'
    AND e.subject_id = s.id
  WHERE s.alias = '$subject'
  EOD;
  $result = $conn -> query($query);

  if ($data = $result -> fetch_assoc()) {
    $exercise_id = $data['exercise_id'];

    $translations_query = <<< EOD
    SELECT phrase, translation
    FROM translations
    WHERE exercise_id = $exercise_id
    EOD;
    $translations_result = $conn -> query($translations_query);

    $translations = array();

    while ($translations_row = $translations_result -> fetch_row()) {
      $translations[] = $translations_row;
    }

    header('Content-Type: application/json');
    echo json_encode(array(
      'subject_name'   => $data['subject_name'],
      'exercise_title' => $data['exercise_title'],
      'translations'   => $translations
    ), JSON_UNESCAPED_UNICODE);
  } else {
    not_found();
  }
  $conn -> close();
}
?>