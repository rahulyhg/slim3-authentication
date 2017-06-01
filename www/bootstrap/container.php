<?php

use App\Auth\Auth;
use App\Core\Config;
use App\Utility\Validator;
use Slim\Csrf\Guard as Csrf;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

return [
    // Settings
    "settings" => [
        "displayErrorDetails" => true
    ],
    // Auth
    "auth" => function($container) {
        $sessionName = $container->config->get("sessions/user_id");
        return(new Auth($sessionName));
    },
    // Config
    "config" => function(){
      return(new Config(ROOT . "config"));  
    },
    // Csrf
    "csrf" => function() {
        return(new Csrf);
    },
    // Database
    "db" => function($container){
        $capsule = new Capsule;
        $capsule->addConnection($container->config->get("database"));
        $capsule->setAsGlobal();
        return $capsule;
    },
    // Flash
    "flash" => function() {
        return(new Flash);
    },
    // Validator
    "validator" => function() {
        Respect\Validation\Validator::with("App\\Utility\\Validator\\Rules");
        return(new Validator);
    },
    // View
    "view" => function($container) {
        $view = new Twig(ROOT . "resources/views", [
            "cache" => false
        ]);

        $view->addExtension(new TwigExtension($container->router, $container->request->getUri()));

        $view->addExtension(new App\View\CsrfExtension($container["csrf"]));

        $view->getEnvironment()->addGlobal("auth", [
            "check" => $container->auth->check(),
            "user" => $container->auth->user(),
        ]);

        $view->getEnvironment()->addGlobal("flash", $container->flash);

        return $view;
    }
];