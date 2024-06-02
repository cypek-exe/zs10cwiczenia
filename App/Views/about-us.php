<?php

$siteTitle = $data['siteTitle'];

ob_start();
?>
<section class="cards" id="about-us">
  <article class="panel">
    <h2>Karol Kopczyński</h2>
    <p>
      Założyciel projektu. Zajmuję się Back-Endem oraz po części Front-endem. 
      Jestem odpowiedzialny głównie za zawartość strony oraz pomagam w jej 
      designowaniu i pisaniu skryptów.
    </p>
  </article>
  <article class="panel">
    <h2>Cyprian Moj</h2>
    <p>
      Programista full-stack - zaimplementowałem skrypty po stronie serwera. 
      Pomagam w tworzeniu responsywnej strony. Zajmuję się optymalizacją kodu.
      <div class="links">
        <a href="https://cypek.ct8.pl/o-mnie" target="_blank">O mnie</a>
        <a href="https://github.com/cypekdev" target="_blank">Mój Github</a>
      </div>
    </p>
  </article>
  <article class="panel">
    <h2>Paweł Wasilewski</h2>
    <p>
      Visual designer, zajmuję sie tworzeniem atrakcyjnego i funkcjonalnego 
      interfejsu, który będzie łatwy w obsłudze dla użytkownika końcowego. 
      Odpowiedzialny za szatę graficzną strony oraz jej responsywność.
    </p>
  </article>
</section>
<?php
$content = ob_get_clean();

include 
  ROOT_DIR            . 'App' . 
  DIRECTORY_SEPARATOR . 'Views' . 
  DIRECTORY_SEPARATOR . 'Layouts' . 
  DIRECTORY_SEPARATOR . 'layout.php';
