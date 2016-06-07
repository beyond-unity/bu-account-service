<?php
// Application middleware

$app->add(new \pavlakis\cli\CliRequest());
$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret" => "mysecret",
    "relaxed" => ["localhost", "accounts.service.bu.local"],
    "path" => "/",
    "passthrough" => ["/createaccount", "/token"],
]));