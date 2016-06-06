<?php
// Autoloader inclusion
require_once 'vendor/autoload.php';

// Accesses
use conf\Router;
use conf\Configuration;
use Slim\Slim;

// DB configuration
Configuration::config();

// Slim app creation
$app = new Slim(array(
    'templates.path' => 'app/view',
    'debug' => true
));

// Do not forget sessions...
session_start ();

//
// Now routing definition
//

// Set routes

$router = new Router($app, 'conf/routes', '');
$router->parseRoutes();

// Finally, generate result
$app->run();
