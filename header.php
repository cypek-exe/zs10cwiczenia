<?php

function get_header($title) {

?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/styles/style.css">
  <link rel="stylesheet" href="/styles/header.css">
  <title><?php echo $title ?></title>
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
            <a href="https://github.com/cypek-exe/zs10cwiczenia" target="_blank">GitHub</a>
          </li>
        </ul>
        <div id="menu-icon" tabindex="0">
          <div class="menu-icon-line"></div>
          <div class="menu-icon-line"></div>
          <div class="menu-icon-line"></div>
        </div>
      </nav>
    </div>
  </header>
<?php

}
