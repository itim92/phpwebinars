<?php


use App\Http\Request;
use App\Http\Response;
use App\Middleware\AuthMiddleware;
use App\Middleware\CartMiddleware;
use App\Renderer\Renderer;

return [
    Request::class,
    Response::class,
    Renderer::class,
    AuthMiddleware::class,
    CartMiddleware::class,
];