<?php


use App\Middleware\AuthMiddleware;
use App\Middleware\SharedData;

return [
    AuthMiddleware::class,
    SharedData::class,
];