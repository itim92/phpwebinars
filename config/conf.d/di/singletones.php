<?php


use App\Http\Request;
use App\Http\Response;
use App\Middleware\AuthMiddleware;
use App\Renderer\Renderer;

return [
    Request::class,
    Response::class,
    Renderer::class,
    AuthMiddleware::class,
];