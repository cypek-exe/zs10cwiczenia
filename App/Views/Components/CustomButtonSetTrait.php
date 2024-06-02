<?php

namespace App\Views\Components;

trait CustomButtonSetTrait
{
  private $customButtonSet;

  /**
   * @return string returns HTML of custom buttons set
   */
  private function getCustomButtonSet() {
    if (is_null($this->customButtonSet)) {
      return '';
    }

    switch ($this->customButtonSet) {
      case 0:
        ob_start();
        ?>
        <div id="special-signs">
          <input type="button" value="ä" class="special-sign case-changeable">
          <input type="button" value="ö" class="special-sign case-changeable">
          <input type="button" value="ü" class="special-sign case-changeable">
          <input type="button" value="ß" class="special-sign">
        </div>
        <script type="module" src="/js/special_signs.js"></script>
        <?php
        return ob_get_clean();

      default:
        return '';
    }
  }
}
