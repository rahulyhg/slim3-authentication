<?php

return [
    // 
    // Settings
    // -------------------------------------------------------------------------
    "settings" => [
        "displayErrorDetails" => true
    ],
    // 
    // Auth
    // -------------------------------------------------------------------------
    "auth" => function() {
        return(new App\Auth\Auth);
    },
    // 
    // Config
    // -------------------------------------------------------------------------
    "config" => function(){
      return(new App\Core\Config(ROOT . "config"));  
    },
    //
    // Csrf
    // -------------------------------------------------------------------------
    "csrf" => function($container) {
        $guard = new Slim\Csrf\Guard;
        $guard->setFailureCallable(function($request, $response, $next) use ($container) {
            $request = $request->withAttribute("csrf_status", false);
            if($request->getAttribute("csrf_status") === false) {
                $container->flash->addMessage("danger", "CSRF verification failed, terminating your request.");
                return($response->withStatus(400)->withRedirect($container->router->pathFor("index")));
            } else {
                return $next($request, $response);
            }
        });
        return $guard;
    },
    //
    // Database
    // -------------------------------------------------------------------------
    "db" => function($container){
        $capsule = new Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container["config"]->get("database"));
        $capsule->setAsGlobal();
        return $capsule;
    },
    //
    // Email
    // -------------------------------------------------------------------------
    "email" => function($container){
        $mailer = new \PHPMailer;
        $mailer->isSMTP();
        $mailer->Host = $container["config"]->get("email/host");
        $mailer->Port = $container["config"]->get("email/port");
        $mailer->Username = $container["config"]->get("email/username");
        $mailer->Password = $container["config"]->get("email/password");
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = false;
        $mailer->FromName = $container["config"]->get("email/name");
        $mailer->From = $container["config"]->get("email/from");
        $mailer->isHTML(true);
        return(new App\Mail\Mailer($mailer, $container));
    },
    //
    // Flash
    // -------------------------------------------------------------------------
    "flash" => function() {
        return(new Slim\Flash\Messages);
    },
    //
    // Hash
    // -------------------------------------------------------------------------
    "hash" => function() {
        return(new App\Core\Hash);
    },
    // 
    // Validator
    // -------------------------------------------------------------------------
    "validator" => function() {
        return(new App\Validation\Validator);
    },
    // 
    // View
    // -------------------------------------------------------------------------
    "view" => function($container) {
        $view = new Slim\Views\Twig(ROOT . "resources/views", [
            "cache" => false
        ]);

        $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));

        $view->addExtension(new App\View\CsrfExtension($container["csrf"]));

        $view->getEnvironment()->addGlobal("auth", [
            "check" => $container->auth->check(),
            "user" => $container->auth->user(),
        ]);

        $view->getEnvironment()->addGlobal("flash", $container->flash);

        return $view;
    }
];