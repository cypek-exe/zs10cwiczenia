<?php

namespace App\Engine;

trait SingletonTrait
{
  protected static $instance;

  public static function getInstance() {
    return self::$instance ?? self::$instance = new self(); 
  }
}