<?php

use App\Utility\Session;
use Respect\Validation\Validator;

require_once "../../vendor/autoload.php";

Session::init();

$App = new \Slim\App([
    "settings" => [
        "displayErrorDetails" => true,
        "db" => [
            "driver" => "mysql",
            "host" => "localhost",
            "database" => "myApp",
            "username" => "root",
            "password" => "password",
            "charset" => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix" => "",
        ]
    ]
]);

$container = $App->getContainer();

$container["auth"] = function($container) {
    return new \App\Auth\Auth();
};

$container["csrf"] = function($container) {
    return new Slim\Csrf\Guard;
};

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container["settings"]["db"]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
    
$container["db"] = function ($container) use ($capsule) {
    return $capsule;
};

$container["flash"] = function ($container) {
    return new Slim\Flash\Messages;
};

$container["validator"] = function ($container) {
    return new App\Utility\Validator;
};

$container["view"] = function ($container) {
    $view = new \Slim\Views\Twig("../resources/views", [
        'cache' => false
    ]);
    
    $view->addExtension(new \Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    $view->addExtension(new App\View\CsrfExtension($container["csrf"]));

    $view->getEnvironment()->addGlobal("auth", [
        "check" => $container->auth->check(),
        "user" => $container->auth->user(),
    ]);
    
    $view->getEnvironment()->addGlobal("flash", $container->flash);
    
    return $view;
};

$App->add(new App\Middleware\OldInput($container));
$App->add(new App\Middleware\ValidationErrors($container));
$App->add($container->csrf);

Validator::with("App\\Utility\\Validator\\Rules");

require_once "../routes/web.php";
