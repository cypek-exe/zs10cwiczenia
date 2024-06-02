<?php

define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);

use App\Engine\Loader;
use App\Engine\Router;
use App\Controllers\HomePageController;
use App\Controllers\AboutUsPageController;
use App\Controllers\GetDataController;

include ROOT_DIR . str_replace('\\', DIRECTORY_SEPARATOR, Loader::class) . '.php';

$loader = new Loader();
$loader->init();

$router = new Router();
$router->addRout('/', HomePageController::class, 'renderHTML');
$router->addRout('/o-nas', AboutUsPageController::class, 'renderHTML');
$router->addRout('/get-data.php', GetDataController::class, 'renderJSON');

$path = '/' . (trim($_SERVER['DOCUMENT_URI'], '/') ?? '');
$router->dispatch($path);
