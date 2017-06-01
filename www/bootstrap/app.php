<?php

use App\Core\App;
use Slim\Container;
use App\Utility\Session;
use App\Middleware\LoginWithCookie;
use App\Middleware\OldInput;
use App\Middleware\ValidationErrors;

require_once "../../vendor/autoload.php";

Session::init();

define("ROOT", realpath(dirname(__FILE__) . "/../") . "/");

// App
$App = new App(new Container(require_once ROOT . "bootstrap/container.php"));

// Container
$container = $App->getContainer();
$container["db"]->bootEloquent();

// Middleware
$App->add(new LoginWithCookie($container));
$App->add(new OldInput($container));
$App->add(new ValidationErrors($container));
$App->add($container->csrf);

// Routes
require_once ROOT . "routes/web.php";
