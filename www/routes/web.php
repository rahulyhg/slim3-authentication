<?php

use App\Controller\Auth;
use App\Controller\Index;
use App\Controller\Profile;
use App\Middleware\RestirctAuth;
use App\Middleware\RestirctGuests;

// Authenticated only routes
$App->group("", function () {
    
    // Get requests
    $this->get("/", Index::class . ":getIndex")->setName("index");
    $this->get("/logout", Auth::class . ":getLogout")->setName("auth.logout");
    $this->get("/profile/{username}", Profile::class . ":getProfile")->setName("profile");
})->add(new RestirctGuests($container));

// Unauthenticated only routes
$App->group("", function () {
    
    // Get requests
    $this->get("/login", Auth::class . ":getLogin")->setName("auth.login");
    $this->get("/register", Auth::class . ":getRegister")->setName("auth.register");
    
    // Post requets
    $this->post("/login", Auth::class . ":postLogin");
    $this->post("/register", Auth::class . ":postRegister");
})->add(new RestirctAuth($container));