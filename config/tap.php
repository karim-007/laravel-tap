<?php

return [
    "sandbox"           => env("TAP_SANDBOX", true),
    "popUpCloseTimeOut" => env("TAP_POPUP_CLOSE_TIME_OUT", 5),

    "authAPIKey"     => env("TAP_AUTH_API_KEY", ""),
    "auth_token"     => env("TAP_AUTH_TOKEN", ""),
    "username"       => env("TAP_USERNAME", ""),
    "password"       => env("TAP_PASSWORD", ""),

    "authAPIKey_2"   => env("TAP_AUTH_API_KEY_2", ""),
    "auth_token_2"   => env("TAP_AUTH_TOKEN_2", ""),
    "username_2"     => env("TAP_USERNAME_2", ""),
    "password_2"     => env("TAP_PASSWORD_2", ""),

    "authAPIKey_3"   => env("TAP_AUTH_API_KEY_3", ""),
    "auth_token_3"   => env("TAP_AUTH_TOKEN_3", ""),
    "username_3"     => env("TAP_USERNAME_3", ""),
    "password_3"     => env("TAP_PASSWORD_3", ""),

    "authAPIKey_4"   => env("TAP_AUTH_API_KEY_4", ""),
    "auth_token_4"   => env("TAP_AUTH_TOKEN_4", ""),
    "username_4"     => env("TAP_USERNAME_4", ""),
    "password_4"     => env("TAP_PASSWORD_4", ""),

    "callbackURL"    => env("TAP_CALLBACK_URL", "http://127.0.0.1:8000/tap/callback"),
    'timezone'       => 'Asia/Dhaka',
];
