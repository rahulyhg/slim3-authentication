<?php

use App\Auth\Auth;
use App\Utility\Validator;
use Slim\Csrf\Guard as Csrf;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

return [
    // Auth
    "auth" => function($container) {
        return new Auth;
    },
    // Csrf
    "csrf" => function($container) {
        return new Csrf;
    },
    // Database
    "db" => function($container){
        $capsule = new Capsule;
        $capsule->addConnection($container["config"]["db"]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    },
    // Flash
    "flash" => function($container) {
        return new Flash;
    },
    // Settings
    "settings" => [
        "displayErrorDetails" => true
    ],
    // Validator
    "validator" => function($container) {
        return new Validator;
    },
    // View
    "view" => function($container) {
        $view = new Twig("../app/View/html", [
            "cache" => false
        ]);

        $view->addExtension(new TwigExtension($container->router, $container->request->getUri()));

        //$view->addExtension(new App\View\CsrfExtension($container["csrf"]));

        $view->getEnvironment()->addGlobal("auth", [
            "check" => $container->auth->check(),
            "user" => $container->auth->user(),
        ]);

        $view->getEnvironment()->addGlobal("flash", $container->flash);

        return $view;
    }
];