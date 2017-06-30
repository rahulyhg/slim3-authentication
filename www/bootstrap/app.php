<?php

use App\Core\App;
use Slim\Container;
use App\Utility\Session;
use App\Middleware\LoginWithCookie;
use App\Middleware\OldInput;
use App\Middleware\ValidationErrors;
use App\Middleware\CsrfView;

require_once "../../vendor/autoload.php";
Session::init();

define("ROOT", realpath(dirname(__FILE__) . "/../") . "/");

if(file_exists(ROOT . '../.env')) {
    $env = new Dotenv\Dotenv(ROOT . '../');
    $env->load();
}

// App
$App = new App(new Container(require_once "container.php"));

// Container
$container = $App->getContainer();
$container["db"]->bootEloquent();

// Middleware
$App->add(new LoginWithCookie($container));
$App->add(new OldInput($container));
$App->add(new ValidationErrors($container));
$App->add(new CsrfView($container));
$App->add($container->csrf);

// 
Respect\Validation\Validator::with("App\\Validation\\Rules\\");

// Routes
require_once ROOT . "routes/api.php";
require_once ROOT . "routes/web.php";
