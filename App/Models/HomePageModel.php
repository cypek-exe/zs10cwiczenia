<?php

namespace App\Models;

use App\Engine\Database;
use PDOStatement;

class HomePageModel
{
  private $db;

  public function __construct() {
    $this->db = Database::getInstance();
  }

  /**
   * @return PDOStatement|false returns the executed PDOStatement object or false on error
   */
  public function getAllSubjects() {
    $query = 'SELECT Alias, Name, Description, Image FROM Subjects';
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}