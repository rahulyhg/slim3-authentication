<?php

return [
    "settings" => [
        'displayErrorDetails' => true,
    ],
    "auth" => function() {
        return(new App\Core\Auth);
    },
    "config" => function(){
        return(new Noodlehaus\Config(ROOT . "config"));
    },
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
    "db" => function($container){
        $capsule = new Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container["config"]->get("database"));
        $capsule->setAsGlobal();
        return $capsule;
    },
    "email" => function($container){
        $mailer = new \PHPMailer;
        $mailer->isSMTP();
        $mailer->Host = $container["config"]->get("email.host");
        $mailer->Port = $container["config"]->get("email.port");
        $mailer->Username = $container["config"]->get("email.username");
        $mailer->Password = $container["config"]->get("email.password");
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = false;
        $mailer->FromName = $container["config"]->get("email.name");
        $mailer->From = $container["config"]->get("email.from");
        $mailer->isHTML(true);
        return(new App\Mail\Mailer($mailer, $container));
    },
    "flash" => function() {
        return(new Slim\Flash\Messages);
    },
    "hash" => function() {
        return(new App\Core\Hash);
    },
    "validator" => function() {
        return(new App\Validation\Validator);
    },
    "view" => function($container) {
        $view = new Slim\Views\Twig(ROOT . "resources/views", [
            "cache" => false
        ]);
        $view->addExtension(new Slim\Views\TwigExtension($container->router, $container->request->getUri()));
        $view->getEnvironment()->addGlobal("auth", [
            "check" => $container->auth->check(),
            "user" => $container->auth->user(),
        ]);
        $view->getEnvironment()->addGlobal("flash", $container->flash);
        return $view;
    }
];