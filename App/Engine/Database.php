<?php

namespace App\Engine;

use PDO;

class Database extends PDO
{
  use SingletonTrait;

  public function __construct() {
    parent::__construct(
      'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME,
      Config::DB_USR,
      Config::DB_PWD
    );
  }
}