<?php


use App\Data\Shop\Order\OrderRepository;
use App\Http\Request;
use App\Http\Response;
use App\Middleware\AuthMiddleware;
use App\Middleware\CartMiddleware;
use App\Middleware\SharedData;
use App\Model\ModelAnalyzer;
use App\Model\ModelManager;
use App\Model\Proxy\ProxyModelManager;
use App\Renderer\Renderer;
use App\Utils\DocParser;
use App\Utils\ReflectionUtil;
use App\Utils\StringUtil;

return [
    ReflectionUtil::class,
    StringUtil::class,
    DocParser::class,

    Request::class,
    Response::class,
    Renderer::class,
    ModelManager::class,
    AuthMiddleware::class,
    CartMiddleware::class,
    SharedData::class,


    ModelAnalyzer::class,
    ProxyModelManager::class,
    OrderRepository::class,
];