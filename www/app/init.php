<?php

require_once "../../vendor/autoload.php";

$App = new \Slim\App(["settings" => ["displayErrorDetails" => true]]);

$container = $App->getContainer();
$container["view"] = function ($container) {
    $view = new \Slim\Views\Twig("../resources/views", [
        'cache' => false
    ]);
    $basePath = rtrim(str_ireplace("index.php", "", $container["request"]->getUri()->getBasePath()), "/");
    $view->addExtension(new Slim\Views\TwigExtension($container["router"], $basePath));
    return $view;
};

require_once "../routes/web.php";
