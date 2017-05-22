<?php

// Unauthenticated routes
$App->group("", function () {

    // Get
    $this->get("/login", App\Controller\Login::class . ":index")->setName("login");
    $this->get("/register", App\Controller\Register::class . ":index")->setName("register");

    // Post
    $this->post("/login", App\Controller\Login::class . ":login")->setName("login");
    $this->post("/register", App\Controller\Register::class . ":register")->setName("register");
})->add(new App\Middleware\RestirctAuthenticated($container));


// Authenticated routes
$App->group("", function () {

    // Get
    $this->get("/", App\Controller\Index::class . ":index")->setName("index");
    $this->get("/logout", App\Controller\Login::class . ":logout")->setName("logout");
    $this->get("/profile/{username}", App\Controller\User::class . ":profile")->setName("user.profile");
})->add(new App\Middleware\RestirctGuests($container));
