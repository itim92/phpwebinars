<?php


use App\Middleware\AuthMiddleware;
use App\Middleware\CartMiddleware;
use App\Middleware\SharedData;

return [
    AuthMiddleware::class,
    CartMiddleware::class,
    SharedData::class,
];