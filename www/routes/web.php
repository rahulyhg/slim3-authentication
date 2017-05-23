<?php

// Authenticated only routes
$App->group("", function () {

    // Get
    $this->get("/", App\Controller\Index::class . ":index")->setName("index");
    $this->get("/logout", App\Controller\Auth::class . ":getLogout")->setName("auth.logout");
    $this->get("/post/create", App\Controller\Post::class . ":getCreatePost")->setName("post.create");
    $this->get("/profile/{username}", App\Controller\User::class . ":profile")->setName("user.profile");
    
    // Post
    $this->post("/post/create", App\Controller\Post::class . ":postCreatePost")->setName("post.create");
})->add(new App\Middleware\RestirctGuests($container));

// Unauthenticated only routes
$App->group("", function () {

    // Get
    $this->get("/login", App\Controller\Auth::class . ":getLogin")->setName("auth.login");
    $this->get("/register", App\Controller\Auth::class . ":getRegister")->setName("auth.register");

    // Post
    $this->post("/login", App\Controller\Auth::class . ":postLogin")->setName("auth.login");
    $this->post("/post", App\Controller\Auth::class . ":postCreatePost")->setName("post.create");
    $this->post("/register", App\Controller\Auth::class . ":postRegister")->setName("auth.register");
})->add(new App\Middleware\RestirctAuthenticated($container));

// 
$App->group("", function () {

    // Get
    $this->get("/post/{post_id}", App\Controller\Post::class . ":getPost")->setName("post.index");
});
