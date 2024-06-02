<?php

namespace App\Engine;

use Exception;

class Loader
{
  public function init() {
    spl_autoload_register([$this, 'loadClass']);
  }

  private function loadClass($class) {
    $classPatch = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = ROOT_DIR . $classPatch . '.php';

    if (file_exists($file)) {
      include $file;
    } else {
      throw new Exception('Class ' . $class . ' not found! File ' . $file . ' not exist!');
    }
  }
}