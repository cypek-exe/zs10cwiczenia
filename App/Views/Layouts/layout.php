<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/styles/style.css">
  <link rel="stylesheet" href="/styles/header.css">
  <title><?= $siteTitle ?></title>
</head>
<body>
  <header id="main_header">
    <div class="container">
      <a href="/">
        <h1>ZS10 Ćwiczenia</h1>
      </a>
      <nav>
        <ul id="menu-list">
          <li>
            <a href="/">Strona główna</a>
          </li>
          <li>
            <a href="/o-nas">O nas</a>
          </li>
          <li>
            <a href="https://github.com/cypekdev/zs10cwiczenia" target="_blank">GitHub</a>
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
<?= $content ?>
  <section id="discord_info" class="panel">
    <p>
      Chcesz dać własną propozycje działu lub chciałbyś/chciałabyś żeby jakiś 
      materiał znalazł się na stronie?
    </p>
    <p>
      <a href="https://discord.gg/bDKD9GrTuX" target="_blank">Wbijaj na discorda</a>
      projektu i zaproponuj własny pomysł.
    </p>
  </section>
  <footer>
    <div class="container">
      <p>Wersja strony: 3.0.0.beta.0</p>
      <p>Copyright© <?= date('Y') ?> ZS10 Ćwiczenia</p>
    </div>
  </footer>
  <script type="module" src="/js/hamburger_menu.js"></script>
  <script type="module" src="/js/reveal_sticky_header.js"></script>
</body>
</html>