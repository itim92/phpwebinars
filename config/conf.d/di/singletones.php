<?php


use App\Http\Request;
use App\Http\Response;
use App\Middleware\AuthMiddleware;
use App\Middleware\CartMiddleware;
use App\Middleware\SharedData;
use App\Model\ModelManager;
use App\Renderer\Renderer;
use App\Utils\DocParser;
use App\Utils;
use App\Utils\StringUtil;

return [
    Utils\ReflectionUtil::class,
    StringUtil::class,
    DocParser::class,

    Request::class,
    Response::class,
    Renderer::class,
    ModelManager::class,
    AuthMiddleware::class,
    CartMiddleware::class,
    SharedData::class,
];