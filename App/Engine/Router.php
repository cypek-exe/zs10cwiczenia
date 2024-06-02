<?php

namespace App\Engine;

use App\Controllers\SubjectController as SC;
use App\Controllers\ExerciseController as EC;

class Router
{
  private $routes = [];

  /** 
   * @param string $url 
   * @param string $controller
   * @param string $method
   */
  public function addRout($url, $controller, $method) {
    $this->routes[$url] = ['controller' => $controller, 'method' => $method];
  }

  private function processSubject($urlAsArray) {
    $controllerInstance = new SC($urlAsArray);

    switch ($controllerInstance->getRouteInfo()) {
      case SC::FOUND:
        $controllerInstance->renderHTML();
        break;

      case SC::NOT_FOUND:
      default:
        $this->redirect('/');
        break;
    }
  }

  private function processExercise($urlAsArray) {
    $controllerInstance = new EC($urlAsArray);

    switch ($controllerInstance->getRouteInfo()) {
      case EC::FOUND:
        $controllerInstance->renderHTML();
        break;

      case EC::EXERCISE_NOT_FOUND:
        $this->redirect('/' . $urlAsArray[0]);
        break;

      case EC::SUBJECT_NOT_FOUND:
      case EC::SUBJECT_NOT_FOUND | EC::EXERCISE_NOT_FOUND:
      default:
        $this->redirect('/');
        break;
    }
  }

  /** 
   * @param string $url
   */
  public function dispatch($url) {
    if (isset($this->routes[$url])) {
      $controller = $this->routes[$url]['controller'];
      $method     = $this->routes[$url]['method'];

      $controllerInstance = new $controller();
      $controllerInstance->$method();
    } else {
      $urlAsArray = explode('/', trim($url, '/'));
      $quantityUrlMembers = sizeof($urlAsArray);

      if ($quantityUrlMembers === 1) {
        $this->processSubject($urlAsArray);
      } elseif ($quantityUrlMembers > 1) {
        $this->processExercise($urlAsArray);
      }
    }
  }

  public function redirect($url) {
    header('Location: ' . $url);
  }
}