<?php

use App\Utility\Session;
use Respect\Validation\Validator;

require_once "../../vendor/autoload.php";

Session::init();

define("ROOT", realpath(dirname(__FILE__) . "/../") . "/");
define("APP_ROOT", ROOT . "app/");
define("PUBLIC_ROOT", ROOT . "public/");

// App
$App = new Slim\App(new Slim\Container(include APP_ROOT . 'container.php'));

// Container
$container = $App->getContainer();

// Middleware
$App->add(new App\Middleware\LoginWithCookie($container));
$App->add(new App\Middleware\OldInput($container));
$App->add(new App\Middleware\ValidationErrors($container));
$App->add($container->csrf);

Validator::with("App\\Utility\\Validator\\Rules");

require_once "../routes/web.php";
