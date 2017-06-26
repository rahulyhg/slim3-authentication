<?php

return [
    "app" => [
        "name" => "myApp",
        "app" => [
            "activation" => false
        ],
        "cookies" => [
            "user_remember" => "user_remember"
        ],
        "sessions" => [
            "user_id" => "user_id"
        ]
    ],
    "database" => [
        "driver" => "mysql",
        "host" => "localhost",
        "database" => "myApp",
        "username" => "root",
        "password" => "password",
        "charset" => "utf8",
        "collation" => "utf8_unicode_ci",
        "prefix" => "",
    ],
    "texts" => [
        "login" => [
            "invalid" => "The login credentials you have supplied are invalid."
        ],
        "register" => [
            "error" => "There was a problem creating your account! Please fix any errors and try again.",
            "success" => "Your account has been successfully created!"
        ],
        "user" => [
            "account_updated" => "Your account has been successfully updated!",
            "password_invalid" => "The current password you have entered is incorrect!",
            "password_updated" => "Your password has been successfully updated!",
            "profile_updated" => "Your profile has been successfully updated!",
            "" => ""
        ]
    ]
];
