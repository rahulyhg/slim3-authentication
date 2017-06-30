<?php

$App->group("", function () {
    
})->add(new App\Middleware\JsonResponse($container));
