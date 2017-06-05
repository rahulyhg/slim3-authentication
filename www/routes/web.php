<?php

use App\Controller\Auth;
use App\Controller\Index;
use App\Controller\Profile;
use App\Middleware\RestirctAuth;
use App\Middleware\RestirctGuests;
use App\Middleware\RestrictNonAdmin;

$App->route(["GET"], "/", Index::class, "index")->setName("index");

// Authenticated only routes
$App->group("", function () {
    $this->route(["GET"], "/logout", Auth::class, "logout")->setName("auth.logout");
    $this->route(["GET"], "/profile/{username}", Profile::class, "profile")->setName("profile");
})->add(new RestirctGuests($container));

$App->group("/admin", function() {
    $this->route(["GET"], "/", "")->setName("admin.index");
})->add(new RestrictNonAdmin($container));

// Unauthenticated only routes
$App->group("", function () {
    $this->route(["GET", "POST"], "/login", Auth::class, "login")->setName("auth.login");
    $this->route(["GET", "POST"], "/register", Auth::class, "register")->setName("auth.register");
})->add(new RestirctAuth($container));

