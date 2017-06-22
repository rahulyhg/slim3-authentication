<?php

use App\Middleware;

$App->route(["GET"], "/", App\Controller\Index::class, "index")->setName("index");

// Authenticated only routes
$App->group("", function () {
    $this->route(["GET"], "/logout", App\Controller\Auth\Logout::class)->setName("auth.logout");
    $this->route(["GET"], "/profile/{username}", App\Controller\Profile::class, "profile")->setName("profile");
})->add(new Middleware\RestirctGuests($container));

// Authenticated only routes
$App->group("/settings", function () {
    $this->route(["GET", "POST"], "/account", App\Controller\Auth\Settings::class, "account")->setName("auth.account");
    $this->route(["GET", "POST"], "/password", App\Controller\Auth\Settings::class, "password")->setName("auth.password");
    $this->route(["GET", "POST"], "/profile", App\Controller\Auth\Settings::class, "profile")->setName("auth.profile");
})->add(new Middleware\RestirctGuests($container));

// Admin only routes
$App->group("/admin", function() {
    $this->route(["GET", "POST"], "/users/create[/]", App\Controller\Admin\Users::class, "create")->setName("admin.users.create");
    $this->route(["GET", "POST"], "/users/{userId}/update[/]", App\Controller\Admin\Users::class, "update")->setName("admin.users.update");
    $this->route(["GET", "POST"], "/users/{userId}/delete[/]", App\Controller\Admin\Users::class, "delete")->setName("admin.users.delete");
})->add(new Middleware\RestrictNonAdmin($container));

// Unauthenticated only routes
$App->group("", function () {
    $this->route(["GET", "POST"], "/login", App\Controller\Auth\Login::class)->setName("auth.login");
    $this->route(["GET", "POST"], "/register", App\Controller\Auth\Register::class)->setName("auth.register");
})->add(new Middleware\RestirctAuth($container));

