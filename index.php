<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);



require __DIR__.'/vendor/autoload.php';

$config = require 'config.php';
include_once 'core/Router.php';
include_once 'core/Request.php';
$routes = include_once 'routes.php';



$request = new Request;

$router = new Router;
$router->load($routes);

$router->direct($request->getPath(), $request->getMethod());


















