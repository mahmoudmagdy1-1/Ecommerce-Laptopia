<?php
require   "../helpers.php";
require "../vendor/autoload.php";

use Core\Session;
Session::start();

use Core\Router;
$router = new Router();
$routes = require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->route($uri);