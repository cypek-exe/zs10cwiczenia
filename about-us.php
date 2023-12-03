<?php

require_once 'header.php';
require_once 'footer.php';

get_header('ZS10 Ćwiczenia - O nas');

?>
  <section class="cards" id="about-us">
    <article class="panel">
      <h2>Karol Kopczyński</h2>
      <p>
        Założyciel projektu. Zajmuję się Back-Endem oraz po części Front-endem. Jestem odpowiedzialny głównie za działanie funkcji strony oraz pomagam w jej designowaniu.
      </p>
    </article>
    <article class="panel">
      <h2>Cyprian Moj</h2>
      <p>
        Programista full-stack - zaimplementowałem skrypty po stronie serwera. Pomagam w tworzeniu responsywnej strony. Zajmuję się optymalizacją kodu. 
      </p>
      <div class="links">
        <a href="https://cypek.ct8.pl/o-mnie" target="_blank">O mnie</a>
        <a href="https://github.com/cypek-exe" target="_blank">Mój Github</a>
      </div>
    </article>
    <article class="panel">
      <h2>Paweł Wasilewski</h2>
      <p>
        Visual designer, zajmuję sie tworzeniem atrakcyjnego i funkcjonalnego interfejsu, który będzie łatwy w obsłudze dla użytkownika końcowego. Odpowiedzialny za szatę graficzną strony oraz jej responsywność.
      </p>
    </article>
  </section>
<?php

get_footer();