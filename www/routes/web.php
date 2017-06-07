<?php

use App\Controller;
use App\Middleware;

$App->route(["GET"], "/", Controller\Index::class, "index")->setName("index");

// Authenticated only routes
$App->group("", function () {
    $this->route(["GET"], "/logout", Controller\Auth::class, "logout")->setName("auth.logout");
    $this->route(["GET"], "/profile/{username}", Controller\Profile::class, "profile")->setName("profile");
})->add(new Middleware\RestirctGuests($container));

// Admin only routes
$App->group("/admin", function() {
    $this->route(["GET"], "", Controller\Admin::class)->setName("admin.index");
})->add(new Middleware\RestrictNonAdmin($container));

// Unauthenticated only routes
$App->group("", function () {
    $this->route(["GET", "POST"], "/login", Controller\Auth::class, "login")->setName("auth.login");
    $this->route(["GET", "POST"], "/register", Controller\Auth::class, "register")->setName("auth.register");
})->add(new Middleware\RestirctAuth($container));

